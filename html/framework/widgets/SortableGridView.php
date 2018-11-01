<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 14.03.18
 * Time: 16:37
 */

namespace app\widgets;

use Yii;

class SortableGridView extends \sjaakp\sortable\SortableGridView
{
    /**
     * items per page variants like [10,20,30]
     *
     * @var array
     */
    public $perPageVariants = [10, 20, 50];

    /**
     * default layout for this GridView
     *
     * @var string
     */
    public $layout = '<div>{items}</div><div> {pager}</div><div>{sizer}</div>';

    /**
     * renders the panel with the number of items per page
     * use {sizer} template in layout
     *
     * @param string $name
     *
     * @return bool|string
     */
    public function renderSection($name)
    {
        $result = parent::renderSection($name);
        if (!$result && $name === '{sizer}') {
            $result = $this->renderSizer();
        }

        return $result;
    }

    /**
     * render per-page menu
     */
    public function renderSizer()
    {
        if (empty($this->perPageVariants)) {
            return '';
        }

        $links = array();

        if (!empty($_GET['per-page'])) {
            $perPage = $_GET['per-page'];
        } else {
            $perPage = 20;
        }

        foreach ($this->perPageVariants as $count) :
            $params = array_replace($_GET, ['per-page' => $count]);
            if ($count == $perPage) {
                $links[] = $count;
            } else {
                $links[] = '<a href="'
                    . Yii::$app->urlManager->createUrl(array_merge([
                        Yii::$app->controller->route
                    ], $params))
                    . '">' . $count . '</a>';
            }
        endforeach;

        return 'Показывать по: ' . implode(' ', $links);
    }
}
