<?php

use app\modules\cabinet\assets\VideoRecorderAsset;
use app\modules\cabinet\widgets\FileuploadUIWidget;
use yii\helpers\Html;

/* @var $model app\modules\cabinet\models\ClientVideo */
/* @var $lastVideo app\modules\cabinet\models\ClientVideo */

VideoRecorderAsset::register($this);
?>
<div class="col-xs-12 col-md-8">
            <div class="block-user-video">
              <h1 class="section-title">Личный кабинет</h1>
              <h4 class="section-sub-title">Уважаемый коллега!</h4>
              <p>Ваше участие в Программе отбора кандидатов в резерв управленческих кадров Нижегородской области предполагает запись короткого видеообращения.</p>
              <h4 class="section-sub-title">Инструкция видеообращения</h4>
              <p>Внимание! Перед тем как приступить к записи видеообращения, внимательно Изучите регламент и содержание видеообращения.</p>
              <div id="ca-1" class="collapsable collapsable-base collapsable-slide">
                <div class="ca-control">Регламент видеообращения</div>
                <div class="ca-box">
                  <p class="strong">Ваши предложения по развитию или реформированию в регионе одного из предложенных направлений.</p>
                  <ul>
                    <li>Использование устройства с возможностью ведения видеозаписи;</li>
                    <li>Непосредственное нахождение в фокусе видеокамеры во время видеообращения;</li>
                    <li>Общее время видеозаписи — 3 минуты.</li>
                  </ul>
                </div>
              </div>
              <div id="ca-2" class="collapsable collapsable-base collapsable-slide">
                <div class="ca-control">Содержание видеообращения</div>
                <div class="ca-box">
                  <h4 class="sm-title">Видеообращение должно содержать в себе две части.</h4>
                  <div class="ca-card">
                    <div class="time"><img src="/static/default/img/time.svg">до 1 - 1,5 минуты</div>
                    <p class="card-name">Первая часть</p>
                    <p class="strong">Информация о себе:</p>
                    <ul>
                      <li>Фамилия Имя Отчество, возраст;</li>
                      <li>Ваша текущая должность и ключевые управленческие позиции, которые занимали;</li>
                      <li>Наиболее значимые личностно-профессиональные успехи и качества, которые им способствовали;</li>
                      <li>Ваша мотивация участия в резерве управленческих кадров.</li>
                    </ul>
                  </div>
                  <div class="ca-card">
                    <div class="time"><img src="/static/default/img/time.svg">до 2 минут</div>
                    <p class="card-name">Вторая часть</p>
                    <p class="strong">Ваши предложения по развитию или реформированию в регионе одного из предложенных направлений.</p>
                    <p>Важно обозначить основные проблемы, причины их возникновения, возможные способы устранения текущих проблем и пути дальнейшего развития, кратко изложить Вашу «дорожную карту» действий в отношении данного направления.</p>
                    <div class="hr-line"></div>
                    <p class="strong">Перечень возможных направлений:</p>
                    <ol>
                      <li>Жилищно-коммунальное хозяйство и благоустройство</li>
                      <li>Строительство и архитектура</li>
                      <li>Экономика и инвестиции</li>
                      <li>Управление финансами, налогами и сборами</li>
                      <li>Социальная поддержка и соцобеспечение</li>
                      <li>Образование и наука</li>
                      <li>Культура</li>
                      <li>Здравоохранение</li>
                      <li>Связи с населением и СМИ</li>
                      <li>Общественные организации и объединения</li>
                      <li>Управление человеческими ресурсами</li>
                      <li>Спорт и туризм</li>
                      <li>Молодежная политика</li>
                      <li>Правовое обеспечение государственного управления</li>
                      <li>Безопасность и правопорядок</li>
                      <li>Транспорт и дорожное хозяйство</li>
                      <li>Миграционная политика</li>
                      <li>Информационные технологии (IT-сопровождение государственного управления)</li>
                      <li>Организационно-административное сопровождение государственного управления</li>
                      <li>Природопользование и экология</li>
                      <li>Развитие промышленности и предпринимательства</li>
                      <li>Сельское хозяйство и развитие агропромышленного комплекса</li>
                    </ol>
                  </div>
                </div>
              </div>
              <h4 class="section-sub-title">Загрузка/запись видеообращения</h4>
              <p>Для начала запаси нажмите «Начать запись» на вкладке «Запись с вебкамеры», либо загрузите свое видеообращение на вкладке «Загрузка с компьютера».</p>

              <div class="card-user-video">
                <div class="video-tabs tabs tabs_animate">
                  <ul class='tabs-nav horizontal'>
                    <li><a href="#video-record" class="nav-ell">Запись с веб-камеры</a></li>
                    <li><a href="#video-upload" class="nav-ell">Загрузка с компьютера</a></li>
                  </ul>
                  <div id="video-record" class="tabs-cont">
                    <div id="record" class="tab-pane fade in active">
                      <div class="recordrtc">
                        <video controls id="record-video"></video>
                        <div class="upload-btn">
                          <button class="btn btn-prime" id="btn-record">Начать запись</button>
                          <button class="btn btn-prime" id="upload-to-server" disabled="true">Загрузить</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div id="video-upload" class="tabs-cont">
                    <?= FileuploadUIWidget::widget([
                        'model' => $model,
                        'attribute' => 'src',
                        'url' => ['/cabinet/video/upload-file'],
                        'gallery' => false,
                        'fieldOptions' => [
                            'multiple' => false,
                            'accept' => '.webm, .mp4, .mov',

                        ],
                        'clientOptions' => [
                            'maxFileSize' => 209715200,
                            'maxNumberOfFiles' => 100,
                        ],
                        'options' => [
                            'multiple' => false,
                        ],
                        // ...
                        'clientEvents' => [
                            'fileuploaddone' => 'function(e, data) {
                                
                                $(\'#last-video video\').attr(\'src\' , \'/uploads/video/upload/\' + data.result.files[0].name);
                                $(\'#last-video\').show();
                            }',
                            'fileuploadfail' => 'function(e, data) {
                                console.log(e);
                                console.log(data);
                            }',
                        ],
                    ]); ?>
                  </div>
                </div>

                <div class="video-user-loaded" id="last-video" style="<?= is_null($lastVideo) ? 'display:none' : '' ?>">
                  <?php if($lastVideo !== null) : ?>
                      <h4 class="sm-title">Ваше видеообращение</h4>
                      <div class="video-wrap">
                        <video controls src="<?= $lastVideo->src ?>"></video>
                      </div>
                  <?php endif; ?>
                </div>
              </div>
            </div>
</div>
