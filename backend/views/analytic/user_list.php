<div class="box box-success">
  <div class="box-header">
    <a href="/analytic/view?id=<?=$model->id?>"><h4 class="box-title"><i class="fa fa-archive"></i> <?=$model->username?></h4></a>
  </div>
  <div class="box-body list-group">
  	<div class="container-fluid">
	    <div class="list-group-item row">
	    	<div class="col-md-6 col-lg-6 col-xs-6"><?=$model->getAttributeLabel('newOrderCount')?></div>
	    	<div class="col-md-6 col-lg-6 col-xs-6"><?=$model->getNewOrdersCount()?></div>            	
	    </div>
	    <div class="list-group-item row">
	    	<div class="col-md-6 col-lg-6 col-xs-6"><?=$model->getAttributeLabel('workOrderCount')?></div>
	    	<div class="col-md-6 col-lg-6 col-xs-6"><?=$model->getWorkOrdersCount()?></div>            	
	    </div>
	    <div class="list-group-item row">
	    	<div class="col-md-6 col-lg-6 col-xs-6"><?=$model->getAttributeLabel('completeOrderCount')?></div>
	    	<div class="col-md-6 col-lg-6 col-xs-6"><?=$model->getCompleteOrdersCount()?></div>            	
	    </div>
  	</div>
  </div>
</div>