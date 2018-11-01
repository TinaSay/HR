<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 04.03.18
 * Time: 20:04
 */

/** @var array $tabs */
/** @var array $tabsContent */
/** @var \app\modules\cabinet\models\Client $client */
?>

<div class="col-xs-12 col-md-8">
    <h1 class="section-title">Личный кабинет</h1>
    <div class="block-user-information">
        <div class="user-tabs tabs tabs_animate">
            <ul class='tabs-nav horizontal'>
                <?= implode('', $tabs); ?>
            </ul>
            <?= implode('', $tabsContent); ?>
        </div>
    </div>
    <?php if (\app\modules\questionary\models\Client::isSendProfile() == false) : ?>
        <div class="all-done-block">
            <form class="base-form ac-checkmark">
                <div class="info-card">
                    <img src="/static/default/img/doc.svg">
                    ВНИМАНИЕ! Для отправки на конкурс вам нужно ответить на все вопросы.
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-6">
                        <div class="faild-wrap ac-custom ac-checkbox">
                            <input id="chRes" name="<?= $client->formName(); ?>[goalReserve]"
                                <?= $client->goalReserve ? 'checked="checked"' : ''; ?>
                                   type="checkbox" class="checkbox__field">
                            <label for="chRes"><?= $client->getAttributeLabel('goalReserve'); ?></label>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <div class="faild-wrap ac-custom ac-checkbox">
                            <input id="chMin" name="<?= $client->formName(); ?>[goalMinister]"
                                <?= $client->goalMinister ? 'checked="checked"' : ''; ?>
                                   type="checkbox" class="checkbox__field">
                            <label for="chMin"><?= $client->getAttributeLabel('goalMinister'); ?></label>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <div class="faild-wrap ac-custom ac-checkbox">
                            <input id="readyMove" name="<?= $client->formName(); ?>[readyMove]"
                                   type="checkbox"
                                <?= $client->readyMove ? 'checked="checked"' : ''; ?>
                                   class="checkbox__field">
                            <label for="readyMove"><?= $client->getAttributeLabel('readyMove'); ?></label>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <div class="faild-wrap ac-custom ac-checkbox">
                            <input id="readyMunicipal" name="<?= $client->formName(); ?>[readyMunicipal]"
                                   type="checkbox"
                                <?= $client->readyMunicipal ? 'checked="checked"' : ''; ?>
                                   class="checkbox__field">
                            <label for="readyMunicipal"><?= $client->getAttributeLabel('readyMunicipal'); ?></label>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <button class="btn btn-prime" <?= \app\modules\questionary\models\Client::isFullFilled() ? '' : 'disabled="disabled"' ?>>
                            Отправить на конкурс
                        </button>
                    </div>
                </div>
            </form>
        </div>
    <?php endif; ?>
</div>
