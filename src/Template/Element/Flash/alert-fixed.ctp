<?php if (!isset($params['class'])) {
    $params['class'] = false;
}
if (!isset($params['close'])) {
    $params['close'] = true;
}
?>

<div class="floating-flash">
    <div class="inner-flash">
        <div class="container">

            <div class="alert<?php echo ($params['class']) ? ' ' . $params['class'] : null; ?>">
                <?php if ($params['close']): ?>
                    <a class="close" data-dismiss="alert" href="#">×</a>
                <?php endif; ?>
                <?php echo $message; ?>
            </div>

        </div>
    </div>
</div>

