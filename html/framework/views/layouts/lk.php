<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 03.03.18
 * Time: 17:19
 */

/* @var $this \yii\web\View */

/* @var $content string */

use app\assets\AppAsset;
use app\assets\AppStatusAsset;
use yii\helpers\Html;
use yii\helpers\Url;

AppAsset::register($this);
AppStatusAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="header header-static">
    <div class="container">
        <a href="/" class="logo">
            <img src="/static/default/img/logo.svg">
            <p class="prime">Команда Губернатора</p>
            <p class="sub">Нижегородской области</p>
        </a>
        <div class="control-block">
            <a href="/#section-about" class="link-header">
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
            <a href="<?= Url::to(['/cabinet/default']); ?>" class="link-header link-icon user-in">
                <i class="icon-user"></i>
                <div class="link-cont">
                    <span>Личный кабинет</span>
                    <div class="link-border">
                        <div class="border-bg"></div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
<section class="page-lk">
    <div class="container">
        <div class="row">
            <?= $content ?>
            <div class="col-xs-12 col-md-4">
                <div class="sidebar-wrap">
                    <ul class="sidebar-list">
                        <li>
                            <?php
                            $currentUrl = Yii::$app->request->url;
                            $profileUrl = Url::to(['/cabinet/default']);
                            if (false !== strpos($currentUrl, $profileUrl)):
                                ?>
                                <span class="sidebar-ell-active">
                                    Профиль
                                </span>
                            <?php
                            else:
                                ?>
                                <a href="<?= $profileUrl; ?>" class="sidebar-link">
                                    Профиль
                                    <div class="link-border">
                                        <div class="border-bg"></div>
                                    </div>
                                </a>
                            <?php
                            endif;
                            ?>
                        </li>
                        <li>
                            <?php
                            $questionaryUrl = Url::to(['/cabinet/questionary/question']);
                            if (false !== strpos($currentUrl, $questionaryUrl)):
                                ?>
                                <span class="sidebar-ell-active">
                                    Моя анкета
                                </span>
                            <?php
                            else:
                                ?>
                                <a href="<?= $questionaryUrl; ?>" class="active sidebar-link">
                                    Моя анкета
                                    <div class="link-border">
                                        <div class="border-bg"></div>
                                    </div>
                                </a>
                            <?php
                            endif;
                            ?>
                        </li>
                        <?php
                        if (false && \app\modules\questionary\models\Client::isFullFilled()):
                            ?>
                            <li>
                                <?php
                                $questionaryUrl = Url::to(['/cabinet/video']);
                                if (false !== strpos($currentUrl, $questionaryUrl)):
                                    ?>
                                    <span class="sidebar-ell-active">
                                    Видеообращение
                                </span>
                                <?php
                                else:
                                    ?>
                                    <a href="<?= $questionaryUrl; ?>" class="active sidebar-link">
                                        Видеообращение
                                        <div class="link-border">
                                            <div class="border-bg"></div>
                                        </div>
                                    </a>
                                <?php
                                endif;
                                ?>
                            </li>
                        <?php
                        endif;
                        ?>
                        <li>
                            <a href="<?= Url::to(['/cabinet/default/logout']) ?>" class="sidebar-link">
                                Выход
                                <div class="link-border">
                                    <div class="border-bg"></div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
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
                    <a href="/#section-about" class="link-footer">О проекте</a>
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
                <p class="descr">Методология отбора кандидатов разработана Факультетом оценки и развития
                    управленческих кадров ВШГУ РАНХиГС и, начиная с 2014 г., используется при формировании резерва
                    управленческих кадров, находящегося под патронажем Президента Российской Федерации.</p>
            </div>
        </div>
    </div>
</footer>
<?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>
