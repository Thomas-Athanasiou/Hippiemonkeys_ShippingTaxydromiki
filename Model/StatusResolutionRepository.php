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
        Hippiemonkeys\ShippingTaxydromiki\Model\Spi\StatusResolutionResourceInterface,
        Hippiemonkeys\ShippingTaxydromiki\Exception\NoSuchEntityException,
        Hippiemonkeys\ShippingTaxydromiki\Api\Data\StatusResolutionSearchResultInterfaceFactory as SearchResultInterfaceFactory,
        Hippiemonkeys\ShippingTaxydromiki\Api\Data\StatusResolutionInterface,
        Hippiemonkeys\ShippingTaxydromiki\Api\Data\StatusResolutionInterfaceFactory,
        Hippiemonkeys\ShippingTaxydromiki\Api\Data\StatusResolutionSearchResultInterface,
        Hippiemonkeys\ShippingTaxydromiki\Api\StatusResolutionRepositoryInterface;

    class StatusResolutionRepository
    implements StatusResolutionRepositoryInterface
    {
        /**
         * Id index property
         *
         * @access protected
         *
         * @var \Hippiemonkeys\ShippingTaxydromiki\Api\Data\StatusResolutionInterface[] $_idCache
         */
        protected $_idCache = [];

        /**
         * Code index property
         *
         * @access protected
         *
         * @var \Hippiemonkeys\ShippingTaxydromiki\Api\Data\StatusResolutionInterface[] $_codeCache
         */
        protected $_codeCache = [];

        /**
         * Constructor
         *
         * @access public
         *
         * @param \Hippiemonkeys\ShippingTaxydromiki\Model\Spi\StatusResolutionResourceInterface $statusResolutionResource
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\Data\StatusResolutionInterfaceFactory $statusResolutionFactory
         * @param \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\Data\StatusResolutionSearchResultInterface $searchResulFactory
         */
        public function __construct(
            StatusResolutionResourceInterface $statusResolutionResource,
            StatusResolutionInterfaceFactory $statusResolutionFactory,
            CollectionProcessorInterface $collectionProcessor,
            SearchResultInterfaceFactory $searchResulFactory
        )
        {
            $this->_statusResolutionResource = $statusResolutionResource;
            $this->_statusResolutionFactory = $statusResolutionFactory;
            $this->_collectionProcessor = $collectionProcessor;
            $this->_searchResultFactory = $searchResulFactory;
        }

        /**
         * {@inheritdoc}
         *
         * @throws \Hippiemonkeys\ShippingTaxydromiki\Exception\NoSuchEntityException
         */
        public function getById($id) : StatusResolutionInterface
        {
            $statusResolution = $this->_idCache[$id] ?? null;
            if($statusResolution === null)
            {
                $statusResolution = $this->getStatusResolutionFactory()->create();
                $this->getStatusResolutionResource()->loadStatusResolutionById($statusResolution, $id);
                if ($statusResolution->getId() === null)
                {
                    throw new NoSuchEntityException(
                        __('The StatusResolution with ID "%1" that was requested doesn\'t exist. Verify the StatusResolution and try again.', $id)
                    );
                }
                else
                {
                    $this->_idCache[$id] = $statusResolution;
                    $this->_codeCache[$statusResolution->getCode()] = $statusResolution;
                }
            }
            return $statusResolution;
        }

        /**
         * {@inheritdoc}
         *
         * @throws \Hippiemonkeys\ShippingTaxydromiki\Exception\NoSuchEntityException
         */
        public function getByCode(string $code) : StatusResolutionInterface
        {
            $statusResolution = $this->_codeCache[$code] ?? null;
            if($statusResolution === null)
            {
                $statusResolution = $this->getStatusResolutionFactory()->create();
                $this->getStatusResolutionResource()->loadStatusResolutionByCode($statusResolution, $code);
                $id = $statusResolution->getId();
                if ($id === null)
                {
                    throw new NoSuchEntityException(
                        __('The StatusResolution with ID "%1" that was requested doesn\'t exist. Verify the StatusResolution and try again.', $id)
                    );
                }
                else
                {
                    $this->_idCache[$id] = $statusResolution;
                    $this->_codeCache[$code] = $statusResolution;
                }
            }
            return $statusResolution;
        }

        /**
         * {@inheritdoc}
         */
        public function getList(SearchCriteriaInterface $searchCriteria): StatusResolutionSearchResultInterface
        {
            $searchResult = $this->getSearchResultFactory()->create();
            $searchResult->setSearchCriteria($searchCriteria);
            $this->getCollectionProcessor()->process($searchCriteria, $searchResult);
            return $searchResult;
        }

        /**
         * {@inheritdoc}
         */
        public function save(StatusResolutionInterface $statusResolution) : StatusResolutionInterface
        {
            $this->_idCache[$statusResolution->getId()] = $statusResolution;
            $this->_codeCache[$statusResolution->getCode()] = $statusResolution;
            $this->getStatusResolutionResource()->saveStatusResolution($statusResolution);
            return $statusResolution;
        }

        /**
         * {@inheritdoc}
         */
        public function delete(StatusResolutionInterface $statusResolution) : bool
        {
            unset($this->_idCache[$statusResolution->getId()]);
            unset($this->_codeCache[$statusResolution->getCode()]);
            return $this->getStatusResolutionResource()->deleteStatusResolution($statusResolution);
        }

        /**
         * StatusResolution Resource property
         *
         * @access private
         *
         * @var \Hippiemonkeys\ShippingTaxydromiki\Model\Spi\StatusResolutionResourceInterface $_statusResolutionResource
         */
        private $_statusResolutionResource;

        /**
         * Gets StatusResolution Resource
         *
         * @access protected
         *
         * @return \Hippiemonkeys\ShippingTaxydromiki\Model\Spi\StatusResolutionResourceInterface
         */
        protected function getStatusResolutionResource(): StatusResolutionResourceInterface
        {
            return $this->_statusResolutionResource;
        }

        /**
         * StatusResolution Factory property
         *
         * @access private
         *
         * @var \Hippiemonkeys\ShippingTaxydromiki\Api\Data\StatusResolutionInterfaceFactory
         */
        private $_statusResolutionFactory;

        /**
         * Gets StatusResolution Factory
         *
         * @access protected
         *
         * @return \Hippiemonkeys\ShippingTaxydromiki\Api\Data\StatusResolutionInterfaceFactory
         */
        protected function getStatusResolutionFactory() : StatusResolutionInterfaceFactory
        {
            return $this->_statusResolutionFactory;
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
         * @var \Hippiemonkeys\ShippingTaxydromiki\Api\Data\StatusResolutionSearchResultInterfaceFactory
         */
        private $_searchResultFactory;

        /**
         * Gets Search Result Factory
         *
         * @access protected
         *
         * @return \Hippiemonkeys\ShippingTaxydromiki\Api\Data\StatusResolutionSearchResultInterfaceFactory
         */
        protected function getSearchResultFactory(): SearchResultInterfaceFactory
        {
            return $this->_searchResultFactory;
        }
    }
?>