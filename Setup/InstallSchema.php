<?php
/**
 *
 * @package     magento2
 * @author      Codilar Technologies
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @link        http://www.codilar.com/
 */

namespace Codilar\MailTracker\Setup;


use Codilar\MailTracker\Model\ResourceModel\Mail;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{

    /**
     * Installs DB schema for a module
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        try {
            $this->createMailLogTableIfNotExists($setup);
        } catch (\Zend_Db_Exception $e) {
            echo $e->getMessage();die;
        }
    }

    /**
     * @param SchemaSetupInterface $setup
     * @throws \Zend_Db_Exception
     */
    protected function createMailLogTableIfNotExists(SchemaSetupInterface $setup) {
        $tableName = $setup->getTable(Mail::TABLE_NAME);
        if (!$setup->getConnection()->isTableExists($tableName)) {
            $table = $setup->getConnection()->newTable(
                $tableName
            )->addColumn(
                'email_id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Entity ID'
            )->addColumn(
                'from',
                Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'From Email Address'
            )->addColumn(
                'to',
                Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'To Email Address'
            )->addColumn(
                'body',
                Table::TYPE_TEXT,
                null,
                ['nullable' => false],
                'Email Body'
            )->addColumn(
                'additional_information',
                Table::TYPE_TEXT,
                null,
                ['nullable' => false],
                'Additional Information stored as JSON'
            )->addColumn(
                'opened_at',
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => true, 'default' => null],
                'Created Date'
            )->addColumn(
                'created_at',
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
                'Created Date'
            )->setComment(
                'Codilar Mail Tracking Log Table'
            );
            $setup->getConnection()->createTable($table);
        }
    }

}