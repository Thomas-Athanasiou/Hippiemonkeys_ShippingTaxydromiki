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

    namespace Hippiemonkeys\ShippingTaxydromiki\Model;

    use Hippiemonkeys\ShippingTaxydromiki\Api\JobManagementInterface,
        Hippiemonkeys\ShippingTaxydromiki\Api\Data\JobInterface;

    class JobManagementComposite
    implements JobManagementInterface
    {
        /**
         * Constructor
         *
         * @access public
         *
         * @param \Hippiemonkeys\ShippingTaxydromiki\Api\JobManagementInterface[] $jobManagements
         */
        public function __construct(
            array $jobManagements
        )
        {
            $this->_jobManagements;
        }

        /**
         * @inheritdoc
         */
        public function processJob(JobInterface $job): void
        {
            foreach ($this->getJobManagements() as $jobManagement)
            {
                $jobManagement->processJob($job);
            }
        }

        /**
         * Job Managements property
         *
         * @access private
         *
         * @var \Hippiemonkeys\ShippingTaxydromiki\Api\JobManagementInterface[] $_jobManagements
         */
        private $_jobManagements;

        /**
         * Gets Job Managements
         *
         * @access protected
         *
         * @return \Hippiemonkeys\ShippingTaxydromiki\Api\JobManagementInterface[]
         */
        protected function getJobManagements(): array
        {
            return $this->_jobManagements;
        }
    }
?>