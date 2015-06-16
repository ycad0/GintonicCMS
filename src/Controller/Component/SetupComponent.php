<?php

namespace GintonicCMS\Controller\Component;

use Cake\Controller\Component;
use Cake\Datasource\ConnectionManager;
use Migrations\Command\Migrate;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;

class SetupComponent extends Component
{
    /**
     * Runs the migrations for a given plugin
     *
     * @param string $tableName Name of the table to check.
     * @return void
     */
    public function runMigration($plugin)
    {
        $command = new Migrate();
        $output = new NullOutput();
        $input = new ArrayInput(['--plugin' => $plugin]);
        $resultCode = $command->run($input, $output);
    }

    /**
     * Check whether table is exists in database or not.
     *
     * @param string $tableName Name of the table to check.
     * @return boolean True if table exists, False else.
     */
    public function tableExists($tableName, $connectionName = 'default')
    {
        try {
            $db = ConnectionManager::get($connectionName);
            $collection = $db->schemaCollection();
            $tables = $collection->listTables();
            if (in_array($tableName, $tables)) {
                return true;
            }
        } catch (PDOException $connectionError) {
            return false;
        }
        return false;
    }

    /**
     * Test database connection.
     *
     * @param type $dataSource name of data source.
     * @return boolean True if we're able to connect to the database
     */
    public function databaseConnection($dataSource = 'default')
    {
        try {
            $connection = ConnectionManager::get($dataSource);
            $connected = $connection->connect();
        } catch (MissingConnectionException $connectionError) {
            $connected = false;
        }
        return $connected;
    }
}
