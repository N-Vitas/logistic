<?php
/**
 * Created by PhpStorm.
 * User: CrazyDeveloper
 * Date: 21-Mar-16
 * Time: 17:09
 */

namespace common\widgets;


use common\models\Client;
use yii\base\Widget;

class FilterForm extends Widget
{
    /**
     * @var $client Client клиент, по которому отображается информация
     */
    public $filterModel;

    public function run()
    {
        return $this->render(
            'filter-form',
            [
                'filterModel' => $this->filterModel,
                'time' => date('H:i:s'),
            ]
        );
    }
}