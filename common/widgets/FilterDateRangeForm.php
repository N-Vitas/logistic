<?php
/**
 * Created by PhpStorm.
 * User: CrazyDeveloper
 * Date: 21-Mar-16
 * Time: 17:09
 */

namespace common\widgets;

use yii\base\Widget;

class FilterDateRangeForm extends Widget
{
    /**
     * @var $client Client клиент, по которому отображается информация
     */
    public $filterModel;
    public $export=true;

    public function init(){
        
    }

    public function run()
    {
        return $this->render('filter-date-range-form',['filterModel' => $this->filterModel,'export'=>$this->export]);
    }
}