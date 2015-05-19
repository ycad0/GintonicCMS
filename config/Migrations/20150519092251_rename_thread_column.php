<?php
use Phinx\Migration\AbstractMigration;

class RenameThreadColumn extends AbstractMigration
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
		$table->renameColumn('thread_participant_count', 'threads_user_count');
    }
}
