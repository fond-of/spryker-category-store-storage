<?php

namespace FondOfSpryker\Service\CategoryStoreStorage;

use FondOfSpryker\Service\CategoryStoreStorage\Dependency\Service\CategoryStoreStorageToSynchronizationServiceInterface;
use Spryker\Service\Kernel\AbstractServiceFactory;
use Spryker\Shared\Kernel\Store;

class CategoryStoreStorageServiceFactory extends AbstractServiceFactory
{
    /**
     * @return \Spryker\Shared\Kernel\Store
     */
    public function getStore(): Store
    {
        return $this->getProvidedDependency(CategoryStoreStorageDependencyProvider::STORE);
    }

    /**
     * @return \FondOfSpryker\Service\CategoryStoreStorage\Dependency\Service\CategoryStoreStorageToSynchronizationServiceInterface
     */
    public function getSynchronizationService(): CategoryStoreStorageToSynchronizationServiceInterface
    {
        return $this->getProvidedDependency(CategoryStoreStorageDependencyProvider::SERVICE_SYNCHRONIZATION);
    }
}
