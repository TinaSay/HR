<?php

/* @var $this yii\web\View */

use app\modules\cabinet\models\Client;
use tina\html\widgets\HtmlWidget;
use yii\helpers\Url;

/* @var $dto \krok\content\dto\frontend\ContentDto */

$this->title = $dto->getTitle();

$this->registerMetaTag(['name' => 'keywords', 'content' => $dto->getKeywords()]);
$this->registerMetaTag(['name' => 'description', 'content' => $dto->getDescription()]);
/*
<div class="site-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= $dto->getText() ?>
    </p>
</div>
*/
?>
<!-- section-prime -->
<section class="section-prime section">
    <div class="prime-content">
        <div class="container">
            <h1>Команда Губернатора — программа по подбору сильных управленцев и лидеров</h1>
            <p>Зарегистрируйтесь и примите участие в конкурсе</p>
            <?php
            if (Yii::$app->user->isGuest):
                ?>
                <span class="btn btn-prime md-trigger"
                      data-modal="modalLogIn" data-tab="registration"
                      data-goal="<?= Client::GOAL_RESERVE; ?>">
                        Подать заявку в резерв
                </span>
                <span class="btn btn-prime md-trigger"
                      data-modal="modalLogIn" data-tab="registration"
                      data-goal="<?= Client::GOAL_MINISTER; ?>">
                        Конкурс на вакансии министров
                </span>
            <?php
            else:
                ?>
                <a href="<?= Url::to(['/cabinet/default']); ?>" class="btn btn-prime md-trigger">
                    Подать заявку в резерв
                </a>
                <a href="<?= Url::to(['/cabinet/default']); ?>" class="btn btn-prime md-trigger">
                    Конкурс на вакансии министров
                </a>
            <?php
            endif;
            ?>
        </div>
    </div>
    <div class="prime-map">
        <img src="/static/default/img/map_1.png">
    </div>
</section>
<!-- section-prime end -->

<!-- section-about -->
<section id="section-about" class="section-about section">
    <div class="container">
        <div class="card-about">
            <div class="row">
                <div class="col-xs-12 col-md-4">
                    <div class="card-avatar">
                        <div class="avatar" style="background-image: url('/static/default/img/demo/avatar.jpg');"></div>
                        <p class="name">Никитин<br/>Глеб Сергеевич</p>
                        <p class="sub">Врио Губернатора<br/>Нижегородской области</p>
                        <p class="descr">В Нижегородской области есть все для устойчивого развития, движения
                            вперед: хорошая экономическая и социальная база, активные, талантливые инициативные люди,
                            грамотные профессионалы. От консолидации наших усилий зависит благополучие всего региона,
                            всех нижегородцев.</p>
                    </div>
                </div>
                <div class="col-xs-12 col-md-8">
                    <div class="card-content">
                        <?= HtmlWidget::widget([
                            'name' => 'about',
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-5">
                <div class="vacancies-block">
                    <div class="vacancies-name">
                        <div class="vacancies-descr">
                            <span class="num">1</span>
                            <div class="text">
                                <span class="prime">вакансия</span>
                                <span class="sub">на должность</span>
                            </div>
                        </div>
                        <p>Заместитель главы администрации Нижнего Новгорода</p>
                    </div>
                </div>
                <div class="vacancies-block">
                    <div class="vacancies-name">
                        <div class="vacancies-descr">
                            <span class="num">2</span>
                            <div class="text">
                                <span class="prime">вакансии</span>
                                <span class="sub">на должность</span>
                            </div>
                        </div>
                        <p>Министр<br/>Правительства</p>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-7">
                <div class="opportunity-text">
                    <h2 class="section-title">Возможности</h2>
                    <p>Правительство Нижегородской области объявляет конкурс на замещение открытых вакансий на высшие
                        руководящие должности в органах исполнительной власти региона. На текущий момент открыто 2
                        вакансии на позиции министров и 1 вакансия на позицию Директора Департамента. Принять участие в
                        отборе в Команду Губернатора может гражданин Российской Федерации старше 25 лет, имеющий высшее
                        образование и необходимый управленческий опыт.</p>
                    <p>Оценка будет проводиться в два этапа: заочный и очный. Концепция отбора основана на ресурсном
                        подходе к анализу личных и профессиональных качеств претендентов. Данный анализ позволит
                        определить уровень управленческих компетенций кандидатов.</p>
                    <p>Для участия в проекте необходимо подать заявку на официальном сайте. После обработки поступивших
                        заявок претенденты пройдут квалификационные испытания. По их результатам будет принято решение о
                        включении кандидатов в резерв управленческих кадров.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- section-about end -->

<!-- section-mentor -->
<section class="section-mentor section">
    <div class="container">
        <div class="block-join">
            <h2 class="section-title">Стань участником<br/>Команды Губернатора!</h2>
            <p class="section-descr">Подай заявку на участие в конкурсе!</p>
            <div class="btn-wrap">
                <?php
                if (Yii::$app->user->isGuest):
                    ?>
                    <a href="#" class="btn btn-border md-trigger"
                       data-modal="modalLogIn" data-tab="registration"
                       data-goal="<?= Client::GOAL_RESERVE; ?>">
                        Подать заявку в резерв
                    </a>
                    <a href="#" class="btn btn-border md-trigger"
                       data-modal="modalLogIn" data-tab="registration"
                       data-goal="<?= Client::GOAL_MINISTER; ?>">
                        Конкурс на вакансии министров
                    </a>
                <?php
                else:
                    ?>
                    <a href="<?= Url::to(['/cabinet/default']); ?>" class="btn btn-border md-trigger">
                        Подать заявку в резерв
                    </a>
                    <a href="<?= Url::to(['/cabinet/default']); ?>" class="btn btn-border md-trigger">
                        Конкурс на вакансии министров
                    </a>
                <?php
                endif;
                ?>
            </div>
        </div>
        <h2 class="section-title">Наставники</h2>
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-3">
                <div class="card-mentor">
                    <div class="avatar-wrap">
                        <div class="avatar"
                             style="background-image: url('/static/default/img/demo/mentor_1.jpg');"></div>
                    </div>
                    <p class="name">Кириенко<br/>Сергей Владиленович </p>
                    <p class="descr">Первый заместитель Руководителя Администрации Президента</p>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3">
                <div class="card-mentor">
                    <div class="avatar-wrap">
                        <div class="avatar"
                             style="background-image: url('/static/default/img/demo/mentor_2.jpg');"></div>
                    </div>
                    <p class="name">Седых<br/>Анатолий Михайлович</p>
                    <p class="descr">Председатель совета директоров ОМК (Объединенная металлургическая компания)</p>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3">
                <div class="card-mentor">
                    <div class="avatar-wrap">
                        <div class="avatar"
                             style="background-image: url('/static/default/img/demo/mentor_3.jpg');"></div>
                    </div>
                    <p class="name">Рахманов<br/>Алексей Львович</p>
                    <p class="descr">Президент АО «ОСК» (Объединенная судостроительная корпорация)</p>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3">
                <div class="card-mentor">
                    <div class="avatar-wrap">
                        <div class="avatar"
                             style="background-image: url('/static/default/img/demo/mentor_4.jpg');"></div>
                    </div>
                    <p class="name">Панов<br/>Владимир Александрович</p>
                    <p class="descr">Глава города Нижнего Новгорода</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- section-mentor end -->

