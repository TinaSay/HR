<?php

/* @var $this yii\web\View */

use krok\paperDashboard\widgets\analytics\AnalyticsWidget;
use krok\paperDashboard\widgets\analytics\SpaceCircleChart;
use krok\paperDashboard\widgets\logging\LoggingWidget;

$this->title = 'Администрирование';
?>
<div class="row">
    <div class="style-card">
        <div class="col-lg-6">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-user-hello">
                        <div class="card-header">
                            <div class="card-header__inner">
                                <i class="card-user-hello__icon"></i>
                                <h4 class="card-title">Добро пожаловать!</h4>
                                <p class="category">Вы авторизовались, как <a href="#">webmaster</a></p>
                            </div>
                        </div>
                        <div class="card-footer">
                            <p class="category">
                                <i class="ti-time"></i>Ваше последнее посещение панели администратора:
                                <span>23.07.2017 в 17:56</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Избранное</h4>
                            <p class="category">Список ваших избранных страниц в панели администратора</p>
                        </div>
                        <div class="card-content">
                            <div class="table-full-width table-tasks">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td>
                                            <a class="link-not-color"
                                               href="http://mintrud.dev-vps.ru/cp/ru-RU/news/news/view/7">
                                                Данные мониторинга рынка труда по субъектам Российской Федерации
                                            </a>
                                        </td>
                                        <td class="td-actions text-right">
                                            <div class="table-icons">
                                                <button type="button" rel="tooltip" title=""
                                                        class="btn btn-invert btn-danger btn-simple btn-xs"
                                                        data-original-title="Удалить">
                                                    <i class="ti-close"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a class="link-not-color"
                                               href="http://mintrud.dev-vps.ru/cp/ru-RU/event/event/view/72">
                                                Федеральный этап Всероссийского конкурса профессионального мастерства
                                                «Лучший по профессии» в номинации «Лучший электромонтер»
                                            </a>
                                        </td>
                                        <td class="td-actions text-right">
                                            <div class="table-icons">
                                                <button type="button" rel="tooltip" title=""
                                                        class="btn btn-invert btn-danger btn-simple btn-xs"
                                                        data-original-title="Удалить">
                                                    <i class="ti-close"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a class="link-not-color"
                                               href="http://mintrud.dev-vps.ru/cp/ru-RU/news/news/view/12">
                                                Руководитель Роструда Юрий Герций: Как найти новую работу и какую помощь
                                                может оказать государство
                                            </a>
                                        </td>
                                        <td class="td-actions text-right">
                                            <div class="table-icons">
                                                <button type="button" rel="tooltip" title=""
                                                        class="btn btn-invert btn-danger btn-simple btn-xs"
                                                        data-original-title="Удалить">
                                                    <i class="ti-close"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a class="link-not-color"
                                               href="http://mintrud.dev-vps.ru/cp/ru-RU/news/news/view/13">
                                                Мониторинг рынка труда: 40% уволенных сотрудников трудоустроены
                                            </a>
                                        </td>
                                        <td class="td-actions text-right">
                                            <div class="table-icons">
                                                <button type="button" rel="tooltip" title=""
                                                        class="btn btn-invert btn-danger btn-simple btn-xs"
                                                        data-original-title="Удалить">
                                                    <i class="ti-close"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a class="link-not-color"
                                               href="http://mintrud.dev-vps.ru/cp/ru-RU/event/event/view/89">
                                                Пресс-конференция заместителя министра Алексея Вовченко на тему:
                                                «Социальная поддержка россиян в 2013 году»
                                            </a>
                                        </td>
                                        <td class="td-actions text-right">
                                            <div class="icons-table">
                                                <button type="button" rel="tooltip" title=""
                                                        class="btn btn-invert btn-danger btn-simple btn-xs"
                                                        data-original-title="Удалить">
                                                    <i class="ti-close"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            <hr>
                            <a target="_blank" class="btn btn-success" href="https://metrika.yandex.ru/list">
                                Все избранные страницы
                            </a>
                        </div>
                    </div>
                </div>
                <?= LoggingWidget::widget() ?>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-chart">
                        <div class="card-header">
                            <h4 class="card-title">Посещаемость</h4>
                            <p class="category">Последние 10 дней</p>
                        </div>
                        <div class="card-content">
                            <div id="chartViews"></div>
                        </div>
                        <div class="card-footer">
                            <hr>
                            <a class="btn btn-success" href="https://metrika.yandex.ru/list">Посмотреть статистику</a>
                        </div>
                    </div>
                    <div class="card card-chart">
                        <div class="card-header">
                            <h4 class="card-title">Статистика обращений граждан</h4>
                            <p class="category">Информация за последние 6 месяцев о поданных обращениях и личных
                                кабинетах граждан</p>
                        </div>
                        <div class="card-content">
                            <div id="chartActivity"></div>
                        </div>
                        <div class="card-footer">
                            <hr>
                            <div class="chart-legend">
                                <span class="chart-legend__item"><i class="fa fa-circle text-primary"></i> Подано обращений</span>
                                <span class="chart-legend__item"><i class="fa fa-circle text-warning"></i> Создано личных кабинетов</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="row">
                                <div class="col-xs-5">
                                    <div class="icon-big icon-color-1"><i class="ti-files"></i></div>
                                </div>
                                <div class="col-xs-7">
                                    <div class="numbers">
                                        <p>Общее количество документов</p> 4 086
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="row">
                                <div class="col-xs-5">
                                    <div class="icon-big icon-color-2"><i class="ti-reload"></i></div>
                                </div>
                                <div class="col-xs-7">
                                    <div class="numbers">
                                        <p>Общее количество обращений</p> 721
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="two-card-info">
                    <div class="col-md-6 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Общие характеристики системы</h4>
                            </div>
                            <div class="card-content">
                                <ul class="system-info-list">
                                    <li>
                                        <?= AnalyticsWidget::widget(['name' => 'os/version', 'constructor' => ['s']]) ?>
                                    </li>
                                    <li>
                                        <?= AnalyticsWidget::widget(['name' => 'database/info']) ?>
                                    </li>
                                    <li>
                                        <?= AnalyticsWidget::widget(['name' => 'php/version']) ?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <?= SpaceCircleChart::widget() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
