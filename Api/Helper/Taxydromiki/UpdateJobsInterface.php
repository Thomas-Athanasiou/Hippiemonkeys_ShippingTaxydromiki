<?php
    /**
     * @author Thomas Athanasiou at Hippiemonkeys | @Thomas-Athanasiou
     * @copyright Copyright (c) 2022 Hippiemonkeys (https://hippiemonkeys.com)
     * @package Hippiemonkeys_ShippingTaxydromiki
     */

    declare(strict_types=1);

    namespace Hippiemonkeys\ShippingTaxydromiki\Api\Helper\Taxydromiki;

    use Hippiemonkeys\ShippingTaxydromiki\Api\Helper\TaxydromikiInterface;

    interface UpdateJobsInterface
    extends TaxydromikiInterface
    {
        /**
         * Updates persistent jobs from the external carrier service
         *
         * @api
         */
        public function updateJobs(): void;
    }
?>