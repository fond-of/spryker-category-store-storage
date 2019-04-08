<?php

namespace FondOfSpryker\Service\CategoryStoreStorage\Plugin\Synchronization;

use Generated\Shared\Transfer\SynchronizationDataTransfer;
use Spryker\Service\Kernel\AbstractPlugin;
use Spryker\Service\Synchronization\Dependency\Plugin\SynchronizationKeyGeneratorPluginInterface;

/**
 * @method \FondOfSpryker\Service\CategoryStoreStorage\CategoryStoreStorageServiceFactory getFactory()
 */
class CategoryStoreStorageSynchronizationKeyGeneratorPlugin extends AbstractPlugin implements SynchronizationKeyGeneratorPluginInterface
{
    /**
     * Specification:
     * - Generates storage or search key based on SynchronizationDataTransfer
     * for entities which use synchronization
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\SynchronizationDataTransfer $dataTransfer
     *
     * @return string
     */
    public function generateKey(SynchronizationDataTransfer $dataTransfer): string
    {
        if ($dataTransfer->getStore() === null) {
            $storeName = $this->getFactory()->getStore()->getStoreName();

            $dataTransfer->setStore($storeName);
        }

        return $this->getFactory()->getSynchronizationService()
            ->getStorageKeyBuilder('')
            ->generateKey($dataTransfer);
    }
}
