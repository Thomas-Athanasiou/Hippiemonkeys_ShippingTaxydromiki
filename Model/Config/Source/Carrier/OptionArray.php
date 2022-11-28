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

    namespace Hippiemonkeys\ShippingTaxydromiki\Model\Config\Source\Carrier;

    use Magento\Framework\Option\ArrayInterface;

    class OptionArray
    implements ArrayInterface
    {
        /**
         * Constructor
         *
         * @access public
         *
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
         * @access private
         *
         * @var array
         */
        private $_optionArray;

        /**
         * Gets Option Array
         *
         * @access protected
         *
         * @return array
         */
        protected function getOptionArray(): array
        {
            return $this->_optionArray;
        }
    }
?>