<?php
use Phinx\Migration\AbstractMigration;

class AddFieldToTable extends AbstractMigration
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
        $table = $this->table('album_photos');
        $table->rename('albums');
    }
}
