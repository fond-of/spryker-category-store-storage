<?php

namespace FondOfSpryker\Client\CategoryStoreStorage\Plugin;

use Generated\Shared\Transfer\SynchronizationDataTransfer;
use Spryker\Client\CategoryStorage\CategoryStorageConfig;
use Spryker\Client\CategoryStorage\Plugin\UrlStorageCategoryNodeMapperPlugin as SprykerUrlStorageCategoryNodeMapperPlugin;
use Spryker\Shared\CategoryStorage\CategoryStorageConstants;
use Spryker\Shared\Kernel\Store;

/**
 * @method \Spryker\Client\CategoryStorage\CategoryStorageFactory getFactory()
 */
class UrlStorageCategoryNodeMapperPlugin extends SprykerUrlStorageCategoryNodeMapperPlugin
{
    /**
     * @param int $idCategoryNode
     * @param string $locale
     *
     * @return string
     */
    protected function generateKey($idCategoryNode, $locale)
    {
        if (CategoryStorageConfig::isCollectorCompatibilityMode()) {
            $collectorDataKey = sprintf(
                '%s.%s.resource.categorynode.%s',
                strtolower(Store::getInstance()->getStoreName()),
                strtolower($locale),
                $idCategoryNode
            );

            return $collectorDataKey;
        }

        $storeName = Store::getInstance()->getStoreName();
        $synchronizationDataTransfer = new SynchronizationDataTransfer();
        $synchronizationDataTransfer->setLocale($locale);
        $synchronizationDataTransfer->setStore($storeName);
        $synchronizationDataTransfer->setReference($idCategoryNode);

        return $this->getFactory()->getSynchronizationService()->getStorageKeyBuilder(CategoryStorageConstants::CATEGORY_NODE_RESOURCE_NAME)->generateKey($synchronizationDataTransfer);
    }
}
