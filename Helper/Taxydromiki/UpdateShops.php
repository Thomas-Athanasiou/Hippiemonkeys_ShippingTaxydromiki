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

    namespace Hippiemonkeys\ShippingTaxydromiki\Helper\Taxydromiki;

    use Magento\Framework\App\Helper\Context,
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
         * Constructor
         *
         * @access public
         *
         * @param \Magento\Framework\App\Helper\Context $context
         * @param \Hippiemonkeys\Core\Api\Helper\ConfigInterface $config
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\CarrierInterface $carrier
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\ShopManagementInterface $shopManagement
         */
        public function __construct(
            Context $context,
            ConfigInterface $config,
            CarrierInterface $carrier,
            ShopManagementInterface $shopManagement
        )
        {
            parent::__construct($context, $config, $carrier);
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
         * @access private
         *
         * @var \Hippiemonkeys\ShippingTaxydromiki\Api\ShopManagementInterface
         */
        private $_shopManagement;

        /**
         * Gets Shop Management
         *
         * @access protected
         *
         * @return \Hippiemonkeys\ShippingTaxydromiki\Api\ShopManagementInterface
         */
        protected function getShopManagement(): ShopManagementInterface
        {
            return $this->_shopManagement;
        }
    }
?>