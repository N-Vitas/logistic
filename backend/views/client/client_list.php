
<div class="box box-success">
  <div class="box-header">
    <a href="/client/view?id=<?=$model->id?>"><h4 class="box-title"><i class="fa fa-archive"></i> <?=$model->name?></h4></a>
    <a class="pull-right" href="/client/update?id=<?=$model->id?>"><h4 class="box-title"><i class="glyphicon glyphicon-pencil"></i></h4></a>
  </div>
  <div class="box-body list-group">
    <div class="container-fluid">
        <div class="list-group-item row">
            <div class="col-md-6 col-lg-6 col-xs-6"><?=$model->getAttributeLabel('legal_name')?></div>
            <div class="col-md-6 col-lg-6 col-xs-6"><?=$model->legal_name?></div>               
        </div>
        <div class="list-group-item row">
            <div class="col-md-6 col-lg-6 col-xs-6"><?=$model->getAttributeLabel('productCount')?></div>
            <div class="col-md-6 col-lg-6 col-xs-6"><?=\common\models\Product::find()->where(['client_id' => $model->is_id])->count()?></div>               
        </div>
        <div class="list-group-item row">
            <div class="col-md-6 col-lg-6 col-xs-6"><?=$model->getAttributeLabel('settings.phone')?></div>
            <div class="col-md-6 col-lg-6 col-xs-6"><?=$model->settings->phone?></div>              
        </div>
        <div class="list-group-item row">
            <div class="col-md-6 col-lg-6 col-xs-6"><?=$model->getAttributeLabel('settings.email')?></div>
            <div class="col-md-6 col-lg-6 col-xs-6"><?=$model->settings->email?></div>              
        </div>
        <div class="list-group-item row">
            <div class="col-md-6 col-lg-6 col-xs-6"><?=$model->getAttributeLabel('activeOrders')?></div>
            <div class="col-md-6 col-lg-6 col-xs-6"><?=\common\models\Order::find()
                        ->where(['client_id' => $model->is_id])
                        ->andWhere(['in', 'status', [0,1,2]])
                        ->count();?></div>                
        </div>
    </div>
  </div>
</div>