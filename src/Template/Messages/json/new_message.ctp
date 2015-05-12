<?php
$content = '<div class="chat-message text-right">'.
    '<div class="arrow_down text-info">'.
        $this->Html->link('<i class="fa fa-trash-o text-danger">&nbsp;</i>', ['plugin' => 'GintonicCMS', 'controller' => 'messages', 'action' => 'delete', $message['id']], ['class' => 'delete-message', 'escape' => false]).
        
        '<span>'.
            $message['body'].
        '</span>'.
    '</div>'.
'</div>';
echo json_encode(compact('content','status'));
