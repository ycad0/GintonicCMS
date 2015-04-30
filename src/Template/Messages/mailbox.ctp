<?php

use Cake\I18n\Time;
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2> Inbox </h2>
        </div>
        <div class="col-md-12">
            <?php if (!empty($messages->toArray())): ?>
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
                                            );?>
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
                <h3>Your inbox is empty</h3>
            <?php endif; ?>
        </div>
    </div>
</div>
