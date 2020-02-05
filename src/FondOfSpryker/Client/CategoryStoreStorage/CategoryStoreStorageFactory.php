<?php

namespace FondOfSpryker\Client\CategoryStoreStorage;

use FondOfSpryker\Client\CategoryStoreStorage\Storage\CategoryNodeStorage;
use Spryker\Client\CategoryStorage\CategoryStorageFactory as SprykerCategoryStorageFactory;

class CategoryStoreStorageFactory extends SprykerCategoryStorageFactory
{
    /**
     * @return \FondOfSpryker\Client\CategoryStoreStorage\Storage\CategoryNodeStorage|\Spryker\Client\CategoryStorage\Storage\CategoryNodeStorageInterface
     */
    public function createCategoryNodeStorage(): CategoryNodeStorage
    {
        return new CategoryNodeStorage(
            $this->getStorage(),
            $this->getSynchronizationService()
        );
    }
}
