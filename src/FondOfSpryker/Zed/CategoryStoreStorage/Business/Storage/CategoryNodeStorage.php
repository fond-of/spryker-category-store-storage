<?php

namespace FondOfSpryker\Zed\CategoryStoreStorage\Business\Storage;

use Generated\Shared\Transfer\CategoryNodeStorageTransfer;
use Orm\Zed\Category\Persistence\Base\SpyCategoryNode;
use Orm\Zed\Category\Persistence\SpyCategoryNodeQuery;
use Orm\Zed\CategoryStorage\Persistence\SpyCategoryNodeStorage;
use Orm\Zed\Store\Persistence\SpyStoreQuery;
use Spryker\Shared\Log\LoggerTrait;
use Spryker\Zed\CategoryStorage\Business\Storage\CategoryNodeStorage as SprykerCategoryNodeStorage;

class CategoryNodeStorage extends SprykerCategoryNodeStorage
{
    use LoggerTrait;

    /**
     * @param \Generated\Shared\Transfer\CategoryNodeStorageTransfer $categoryNodeStorageTransfer
     * @param string $localeName
     * @param \Orm\Zed\CategoryStorage\Persistence\SpyCategoryNodeStorage|null $spyCategoryNodeStorageEntity
     *
     * @return void
     */
    protected function storeDataSet(CategoryNodeStorageTransfer $categoryNodeStorageTransfer, $localeName, ?SpyCategoryNodeStorage $spyCategoryNodeStorageEntity = null)
    {
        $categoryNodeStorageTransfer->getNodeId();

        if ($spyCategoryNodeStorageEntity === null) {
            $spyCategoryNodeStorageEntity = new SpyCategoryNodeStorage();
        }

        if (!$categoryNodeStorageTransfer->getIsActive()) {
            if (!$spyCategoryNodeStorageEntity->isNew()) {
                $spyCategoryNodeStorageEntity->delete();
            }

            return;
        }

        $categoryNodeNodeData = $this->utilSanitize->arrayFilterRecursive($categoryNodeStorageTransfer->toArray());
        $spyCategoryNodeStorageEntity->setFkCategoryNode($categoryNodeStorageTransfer->getNodeId());
        $spyCategoryNodeStorageEntity->setData($categoryNodeNodeData);
        $spyCategoryNodeStorageEntity->setStore($this->getStoreName($categoryNodeStorageTransfer));
        $spyCategoryNodeStorageEntity->setLocale($localeName);
        $spyCategoryNodeStorageEntity->setIsSendingToQueue($this->isSendingToQueue);
        $spyCategoryNodeStorageEntity->save();

    }

    /**
     * Retreieve Store Name
     *
     * @param \Generated\Shared\Transfer\CategoryNodeStorageTransfer $categoryNodeStorageTransfer
     *
     * @return string
     */
    protected function getStoreName(CategoryNodeStorageTransfer $categoryNodeStorageTransfer)
    {
        $categoryNodeEntity = SpyCategoryNodeQuery::create()
            ->filterByIdCategoryNode($categoryNodeStorageTransfer->getNodeId())
            ->findOne();

        $storeEntity = SpyStoreQuery::create()
            ->filterByIdStore($categoryNodeEntity->getFkStore())
            ->findOne();

        return $storeEntity->getName();
    }
}