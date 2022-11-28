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

    namespace Hippiemonkeys\ShippingTaxydromiki\Helper;

    use Psr\Log\LoggerInterface,
        Magento\Framework\App\Helper\Context,
        Magento\Framework\App\Helper\AbstractHelper,
        Hippiemonkeys\Core\Api\Helper\ConfigInterface,
        Hippiemonkeys\ShippingTaxydromiki\Api\CarrierInterface,
        Hippiemonkeys\ShippingTaxydromiki\Api\Helper\TaxydromikiInterface;

    class Taxydromiki
    extends AbstractHelper
    implements TaxydromikiInterface
    {
        /**
         * Constructor
         *
         * @access public
         *
         * @param \Magento\Framework\App\Helper\Context $context
         * @param \Hippiemonkeys\Core\Api\Helper\ConfigInterface $config
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\CarrierInterface $carrier
         */
        public function __construct(
            Context $context,
            ConfigInterface $config,
            CarrierInterface $carrier
        )
        {
            parent::__construct($context);
            $this->_config  = $config;
            $this->_carrier = $carrier;
        }

        /**
         * Config property
         *
         * @access private
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
         * @access private
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
         *
         * @access protected
         *
         * @return \Psr\Log\LoggerInterface
         */
        protected function getLogger(): LoggerInterface
        {
            return $this->_logger;
        }
    }
?>