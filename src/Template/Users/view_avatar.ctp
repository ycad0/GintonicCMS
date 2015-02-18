<div class="row">
    <div class="col-md-12">
        <h1><?php echo $user->first.' '.$user->last?></h1>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <img src="http://i.imgur.com/dCVa3ik.jpg" class="img-responsive img-thumbnail" alt="Responsive image">
        <h2><a href="mailto:<?php echo $user->email?>"><?php echo $user->email; ?></a></h2>
    </div>
    <div class="col-md-8">
        
    </div>
</div>
<hr/>