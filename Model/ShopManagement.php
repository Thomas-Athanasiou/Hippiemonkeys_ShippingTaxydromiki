<?php
    /**
     * @author Thomas Athanasiou at Hippiemonkeys
     * @copyright Copyright (c) 2022 Hippiemonkeys (https://hippiemonkeys.com)
     * @package Hippiemonkeys_ShippingTaxydromikiCronjob
     */

    declare(strict_types=1);

    namespace Hippiemonkeys\ShippingTaxydromiki\Model;

    use Magento\Framework\Api\SearchCriteriaBuilderFactory,
        Hippiemonkeys\ShippingTaxydromiki\Api\CarrierInterface,
        Hippiemonkeys\ShippingTaxydromiki\Api\ShopManagementInterface,
        Hippiemonkeys\ShippingTaxydromiki\Api\ShopRepositoryInterface,
        Hippiemonkeys\ShippingTaxydromiki\Api\Data\ShopInterfaceFactory,
        Hippiemonkeys\ShippingTaxydromiki\Model\ResourceModel\Shop as ResourceModel;

    class ShopManagement
    implements ShopManagementInterface
    {
        protected const
            SHOP_SEARCH_PAGE_SIZE       = 4096,
            SHOP_SEARCH_CURRENT_PAGE    = 1;

        /**
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\CarrierInterface $carrier
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\Data\ShopInterfaceFactory $shopFactory
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\ShopRepositoryInterface $shopRepository
         * @param \Magento\Framework\Api\SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory
         */
        public function __construct(
            CarrierInterface $carrier,
            ShopInterfaceFactory $shopFactory,
            ShopRepositoryInterface $shopRepository,
            SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory
        )
        {
            $this->_carrier                         = $carrier;
            $this->_shopFactory                     = $shopFactory;
            $this->_shopRepository                  = $shopRepository;
            $this->_searchCriteriaBuilderFactory    = $searchCriteriaBuilderFactory;
        }

        /**
         * @inheritdoc
         */
        public function saveShops(array $soapShops): void
        {
            foreach($soapShops as $soapShop)
            {
                $this->saveShop($soapShop);
            }
        }

        /**
         * @inheritdoc
         */
        public function saveShop(object $soapShop): void
        {
            $shopFactory    = $this->getShopFactory();
            $shopRepository = $this->getShopRepository();

            $shopCode       = $soapShop->Code;
            $shopCode2      = $soapShop->Code2;
            $shopName       = $soapShop->Name;
            $shopCountry    = $soapShop->Country;
            $shopState      = $soapShop->State;
            $shopCity       = $soapShop->City;
            $shopAddress    = $soapShop->Address;

            $searchCriteriaBuilder = $this->getSearchCriteriaBuilderFactory()->create();
            $searchCriteriaBuilder->addFilter(ResourceModel::FIELD_CODE, $shopCode, 'eq');
            $searchCriteriaBuilder->addFilter(ResourceModel::FIELD_CODE2, $shopCode2, 'eq');
            $searchCriteriaBuilder->addFilter(ResourceModel::FIELD_NAME, $shopName, 'eq');
            $searchCriteriaBuilder->addFilter(ResourceModel::FIELD_COUNTRY, $shopCountry, 'eq');
            $searchCriteriaBuilder->addFilter(ResourceModel::FIELD_STATE, $shopState, 'eq');
            $searchCriteriaBuilder->addFilter(ResourceModel::FIELD_CITY, $shopCity, 'eq');
            $searchCriteriaBuilder->addFilter(ResourceModel::FIELD_ADDRESS, $shopAddress, 'eq');

            $shop = $shopRepository->getList( $searchCriteriaBuilder->create() )->getItems() [0] ?? $shopFactory->create();
            $shop->setCode($shopCode);
            $shop->setCode2($shopCode2);
            $shop->setName($shopName);
            $shop->setState($shopState);
            $shop->setCity($shopCity);
            $shop->setCountry($shopCountry);
            $shop->setAddress($shopAddress);
            $shop->setTelephone($soapShop->Telephone);
            $shop->setZip($soapShop->Zip);
            $shop->setEmail($soapShop->Email);
            $shop->setLongitude((float) ($soapShop->Longitude));
            $shop->setLatitude((float) ($soapShop->Latitude));
            $shop->setSubShop((bool) ($soapShop->SubShop));
            $shop->setActive((bool) ($soapShop->Active));

            $shopRepository->save($shop);
        }

        /**
         * @inheritdoc
         */
        public function cleanPersistentShops(array $soapShops): void
        {
            $searchCriteriaBuilder = $this->getSearchCriteriaBuilderFactory()->create();
            $searchCriteriaBuilder->setCurrentPage( self::SHOP_SEARCH_CURRENT_PAGE );
            $searchCriteriaBuilder->setPageSize( self::SHOP_SEARCH_PAGE_SIZE );

            $shopRepository = $this->getShopRepository();
            foreach($shopRepository->getList( $searchCriteriaBuilder->create() )->getItems() as $shop)
            {
                $found = false;

                $shopCode       = $shop->getCode();
                $shopCode2      = $shop->getCode2();
                $shopName       = $shop->getName();
                $shopCountry    = $shop->getCountry();
                $shopState      = $shop->getState();
                $shopCity       = $shop->getCity();
                $shopAddress    = $shop->getAddress();
                foreach($soapShops as $soapShop)
                {
                    if(
                        $soapShop->Code         === $shopCode
                        && $soapShop->Code2     === $shopCode2
                        && $soapShop->Name      === $shopName
                        && $soapShop->Country   === $shopCountry
                        && $soapShop->State     === $shopState
                        && $soapShop->City      === $shopCity
                        && $soapShop->Address   === $shopAddress
                    )
                    {
                        $found = true;
                        break;
                    }
                }
                if(!$found)
                {
                    $shopRepository->delete($shop);
                }
            }
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
         * @var \Hippiemonkeys\ShippingTaxydromiki\Api\Data\ShopInterfaceFactory
         */
        protected function getShopFactory(): ShopInterfaceFactory
        {
            return $this->_shopFactory;
        }

        /**
         * Shop Repository property
         *
         * @var \Hippiemonkeys\ShippingTaxydromiki\Api\ShopRepositoryInterface
         */
        private $_shopRepository;

        /**
         * Gets Shop Repository
         *
         * @return \Hippiemonkeys\ShippingTaxydromiki\Api\ShopRepositoryInterface
         */
        protected function getShopRepository(): ShopRepositoryInterface
        {
            return $this->_shopRepository;
        }

        /**
         * Search Criteria Factory property
         *
         * @var \Magento\Framework\Api\SearchCriteriaBuilderFactory
         */
        private $_searchCriteriaBuilderFactory;

        /**
         * Gets Search Criteria Factory
         *
         * @return \Magento\Framework\Api\SearchCriteriaBuilderFactory
         */
        protected function getSearchCriteriaBuilderFactory(): SearchCriteriaBuilderFactory
        {
            return $this->_searchCriteriaBuilderFactory;
        }

        /**
         * Carrier property
         *
         * @var \Hippiemonkeys\ShippingTaxydromiki\Api\CarrierInterface
         */
        private $_carrier;

        /**
         * Gets Carrier
         *
         * @return \Hippiemonkeys\ShippingTaxydromiki\Api\CarrierInterface
         */
        protected function getCarrier(): SearchCriteriaBuilderFactory
        {
            return $this->_carrier;
        }
    }
?>