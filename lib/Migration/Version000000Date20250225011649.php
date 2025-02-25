<?php

declare(strict_types=1);

namespace OCA\PrintOrders\Migration;

use Closure;
use OCP\DB\ISchemaWrapper;
use OCP\Migration\SimpleMigrationStep;
use OCP\Migration\IOutput;

class Version000000Date20250225011649 extends SimpleMigrationStep 
{
    /**
     * @param IOutput $output
     * @param Closure $schemaClosure The `\Closure` returns \OCP\DB\ISchemaWrapper
     * @param array $options
     * @return null|ISchemaWrapper
     */
    public function changeSchema(IOutput $output, Closure $schemaClosure, array $options) 
    {
        /** @var ISchemaWrapper $schema */
        $schema = $schemaClosure();

        if (!$schema->hasTable('printorders')) {
            $table = $schema->createTable('printorders');
            $table->addColumn('id', 'integer', [
                'autoincrement' => true,
                'notnull' => true,
            ]);
            $table->addColumn('user_id', 'string', [
                'notnull' => true,
                'length' => 64,
            ]);
            $table->addColumn('title', 'string', [
                'notnull' => true,
                'length' => 64,
            ]);
            $table->addColumn('description', 'text', [
                'notnull' => true,
                'default' => '',
            ]);
            $table->addColumn('status', 'string', [
                'notnull' => true,
                'length' => 32,
            ]);
            $table->addColumn('created_at', 'datetime', [
                'notnull' => true,
            ]);
            $table->addColumn('updated_at', 'datetime', [
                'notnull' => false,
            ]);

            $table->setPrimaryKey(['id']);
            $table->addIndex(['user_id'], 'printorders_user_id_index');
        }
        return $schema;
    }
}