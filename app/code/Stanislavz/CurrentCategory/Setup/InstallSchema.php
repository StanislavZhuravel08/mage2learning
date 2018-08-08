<?php

namespace Stanislavz\CurrentCategory\Setup;

use \Magento\Framework\Setup\InstallSchemaInterface;

class InstallSchema implements InstallSchemaInterface
{
    const TABLE_NAME = 'recently_visited_categories';
    const USER_ENTITY_TABLE = 'customer_entity';
    const ID_COLUMN = 'entity_id';
    const CATEGORY_ENTITY_TABLE = 'catalog_category_entity';

    /**
     * @param \Magento\Framework\Setup\SchemaSetupInterface $setup
     * @param \Magento\Framework\Setup\ModuleContextInterface $context
     * @throws \Zend_Db_Exception
     */
    public function install(
        \Magento\Framework\Setup\SchemaSetupInterface $setup,
        \Magento\Framework\Setup\ModuleContextInterface $context
    ) {
        $installer = $setup;
        $installer->startSetup();

        $connection = $installer->getConnection();

        $table = $connection->newTable(
            $installer->getTable(self::TABLE_NAME)
        )->addColumn(
            'visit_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            10,
            [   'identity' => true,
                'nullable' => false,
                'primary'  => true,
                'unsigned' => true,
            ],
            'Visit Id'
        )->addColumn(
            'customer_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            10,
            [   'identity' => false,
                'nullable' => false,
                'primary'  => false,
                'unsigned' => true,
            ],
            'Customer Id'
        )->addColumn(
            'category_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            10,
            [   'identity' => false,
                'nullable' => false,
                'primary'  => false,
                'unsigned' => true,
            ],
            'Category Id'
//        )->addColumn(
//            'category_name',
//            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
//            255,
//            [   'identity' => false,
//                'nullable' => false,
//                'primary'  => false,
//                'unsigned' => true,
//            ],
//            'Category Name'
//        )->addColumn(
//            'category_url',
//            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
//            255,
//            [],
//            'Category URL Key'
//        )->addColumn(
//            'category_full_path',
//            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
//            255,
//            [],
//            'Category Full Path'
        )->addColumn(
            'created_at',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            [   'nullable' => false,
                'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT
            ],
            'Created At'
        )->setComment('Recently Visited Categories');

        $connection->createTable($table);

        $connection->addIndex(
            $installer->getTable(self::TABLE_NAME),
            $setup->getIdxName(
                $installer->getTable(self::TABLE_NAME),
                ['visit_id', 'customer_id', 'category_id'],
                \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_INDEX
            ),
            ['visit_id', 'customer_id', 'category_id'],
            \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_INDEX
        );

        $connection->addForeignKey(
            $installer->getFkName(
                $installer->getTable(self::TABLE_NAME),
                'customer_id',
                $installer->getTable(self::USER_ENTITY_TABLE),
                self::ID_COLUMN
            ),
            $installer->getTable(self::TABLE_NAME),
            'customer_id',
            $installer->getTable(self::USER_ENTITY_TABLE),
            self::ID_COLUMN
        );

        $connection->addForeignKey(
            $installer->getFkName(
                $installer->getTable(self::TABLE_NAME),
                'category_id',
                $installer->getTable(self::CATEGORY_ENTITY_TABLE),
                self::ID_COLUMN
            ),
            $installer->getTable(self::TABLE_NAME),
            'category_id',
            $installer->getTable(self::CATEGORY_ENTITY_TABLE),
            self::ID_COLUMN
        );

        $installer->endSetup();
    }
}
