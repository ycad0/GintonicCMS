<?php
$this->assign('pagetitle', __('Files') . '<small>' . __('File Management') . '</small>');
$this->Html->addCrumb(__('File Management'), ['controller' => 'files', 'action' => 'index']);
$this->Html->addCrumb(__('Files'));

$this->start('top_links');
$this->end();

echo $this->Require->req('files/filepicker');
?>
<div id = "upload-alert"></div>
<div id="modal-loader"></div>
<div class="row">
    <div class="col-md-12 padding-bottom-15">
        <?= $this->Html->link(
            '<i class="fa fa-upload">&nbsp;</i>&nbsp;Upload file', 'javascript:void(0)', 
            [
                'data-multiple' => 'true',
                'data-loading-text' => 'Loading...',
                'data-upload-callback' => 'files/index',
                'class' => 'btn btn-primary upload btn-sm pull-right',
                'escape' => false,
                'title' => 'Click here to upload files'
            ]
        ); ?>
    </div>
    <div class="col-xs-12">
        <div class="box box-primary">           
            <div class="box-footer clearfix">
                <?= $this->element('GintonicCMS.Pagination/paginationtop'); ?>
            </div>
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th><?= $this->Paginator->sort('id'); ?></th>
                            <th><?= $this->Paginator->sort('title'); ?></th>
                            <th><?= $this->Paginator->sort('filename'); ?></th>
                            <th><?= $this->Paginator->sort('ext', 'Extension'); ?></th>
                            <th><?= $this->Paginator->sort('size'); ?></th>
                            <?php if ($this->request->session()->read('Auth.User.role') == 'admin') : ?>
                                <th><?= $this->Paginator->sort('User.first', 'Owner'); ?></th>
                            <?php endif; ?>
                            <th><?= $this->Paginator->sort('created', 'Added'); ?></th>
                            <th class='text-center'>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($files)) : ?>
                            <tr>
                                <td colspan='7' class='text-warning'>No file uploaded yet.</td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($files as $file) : ?>
                                <?= $this->element('Files/filelist', array('file' => $file)); ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="box-footer clearfix">
                <?php echo $this->element('GintonicCMS.Pagination/pagination'); ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editTitleModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <?= $this->Form->create('Files', [
                'url' => ['action' => 'update'], 
                'id' => 'FileUpdateForm'
            ]); ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?php echo __('Update Title'); ?></h4>
            </div>
            <div class="modal-body">                
                <?= $this->Form->input('id', [
                    'type' => 'hidden',
                    'id' => 'Fileid'
                ]); ?>
                <?= $this->Form->input('title', [
                    'label' => false,
                    'class' => 'form-control',
                    'div' => false,
                    'id' => 'FileTitle',
                    'maxlength' => 255
                ]); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" style="display:none;">
                    <i class="fa fa-refresh fa-spin"></i> 
                    <?= __('Please wait...'); ?>
                </button>
                <?= $this->Form->submit('Save', [
                    'div' => false,
                    'class' => 'btn btn-primary pull-right'
                ]); ?>
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">
                    <?= __('Close'); ?>
                </button>
            </div>
            <?php $this->Form->end(); ?>
        </div>
    </div>
</div>
<div class="modal fade" id="getFileLinkModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?= __('Link of File'); ?></h4>
            </div>
            <div class="modal-body">
                <?= $this->Form->input('link', [
                    'label' => false,
                    'class' => 'form-control',
                    'onclick' => 'this.select();',
                    'div' => false,
                    'id' => 'FileLink',
                    'maxlength' => 255
                ]); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <?= __('Close'); ?>
                </button>
            </div>            
        </div>
    </div>
</div>
