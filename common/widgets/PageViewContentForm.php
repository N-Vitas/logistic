<?php
/**
 * Created by PhpStorm.
 * User: CrazyDeveloper
 * Date: 21-Mar-16
 * Time: 17:09
 */

namespace common\widgets;
use Yii;
use yii\base\Widget;

class PageViewContentForm extends Widget
{
  public $view = 'table';  

  public function run()
  {
    return $this->render('page-view-content', [
    	'view' => $this->view,
    ]);      
  }
}
