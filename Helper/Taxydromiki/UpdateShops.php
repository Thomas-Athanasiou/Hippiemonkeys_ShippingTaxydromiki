<?php
    /**
     * @author Thomas Athanasiou at Hippiemonkeys | @Thomas-Athanasiou
     * @copyright Copyright (c) 2022 Hippiemonkeys (https://hippiemonkeys.com)
     * @package Hippiemonkeys_ShippingTaxydromiki
     */

    declare(strict_types=1);

    namespace Hippiemonkeys\ShippingTaxydromiki\Helper\Taxydromiki;

    use Psr\Log\LoggerInterface,
        Hippiemonkeys\Core\Api\Helper\ConfigInterface,
        Hippiemonkeys\ShippingTaxydromiki\Api\CarrierInterface,
        Hippiemonkeys\ShippingTaxydromiki\Api\ShopManagementInterface,
        Hippiemonkeys\ShippingTaxydromiki\Api\Helper\Taxydromiki\UpdateShopsInterface,
        Hippiemonkeys\ShippingTaxydromiki\Helper\Taxydromiki,
        Hippiemonkeys\ShippingTaxydromiki\Exception\ServiceException;

    class UpdateShops
    extends Taxydromiki
    implements UpdateShopsInterface
    {
        /**
         * @param \Psr\Log\LoggerInterface $logger
         * @param \Hippiemonkeys\Core\Api\Helper\ConfigInterface $config
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\CarrierInterface $carrier
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\ShopManagementInterface $shopManagement
         */
        public function __construct(
            LoggerInterface $logger,
            ConfigInterface $config,
            CarrierInterface $carrier,
            ShopManagementInterface $shopManagement
        )
        {
            parent::__construct($logger, $config, $carrier);
            $this->_shopManagement = $shopManagement;
        }

        /**
         * @inheritdoc
         *
         * @throws \Hippiemonkeys\ShippingTaxydromiki\Exception\ServiceException
         */
        public function updateShops(): void
        {
            $getShopsListResult = $this->getCarrier()->getShopsList()->GetShopsListResult;
            $resultCode = $getShopsListResult->Result;
            if($resultCode === CarrierInterface::RESULT_CODE_SUCCESS)
            {
                $soapShops = $getShopsListResult->Shops->Shop ?? [];
                $shopManagement = $this->getShopManagement();
                $shopManagement->saveShops($soapShops);
                $shopManagement->cleanPersistentShops($soapShops);
            }
            else
            {
                throw new ServiceException(
                    __('Unable to update geniki shops, Geniki service replied with code: %1', $resultCode)
                );
            }
        }

        /**
         * Shop Management property
         *
         * @var \Hippiemonkeys\ShippingTaxydromiki\Api\ShopManagementInterface
         */
        private $_shopManagement;

        /**
         * Gets Shop Management
         *
         * @return \Hippiemonkeys\ShippingTaxydromiki\Api\ShopManagementInterface
         */
        protected function getShopManagement(): ShopManagementInterface
        {
            return $this->_shopManagement;
        }
    }
?>