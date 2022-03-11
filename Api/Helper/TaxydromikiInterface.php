<?php
    /**
     * @author Thomas Athanasiou at Hippiemonkeys | @Thomas-Athanasiou
     * @copyright Copyright (c) 2022 Hippiemonkeys (https://hippiemonkeys.com)
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
         *
         * @return \Hippiemonkeys\Core\Api\Helper\ConfigInterface
         */
        public function getConfig(): ConfigInterface;

        /**
         * Gets Carrier
         *
         * @api
         *
         * @return \Hippiemonkeys\ShippingTaxydromiki\Api\CarrierInterface
         */
        public function getCarrier(): CarrierInterface;

        /**
         * Gets Active Flag (Whether the shipping module is active or not)
         *
         * @api
         *
         * @return bool
         */
        public function getActive(): bool;
    }
?>