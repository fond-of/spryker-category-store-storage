<?php

namespace FondOfSpryker\Zed\CategoryStoreStorage\Business;

use FondOfSpryker\Zed\CategoryStoreStorage\Business\Storage\CategoryNodeStorage;
use Spryker\Zed\CategoryStorage\Business\CategoryStorageBusinessFactory as SprykerCategoryStorageBusinessFactory;

/**
 * @method \Spryker\Zed\CategoryStorage\CategoryStorageConfig getConfig()
 * @method \Spryker\Zed\CategoryStorage\Persistence\CategoryStorageQueryContainerInterface getQueryContainer()
 */
class CategoryStoreStorageBusinessFactory extends SprykerCategoryStorageBusinessFactory
{
    /**
     * @return \FondOfSpyker\Zed\CategoryStoreStorage\Business\Storage\CategoryNodeStorageInterface
     */
    public function createCategoryNodeStorage()
    {
        return new CategoryNodeStorage(
            $this->getQueryContainer(),
            $this->getUtilSanitizeService(),
            $this->getStore(),
            $this->getConfig()->isSendingToQueue()
        );
    }
}
