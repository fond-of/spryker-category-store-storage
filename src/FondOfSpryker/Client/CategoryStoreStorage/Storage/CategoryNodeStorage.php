<?php

namespace FondOfSpryker\Client\CategoryStoreStorage\Storage;

use Generated\Shared\Transfer\CategoryNodeStorageTransfer;
use Generated\Shared\Transfer\SynchronizationDataTransfer;
use Spryker\Client\CategoryStorage\Storage\CategoryNodeStorage as SprykerCategoryNodeStorage;
use Spryker\Shared\CategoryStorage\CategoryStorageConstants;
use Spryker\Shared\Kernel\Store;

class CategoryNodeStorage extends SprykerCategoryNodeStorage implements CategoryNodeStorageInterface
{
    /**
     * @param int $idCategoryNode
     * @param string $locale
     *
     * @return string
     */
    protected function generateKey($idCategoryNode, $locale)
    {
        $storeName = Store::getInstance()->getStoreName();
        $synchronizationDataTransfer = new SynchronizationDataTransfer();
        $synchronizationDataTransfer->setReference($idCategoryNode);
        $synchronizationDataTransfer->setLocale($locale);
        $synchronizationDataTransfer->setStore($storeName);

        return $this->synchronizationService->getStorageKeyBuilder(CategoryStorageConstants::CATEGORY_NODE_RESOURCE_NAME)->generateKey($synchronizationDataTransfer);
    }
}
