<?php

namespace Stanislavz\CurrentCategory\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    const TABLE_NAME = 'recently_visited_categories';

    public function upgrade(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $setup->startSetup();

        if (version_compare($context->getVersion(), '1.1.2', '<=')) {
            $setup->getConnection()->dropColumn($setup->getTable(self::TABLE_NAME), 'category_name');
            $setup->getConnection()->dropColumn($setup->getTable(self::TABLE_NAME), 'category_full_path');
            $setup->getConnection()->dropColumn($setup->getTable(self::TABLE_NAME), 'category_url');

            $setup->getConnection()->addColumn(
                $setup->getTable(self::TABLE_NAME),
                'updated_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                [
                    'nullable' => false,
                    'default'  => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE
                ],
                'Update Time'
            );
        }
    }
}
