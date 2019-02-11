<?php

namespace FondOfSpryker\Zed\CategoryStoreStorage\Communication\Plugin\Event\Listener;

use Spryker\Shared\Log\LoggerTrait;
use Spryker\Zed\Category\Dependency\CategoryEvents;
use Spryker\Zed\PropelOrm\Business\Transaction\DatabaseTransactionHandlerTrait;

use Spryker\Zed\CategoryStorage\Communication\Plugin\Event\Listener\CategoryTreeStorageListener as SprykerCategoryTreeStorageListener;

/**
 * @method \Spryker\Zed\CategoryStorage\Persistence\CategoryStorageQueryContainerInterface getQueryContainer()
 * @method \Spryker\Zed\CategoryStorage\Communication\CategoryStorageCommunicationFactory getFactory()
 * @method \FondOfSpryker\Zed\CategoryStoreStorage\Business\CategoryStoreStorageFacadeInterface getFacade()
 * @method \Spryker\Zed\CategoryStorage\CategoryStorageConfig getConfig()
 */
class CategoryTreeStoreStorageListener extends SprykerCategoryTreeStorageListener
{
    use DatabaseTransactionHandlerTrait;

    use LoggerTrait;

    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\EventEntityTransfer[] $eventTransfers
     * @param string $eventName
     *
     * @return void
     */
    public function handleBulk(array $eventTransfers, $eventName)
    {
        $this->preventTransaction();
        if ($eventName === CategoryEvents::CATEGORY_TREE_UNPUBLISH
        ) {
            $this->getFacade()->unpublishCategoryTree();

            return;
        }

        $this->getFacade()->publishCategoryTree();
    }
}
