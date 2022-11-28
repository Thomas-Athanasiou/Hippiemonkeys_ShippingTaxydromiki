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

    class Shop
    extends AbstractDb
    {
        public const
            FIELD_ID            = 'id',
            FIELD_CODE          = 'code',
            FIELD_CODE2         = 'code2',
            FIELD_NAME          = 'name',
            FIELD_STATE         = 'state',
            FIELD_CITY          = 'city',
            FIELD_ADDRESS       = 'address',
            FIELD_TELEPHONE     = 'telephone',
            FIELD_COUNTRY       = 'country',
            FIELD_ZIP           = 'zip',
            FIELD_EMAIL         = 'email',
            FIELD_LONGITUDE     = 'longitude',
            FIELD_LATITUDE      = 'latitude',
            FIELD_SUBSHOP       = 'subshop',
            FIELD_ACTIVE        = 'active';

        protected const
            TABLE_MAIN = 'hippiemonkeys_shippingtaxydromiki_shop';

        /**
         * @inheritdoc
         */
        protected function _construct()
        {
            $this->_init(static::TABLE_MAIN, static::FIELD_ID);
        }
    }
?>