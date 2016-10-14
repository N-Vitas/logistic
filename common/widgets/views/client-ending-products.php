<?php
/**
 * @var $endingProducts \common\models\Product[]
 * @var $endedProducts \common\models\Product[]
 */

?>

<div class="row">
    <div class="col-md-6">
        <div class="alert alert-warning">

            <a class="accordion-toggle" role="button" data-toggle="collapse" href="#ending-products-collapse"
               aria-expanded="false" aria-controls="ending-products-collapse">
                <i class="fa fa-sort-numeric-desc"></i> Заканчивающийся товар
            </a>

            <div class="collapse in" id="ending-products-collapse" aria-expanded="true">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Наименование</th>
                        <th>Кол-во</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($endingProducts as $product): ?>
                        <tr>
                            <td><?= $product->title ?></td>
                            <td><?= $product->balance ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    <div class="col-md-6">
        <div class="alert alert-danger">

            <a class="accordion-toggle" role="button" data-toggle="collapse" href="#ended-products-collapse"
               aria-expanded="false" aria-controls="ended-products-collapse">
                <i class="fa fa-times"></i> Закончившийся товар
            </a>
            <div class="collapse in" id="ended-products-collapse" aria-expanded="true">

                <table class="table">
                    <thead>
                    <tr>
                        <th>Наименование</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($endedProducts as $product): ?>
                        <tr>
                            <td><?= $product->title ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>