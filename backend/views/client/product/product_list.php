<div class="box box-success">
  <div class="box-header">
    <h4 class="box-title"><i class="fa fa-archive"></i> <?=$model->title?></h4>
  </div>
  <div class="box-body list-group">
  	<div class="container-fluid">
	    <div class="list-group-item row">
	    	<div class="col-md-6 col-lg-6 col-xs-6"><?=$model->getAttributeLabel('nomenclature')?></div>
	    	<div class="col-md-6 col-lg-6 col-xs-6"><?=$model->nomenclature?></div>            	
	    </div>
	    <div class="list-group-item row">
	    	<div class="col-md-6 col-lg-6 col-xs-6"><?=$model->getAttributeLabel('balance')?></div>
	    	<div class="col-md-6 col-lg-6 col-xs-6"><?=$model->balance?></div>            	
	    </div>
	    <?php if($model->article):?>
		    <div class="list-group-item row">
		    	<div class="col-md-6 col-lg-6 col-xs-6"><?=$model->getAttributeLabel('article')?></div>
		    	<div class="col-md-6 col-lg-6 col-xs-6"><?=$model->article?></div>            	
		    </div>
	  	<?php endif; ?>
	    <?php if($model->barcode):?>
		    <div class="list-group-item row">
		    	<div class="col-md-6 col-lg-6 col-xs-6"><?=$model->getAttributeLabel('barcode')?></div>
		    	<div class="col-md-6 col-lg-6 col-xs-6"><?=$model->barcode?></div>            	
		    </div>
	  	<?php endif; ?>
	    <?php if($model->code_client):?>
		    <div class="list-group-item row">
		    	<div class="col-md-6 col-lg-6 col-xs-6"><?=$model->getAttributeLabel('code_client')?></div>
		    	<div class="col-md-6 col-lg-6 col-xs-6"><?=$model->code_client?></div>            	
		    </div>
	  	<?php endif; ?>
  	</div>
  </div>
</div>