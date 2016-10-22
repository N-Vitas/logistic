<div class="row">
  <div class="col-md-4">
    <div class="alert alert-danger">
      <h5><i class="fa fa-dollar"></i> Итого отмененных наложенных платежей</h5>
      <h2><?= $cancelPayments ? $cancelPayments : 0 ; ?></h2>
    </div>
  </div>
  <div class="col-md-4">
    <div class="alert alert-success">
      <h5><i class="fa fa-dollar"></i> Итого получено наложенных платежей</h5>
      <h2><?= $finishedPayments ? $finishedPayments : 0 ; ?></h2>
    </div>
  </div>
  <div class="col-md-4">
    <div class="alert alert-warning">
      <h5><i class="fa fa-clock-o"></i> Итого ожидается наложенных платежей</h5>
      <h2><?= $toFinishPayments ? $toFinishPayments : 0 ; ?></h2>
    </div>
  </div>
</div>