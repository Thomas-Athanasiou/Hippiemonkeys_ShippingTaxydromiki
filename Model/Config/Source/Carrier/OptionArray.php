<?php
    /**
     * @author Thomas Athanasiou at Hippiemonkeys
     * @copyright Copyright (c) 2022 Hippiemonkeys (https://hippiemonkeys.com)
     * @package Hippiemonkeys_ShippingTaxydromiki
     */

    declare(strict_types=1);

    namespace Hippiemonkeys\ShippingTaxydromiki\Model\Config\Source\Carrier;

    use Magento\Framework\Option\ArrayInterface;

    class OptionArray
    implements ArrayInterface
    {
        /**
         * @param array $optionArray
         */
        public function __construct(
            array $optionArray
        )
        {
            $this->_optionArray = $optionArray;
        }

        /**
         * @inheritdoc
         */
        public function toOptionArray()
        {
            return $this->getOptionArray();
        }

        /**
         * Option Array Property
         *
         * @var array
         */
        private $_optionArray;

        /**
         * Gets Option Array
         *
         * @return array
         */
        protected function getOptionArray(): array
        {
            return $this->_optionArray;
        }
    }
?>