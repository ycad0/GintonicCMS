<?php
use Phinx\Migration\AbstractMigration;

class RenameField extends AbstractMigration
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
		$table = $this->table('transactions');
		$table->renameColumn('transaction_type_id', 'transactions_type_id');
    }
}
