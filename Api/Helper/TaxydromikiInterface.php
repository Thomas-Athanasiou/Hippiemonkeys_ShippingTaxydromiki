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

    namespace Hippiemonkeys\ShippingTaxydromiki\Api\Helper;

    use Hippiemonkeys\Core\Api\Helper\ConfigInterface,
        Hippiemonkeys\ShippingTaxydromiki\Api\CarrierInterface;

    interface TaxydromikiInterface
    {
        /**
         * Gets Config
         *
         * @api
         * @access public
         *
         * @return \Hippiemonkeys\Core\Api\Helper\ConfigInterface
         */
        public function getConfig(): ConfigInterface;

        /**
         * Gets Carrier
         *
         * @api
         * @access public
         *
         * @return \Hippiemonkeys\ShippingTaxydromiki\Api\CarrierInterface
         */
        public function getCarrier(): CarrierInterface;

        /**
         * Gets Active Flag (Whether the shipping module is active or not)
         *
         * @api
         * @access public
         *
         * @return bool
         */
        public function getActive(): bool;
    }
?>