<?php
    /**
     * @Thomas-Athanasiou
     *
     * @author Thomas Athanasiou at Hippiemonkeys
     * @link https://github.com/Thomas-Athanasiou
     * @copyright Copyright (c) 2022 Hippiemonkeys Web Inteligence EE (https://hippiemonkeys.com)
     * @package Hippiemonkeys_ShippingTaxydromiki
     */

    declare(strict_types=1);

    namespace Hippiemonkeys\ShippingTaxydromiki\Api;

    /**
     * @api
     */
    interface JobManagementInterface
    {
        /**
         * Processes a Job
         *
         * @access public
         *
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\JobInterface $job
         */
        function processJob(JobInterface $job): void;
    }
?>