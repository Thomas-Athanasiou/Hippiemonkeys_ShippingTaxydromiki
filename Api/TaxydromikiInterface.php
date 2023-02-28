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

    interface TaxydromikiInterface
    {
        const
            /**
             * 1Σ = ΥΠΗΥΡΕΣΙΑ SPECIAL ΠΡΩΙΝΗ ΠΑΡΑΔΟΣΗ
             */
            SERVICE_SPECIAL_MORNING_DELIVERY = '1Σ',

            /**
             * 3Σ = ΥΠΗΥΡΕΣΙΑ ΑΥΘΗΜΕΡΟΝ ΠΟΛΗΣ
             */
            SERVICE_CITY_SAMEDAY = '3Σ',

            /**
             * 5Σ = ΥΠΗΥΡΕΣΙΑ ΠΑΡΑΔΟΣΗ ΣΑΒΒΑΤΟ
             */
            SERVICE_SATURDAY_DELIVERY = '5Σ',

            /**
             * ΑΜ = ΥΠΗΥΡΕΣΙΑ ΑΝΤΙΚΑΤΑΒΟΛΗ ΜΕΤΡΗΤΟΙΣ
             */
            SERVICE_CASHONDELIVERY = 'ΑΜ',

            /**
             * ΑΜ = ΥΠΗΥΡΕΣΙΑ ΑΝΤΙΚΑΤΑΒΟΛΗ ΑΞΙΟΓΡΑΦΑ
             */
            SERVICE_CASHONCHECK = 'ΑΝ',

            /**
             * ΑΣ = ΥΠΗΥΡΕΣΙΑ ΑΣΦΑΛΙΣΗ
             */
            SERVICE_INSURANCE = 'ΑΣ',

            /**
             * ΔΔ = ΥΠΗΥΡΕΣΙΑ ΔΙΚΑΙΟΛΟΓΗΤΙΚΑ ΔΙΑΓΩΝΙΣΜΩΝ
             */
            SERVICE_TENDER_SUPPORTING_DOCUMENTS = 'ΔΔ',

            /**
             * ΕΔ = ΥΠΗΥΡΕΣΙΑ ΕΙΔΙΚΗ ΧΡΕΩΣΗ
             */
            SERVICE_SPECIAL_CHARGE = 'ΕΔ',

            /**
             * ΕΜ = ΥΠΗΥΡΕΣΙΑ ΠΑΡΑΛΑΒΗ ΔΙΚΑΙΟΛΟΓΗΤΙΚΩΝ
             */
            SERVICE_DOCUMENT_PICKUP = 'ΕΜ',

            /**
             * ΕΨ = ΥΠΗΥΡΕΣΙΑ ΕΙΔΗ ΨΥΓΕΙΟΥ
             */
            SERVICE_FRIDGE_PRODUCTS = 'ΕΨ',

            /**
             * ΠΡ = ΥΠΗΥΡΕΣΙΑ ΠΑΡΑΛΑΒΗ ΠΡΩΤΟΚΟΛΟΥ
             */
            SERVICE_PROTOCOL_PICKUP = 'ΠΡ',

            /**
             * ΠΚ = ΥΠΗΥΡΕΣΙΑ ΕΠΙΣΤΡΟΦΗ ΠΑΚΕΤΟΥ
             */
            SERVICE_PACKAGE_RETURN = 'ΠΚ',

            /**
             * ΤΝ = ΥΠΗΥΡΕΣΙΑ ΑΕΡΟΜΕΤΑΦΟΡΑ
             */
            SERVICE_AIR_TRANSPORT = 'ΤΝ',

            /**
             * ΧΠ = ΥΠΗΥΡΕΣΙΑ ΧΡΕΩΣΗ ΠΑΡΑΛΗΠΤΗ
             */
            SERVICE_RECIPIENT_CHARGE = 'ΧΠ',

            /**
             * Τ1 = ΥΠΗΥΡΕΣΙΑ ΤΑΧΥΔΡ. ΚΙΒΩΤΙΟ Ν1 - 5 (ΕΩΣ 2 KG)
             */
            SERVICE_N1_PACKAGE = 'Τ1',

            /**
             * Τ6 = ΥΠΗΥΡΕΣΙΑ ΤΑΧΥΔΡ. ΚΙΒΩΤΙΟ Ν6 - 7 (ΕΩΣ 4KG)
             */
            SERVICE_N6_PACKAGE = 'Τ6',

            /**
             * ΤΕ = ΥΠΗΥΡΕΣΙΑ ΤΑΧΥΔΡ. ΚΙΒΩΤΙΟ ΕΓΓΡΑΦΩΝ (ΕΩΣ 2 KG)
             */
            SERVICE_DOCUMENT_PACKAGE = 'ΤΕ',

            /**
             * ΦΡ = ΥΠΗΥΡΕΣΙΑ ΕΜΠΟΡΕΥΜΑΤΙΚΗ ΜΕΤΑΦΟΡΑ
             */
            SERVICE_FREIGHT_TRANSPORT = 'ΦΡ',

            TDS_DELIVERED = 'DELIVERED',
            TDS_INTRANSIT = 'IN TRANSIT',
            TDS_INRETURN = 'IN RETURN',

            RESULT_CODE_INVALID = -1,
            RESULT_CODE_SUCCESS = 0,
            RESULT_CODE_ERROR_AUTHENTICATION = 1,
            RESULT_CODE_ERROR_NOT_IMPLEMENTED = 2,
            RESULT_CODE_ERROR_NO_DATA = 3,
            RESULT_CODE_ERROR_INVALID_OPERATION = 4,
            RESULT_CODE_ERROR_MAX_VOUCHERS = 5,
            RESULT_CODE_ERROR_MAX_SUBVOUCHERS = 6,
            RESULT_CODE_ERROR_SQL = 8,
            RESULT_CODE_ERROR_JOB_NOT_FOUND = 9,
            RESULT_CODE_ERROR_NOT_AUTHORIZED = 10;

        /**
         * Closes pending jobs
         *
         * @api
         * @access public
         *
         * @return int
         */
        function closePendingJobs(): object;

        /**
         * Closes Pending Job by Date
         *
         * @api
         * @access public
         *
         * @param string $dateFrom
         * @param string $dateTo
         *
         * @return int
         */
        function closePendingJobsByDate(string $dateFrom, string $dateTo): object;

        /**
         * Cancels a Job
         *
         * @api
         * @access public
         *
         * @param int $jobId
         * @param bool $cancel
         *
         * @return int
         */
        function cancelJob(int $jobId, bool $cancel): object;

        /**
         * Gets a Voucher Job
         *
         * @api
         * @access public
         *
         * @param int $jobId
         *
         * @return object
         */
        function getVoucherJob(int $jobId): object;

        /**
         * Gets Jobs From Order ID
         *
         * @api
         * @access public
         *
         * @param string $orderId
         *
         * @return object
         */
        function getJobsFromOrderId(string $orderId): object;

        /**
         * Gets a Voucher Job
         *
         * @api
         * @access public
         *
         * @param array $vouchers
         *
         * @return object
         */
        function getVouchersPdf(array $vouchers) : object;

        /**
         * Gets Shops List
         *
         * @api
         * @access public
         *
         * @return object
         */
        function getShopsList();

        /**
         * Does a Track Delivery Status request
         *
         * @api
         * @access public
         *
         * @return object
         */
        function trackDeliveryStatus(string $voucher, string $language): object;

        /**
         * Does a Track and Trace request
         *
         * @api
         * @access public
         *
         * @return object
         */
        function trackAndTrace(string $voucherNo, string $language): object;

        /**
         * Sends a Create Job request to taxydromiki service
         *
         * @api
         * @access public
         *
         * @param string $orderId,
         * @param string $name,
         * @param string $address,
         * @param string $city,
         * @param string $telephone,
         * @param string $zip,
         * @param string $destination,
         * @param string $courier,
         * @param int $pieces,
         * @param float $weight,
         * @param string[] $comments,
         * @param string[] $services,
         * @param float $codAmount,
         * @param float $insAmoubnt,
         * @param string $voucherNumber,
         * @param string $subCode,
         * @param string $belongsTo,
         * @param string $deliverTo,
         * @param string $receivedDate
         *
         * @return object
         */
        function createJob(
            string $orderId,
            string $name,
            string $address,
            string $city,
            string $telephone,
            string $zip,
            string $destination,
            string $courier,
            int $pieces,
            float $weight,
            array $comments,
            array $services,
            float $codAmount,
            float $insAmoubnt,
            string $voucherNumber,
            string $subCode,
            string $belongsTo,
            string $deliverTo,
            string $receivedDate
        ): object;
    }
?>