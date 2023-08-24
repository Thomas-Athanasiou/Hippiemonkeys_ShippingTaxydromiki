<?php
    /**
     * @Thomas-Athanasiou
     *
     * @author Thomas Athanasiou {thomas@hippiemonkeys.com}
     * @link https://hippiemonkeys.com
     * @link https://github.com/Thomas-Athanasiou
     * @copyright Copyright (c) 2022 Hippiemonkeys Web Intelligence EE All Rights Reserved.
     * @license http://www.gnu.org/licenses/ GNU General Public License, version 3
     * @package Hippiemonkeys_ShippingTaxydromiki
     */

    declare(strict_types=1);

    namespace Hippiemonkeys\ShippingTaxydromiki\Api;

    use Magento\Framework\Api\SearchCriteriaInterface,
        Hippiemonkeys\ShippingTaxydromiki\Api\Data\JobInterface,
        Hippiemonkeys\ShippingTaxydromiki\Api\Data\JobSearchResultInterface as SearchResultInterface;

    interface JobRepositoryInterface
    {
        /**
         * Gets Job by Id
         *
         * @api
         * @access public
         *
         * @param mixed $id
         *
         * @return \Hippiemonkeys\ShippingTaxydromiki\Api\Data\JobInterface
         */
        function getById($id): JobInterface;

        /**
         * Gets Job by Job Id
         *
         * @api
         * @access public
         *
         * @param int $jobId
         *
         * @return \Hippiemonkeys\ShippingTaxydromiki\Api\Data\JobInterface
         */
        function getByJobId(int $jobId): JobInterface;

        /**
         * Gets Job by voucher
         *
         * @api
         * @access public
         *
         * @param string $voucher
         *
         * @return \Hippiemonkeys\ShippingTaxydromiki\Api\Data\JobInterface
         */
        function getByVoucher(string $voucher): JobInterface;

        /**
         * Gets list by Search Criteria
         *
         * @api
         * @access public
         *
         * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
         *
         * @return \Hippiemonkeys\ShippingTaxydromiki\Api\Data\JobSearchResultInterface
         */
        function getList(SearchCriteriaInterface $searchCriteria): SearchResultInterface;

        /**
         * Deletes Job
         *
         * @api
         * @access public
         *
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\Data\JobInterface $job
         *
         * @return bool
         */
        function delete(JobInterface $job): bool;

        /**
         * Saves Job
         *
         * @api
         * @access public
         *
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\Data\JobInterface $job
         *
         * @return \Hippiemonkeys\ShippingTaxydromiki\Api\Data\JobInterface
         */
        function save(JobInterface $job): JobInterface;
    }
?>