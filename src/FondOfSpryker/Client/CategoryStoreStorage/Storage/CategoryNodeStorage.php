<?php

namespace FondOfSpryker\Client\CategoryStoreStorage\Storage;

use Generated\Shared\Transfer\SynchronizationDataTransfer;
use Spryker\Client\CategoryStorage\Storage\CategoryNodeStorage as SprykerCategoryNodeStorage;
use Spryker\Shared\CategoryStorage\CategoryStorageConstants;

class CategoryNodeStorage extends SprykerCategoryNodeStorage implements CategoryNodeStorageInterface
{
    /**
     * @param int $idCategoryNode
     * @param string $localeName
     * @param string $storeName
     *
     * @return string
     */
    protected function generateKey(int $idCategoryNode, string $localeName, string $storeName): string
    {
        $synchronizationDataTransfer = new SynchronizationDataTransfer();
        $synchronizationDataTransfer->setReference($idCategoryNode);
        $synchronizationDataTransfer->setLocale($localeName);
        $synchronizationDataTransfer->setStore($storeName);

        return $this->synchronizationService->getStorageKeyBuilder(CategoryStorageConstants::CATEGORY_NODE_RESOURCE_NAME)->generateKey($synchronizationDataTransfer);
    }
}
