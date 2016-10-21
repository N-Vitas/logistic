<div class="row">
  <div class="col-md-4">
    <div class="alert alert-info">
      <h4><i class="fa fa-calendar"></i> Доставлено вчера</h4>
      <h2><?= $deliveredYesterday ?></h2>
    </div>
  </div>
  <div class="col-md-4">
    <div class="alert alert-success">
      <h4><i class="fa fa-check"></i> Доставлено сегодня</h4>
      <h2><?= $deliveredToday ?></h2>
    </div>
  </div>
  <div class="col-md-4">
    <div class="alert alert-warning">
      <h4><i class="fa fa-clock-o"></i> Ожидает доставки</h4>
      <h2><?= $toDeliver ?></h2>
    </div>
  </div>
</div>