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

    namespace Hippiemonkeys\ShippingTaxydromiki\Helper\Taxydromiki;

    use Psr\Log\LoggerInterface,
        Hippiemonkeys\Core\Api\Helper\ConfigInterface,
        Hippiemonkeys\ShippingTaxydromiki\Api\CarrierInterface,
        Hippiemonkeys\ShippingTaxydromiki\Api\JobManagementInterface,
        Hippiemonkeys\ShippingTaxydromiki\Api\Helper\Taxydromiki\UpdateJobsInterface,
        Hippiemonkeys\ShippingTaxydromiki\Helper\Taxydromiki;

    class UpdateJobs
    extends Taxydromiki
    implements UpdateJobsInterface
    {
        /**
         * @param \Psr\Log\LoggerInterface $logger
         * @param \Hippiemonkeys\Core\Api\Helper\ConfigInterface $config
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\CarrierInterface $carrier
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\JobManagementInterface $jobManagement
         */
        public function __construct(
            LoggerInterface $logger,
            ConfigInterface $config,
            CarrierInterface $carrier,
            JobManagementInterface $jobManagement
        )
        {
            parent::__construct($logger, $config, $carrier);
            $this->_jobManagement = $jobManagement;
        }

        /**
         * @inheritdoc
         * @todo
         */
        public function updateJobs(): void
        {
        }

        /**
         * Job Management property
         *
         * @var \Hippiemonkeys\ShippingTaxydromiki\Api\JobManagementInterface
         */
        private $_jobManagement;

        /**
         * Gets Job Management
         *
         * @return \Hippiemonkeys\ShippingTaxydromiki\Api\JobManagementInterface
         */
        protected function getJobManagement(): JobManagementInterface
        {
            return $this->_jobManagement;
        }
    }
?>