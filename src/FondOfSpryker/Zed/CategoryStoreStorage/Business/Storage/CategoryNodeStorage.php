<?php

namespace FondOfSpryker\Zed\CategoryStoreStorage\Business\Storage;

use Generated\Shared\Transfer\CategoryNodeStorageTransfer;
use Orm\Zed\CategoryStorage\Persistence\SpyCategoryNodeStorage;
use Spryker\Zed\CategoryStorage\Business\Storage\CategoryNodeStorage as SprykerCategoryNodeStorage;

class CategoryNodeStorage extends SprykerCategoryNodeStorage
{
    /**
     * @param \Generated\Shared\Transfer\CategoryNodeStorageTransfer $categoryNodeStorageTransfer
     * @param string $localeName
     * @param \Orm\Zed\CategoryStorage\Persistence\SpyCategoryNodeStorage|null $spyCategoryNodeStorageEntity
     *
     * @return void
     */
    protected function storeDataSet(CategoryNodeStorageTransfer $categoryNodeStorageTransfer, $localeName, ?SpyCategoryNodeStorage $spyCategoryNodeStorageEntity = null)
    {
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
        $spyCategoryNodeStorageEntity->setStore($this->store->getStoreName());
        $spyCategoryNodeStorageEntity->setLocale($localeName);
        $spyCategoryNodeStorageEntity->setIsSendingToQueue($this->isSendingToQueue);
        $spyCategoryNodeStorageEntity->save();

    }
}
