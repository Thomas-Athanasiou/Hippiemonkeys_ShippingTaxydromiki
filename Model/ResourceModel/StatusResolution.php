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

    namespace Hippiemonkeys\ShippingTaxydromiki\Model\ResourceModel;

    use Hippiemonkeys\Core\Model\ResourceModel\AbstractResource,
        Hippiemonkeys\ShippingTaxydromiki\Api\Data\StatusResolutionInterface,
        Hippiemonkeys\ShippingTaxydromiki\Model\Spi\StatusResolutionResourceInterface;

    class StatusResolution
    extends AbstractResource
    implements StatusResolutionResourceInterface
    {
        protected const
            TABLE_MAIN = 'hippiemonkeys_shippingtaxydromiki_statusresolution';

        /**
         * {@inheritdoc}
         */
        protected function _construct()
        {
            $this->_init(static::TABLE_MAIN, static::FIELD_ID);
        }

        /**
         * {@inheritdoc}
         */
        public function saveStatusResolution(StatusResolutionInterface $statusResolution): StatusResolution
        {
            return $this->saveModel($statusResolution);
        }

        /**
         * {@inheritdoc}
         */
        public function loadStatusResolutionById(StatusResolutionInterface $statusResolution, $id): StatusResolution
        {
            return $this->loadModelById($statusResolution, $id);
        }

        /**
         * {@inheritdoc}
         */
        public function loadStatusResolutionByCode(StatusResolutionInterface $statusResolution, string $code): StatusResolution
        {
            return $this->loadModel($statusResolution, $code, static::FIELD_CODE);
        }

        /**
         * {@inheritdoc}
         */
        public function deleteStatusResolution(StatusResolutionInterface $statusResolution): bool
        {
            return $this->deleteModel($statusResolution);
        }
    }
?>