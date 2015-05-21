<?php

namespace GintonicCMS\Controller;

use GintonicCMS\Controller\AppController;
use Migrations\Command\Migrate;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;

class SettingsController extends AppController
{
    /**
     * TODO: Write Document
     */
    public function migrate()
    {
        $this->autoRender = false;
        $command = new Migrate();
        $input = new ArrayInput(array('--plugin' => 'GintonicCMS'));
        $output = new NullOutput();
        $resultCode = $command->run($input, $output);
        if($resultCode == 0 ){
            echo __('Migration perform successfully.');
        } else {
            echo __('Oops!!! Error occure while performing Migration.');
        }
    }
}
