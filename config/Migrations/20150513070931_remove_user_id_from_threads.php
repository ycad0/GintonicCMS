<?php
use Phinx\Migration\AbstractMigration;

class RemoveUserIdFromThreads extends AbstractMigration
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
        $table = $this->table('threads');
        $table->removeColumn('user_id');
        $table->update();
    }
}
