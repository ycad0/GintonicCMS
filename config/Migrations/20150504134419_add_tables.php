<?php
use Phinx\Migration\AbstractMigration;

class AddTables extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
		$table = $this->table('subscribe_plan_users');
        $table
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('plan_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('status', 'string', [
                'default' => null,
                'limit' => 10,
                'null' => false,
            ])
            ->addColumn('last_charged', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->create();
        $table = $this->table('subscribe_plans');
        $table
            ->addColumn('plan_id', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('plan_interval', 'string', [
                'default' => 'month',
                'limit' => 10,
                'null' => false,
            ])
            ->addColumn('interval_count', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('amount', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('status', 'string', [
                'default' => null,
                'limit' => 10,
                'null' => false,
            ])
            ->addColumn('plan_user_count', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->create();
			$table = $this->table('transaction_types');
        $table
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->create();
        $table = $this->table('transactions');
        $table
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('transaction_type_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('plan_id', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('plan_name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('fixed_price', 'integer', [
                'default' => null,
                'limit' => 2,
                'null' => false,
            ])
            ->addColumn('amount', 'float', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('currency', 'string', [
                'default' => null,
                'limit' => 10,
                'null' => false,
            ])
            ->addColumn('transaction_id', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('customer_id', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('email', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('brand', 'string', [
                'default' => null,
                'limit' => 10,
                'null' => false,
            ])
            ->addColumn('last4', 'string', [
                'default' => null,
                'limit' => 6,
                'null' => false,
            ])
            ->addColumn('paid', 'boolean', [
                'default' => 0,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('captured', 'boolean', [
                'default' => 0,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->create();
        $table = $this->table('user_customers');
        $table
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('customer_id', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->create();
    }
	
	public function down()
    {
        $this->dropTable('subscribe_plan_users');
        $this->dropTable('subscribe_plans');
        $this->dropTable('transaction_types');
        $this->dropTable('transactions');
        $this->dropTable('user_customers');
    }
}
