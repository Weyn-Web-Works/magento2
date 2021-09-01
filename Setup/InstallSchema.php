<?php
namespace TradeTracker\Connect\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{

    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @throws \Zend_Db_Exception
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        $this->addTableColumnIfNotExists($setup, $setup->getTable('sales_order'), 'tt_status', [
            'type' => 'varchar',
            'size' => 50,
            'nullable' => true,
            'comment' => 'TradeTracker Status'
        ]);

        $this->addTableColumnIfNotExists($setup, $setup->getTable('sales_order_grid'), 'tt_status', [
            'type' => 'varchar',
            'size' => 50,
            'nullable' => true,
            'comment' => 'TradeTracker Status'
        ]);
        $installer->endSetup();
    }

    /**
     * Add table column if not exists.
     *
     * @param SchemaSetupInterface $setup
     * @param string $table
     * @param string $columnName
     * @param array $data
     */
    protected function addTableColumnIfNotExists(SchemaSetupInterface $setup,  $table,  $columnName, $data = []) {
        if (!$setup->getConnection()->tableColumnExists($table, $columnName)) {
            $setup->getConnection()->addColumn($table, $columnName, $data);
        }
    }
}