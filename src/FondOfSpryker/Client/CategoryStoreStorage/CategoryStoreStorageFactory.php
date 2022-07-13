<?php

namespace FondOfSpryker\Client\CategoryStoreStorage;

use FondOfSpryker\Client\CategoryStoreStorage\Storage\CategoryNodeStorage;
use Spryker\Client\CategoryStorage\CategoryStorageFactory as SprykerCategoryStorageFactory;
use Spryker\Client\CategoryStorage\Storage\CategoryNodeStorageInterface;

class CategoryStoreStorageFactory extends SprykerCategoryStorageFactory
{
    /**
     * @return \Spryker\Client\CategoryStorage\Storage\CategoryNodeStorageInterface
     */
    public function createCategoryNodeStorage(): CategoryNodeStorageInterface
    {
        return new CategoryNodeStorage(
            $this->getStorageClient(),
            $this->getSynchronizationService()
        );
    }
}
