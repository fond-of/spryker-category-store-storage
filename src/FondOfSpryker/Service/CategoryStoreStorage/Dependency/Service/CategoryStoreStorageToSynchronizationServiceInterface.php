<?php

namespace FondOfSpryker\Service\CategoryStoreStorage\Dependency\Service;

use Spryker\Service\Synchronization\Dependency\Plugin\SynchronizationKeyGeneratorPluginInterface;

interface CategoryStoreStorageToSynchronizationServiceInterface
{
    /**
     * @param string $resourceName
     *
     * @return \Spryker\Service\Synchronization\Dependency\Plugin\SynchronizationKeyGeneratorPluginInterface
     */
    public function getStorageKeyBuilder(string $resourceName): SynchronizationKeyGeneratorPluginInterface;
}
