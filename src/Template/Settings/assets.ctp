<?php
use Cake\View\Helper\UrlHelper;
echo $this->Require->req('GintonicCMS/js/settings/assets');
?>
<div class="container">
    <div class="row">
        <h3>Build Assets</h3>
        
        <table class="table">
            <tr>
                <td>1</td>
                <td>Install toolkit</td>
                <td>
                    <?php
                    echo $this->Html->image('GintonicCMS.loading.gif', ['id' => 'install-kit', 'style' => 'position: absolute; margin-left: 9%; margin-top: 10px;', 'class' => 'hidden']);
                    ?>
                    <input type="button" value="Install" class="btn btn-block setup" data-src="<?php echo $this->Url->build(['controller' => 'settings', 'action' => 'nodeInstall']);?>" data-install-kit>
                </td>
            </tr>
            <tr>
                <td>2</td>
                <td>Download dependencies</td>
                <td>
                    <?php
                    echo $this->Html->image('GintonicCMS.loading.gif', ['id' => 'download-kit', 'style' => 'position: absolute; margin-left: 9%; margin-top: 10px;', 'class' => 'hidden']);
                    ?>
                    <input type="button" value="Install" class="btn btn-block disabled" data-src="<?php echo $this->Url->build(['controller' => 'settings', 'action' => 'bowerInstall']);?>" data-download-kit>
                </td>
            </tr>
            <tr>
                <td>3</td>
                <td>Build assets</td>
                <td>
                    <?php
                    echo $this->Html->image('GintonicCMS.loading.gif', ['id' => 'grunt', 'style' => 'position: absolute; margin-left: 9%; margin-top: 10px;', 'class' => 'hidden']);
                    ?>
                    <input type="button" value="Install" class="btn btn-block disabled" data-src="<?php echo $this->Url->build(['controller' => 'settings', 'action' => 'grunt']);?>" data-grunt>
                </td>
            </tr>
        </table>
    </div>
</div>