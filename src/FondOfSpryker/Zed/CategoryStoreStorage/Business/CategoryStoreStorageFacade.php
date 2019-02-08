<?php

namespace FondOfSpryker\Zed\CategoryStoreStorage\Business;

use Spryker\Zed\Kernel\Business\AbstractFacade;
use Spryker\Zed\CategoryStorage\Business\CategoryStorageFacade as SprykerCategoryStorageFacade;

/**
 * @method \FondOfSpryker\Zed\CategoryStoreStorage\Business\CategoryStoreStorageBusinessFactory getFactory()
 */
class CategoryStoreStorageFacade extends SprykerCategoryStorageFacade
{
    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param array $categoryNodeIds
     *
     * @return void
     */
    public function publish(array $categoryNodeIds)
    {
        $this->getFactory()->createCategoryNodeStorage()->publish($categoryNodeIds);
    }

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @return void
     */
    public function publishCategoryTree()
    {
        $this->getFactory()->createCategoryTreeStorage()->publish();
    }
}
