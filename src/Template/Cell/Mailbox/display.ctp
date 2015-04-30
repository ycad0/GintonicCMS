<?php

use Cake\I18n\Time;
?>
<?php if ($messages->count()): ?>
    <table class="table table-hover table-bordered">
        <?php foreach ($messages as $key => $message): ?>
            <tr>
                <td colspan="4">
                    <div class="col-md-12 col-sm-12">
                        <div class="col-md-1 col-sm-1 ">
                            <?php
                            if (!empty($message->Sender->file->filename)):
                                echo $this->Html->image(
                                        $this->File->getFileUrl(
                                                $message->Sender->file->filename, $message->Sender->file->dir
                                        ), ['style' => 'width: 50px; height: 50px']
                                );
                            endif;
                            ?>
                        </div>
                        <div class="col-md-11 col-sm-11">
                            <h4>
                                <?php
                                $name = $message->Sender->first . ' ' . $message->Sender->last;
                                echo $this->Html->link($name, [
                                    'plugin' => 'GintonicCMS',
                                    'controller' => 'messages',
                                    'action' => 'mailboxView',
                                    $message->Sender->id
                                        ], ['escape' => false]
                                );
                                ?>
                            </h4>
                            <span><?= $message->body ?></span>
                            <span class="pull-right">
                                <?= Time::parse($message->created->i18nFormat())->format('F jS, Y') ?>
                            </span>
                        </div>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <h3>No unread message</h3>
<?php endif; ?>
