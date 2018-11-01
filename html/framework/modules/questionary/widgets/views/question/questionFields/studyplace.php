<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 24.03.18
 * Time: 11:28
 */

use app\modules\questionary\widgets\StudyPlaceWidget;

/** @var \app\modules\questionary\models\DataField $dataField */
?>
    <div class="col-xs-12 study-place-area" data-name="<?= $dataField->fieldName; ?>">
        <?= StudyPlaceWidget::widget(['dataField' => $dataField]); ?>
    </div>
<?php
if (!\app\modules\questionary\models\Client::isFullFilled()):
    ?>
    <div class="col-xs-12">
	    <a href="javascript:void();" class="study-place-button add-btn btn btn-prime">
	        Добавить
	        <i class="icon-plus"></i>
	    </a>
	</div>
<?php
endif;
?>