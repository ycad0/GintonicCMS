<?php 
use Cake\I18n\Time;
use Cake\I18n\Number;
?>
<tr>
    <td><?php echo $file->id;?></td>
    <td>
        <span id='title_<?php echo $file->id?>'><?php echo $file->title;?></span>
        <a href="javascript:void(0)" class="editTitle pull-right" data-value="<?php echo $file->title?>" data-pk="<?php echo $file->id;?>"><i class="fa fa-pencil"> </i></a>
    </td>
    <td><?php echo $file->filename;?></td>
    <td><?php echo $file->ext;?></td>
    <td class='text-right'><?php echo Number::toReadableSize($file->size);?></td>
    <?php if($this->Session->read('Auth.User.role')=='admin'){ ?>
        <td><?php echo $file->filename.' <small>('.$file->ext.')</small>';?></td>
    <?php }?>
    <td>
        <?php
            echo $file->created->i18nFormat();
        ?>
    </td>
    <td class="text-center">
        <span class="text-center ">
            <?php 
            echo $this->Html->link('<i class="fa fa-link">&nbsp;</i>&nbsp;','javascript:void(0)',['escape'=>false,'class'=>'getFileLink','data-value'=> $this->Url->build('/',true) . 'files' . DS . 'uploads' . DS .$file->filename,'data-pk'=>$file->id]);
            echo $this->Html->link('<i class="fa fa-download">&nbsp;</i>&nbsp;',['action'=>'download', $file->filename],['escape'=>false]);
            echo $this->Html->link('<i class="fa fa-trash-o"> </i>',['controller'=>'files','action'=>'delete',$file->id],['role'=>'button','escape'=>false,'title'=>__('Delete this file'),'confirm'=>__('Are you sure? You want to delete this file.')]);
            ?>
        </span>
    </td>
</tr>
