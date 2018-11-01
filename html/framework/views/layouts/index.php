<?php

/* @var $this \yii\web\View */

/* @var $content string */

use app\assets\AppAsset;
use app\modules\cabinet\widgets\LoginWidget;
use yii\helpers\Html;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="header header-absl">
    <div class="container">
        <a href="/" class="logo">
            <img src="/static/default/img/logo.svg">
            <p class="prime">Команда Губернатора</p>
            <p class="sub">Нижегородской области</p>
        </a>
        <div class="control-block">
            <a href="#section-about" class="link-scroll link-header">
                <div class="link-cont">
                    <span>О проекте</span>
                    <div class="link-border">
                        <div class="border-bg"></div>
                    </div>
                </div>
            </a>
            <a href="<?= \yii\helpers\Url::to(['/cabinet/rules']); ?>" class="link-header">
                <div class="link-cont">
                    <span>Правила участия</span>
                    <div class="link-border">
                        <div class="border-bg"></div>
                    </div>
                </div>
            </a>
            <?php
            if (Yii::$app->user->isGuest):
                ?>
                <span class="link-header link-icon md-trigger" data-modal="modalLogIn" data-tab="login">
                    <i class="icon-user"></i>
                    <div class="link-cont">
                        <span>Личный кабинет</span>
                        <div class="link-border">
                            <div class="border-bg"></div>
                        </div>
                    </div>
                </span>
            <?php
            else:
                ?>
                <a href="<?= Url::to(['/cabinet/default']); ?>" class="link-header link-icon user-in">
                    <i class="icon-user"></i>
                    <div class="link-cont">
                        <span>Личный кабинет</span>
                        <div class="link-border">
                            <div class="border-bg"></div>
                        </div>
                    </div>
                </a>
            <?php
            endif;
            ?>
        </div>
    </div>
</div>
<?= $content ?>
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-5 col-md-3">
                <a href="/" class="logo">
                    <img src="/static/default/img/logo.svg">
                    <p class="prime">Команда Губернатора</p>
                    <p class="sub">Нижегородской области</p>
                </a>
            </div>
            <div class="col-xs-12 col-sm-7 col-md-9">
                <div class="control-block">
                    <a href="#section-about" class="link-scroll link-footer">О проекте</a>
                    <a href="<?= \yii\helpers\Url::to(['/cabinet/rules']); ?>" class="link-footer">Правила участия</a>
                </div>
            </div>
            <!--
            <div class="col-xs-12 col-sm-12 col-md-3">
                <div class="social-block">
                    <ul class="social-list">
                        <li><a href="#"><i class="icon-soc-vk"></i></a></li>
                        <li><a href="#"><i class="icon-soc-odk"></i></a></li>
                        <li><a href="#"><i class="icon-soc-face"></i></a></li>
                        <li><a href="#"><i class="icon-soc-twit"></i></a></li>
                    </ul>
                </div>
            </div>
            -->
            <div class="col-xs-12">
                <p class="descr">Методология отбора кандидатов разработана Факультетом оценки и развития управленческих
                    кадров ВШГУ РАНХиГС и, начиная с 2014 г., используется при формировании резерва управленческих
                    кадров, находящегося под патронажем Президента Российской Федерации.</p>
            </div>
        </div>
    </div>
</footer>
<?= LoginWidget::widget() ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
