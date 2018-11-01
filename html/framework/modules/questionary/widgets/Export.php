<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 14.03.18
 * Time: 13:46
 */

namespace app\modules\questionary\widgets;

use app\modules\questionary\models\DataField;
use app\modules\questionary\models\QuestionField;
use Closure;
use yii\base\NotSupportedException;
use yii\helpers\ArrayHelper;

/**
 * Class Export
 *
 * @package app\modules\questionary\widgets
 */
class Export extends \krok\extend\widgets\export\Export
{
    /**
     * @return $this
     * @throws NotSupportedException
     * @throws \PHPExcel_Exception
     */
    public function generate()
    {
        $this->phpExcel->setActiveSheetIndex(0);
        $sheet = $this->phpExcel->getActiveSheet();

        $this->dataProvider->setPagination([
            'pageSize' => false,
        ]);
        $models = $this->dataProvider->getModels();
        $questionaryFields = QuestionField::find()
            ->where(['hidden' => QuestionField::HIDDEN_NO])
            ->all();
        /** @var QuestionField[] $questionaryFields */
        foreach ($questionaryFields as $questionaryField) {
            $this->attributes[] = [
                'attribute' => $questionaryField->name,
                'value' => function ($model) use ($questionaryField) {
                    $field = new DataField($questionaryField, $model);

                    return $field->text;
                }
            ];
        }

        foreach ($this->attributes as $column => $property) {

            if (is_array($property)) {
                $attribute = ArrayHelper::getValue($property, 'attribute');
            } elseif (is_string($property)) {
                $attribute = $property;
            } else {
                throw new NotSupportedException('The "attributes" not support.');
            }

            $label = $attribute instanceof Closure ? call_user_func($attribute) : $this->model->getAttributeLabel(
                $attribute
            );

            $sheet->setCellValueByColumnAndRow($column, 1, $label);
        }

        foreach ($models as $row => $model) {
            foreach ($this->attributes as $column => $property) {

                if (is_array($property)) {
                    $attribute = ArrayHelper::getValue($property, 'value');
                    if ($attribute === null) {
                        $attribute = ArrayHelper::getValue($property, 'attribute');
                    }
                } elseif (is_string($property)) {
                    $attribute = $property;
                } else {
                    throw new NotSupportedException('The "attributes" not support.');
                }

                $value = $attribute instanceof Closure ? call_user_func($attribute, $model) : ArrayHelper::getValue(
                    $model,
                    $attribute
                );
                $sheet->setCellValueByColumnAndRow($column, $row + 2, $value);
            }
        }

        return $this;
    }
}
