<?php

namespace FondOfSpryker\Client\CategoryStoreStorage;

use FondOfSpryker\Client\CategoryStoreStorage\Storage\CategoryNodeStorage;
use Spryker\Client\CategoryStorage\CategoryStorageFactory as SprykerCategoryStorageFactory;

class CategoryStoreStorageFactory extends SprykerCategoryStorageFactory
{
    /**
     * @return \FondOfSpryker\Client\CategoryStorerStorage\Storage\CategoryNodeStorageInterface
     */
    public function createCategoryNodeStorage()
    {
        return new CategoryNodeStorage(
            $this->getStorage(),
            $this->getSynchronizationService()
        );
    }
}
