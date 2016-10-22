<?php
/**
 * Created by PhpStorm.
 * User: CrazyDeveloper
 * Date: 21-Mar-16
 * Time: 17:09
 */

namespace common\widgets;

use yii\base\Widget;

class FilterDeliveryForm extends Widget
{
    /**
     * @var $client Client клиент, по которому отображается информация
     */
    public $filterModel;

    public function init(){
        
    }

    public function run()
    {
        return $this->render('filter-delivary-form',['filterModel' => $this->filterModel]);
    }
}