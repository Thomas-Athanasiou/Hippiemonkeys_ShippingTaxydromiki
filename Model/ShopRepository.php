<?php
    /**
     * @author Thomas Athanasiou at Hippiemonkeys | @Thomas-Athanasiou
     * @copyright Copyright (c) 2022 Hippiemonkeys (https://hippiemonkeys.com)
     * @package Hippiemonkeys_ShippingTaxydromiki
     */

    declare(strict_types=1);

    namespace Hippiemonkeys\ShippingTaxydromiki\Model;

    use Magento\Framework\Api\SearchCriteriaInterface,
        Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface,
        Hippiemonkeys\ShippingTaxydromiki\Model\ResourceModel\Shop as ResourceModel,
        Hippiemonkeys\ShippingTaxydromiki\Exception\NoSuchEntityException,
        Hippiemonkeys\ShippingTaxydromiki\Api\Data\ShopSearchResultInterfaceFactory as SearchResultInterfaceFactory,
        Hippiemonkeys\ShippingTaxydromiki\Api\Data\ShopInterface,
        Hippiemonkeys\ShippingTaxydromiki\Api\Data\ShopInterfaceFactory,
        Hippiemonkeys\ShippingTaxydromiki\Api\Data\ShopSearchResultInterface,
        Hippiemonkeys\ShippingTaxydromiki\Api\ShopRepositoryInterface;

    class ShopRepository
    implements ShopRepositoryInterface
    {
        protected
            $_idIndex = [];

        /**
         * @param \Hippiemonkeys\ShippingTaxydromiki\Model\ResourceModel\Shop
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\Data\ShopInterfaceFactory
         * @param \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\Data\ShopSearchResultInterface
         */
        public function __construct(
            ResourceModel $resourceModel,
            ShopInterfaceFactory $shopFactory,
            CollectionProcessorInterface $collectionProcessor,
            SearchResultInterfaceFactory $searchResulFactory
        )
        {
            $this->_resourceModel       = $resourceModel;
            $this->_shopFactory         = $shopFactory;
            $this->_collectionProcessor = $collectionProcessor;
            $this->_searchResultFactory = $searchResulFactory;
        }

        /**
         * @inheritdoc
         *
         * @throws \Hippiemonkeys\ShippingTaxydromiki\Exception\NoSuchEntityException
         */
        public function getById($id) : ShopInterface
        {
            $shop = $this->_idIndex[$id] ?? null;
            if(!$shop) {
                $shop = $this->getShopFactory()->create();
                $this->getResourceModel()->load($shop, $id, ResourceModel::FIELD_ID);
                if (!$shop->getId())
                {
                    throw new NoSuchEntityException(
                        __('The Shop with ID "%1" that was requested doesn\'t exist. Verify the Shop and try again.', $id)
                    );
                }
                $this->_idIndex[$id] = $shop;
            }
            return $shop;
        }

        /**
         * @inheritdoc
         */
        public function getList(SearchCriteriaInterface $searchCriteria): ShopSearchResultInterface
        {
            $searchResult = $this->getSearchResultFactory()->create();
            $searchResult->setSearchCriteria($searchCriteria);
            $this->getCollectionProcessor()->process($searchCriteria, $searchResult);
            return $searchResult;
        }

        /**
         * @inheritdoc
         */
        public function save(ShopInterface $shop) : ShopInterface
        {
            $this->getResourceModel()->save($shop);
            $this->_idIndex[ $shop->getId() ] = $shop;
            return $shop;
        }

        /**
         * @inheritdoc
         */
        public function delete(ShopInterface $shop) : bool
        {
            $this->getResourceModel()->delete($shop);
            unset($this->_idIndex[ $shop->getId() ]);
            return $shop->isDeleted();
        }

        /**
         * Resource Model property
         *
         * @var \Hippiemonkeys\ShippingTaxydromiki\Model\ResourceModel\Shop
         */
        private $_resourceModel;

        /**
         * Gets Resource Model
         *
         * @return \Hippiemonkeys\ShippingTaxydromiki\Model\ResourceModel\Shop
         */
        protected function getResourceModel(): ResourceModel
        {
            return $this->_resourceModel;
        }

        /**
         * Shop Factory property
         *
         * @var \Hippiemonkeys\ShippingTaxydromiki\Api\Data\ShopInterfaceFactory
         */
        private $_shopFactory;

        /**
         * Gets Shop Factory
         *
         * @return \Hippiemonkeys\ShippingTaxydromiki\Api\Data\ShopInterfaceFactory
         */
        protected function getShopFactory() : ShopInterfaceFactory
        {
            return $this->_shopFactory;
        }

        /**
         * Collection Processor property
         *
         * @var \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface
         */
        private $_collectionProcessor;

        /**
         * Gets Collection Processor
         *
         * @return \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface
         */
        protected function getCollectionProcessor() : CollectionProcessorInterface
        {
            return $this->_collectionProcessor;
        }

        /**
         * Search Result Factory property
         *
         * @var \Hippiemonkeys\ShippingTaxydromiki\Api\Data\SearchResultInterfaceFactory
         */
        private $_searchResultFactory;

        /**
         * Gets Search Result Factory
         *
         * @return \Hippiemonkeys\ShippingTaxydromiki\Api\Data\SearchResultInterfaceFactory
         */
        protected function getSearchResultFactory(): SearchResultInterfaceFactory
        {
            return $this->_searchResultFactory;
        }
    }
?>