<?php
    /**
     * @author Thomas Athanasiou at Hippiemonkeys
     * @copyright Copyright (c) 2022 Hippiemonkeys (https://hippiemonkeys.com)
     * @package Hippiemonkeys_ShippingTaxydromikiHelperjob
     */

    declare(strict_types=1);

    namespace Hippiemonkeys\ShippingTaxydromiki\Helper;

    use Psr\Log\LoggerInterface,
        Magento\Framework\App\Helper\AbstractHelper,
        Hippiemonkeys\Core\Api\Helper\ConfigInterface,
        Hippiemonkeys\ShippingTaxydromiki\Api\CarrierInterface,
        Hippiemonkeys\ShippingTaxydromiki\Api\Helper\TaxydromikiInterface;

    class Taxydromiki
    extends AbstractHelper
    implements TaxydromikiInterface
    {
        /**
         * @param \Psr\Log\LoggerInterface $logger
         * @param \Hippiemonkeys\Core\Api\Helper\ConfigInterface $config
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\CarrierInterface $carrier
         */
        public function __construct(
            LoggerInterface $logger,
            ConfigInterface $config,
            CarrierInterface $carrier
        )
        {
            $this->_logger  = $logger;
            $this->_config  = $config;
            $this->_carrier = $carrier;
        }

        /**
         * Config property
         *
         * @var \Hippiemonkeys\Core\Api\Helper\ConfigInterface
         */
        private $_config;

        /**
         * @inheritdoc
         */
        public function getConfig(): ConfigInterface
        {
            return $this->_config;
        }

        /**
         * Carrier property
         *
         * @var \Hippiemonkeys\ShippingTaxydromiki\Api\CarrierInterface
         */
        private $_carrier;

        /**
         * @inheritdoc
         */
        public function getCarrier(): CarrierInterface
        {
            return $this->_carrier;
        }

        /**
         * @inheritdoc
         */
        public function getActive(): bool
        {
            return $this->getConfig()->getFlag('active');
        }

        /**
         * Gets Logger
         */
        protected function getLogger(): LoggerInterface
        {
            return $this->_logger;
        }
    }
?>