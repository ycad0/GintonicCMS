<?php
use Phinx\Migration\AbstractMigration;

class Initial extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('albums');
        $table
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('file_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->create();
        $table = $this->table('customers_users');
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
        $table = $this->table('files');
        $table
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('title', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('filename', 'string', [
                'default' => null,
                'limit' => 250,
                'null' => false,
            ])
            ->addColumn('type', 'string', [
                'default' => null,
                'limit' => 10,
                'null' => false,
            ])
            ->addColumn('size', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('ext', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => false,
            ])
            ->addColumn('dir', 'string', [
                'default' => null,
                'limit' => 250,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();
        $table = $this->table('message_read_statuses');
        $table
            ->addColumn('message_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('status', 'integer', [
                'default' => 0,
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
        $table = $this->table('messages');
        $table
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('thread_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('title', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => false,
            ])
            ->addColumn('body', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->create();
        $table = $this->table('plans');
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
        $table = $this->table('plans_users');
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
        $table = $this->table('threads');
        $table
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
        $table = $this->table('threads_users');
        $table
            ->addColumn('thread_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
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
            ->addColumn('transactions_type_id', 'integer', [
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
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('captured', 'boolean', [
                'default' => false,
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
        $table = $this->table('transactions_types');
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
        $table = $this->table('users');
        $table
            ->addColumn('email', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('password', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('first', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('last', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('verified', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('token', 'string', [
                'default' => 0,
                'limit' => 32,
                'null' => false,
            ])
            ->addColumn('token_creation', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();
    }

    public function down()
    {
        $this->dropTable('albums');
        $this->dropTable('customers_users');
        $this->dropTable('files');
        $this->dropTable('message_read_statuses');
        $this->dropTable('messages');
        $this->dropTable('plans');
        $this->dropTable('plans_users');
        $this->dropTable('threads');
        $this->dropTable('threads_users');
        $this->dropTable('transactions');
        $this->dropTable('transactions_types');
        $this->dropTable('users');
    }
}
