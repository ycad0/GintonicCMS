<?php
use Phinx\Migration\AbstractMigration;

class RenameTable extends AbstractMigration
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
        $table->rename('plans_users');
		
		$table = $this->table('transaction_types');
        $table->rename('transactions_types');
		
		$table = $this->table('user_customers');
        $table->rename('customers_users');
    }
}
