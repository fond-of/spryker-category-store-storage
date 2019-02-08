<?php

namespace FondOfSpryker\Zed\CategoryStoreStorage\Business\Storage;

use Generated\Shared\Transfer\CategoryNodeStorageTransfer;
use Generated\Shared\Transfer\CategoryTreeStorageTransfer;
use Orm\Zed\Category\Persistence\SpyCategoryNode;
use Orm\Zed\CategoryStorage\Persistence\SpyCategoryTreeStorage;
use Orm\Zed\Store\Persistence\SpyStoreQuery;
use Spryker\Shared\Kernel\Store;
use Spryker\Shared\Log\LoggerTrait;
use Spryker\Zed\CategoryStorage\Business\Storage\CategoryTreeStorage as SprykerCategoryTreeStorage;
use Spryker\Zed\CategoryStorage\Dependency\Service\CategoryStorageToUtilSanitizeServiceInterface;
use Spryker\Zed\CategoryStorage\Persistence\CategoryStorageQueryContainerInterface;


class CategoryTreeStorage extends SprykerCategoryTreeStorage
{
    use LoggerTrait;

    protected $rootCategoryNode;


    /**
     * @param \Spryker\Zed\CategoryStorage\Persistence\CategoryStorageQueryContainerInterface $queryContainer
     * @param \Spryker\Zed\CategoryStorage\Dependency\Service\CategoryStorageToUtilSanitizeServiceInterface $utilSanitize
     * @param \Spryker\Shared\Kernel\Store $store
     * @param bool $isSendingToQueue
     */
    public function __construct(CategoryStorageQueryContainerInterface $queryContainer, CategoryStorageToUtilSanitizeServiceInterface $utilSanitize, Store $store, $isSendingToQueue)
    {
        $this->queryContainer = $queryContainer;
        $this->utilSanitize = $utilSanitize;
        $this->store = $store;
        $this->isSendingToQueue = $isSendingToQueue;
        $this->rootCategoryNode = $queryContainer->queryCategoryRoot()->findOne();
    }


    /**
     * @param \Generated\Shared\Transfer\CategoryNodeStorageTransfer[] $categoryNodeStorageTransfers
     * @param string $localeName
     * @param \Orm\Zed\CategoryStorage\Persistence\SpyCategoryTreeStorage|null $spyCategoryTreeStorage
     *
     * @return void
     */
    protected function storeDataSet(array $categoryNodeStorageTransfers, $localeName, ?SpyCategoryTreeStorage $spyCategoryTreeStorage = null)
    {
        if ($spyCategoryTreeStorage === null) {
            $spyCategoryTreeStorage = new SpyCategoryTreeStorage();
        }

        $categoryTreeStorageTransfer = new CategoryTreeStorageTransfer();
        foreach ($categoryNodeStorageTransfers as $categoryNodeStorageTransfer) {
            $categoryTreeStorageTransfer->addCategoryNodeStorage($categoryNodeStorageTransfer);
        }

        $data = $this->utilSanitize->arrayFilterRecursive($categoryTreeStorageTransfer->toArray());
        $spyCategoryTreeStorage->setLocale($localeName);
        $spyCategoryTreeStorage->setStore($this->getStoreName($this->rootCategoryNode));
        $spyCategoryTreeStorage->setData($data);
        $spyCategoryTreeStorage->setIsSendingToQueue($this->isSendingToQueue);
        $spyCategoryTreeStorage->save();
    }

    /**
     * Retreieve Store Name
     *
     * @param \Orm\Zed\Category\Persistence\SpyCategoryNode $categoyNodeEntity
     *
     * @return string
     */
    protected function getStoreName(SpyCategoryNode $categoryNodeEntity)
    {
        $storeEntity = SpyStoreQuery::create()
            ->filterByIdStore($categoryNodeEntity->getFkStore())
            ->findOne();

        return $storeEntity->getName();
    }
}
