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

    namespace Hippiemonkeys\ShippingTaxydromikiNotification\Model;

    use Hippiemonkeys\ShippingTaxydromiki\Api\Data\JobInterface,
        Hippiemonkeys\ShippingTaxydromiki\Api\JobRepositoryInterface,
        Hippiemonkeys\ShippingTaxydromiki\Api\CarrierInterface;

    class JobManagementUpdateStatus
    implements JobManagementInterface
    {
        /**
         * Constructor
         *
         * @access public
         *
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\CarrierInterface $carrier
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\JobRepositoryInterface $jobRepository
         * @param string[] $statusMap
         */
        public function __construct(
            CarrierInterface $carrier,
            JobRepositoryInterface $jobRepository,
            array $statusMap
        )
        {
            $this->_carrier = $carrier;
            $this->_jobRepository = $jobRepository;
            $this->_statusMap = $statusMap;
        }

        /**
         * @inheritdoc
         */
        public function processJob(CarrierInterface $job)
        {
            $genikiStatus = $this->getCarrier()->trackDeliveryStatus($job->getVoucher(), $this->getLanguage())->TrackDeliveryStatusResult?->Status;
            if(\is_scalar($genikiStatus))
            {
                $status = $this->getStatusMap() [$genikiStatus] ?? null;
                if(\is_string($status))
                {
                    $job->setStatus($statusMap[$genikiStatus]);
                    $this->getJobRepository()->save($job);
                }
            }
        }

        /**
         * Carrier property
         *
         * @access private
         *
         * @var \Hippiemonkeys\ShippingTaxydromiki\Api\CarrierInterface
         */
        private $_carrier;

        /**
         * Gets Carrier
         *
         * @access protected
         *
         * @return \Hippiemonkeys\ShippingTaxydromiki\Api\CarrierInterface
         */
        protected function getCarrier(): CarrierInterface
        {
            return $this->_carrier;
        }

        /**
         * Job Repository property
         *
         * @access private
         *
         * @var \Hippiemonkeys\ShippingTaxydromiki\Api\JobRepositoryInterface
         */
        private $_jobRepository;

        /**
         * Gets Job Repository
         *
         * @access protected
         *
         * @return \Hippiemonkeys\ShippingTaxydromiki\Api\JobRepositoryInterface
         */
        protected function getJobRepository(): JobRepositoryInterface
        {
            return $this->_jobRepository;
        }

        /**
         * Status Map property
         *
         * @access private
         *
         * @var string[] $_statusMap
         */
        private $_statusMap;

        /**
         * Gets Status Map
         *
         * @access protected
         *
         * @return string[]
         */
        protected function getStatusMap(): array
        {
            return $this->_statusMap;
        }
    }
?>