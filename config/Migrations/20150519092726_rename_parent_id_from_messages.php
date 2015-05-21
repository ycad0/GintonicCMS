<?php
use Phinx\Migration\AbstractMigration;

class RenameParentIdFromMessages extends AbstractMigration
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
		$table = $this->table('messages');
        $table->removeColumn('parent_id');
        $table->update();
    }
}
