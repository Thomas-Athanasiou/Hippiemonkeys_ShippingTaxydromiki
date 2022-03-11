<?php
    /**
     * @author Thomas Athanasiou at Hippiemonkeys
     * @copyright Copyright (c) 2022 Hippiemonkeys (https://hippiemonkeys.com)
     * @package Hippiemonkeys_ShippingTaxydromiki
     */

    declare(strict_types=1);

    namespace Hippiemonkeys\ShippingTaxydromiki\Api\Helper\Taxydromiki;

    use Hippiemonkeys\ShippingTaxydromiki\Api\Helper\TaxydromikiInterface;

    interface UpdateShopsInterface
    extends TaxydromikiInterface
    {
        /**
         * Updates persistent shops from the external carrier service
         */
        public function updateShops(): void;
    }
?>