<?php
/**
 * Created by PhpStorm.
 * User: stanislavz
 * Date: 01.08.18
 * Time: 14:15
 */

namespace Stanislavz\CurrentCategory\Setup;

use \Magento\Framework\Setup\InstallSchemaInterface;

class InstallSchema implements InstallSchemaInterface
{
    private $TABLE_NAME = 'recently_visited_categories';

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

        if (!$installer->tableExists($this->TABLE_NAME)) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable($this->TABLE_NAME)
            )
            ->addColumn(
                'visit_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                [   'identity' => true,
                    'nullable' => false,
                    'primary'  => true,
                    'unsigned' => true,
                ],
                'Visit Id'
            )
            ->addColumn(
                'user_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                [   'identity' => false,
                    'nullable' => false,
                    'primary'  => false,
                    'unsigned' => false,
                ],
                'User Id'
            )
            ->addColumn(
                'category_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                [   'identity' => false,
                    'nullable' => false,
                    'primary'  => false,
                    'unsigned' => false,
                ],
                'Category Id'
            )
            ->addColumn(
                'category_url',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [],
                'Category URL Key'
            )
            ->addColumn(
                'category_full_path',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [],
                'Category Full Path'
            )
            ->setComment('Recently Visited Categories');
            $installer->getConnection()->createTable($table);

            $installer->getConnection()->addIndex(
                $installer->getTable($this->TABLE_NAME),
                $setup->getIdxName(
                    $installer->getTable($this->TABLE_NAME),
                    ['visit_id', 'user_id', 'category_id'],
                    \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_INDEX
                ),
                ['visit_id', 'user_id', 'category_id'],
                \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_INDEX
            );
        }
        $installer->endSetup();
    }
}
