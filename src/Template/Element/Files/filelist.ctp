<?php
use Cake\I18n\Time;
use Cake\I18n\Number;
?>
<tr>
    <td><?php echo $file->id; ?></td>
    <td>
        <?php if(!empty($file->title)): ?>
            <a id='title_<?= $file->id ?>' 
                href="javascript:void(0)" 
                class="editTitle" 
                data-value="<?= $file->title ?>" 
                data-pk="<?= $file->id; ?>">
                    <?= $file->title; ?>
            </a>
        <?php else: ?>
            <a id='title_<?= $file->id ?>' 
                href="javascript:void(0)" 
                class="editTitle" 
                data-value="<?= $file->title ?>" 
                data-pk="<?= $file->id; ?>">
                    Add Title
            </a>
            <span id='title_<?= $file->id ?>'>
                <?= $file->title; ?>
            </span>
            <a href="javascript:void(0)" 
                class="editTitle pull-right" 
                data-value="<?= $file->title ?>" 
                data-pk="<?= $file->id; ?>">
                    <i class="fa fa-pencil"></i>
            </a>
        <?php endif; ?>
    </td>
    <td>
        <?= $file->filename; ?>
    </td>
    <td>
        <?= $file->ext; ?>
    </td>
    <td class='text-right'>
        <?= Number::toReadableSize($file->size); ?>
    </td>
    <?php if ($this->request->session()->read('Auth.User.role') == 'admin') : ?>
        <td>
            <?= $file->user_id ; ?>
        </td>
    <?php endif; ?>
    <td>
        <?php echo !empty($file->created) ? Time::parse($file->created->i18nFormat())->format('Y-m-d H:i') : ''; ?>
    </td>
    <td class="text-center">
        <span class="text-center ">
            <?php echo $this->Html->link(
                '<i class="fa fa-link btn btn-primary"></i> ',
                'javascript:void(0)',
                [
                    'escape' => false,
                    'class' => 'getFileLink',
                    'data-value' => $this->Url->build('/', true) . 'files/uploads/' . $file->filename,
                    'data-pk' => $file->id
                ]
            );
            echo $this->Html->link(
                '<i class="fa fa-download btn btn-primary"></i> ',
                ['action' => 'download', $file->filename],
                ['escape' => false]
            );
            echo $this->Html->link(
                '<i class="fa fa-times btn btn-primary"></i> ',
                ['controller' => 'files', 'action' => 'delete', $file->id],
                [
                    'role' => 'button',
                    'escape' => false,
                    'title' => __('Delete this file'),
                    'confirm' => __('Are you sure? You want to delete this file.')
                ]
            ); ?>
        </span>
    </td>
</tr>
