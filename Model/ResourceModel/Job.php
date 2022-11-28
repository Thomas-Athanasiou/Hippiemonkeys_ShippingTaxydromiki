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

    namespace Hippiemonkeys\ShippingTaxydromiki\Model\ResourceModel;

    use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

    class Job
    extends AbstractDb
    {
        public const
            FIELD_ID        = 'id',
            FIELD_JOB_ID    = 'job_id',
            FIELD_VOUCHER   = 'voucher',
            FIELD_CANCELED  = 'canceled',
            FIELD_STATUS  = 'status';

        protected const
            TABLE_MAIN = 'hippiemonkeys_shippingtaxydromiki_job';

        /**
         * @inheritdoc
         */
        protected function _construct()
        {
            $this->_init(static::TABLE_MAIN, static::FIELD_ID);
        }
    }
?>