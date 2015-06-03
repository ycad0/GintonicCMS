<?= $this->element('infoboxes') ?>
<?= $this->element('monthlyrecap') ?>
<!-- Main row -->
<div class="row">
  <!-- Left col -->
  <div class="col-md-8">
    <?= $this->element('visitorreport') ?>
    <div class="row">
      <div class="col-md-6">
          <?= $this->element('chat') ?>
      </div>
      <div class="col-md-6">
          <?= $this->element('userlist') ?>
      </div>
    </div>
    <?= $this->element('latestorders') ?>
  </div><!-- /.col -->

  <div class="col-md-4">
    <?= $this->element('infoboxes2') ?>
    <?= $this->element('browserusage') ?>
    <?= $this->element('products') ?>
  </div><!-- /.col -->
</div><!-- /.row -->

