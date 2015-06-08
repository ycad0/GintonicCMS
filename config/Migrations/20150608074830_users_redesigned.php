<?php
use Phinx\Migration\AbstractMigration;

class UsersRedesigned extends AbstractMigration
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
        $table = $this->table('users');
        $table
            ->removeColumn('file_id')
            ->removeColumn('role')
            ->changeColumn('email', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->changeColumn('first', 'string', [
                'default' => null,
                'limit' => 255,
            ])
            ->changeColumn('last', 'string', [
                'default' => null,
                'limit' => 255,
            ])
            ->update();
    }
}
