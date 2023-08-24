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

    namespace Hippiemonkeys\ShippingTaxydromiki\Model;

    use Magento\Framework\Model\Context,
        Magento\Framework\Registry,
        Hippiemonkeys\Core\Model\AbstractModel,
        Hippiemonkeys\ShippingTrack\Api\Data\StatusInterface,
        Hippiemonkeys\ShippingTrack\Api\StatusRepositoryInterface,
        Hippiemonkeys\ShippingTaxydromiki\Api\Data\StatusResolutionInterface,
        Hippiemonkeys\ShippingTaxydromiki\Model\Spi\StatusResolutionResourceInterface as ResourceInterface;

    class StatusResolution
    extends AbstractModel
    implements StatusResolutionInterface
    {
        protected const
            FIELD_STATUS = 'status';

        /**
         * Constructor
         *
         * @access public
         *
         * @param \Magento\Framework\Model\Context $context
         * @param \Magento\Framework\Registry $registry
         * @param \Hippiemonkeys\ShippingTrack\Api\StatusRepositoryInterface $statusRepository
         * @param mixed[] $data
         */
        public function __construct(
            Context $context,
            Registry $registry,
            StatusRepositoryInterface $statusRepository,
            array $data = []
        )
        {
            parent::__construct($context, $registry, $data);
            $this->_statusRepository = $statusRepository;
        }

        /**
         * {@inheritdoc}
         */
        public function getCode(): string
        {
            return $this->getData(ResourceInterface::FIELD_CODE);
        }

        /**
         * {@inheritdoc}
         */
        public function setCode(string $code): StatusResolutionInterface
        {
            return $this->setData(ResourceInterface::FIELD_CODE, $code);
        }

        /**
         * {@inheritdoc}
         */
        public function getStatus(): StatusInterface
        {
            $status = $this->getData(static::FIELD_STATUS);

            if($status === null)
            {
                $status = $this->getStatusRepository()->getById($this->getData(ResourceInterface::FIELD_STATUS_ID));
                $this->setData(static::FIELD_STATUS, $status);
            }

            return $status;
        }

        /**
         * {@inheritdoc}
         */
        function setStatus(StatusInterface $status): StatusResolutionInterface
        {
            return $this->setData(static::FIELD_STATUS, $status)->setData(ResourceInterface::FIELD_STATUS_ID, $status->getId());
        }

        /**
         * Status Repository property
         *
         * @access private
         *
         * @var \Hippiemonkeys\ShippingTrack\Api\StatusRepositoryInterface $_statusRepository
         */
        private $_statusRepository;

        /**
         * Gets Status Repository
         *
         * @access protected
         *
         * @return \Hippiemonkeys\ShippingTrack\Api\StatusRepositoryInterface
         */
        protected function getStatusRepository(): StatusRepositoryInterface
        {
            return $this->_statusRepository;
        }
    }
?>