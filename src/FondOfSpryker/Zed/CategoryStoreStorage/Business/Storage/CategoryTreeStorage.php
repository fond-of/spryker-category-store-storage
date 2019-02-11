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

    /**
     * @return void
     */
    public function publish()
    {
        $categoryTrees = $this->getCategoryTrees();
        $spyCategoryStorageEntities = $this->findCategoryStorageEntities();

        foreach ($categoryTrees as $idStore => $categoryTree) {
            $spyCategoryStoreStorageEntities = (isset( $spyCategoryStorageEntities[$idStore])) ? $spyCategoryStorageEntities[$idStore] : array();
            $this->storeDataByStoreAndLocale($categoryTree, $spyCategoryStoreStorageEntities, $idStore);
        }
    }

    /**
     * @param array $categoryTrees
     * @param array $spyCategoryStorageEntities
     *
     * @return void
     */
    protected function storeDataByStoreAndLocale(array $categoryTree, array $spyCategoryStoreStorageEntities, int $idStore)
    {
        foreach ($categoryTree as $localeName => $categoryTreeByStoreAndLocale) {
            if (isset($spyCategoryStoreStorageEntities[$localeName])) {
                $this->storeDataSetByStoreAndLocale($categoryTreeByStoreAndLocale, $idStore, $localeName, $spyCategoryStoreStorageEntities[$localeName]);
                continue;
            }

            $this->storeDataSetByStoreAndLocale($categoryTreeByStoreAndLocale, $idStore, $localeName);
        }
    }

    /**
     * @param \Generated\Shared\Transfer\CategoryNodeStorageTransfer[] $categoryNodeStorageTransfers
     * @param int $idStore
     * @param string $localeName
     * @param \Orm\Zed\CategoryStorage\Persistence\SpyCategoryTreeStorage|null $spyCategoryTreeStorage
     *
     * @return void
     */
    protected function storeDataSetByStoreAndLocale(array $categoryNodeStorageTransfers, $idStore, $localeName, ?SpyCategoryTreeStorage $spyCategoryTreeStorage = null)
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
        $spyCategoryTreeStorage->setStore($this->getStoreName($idStore));
        $spyCategoryTreeStorage->setData($data);
        $spyCategoryTreeStorage->setIsSendingToQueue($this->isSendingToQueue);
        $spyCategoryTreeStorage->save();
    }

    /**
     * @return array
     */
    protected function findCategoryStorageEntities(): array
    {
        $spyCategoryStorageEntities = $this->queryContainer->queryCategoryStorage()->find();
        $categoryStorageEntitiesByStoreAndLocale = [];
        $stores = $this->getAllStoresMappedByName();

        foreach ($spyCategoryStorageEntities as $spyCategoryStorageEntity) {
            $categoryStorageEntitiesByStoreAndLocale[$stores[$spyCategoryStorageEntity->getStore()]][$spyCategoryStorageEntity->getLocale()] = $spyCategoryStorageEntity;
        }

        return $categoryStorageEntitiesByStoreAndLocale;
    }

    /**
     * @return array
     */
    protected function getCategoryTrees(): array
    {
        $localeNames = $this->store->getLocales();
        $locales = $this->queryContainer->queryLocalesWithLocaleNames($localeNames)->find();
        $categoryNodeTree = [];
        $rootCategories = $this->queryContainer->queryCategoryRoot()->find();

        foreach ($rootCategories as $category) {
            $this->disableInstancePooling();
            foreach ($locales as $locale) {
                $categoryNodes = $this->queryContainer->queryCategoryNodeTree($locale->getIdLocale())->find()->getData();
                $categoryNodeTree[$category->getFkStore()][$locale->getLocaleName()] = $this->getChildren($category->getPrimaryKey(), $categoryNodes);
            }
            $this->enableInstancePooling();
        }

        return $categoryNodeTree;
    }

    /**
     * Retreieve Store Name
     *
     * @param \Orm\Zed\Category\Persistence\SpyCategoryNode $categoyNodeEntity
     *
     * @return string
     */
    protected function getStoreName(int $idStore): string
    {
        $storeEntity = SpyStoreQuery::create()
            ->filterByIdStore($idStore)
            ->findOne();

        return $storeEntity->getName();
    }

    /**
     * Retrieve Store list using as key the Store Name
     *
     * @return array
     */
    protected function getAllStoresMappedByName(): array
    {
        $mappedStores = [];
        $stores = SpyStoreQuery::create()
            ->find();

        foreach ($stores as $store) {
            $mappedStores[$store->getName()] = $store->getIdStore();
        }

        return $mappedStores;
    }
}
