<?php

use Cake\I18n\Time;
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>
                Threads with : 
                <?php
                echo $recipientDetail->first. ' ' . $recipientDetail->last;
                echo $this->Html->link('Back', ['controller' => 'messages', 'action' => 'mailbox', 'plugin' => 'GintonicCMS'], ['class' => 'btn btn-primary pull-right']); ?>
            </h2>
        </div>
        <div class="col-md-12">
            <?php if (!empty($chats)): ?>
                <table class="table table-hover table-bordered">
                    <?php foreach ($chats as $key => $chat):
                        ?>
                        <tr>
                            <td colspan="4">
                                <?php
                                $dateClass = 'pull-right';
                                $class = '';
                                $textClass = '';
                                if ($userId == $chat->Sender->id):
                                    $class = 'pull-right';
                                    $textClass = 'text-right';
                                    $dateClass = 'pull-left';
                                endif;
                                ?>
                                <div class="col-md-12 col-sm-12">
                                    <div class="col-md-1 col-sm-1 <?= $class ?>">
                                        <?= $this->Html->image($this->File->getFileUrl($chat->Sender->file->filename, $chat->Sender->file->dir), ['style' => 'width: 50px; height: 50px']); ?>
                                    </div>
                                    <div class="col-md-11 col-sm-11 <?= $textClass ?>">
                                        <h4>
                                            <?= $chat->Sender->first . ' ' . $chat->Sender->last; ?>
                                        </h4>
                                        <span><?= $chat->body ?></span>
                                        <span class="<?= $dateClass ?>"><?= Time::parse($chat->created->i18nFormat())->format('F jS, Y') ?></span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif;
            ?>
        </div>
    </div>
</div>