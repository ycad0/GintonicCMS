<?php
use Phinx\Migration\AbstractMigration;

class RenameColumn extends AbstractMigration
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
		$table = $this->table('message_read_statuses');
		$table->renameColumn('thread_participant_id', 'threads_users_id');
    }
}
