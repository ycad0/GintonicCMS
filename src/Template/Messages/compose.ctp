<?php
use Cake\I18n\Time;
use Cake\View\Helper\UrlHelper;

$this->Helpers()->load('GintonicCMS.Form');
$this->Helpers()->load('GintonicCMS.Require');

echo $this->Require->req('messages/messages');
?>
<span class="messages">
        <!--<h1><?php echo __('Messages'); ?></h1>-->
        <?php echo $this->element('GintonicCMS.header',['recipientID'=>(isset($recipient['id'])?$recipient['id']:''),'isProhibitUser'=>(isset($isProhibitUser)?$isProhibitUser:'')]); ?>
        <div class="col-md-12  col-sm-12">
            <div class="col-md-7  col-sm-7 message-div">
                <?php
                if(isset($isGroupChat)){
                    echo $this->Form->create('Message', ['id' => 'GroupChatForm','url'=>['plugin'=>'GintonicCMS','controller'=>'messages','action'=>'set_group_chat'], 'class' => 'gorupChatForm']);
                    echo $this->Form->input('user_list',['label'=>false,'class'=>'form-control tokenfield']);
                    echo $this->Form->submit(__('Done'), ['class' => 'btn btn-sm btn-primary']);
                    echo $this->Form->end();
                }
                ?>
                <div class="col-md-12 col-sm-12 no-padding chat-msg-inner">
                    <?php foreach ($chats as $chat): ?>
                        <div class="chat-message <?php echo ($chat->user_id == $this->request->session()->read('Auth.User.id'))?'text-right':'text-left'; ?>">
                            <div class="<?php echo ($chat->user_id == $this->request->session()->read('Auth.User.id'))?'arrow_down ':'arrow_up '; ?><?php echo ((in_array($chat->id, $unReadMessage))&& ($chat->user_id != $this->request->session()->read('Auth.User.id')))?' text-info ':''?><?php echo (in_array($chat->id, $deletedMessage))?' deleted-message-color':''; ?>">
                                <?php 
                                    if(in_array($chat->id, $deletedMessage)){
                                        echo '<span>'.'This message has been removed.&nbsp;&nbsp;&nbsp;<i class="fa fa-trash-o"></i>'.'</span>';
                                    }else{
                                        if ($chat->user_id == $this->request->session()->read('Auth.User.id')) {
                                            echo $this->Html->link('<i class="fa fa-trash-o text-danger">&nbsp;</i>', ['plugin' => 'GintonicCMS', 'controller' => 'messages', 'action' => 'delete', $chat->id], ['class' => 'delete-message', 'escape' => false]);
                                        }else{
                                            //currently change status not included
//                                            $status = ((in_array($chat->id, $unReadMessage))&& ($chat->user_id != $this->request->session()->read('Auth.User.id')))?'read':'unread';
//                                            echo $this->Html->link($status, ['plugin' => 'GintonicCMS', 'controller' => 'messages', 'action' => 'change_status', $chat->id], ['class' => 'change-message-status','data-status'=>$status, 'escape' => false]);
                                        }
                                        echo '<span>'.$chat->body.'</span>';
                                    } 
                                ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php
                if(!isset($isGroupChat)){
                    echo $this->Form->create('Message', ['id' => 'MessageComposeForm','url'=>['plugin'=>'GintonicCMS','controller'=>'messages','action'=>'compose'], 'class' => 'messageForm']);
                    echo $this->Form->input('thread_id', ['type' => 'hidden','value' => $threadId]);
                    echo $this->Form->input('thread_participant_id', ['type' => 'hidden','value' => $threadParticipantId]);
                    echo $this->Form->input('thread_recipient_id', ['type' => 'hidden','value' => $threadRecipientId]);
                    echo $this->Form->input('user_id', ['type' => 'hidden','value' => $this->request->session()->read('Auth.User.id')]);
                    echo $this->Form->input('recipient_id', ['type' => 'hidden','value' => $recipient['id']]); 
                    echo $this->Form->input('body', ['label' => false,'placeholder' => 'Message body','rows' => '2','cols' => '140','class' => 'wysiwyg']); 
                    echo $this->Form->submit(__('Send Message'),['class'=>'btn btn-primary']);
                    echo $this->Form->end();
                }
                ?>
            </div>
        </div>
</span>
