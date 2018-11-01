<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 09.03.18
 * Time: 14:38
 */

use app\modules\questionary\widgets\WorkPlaceWidget;

/** @var \app\modules\questionary\models\DataField $dataField */
?>
    <div class="col-xs-12 work-place-area" data-name="<?= $dataField->fieldName; ?>">
        <?= WorkPlaceWidget::widget(['dataField' => $dataField]); ?>
    </div>
<?php
if (!\app\modules\questionary\models\Client::isFullFilled()):
    ?>
    <div class="col-xs-12">
	    <a href="javascript:void();" class="work-place-button add-btn btn btn-prime">
	        Добавить
	        <i class="icon-plus"></i>
	    </a>
	</div>
<?php
endif;
?>