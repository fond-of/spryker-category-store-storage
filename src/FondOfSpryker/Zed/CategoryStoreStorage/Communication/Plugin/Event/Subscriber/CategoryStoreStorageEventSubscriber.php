<?php

namespace FondOfSpryker\Zed\CategoryStoreStorage\Communication\Plugin\Event\Subscriber;

use FondOfSpryker\Zed\CategoryStoreStorage\Communication\Plugin\Event\Listener\CategoryNodeStoreStorageListener;
use Spryker\Zed\Category\Dependency\CategoryEvents;
use Spryker\Zed\CategoryStorage\Communication\Plugin\Event\Subscriber\CategoryStorageEventSubscriber as SprykerCategoryStorageEventSubscriber;
use Spryker\Zed\Event\Dependency\EventCollectionInterface;

class CategoryStoreStorageEventSubscriber extends SprykerCategoryStorageEventSubscriber
{
    /**
     * @api
     *
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return \Spryker\Zed\Event\Dependency\EventCollectionInterface
     */
    public function getSubscribedEvents(EventCollectionInterface $eventCollection)
    {
        $this->addCategoryTreeEvents($eventCollection);

        $this->addCategoryNodePublishListener($eventCollection);
        $this->addCategoryNodeUnpublishListener($eventCollection);
        $this->addCategoryNodeCreateListener($eventCollection);
        $this->addCategoryNodeUpdateListener($eventCollection);
        $this->addCategoryNodeDeleteListener($eventCollection);
        $this->addCategoryCreateListener($eventCollection);
        $this->addCategoryUpdateListener($eventCollection);
        $this->addCategoryDeleteListener($eventCollection);
        $this->addCategoryAttributeUpdateListener($eventCollection);
        $this->addCategoryAttributeCreateListener($eventCollection);
        $this->addCategoryAttributeDeleteListener($eventCollection);
        $this->addCategoryTemplateCreateListener($eventCollection);
        $this->addCategoryTemplateUpdateListener($eventCollection);
        $this->addCategoryTemplateDeleteListener($eventCollection);

        return $eventCollection;
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     *
     */
    protected function addCategoryNodePublishListener(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(CategoryEvents::CATEGORY_NODE_PUBLISH, new CategoryNodeStoreStorageListener());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addCategoryNodeUnpublishListener(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(CategoryEvents::CATEGORY_NODE_UNPUBLISH, new CategoryNodeStoreStorageListener());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addCategoryNodeCreateListener(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(CategoryEvents::ENTITY_SPY_CATEGORY_NODE_CREATE, new CategoryNodeStoreStorageListener());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addCategoryNodeUpdateListener(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(CategoryEvents::ENTITY_SPY_CATEGORY_NODE_UPDATE, new CategoryNodeStoreStorageListener());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addCategoryNodeDeleteListener(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(CategoryEvents::ENTITY_SPY_CATEGORY_NODE_DELETE, new CategoryNodeStoreStorageListener());
    }
}
