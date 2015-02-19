<?php
$this->assign('pagetitle', __('Files') . '<small>' . __('File Management') . '</small>');
$this->Html->addCrumb(__('File Management'), ['controller' => 'files', 'action' => 'index']);
$this->Html->addCrumb(__('Files'));
$this->start('top_links');
if(!empty($userId)){
echo $this->Html->link('<i class="fa fa-chevron-left">&nbsp;</i>&nbsp;Back', 'javascript:void(0)', ['onclick'=>'javascript:history.go(-1);','class' => 'btn btn-default', 'escape' => false, 'title' => 'Click here to go back']);
}
echo $this->Html->link('<i class="fa fa-upload">&nbsp;</i>&nbsp;Upload file', 'javascript:void(0)', ['data-multiple'=>'true','data-loading-text'=>'Loading...','data-upload-callback'=>'files/index','class' => 'btn btn-primary upload', 'escape' => false, 'title' => 'Click here to upload files']);
$this->end();
echo $this->GtwRequire->req('files/filepicker');
?>
<div id = "upload-alert"></div>
<div id="modal-loader"></div>
<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">           
            <div class="box-footer clearfix">
                <?php echo $this->element('paginationtop'); ?>
            </div>
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover table-striped table-bordered" id="all-files">
                    <thead>
                        <tr>
                            <th><?php echo $this->Paginator->sort('id'); ?></th>
                            <th><?php echo $this->Paginator->sort('title'); ?></th>
                            <th><?php echo $this->Paginator->sort('filename'); ?></th>
                            <th><?php echo $this->Paginator->sort('ext', 'Extension'); ?></th>
                            <th class='text-center'><?php echo $this->Paginator->sort('size'); ?></th>
                            <?php if ($this->Session->read('Auth.User.role') == 'admin') { ?>
                                <th><?php echo $this->Paginator->sort('User.first', 'Owner'); ?></th>
                            <?php } ?>
                            <th><?php echo $this->Paginator->sort('created', 'Added'); ?></th>
                            <th class='text-center'>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($files)) : ?>
                            <tr>
                                <td colspan='7' class='text-warning'>No file uploaded yet.</td>
                            </tr>
                            <?php
                        else :
                            foreach ($files as $file) {
                                echo $this->element('filelist', array('file' => $file));
                            }
                        endif;
                        ?>
                    </tbody>
                </table> 
            </div>
            <div class="box-footer clearfix">
                <?php echo $this->element('pagination');  ?>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editTitleModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <?php echo $this->Form->create('Files',array('url'=>array('action'=>'update'),'id'=>'gtwFileUpdateForm'));?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?php echo __('Update Title'); ?></h4>
            </div>
            <div class="modal-body">                
                <?php 
                    echo $this->Form->input('id',array('type'=>'hidden','id'=>'gtwFileid'));
                    echo $this->Form->input('title',array('label'=>false,'class'=>'form-control','div'=>false,'id'=>'gtwFileTitle','maxlength'=>255));
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" style="display:none;"><i class="fa fa-refresh fa-spin"></i> <?php echo __('Please wait...');?></button>
                <?php echo $this->Form->submit('Save', array('div' => false,'class' => 'btn btn-primary pull-right'));?>
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><?php echo __('Close'); ?></button>
            </div>
            <?php $this->Form->end();?>
        </div>
    </div>
</div>
<div class="modal fade" id="getFileLinkModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?php echo __('Link of File'); ?></h4>
            </div>
            <div class="modal-body">
                <?php 
                    echo $this->Form->input('link',array('label'=>false,'class'=>'form-control','onclick'=>'this.select();','div'=>false,'id'=>'gtwFileLink','maxlength'=>255));
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Close'); ?></button>
            </div>            
        </div>
    </div>
</div>
