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

    namespace Hippiemonkeys\ShippingTaxydromiki\Api;

    use \Hippiemonkeys\ShippingTaxydromiki\Api\Data\JobInterface;

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

        /**
         * Updates persistent jobs from the external carrier service
         *
         * @api
         * @access public
         *
         * @param int $limit
         */
        function updateJobs(int $limit): void;

        /**
         * Updates persistent jobs having the specidfied status from the external carrier service
         *
         * @api
         * @access public
         *
         * @param int $status
         * @param int $limit
         */
        function updateJobsWithStatus(int $status, int $limit): void;
    }
?>