<?php
use Phinx\Migration\AbstractMigration;

class RemoveThreadsUsersIdFromMessagesReadStatuses extends AbstractMigration
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
        $table
            ->removeColumn('threads_users_id')
            ->update();
    }
}
