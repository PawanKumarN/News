<?php

namespace Addweb\News\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface {

    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context) {
        $installer = $setup;
        $installer->startSetup();
        $table = $installer->getConnection()
                ->newTable($installer->getTable('news'))
                ->addColumn(
                        'news_id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true], 'News Id'
                )
                ->addColumn(
                        'title', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, null, ['nullable' => false], 'title'
                )
                ->addColumn(
                        'images', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, null, ['unsigned' => true, 'nullable' => true], 'Images'
                )
                ->addColumn(
                        'description', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, null, ['nullable' => true, 'default' => null], 'Description'
                )
                ->addColumn(
                        'status', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, ['nullable' => false, 'default' => 0], 'Status'
                )
                ->setComment('News Table');
        $installer->getConnection()->createTable($table);
        $installer->endSetup();
    }

}
