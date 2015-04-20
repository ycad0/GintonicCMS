<?php
$videos = !empty($videos) ? $videos : []; //Array of video URL
$chunk = !empty($chunk) ? $chunk : 3; //How many chunk is wants.
$height = !empty($height) ? $height : 315; // Height of iFrame.
$videoField = !empty($videoField) ? $videoField : 'url'; // Height of iFrame.
$class = floor(12 / $chunk);
$class = 'col-md-'.$class.' col-sm-'.$class;
?>
<div class="row row-padded-lg">
    <div class="col-md-12">
        <?php if ($owner): ?>
            <?=
            $this->Html->link(
                    '<i class="fa fa-plus"></i> Add New Video', ['controller' => 'videos', 'action' => 'add'], [
                'class' => 'text-warning btn btn-primary pull-right',
                'escape' => false
                    ]
            );
            ?>
        <?php endif; ?>
    </div>
</div>
<div class="row-padded-sm">
    <?php
    $videoChunk = array_chunk($videos, $chunk);

    if (empty($videoChunk)):
        ?>

        <h3><?= __('No Videos Found'); ?></h3>
    <?php endif; ?>

    <?php foreach ($videoChunk as $videos): ?>
        <div class="row">
            <?php
            foreach ($videos as $key => $video):

                $youTubeUrl = $this->File->getYouTubeUrl($video['url']);
                if ($youTubeUrl):
                    ?>
                    <div class="<?= $class;?>">
                        <iframe width="100%" height="<?= $height;?>" frameborder="0" src="<?= $youTubeUrl; ?>"></iframe>
                    </div>
                <?php endif;
                ?>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
</div>