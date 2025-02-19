<?php
namespace OCA\PrintOrders\Migration;

use Closure;
use OCP\DB\ISchemaWrapper;
use OCP\Migration\SimpleMigrationStep;
use OCP\Migration\IOutput;

class Version000000Date20240304000000 extends SimpleMigrationStep {
    public function changeSchema(IOutput $output, Closure $schemaClosure, array $options) {
        /** @var ISchemaWrapper $schema */
        $schema = $schemaClosure();

        if (!$schema->hasTable('print_orders')) {
            $table = $schema->createTable('print_orders');
            $table->addColumn('id', 'integer', [
                'autoincrement' => true,
                'notnull' => true,
            ]);
            $table->addColumn('user_id', 'string', [
                'notnull' => true,
                'length' => 64,
            ]);
            $table->addColumn('tracking_id', 'string', [
                'notnull' => true,
                'length' => 64,
            ]);
            $table->addColumn('customer_name', 'string', [
                'notnull' => true,
                'length' => 255,
            ]);
            $table->addColumn('email', 'string', [
                'notnull' => true,
                'length' => 255,
            ]);
            $table->addColumn('phone', 'string', [
                'notnull' => true,
                'length' => 64,
            ]);
            $table->addColumn('width', 'decimal', [
                'notnull' => true,
                'precision' => 10,
                'scale' => 2,
            ]);
            $table->addColumn('length', 'decimal', [
                'notnull' => true,
                'precision' => 10,
                'scale' => 2,
            ]);
            $table->addColumn('quantity', 'integer', [
                'notnull' => true,
            ]);
            $table->addColumn('special_instructions', 'text', [
                'notnull' => false,
            ]);
            $table->addColumn('photos', 'text', [
                'notnull' => false,
            ]);
            $table->addColumn('status', 'string', [
                'notnull' => true,
                'length' => 32,
                'default' => 'pending'
            ]);
            $table->addColumn('created_at', 'integer', [
                'notnull' => true,
            ]);
            $table->addColumn('updated_at', 'integer', [
                'notnull' => true,
            ]);

            $table->setPrimaryKey(['id']);
            $table->addIndex(['user_id'], 'print_orders_user_id_idx');
            $table->addIndex(['tracking_id'], 'print_orders_tracking_id_idx');
            $table->addIndex(['status'], 'print_orders_status_idx');
        }

        return $schema;
    }
}
