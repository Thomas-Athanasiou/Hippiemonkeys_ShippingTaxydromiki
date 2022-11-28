<?php
    /**
     * @Thomas-Athanasiou
     *
     * @author Thomas Athanasiou {thomas@hippiemonkeys.com}
     * @link https://hippiemonkeys.com
     * @link https://github.com/Thomas-Athanasiou
     * @copyright Copyright (c) 2022 Hippiemonkeys Web Inteligence EE All Rights Reserved.
     * @license http://www.gnu.org/licenses/ GNU General Public License, version 3
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
        /**
         * Id index property
         *
         * @access protected
         *
         * @var \Hippiemonkeys\ShippingTaxydromiki\Api\Data\ShopInterface[] $_idCache
         */
        protected $_idCache = [];

        /**
         * Constructor
         *
         * @access public
         *
         * @param \Hippiemonkeys\ShippingTaxydromiki\Model\ResourceModel\Shop $resourceModel
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\Data\ShopInterfaceFactory $shopFactory
         * @param \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\Data\ShopSearchResultInterface $searchResulFactory
         */
        public function __construct(
            ResourceModel $resourceModel,
            ShopInterfaceFactory $shopFactory,
            CollectionProcessorInterface $collectionProcessor,
            SearchResultInterfaceFactory $searchResulFactory
        )
        {
            $this->_resourceModel = $resourceModel;
            $this->_shopFactory = $shopFactory;
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
            $shop = $this->_idCache[$id] ?? null;
            if(!$shop)
            {
                $shop = $this->getShopFactory()->create();
                $this->getResourceModel()->load($shop, $id, ResourceModel::FIELD_ID);
                if (!$shop->getId())
                {
                    throw new NoSuchEntityException(
                        __('The Shop with ID "%1" that was requested doesn\'t exist. Verify the Shop and try again.', $id)
                    );
                }
                $this->_idCache[$id] = $shop;
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
            $this->_idCache[ $shop->getId() ] = $shop;
            return $shop;
        }

        /**
         * @inheritdoc
         */
        public function delete(ShopInterface $shop) : bool
        {
            $this->getResourceModel()->delete($shop);
            unset($this->_idCache[ $shop->getId() ]);
            return $shop->isDeleted();
        }

        /**
         * Resource Model property
         *
         * @access private
         *
         * @var \Hippiemonkeys\ShippingTaxydromiki\Model\ResourceModel\Shop
         */
        private $_resourceModel;

        /**
         * Gets Resource Model
         *
         * @access protected
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
         * @access private
         *
         * @var \Hippiemonkeys\ShippingTaxydromiki\Api\Data\ShopInterfaceFactory
         */
        private $_shopFactory;

        /**
         * Gets Shop Factory
         *
         * @access protected
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
         * @access private
         *
         * @var \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface
         */
        private $_collectionProcessor;

        /**
         * Gets Collection Processor
         *
         * @access protected
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
         * @access private
         *
         * @var \Hippiemonkeys\ShippingTaxydromiki\Api\Data\SearchResultInterfaceFactory
         */
        private $_searchResultFactory;

        /**
         * Gets Search Result Factory
         *
         * @access protected
         *
         * @return \Hippiemonkeys\ShippingTaxydromiki\Api\Data\SearchResultInterfaceFactory
         */
        protected function getSearchResultFactory(): SearchResultInterfaceFactory
        {
            return $this->_searchResultFactory;
        }
    }
?>