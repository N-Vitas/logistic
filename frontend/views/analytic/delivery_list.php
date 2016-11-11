<div class="box box-success">
  <div class="box-header">
    <a href="/analytic/view?id=<?=$model->id?>"><h4 class="box-title"><i class="fa fa-archive"></i> <?=$model->client_name?></h4></a>
  </div>
  <div class="box-body list-group">
  	<div class="container-fluid">
	    <div class="list-group-item row">
	    	<div class="col-md-6 col-lg-6 col-xs-6"><?=$model->getAttributeLabel('id')?></div>
	    	<div class="col-md-6 col-lg-6 col-xs-6"><?=$model->id?></div>            	
	    </div>
	    <div class="list-group-item row">
	    	<div class="col-md-6 col-lg-6 col-xs-6"><?=$model->getAttributeLabel('created_at')?></div>
	    	<div class="col-md-6 col-lg-6 col-xs-6"><?=$model->created_at?></div>            	
	    </div>
	    <div class="list-group-item row">
	    	<div class="col-md-6 col-lg-6 col-xs-6"><?=$model->getAttributeLabel('city.title')?></div>
	    	<div class="col-md-6 col-lg-6 col-xs-6"><?=$model->city->title?></div>            	
	    </div>
	    <div class="list-group-item row">
	    	<div class="col-md-6 col-lg-6 col-xs-6"><?=$model->getAttributeLabel('address')?></div>
	    	<div class="col-md-6 col-lg-6 col-xs-6"><?=$model->address?></div>            	
	    </div>
	    <div class="list-group-item row">
	    	<div class="col-md-6 col-lg-6 col-xs-6"><?=$model->getAttributeLabel('phone')?></div>
	    	<div class="col-md-6 col-lg-6 col-xs-6"><?=$model->phone?></div>            	
	    </div>
	    <div class="list-group-item row">
	    	<div class="col-md-6 col-lg-6 col-xs-6"><?=$model->getAttributeLabel('paymentType')?></div>
	    	<div class="col-md-6 col-lg-6 col-xs-6"><?=$model->paymentType?></div>            	
	    </div>
	    <div class="list-group-item row">
	    	<div class="col-md-6 col-lg-6 col-xs-6"><?=$model->getAttributeLabel('orderStatus')?></div>
	    	<div class="col-md-6 col-lg-6 col-xs-6"><?=$model->orderStatus?></div>            	
	    </div>
	    <div class="list-group-item row">
	    	<div class="col-md-6 col-lg-6 col-xs-6"><?=$model->getAttributeLabel('delivery_date')?></div>
	    	<div class="col-md-6 col-lg-6 col-xs-6"><?=$model->delivery_date?></div>            	
	    </div>
	    <div class="list-group-item row">
	    	<div class="col-md-6 col-lg-6 col-xs-6"><?=$model->getAttributeLabel('price')?></div>
	    	<div class="col-md-6 col-lg-6 col-xs-6"><?=$model->price?></div>            	
	    </div>
  	</div>
  </div>
</div>