<div class="box box-success">
  <div class="box-header">
    <a href="/product/view?id=<?=$model->id?>"><h4 class="box-title"><i class="fa fa-archive"></i> <?=$model->product->title?></h4></a>
  </div>
  <div class="box-body list-group">
  	<div class="container-fluid">
	    <div class="list-group-item row">
	    	<div class="col-md-6 col-lg-6 col-xs-6"><?=$model->getAttributeLabel('product.nomenclature')?></div>
	    	<div class="col-md-6 col-lg-6 col-xs-6"><?=$model->product->nomenclature?></div>            	
	    </div>
	    <div class="list-group-item row">
	    	<div class="col-md-6 col-lg-6 col-xs-6"><?=$model->getAttributeLabel('product.balance')?></div>
	    	<div class="col-md-6 col-lg-6 col-xs-6"><?=$model->product->balance?></div>            	
	    </div>
	    <?php if($model->product->article):?>
		    <div class="list-group-item row">
		    	<div class="col-md-6 col-lg-6 col-xs-6"><?=$model->getAttributeLabel('product.article')?></div>
		    	<div class="col-md-6 col-lg-6 col-xs-6"><?=$model->product->article?></div>            	
		    </div>
	  	<?php endif; ?>
	    <?php if($model->product->barcode):?>
		    <div class="list-group-item row">
		    	<div class="col-md-6 col-lg-6 col-xs-6"><?=$model->getAttributeLabel('product.barcode')?></div>
		    	<div class="col-md-6 col-lg-6 col-xs-6"><?=$model->product->barcode?></div>            	
		    </div>
	  	<?php endif; ?>
	    <?php if($model->product->code_client):?>
		    <div class="list-group-item row">
		    	<div class="col-md-6 col-lg-6 col-xs-6"><?=$model->getAttributeLabel('product.code_client')?></div>
		    	<div class="col-md-6 col-lg-6 col-xs-6"><?=$model->product->code_client?></div>            	
		    </div>
	  	<?php endif; ?>
	    <div class="list-group-item row">
	    	<div class="col-md-6 col-lg-6 col-xs-6"><?=$model->getAttributeLabel('increase')?></div>
	    	<div class="col-md-6 col-lg-6 col-xs-6"><?=$model->increase?></div>            	
	    </div>
	    <div class="list-group-item row">
	    	<div class="col-md-6 col-lg-6 col-xs-6"><?=$model->getAttributeLabel('decrease')?></div>
	    	<div class="col-md-6 col-lg-6 col-xs-6"><?=$model->decrease?></div>            	
	    </div>
  	</div>
  </div>
</div>