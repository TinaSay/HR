<?php

$config = [
    'id' => 'web',
    'defaultRoute' => 'system',
    'as beforeRequest' => [
        'class' => \krok\system\components\backend\AccessControl::class,
        'except' => [
            'gii/*',
            'debug/*',
            'auth/default/oauth',
            'auth/default/login',
            'auth/default/logout',
            'auth/default/captcha',
        ],
    ],
    'on afterRequest' => function () {
        /**
         * see. https://content-security-policy.com/
         */
        Yii::$app->getResponse()->getHeaders()->add('Content-Security-Policy',
            'default-src \'none\'; script-src \'self\' \'unsafe-inline\' \'unsafe-eval\'; connect-src \'self\'; child-src \'self\'; img-src * data:; style-src * \'unsafe-inline\'; font-src * data:; media-src *;');
    },
    'container' => [
        'definitions' => [
            \yii\captcha\CaptchaAction::class => [
                'transparent' => true,
            ],
            \krok\editor\interfaces\EditorInterface::class => \krok\imperavi\widgets\ImperaviWidget::class,
            \krok\imperavi\widgets\ImperaviWidget::class => [
                'clientOptions' => [
                    'imageResizable' => true,
                    'imagePosition' => true,
                    'minHeight' => 400,
                    'maxHeight' => 400,
                    'lang' => 'ru',
                    'fileUpload' => '/cp/imperavi/default/file-upload',
                    'fileManagerJson' => '/cp/imperavi/default/file-list',
                    'imageUpload' => '/cp/imperavi/default/image-upload',
                    'imageManagerJson' => '/cp/imperavi/default/image-list',
                    'plugins' => [
                        'source',
                        'filemanager',
                        'clips',
                        'imagemanager',
                        'definedlinks',
                        'fontfamily',
                        'fontcolor',
                        'fontsize',
                        'table',
                        'video',
                        'alignment',
                        'fullscreen',
                        'inlinestyle',
                        'properties',
                    ],
                ],
            ],
            \krok\backupManager\Manager::class => function () {
                $filesystems = new \BackupManager\Filesystems\FilesystemProvider(new \BackupManager\Config\Config([
                    'local' => [
                        'type' => 'Local',
                        'root' => Yii::getAlias('@runtime/backup/database'),
                    ],
                ]));
                $filesystems->add(new \BackupManager\Filesystems\LocalFilesystem());

                $databases = new \BackupManager\Databases\DatabaseProvider(new \BackupManager\Config\Config([
                    'db' => [
                        'type' => 'mysql',
                        'host' => getenv('MYSQL_HOST'),
                        'port' => 3306,
                        'user' => getenv('MYSQL_USER'),
                        'pass' => getenv('MYSQL_PASSWORD'),
                        'database' => getenv('MYSQL_DATABASE'),
                        'singleTransaction' => true,
                    ],
                ]));
                $databases->add(new \BackupManager\Databases\MysqlDatabase());

                $compressors = new \BackupManager\Compressors\CompressorProvider();
                $compressors->add(new \BackupManager\Compressors\GzipCompressor());

                $finder = (new \Symfony\Component\Finder\Finder())->ignoreUnreadableDirs(true)->ignoreVCS(true)->exclude([
                    'framework/runtime/backup',
                    'web/cp/assets',
                    'web/assets',
                    'web/uploads',
                ])->in(dirname(Yii::getAlias('@root')));
                $compressor = new \krok\archiver\compressor\ZipCompressor(['path' => Yii::getAlias('@runtime/backup/filesystem')]);

                ini_set('max_execution_time', 90);

                return new \krok\backupManager\Manager(
                    new \BackupManager\Manager($filesystems, $databases, $compressors),
                    new \krok\archiver\Manager($finder, $compressor)
                );
            },
        ],
    ],
    'bootstrap' => [
        'logging' => [
            'class' => \krok\logging\Bootstrap::class,
        ],
    ],
    'modules' => [
        'system' => [
            'class' => \krok\system\Module::class,
            'viewPath' => '@vendor/yii2-developer/yii2-system/views/backend',
            'controllerNamespace' => 'krok\system\controllers\backend',
        ],
        'logging' => [
            'class' => \krok\logging\Module::class,
            'viewPath' => '@vendor/yii2-developer/yii2-logging/views/backend',
            'controllerNamespace' => 'krok\logging\controllers\backend',
        ],
        'imperavi' => [
            'class' => \krok\imperavi\Module::class,
            'uploadDirectory' => '@root/uploads/editor',
            'controllerNamespace' => 'krok\imperavi\controllers\backend',
        ],
        'auth' => [
            'class' => \app\modules\auth\Module::class, // todo
            'viewPath' => '@app/modules/auth/views/backend',
            'controllerNamespace' => 'app\modules\auth\controllers\backend',
        ],
        'content' => [
            'viewPath' => '@vendor/yii2-developer/yii2-content/views/backend',
            'controllerNamespace' => 'krok\content\controllers\backend',
        ],
        'example' => [
            'class' => \krok\example\Module::class,
            'viewPath' => '@vendor/yii2-developer/yii2-example/views/backend',
            'controllerNamespace' => 'krok\example\controllers\backend',
        ],
        'backupManager' => [
            'class' => \krok\backupManager\Module::class,
            'viewPath' => '@vendor/yii2-developer/yii2-backupManager/views/backend',
            'controllerNamespace' => 'krok\backupManager\controllers\backend',
        ],
        'cabinet' => [
            'class' => \krok\cabinet\Module::class,
            'viewPath' => '@app/modules/cabinet/views/backend',
            'controllerNamespace' => 'app\modules\cabinet\controllers\backend',
        ],
        'questionary' => [
            'class' => 'app\modules\questionary\Module',
            'viewPath' => '@app/modules/questionary/views/backend',
            'controllerNamespace' => 'app\modules\questionary\controllers\backend',
        ],
        'html' => [
            'viewPath' => '@vendor/contrib/yii2-html/views/backend',
            'controllerNamespace' => 'tina\html\controllers\backend',
        ],
    ],
    'components' => [
        'view' => [
            'class' => \yii\web\View::class,
            'theme' => [
                'class' => \yii\base\Theme::class,
                'basePath' => '@themes',
                'baseUrl' => '@themes',
                'pathMap' => [
                    '@vendor/yii2-developer/yii2-system/views/backend' => '@app/modules/system/views/backend',
                    '@vendor/yii2-developer/yii2-system/views/backend/layouts' => '@themes/views/layouts',
                ],
            ],
        ],
        'urlManager' => [
            'rules' => require(__DIR__ . DIRECTORY_SEPARATOR . 'backend' . DIRECTORY_SEPARATOR . 'rules.php'),
        ],
        'assetManager' => [
            'class' => \yii\web\AssetManager::class,
            'appendTimestamp' => true,
            'dirMode' => 0755,
            'fileMode' => 0644,
            'bundles' => [
                \yii\web\JqueryAsset::class => [
                    'js' => [
                        YII_ENV_DEV ? 'jquery.js' : 'jquery.min.js',
                    ],
                ],
                \yii\bootstrap\BootstrapAsset::class => [
                    'css' => [
                        YII_ENV_DEV ? 'css/bootstrap.css' : 'css/bootstrap.min.css',
                    ],
                ],
                \yii\bootstrap\BootstrapPluginAsset::class => [
                    'js' => [
                        YII_ENV_DEV ? 'js/bootstrap.js' : 'js/bootstrap.min.js',
                    ],
                ],
            ],
        ],
        'request' => [
            'class' => \krok\language\LanguageRequest::class,
            'csrfParam' => '_csrfBackend',
            'cookieValidationKey' => hash('sha512', __FILE__ . __LINE__),
        ],
        'user' => [
            'class' => \yii\web\User::class,
            'identityClass' => \app\modules\auth\models\Auth::class,
            'idParam' => '__idBackend',
            'authTimeoutParam' => '__expireBackend',
            'absoluteAuthTimeoutParam' => '__absoluteExpireBackend',
            'returnUrlParam' => '__returnUrlBackend',
            'loginUrl' => ['/auth/default/login'],
            // http://www.yiiframework.com/doc-2.0/yii-web-user.html#loginRequired()-detail
            'returnUrl' => ['/'],
            // Whether to enable cookie-based login: Yii::$app->user->login($this->getUser(), 24 * 60 * 60)
            'enableAutoLogin' => false,
            // http://www.yiiframework.com/doc-2.0/yii-web-user.html#$authTimeout-detail
            'authTimeout' => 1 * 60 * 60,
            'on afterLogin' => [
                \app\modules\auth\components\UserEventHandler::class,
                'handleAfterLogin',
            ],
            'on afterLogout' => [
                \app\modules\auth\components\UserEventHandler::class,
                'handleAfterLogout',
            ],
        ],
        'authClientCollection' => [
            'class' => \yii\authclient\Collection::class,
            'clients' => [
                'yandex' => [
                    'class' => \krok\oauth\YandexOAuth::class,
                    'clientId' => '',
                    'clientSecret' => '',
                    'normalizeUserAttributeMap' => [
                        'email' => 'default_email',
                    ],
                ],
                'google' => [
                    'class' => \krok\oauth\GoogleOAuth::class,
                    'clientId' => '',
                    'clientSecret' => '',
                    'normalizeUserAttributeMap' => [
                        'login' => ['emails', 0, 'value'],
                        'email' => ['emails', 0, 'value'],
                    ],
                ],
                'vkontakte' => [
                    'class' => \krok\oauth\VKontakte::class,
                    'clientId' => '',
                    'clientSecret' => '',
                    'normalizeUserAttributeMap' => [
                        'id' => 'user_id',
                        'login' => 'screen_name',
                    ],
                ],
                'facebook' => [
                    'class' => \krok\oauth\Facebook::class,
                    'clientId' => '',
                    'clientSecret' => '',
                    'normalizeUserAttributeMap' => [
                        'login' => 'id',
                    ],
                ],
                'twitter' => [
                    'class' => \krok\oauth\Twitter::class,
                    'consumerKey' => '',
                    'consumerSecret' => '',
                    'normalizeUserAttributeMap' => [
                        'login' => 'screen_name',
                    ],
                ],
                'gitlab' => [
                    'class' => \krok\oauth\GitLab::class,
                    'clientId' => '',
                    'clientSecret' => '',
                    'normalizeUserAttributeMap' => [
                        'login' => 'username',
                    ],
                ],
                'ok' => [
                    'class' => \krok\oauth\Ok::class,
                    'clientId' => '',
                    'clientSecret' => '',
                    'applicationKey' => '',
                    'normalizeUserAttributeMap' => [
                        'login' => 'uid',
                    ],
                    'scope' => 'VALUABLE_ACCESS,GET_EMAIL',
                ],
            ],
        ],
        'errorHandler' => [
            'class' => \krok\sentry\web\SentryErrorHandler::class,
            'errorAction' => 'system/default/error',
            'sentry' => \krok\sentry\Sentry::class,
        ],
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => \yii\debug\Module::class,
        'panels' => [
            'config' => false,
            'request' => [
                'class' => \yii\debug\panels\RequestPanel::class,
                'displayVars' => ['_GET', '_POST', '_COOKIE', '_SESSION', '_FILES'],
            ],
            'log' => [
                'class' => \yii\debug\panels\LogPanel::class,
            ],
            'profiling' => [
                'class' => \yii\debug\panels\ProfilingPanel::class,
            ],
            'db' => [
                'class' => \yii\debug\panels\DbPanel::class,
            ],
            'assets' => [
                'class' => \yii\debug\panels\AssetPanel::class,
            ],
            'mail' => [
                'class' => \yii\debug\panels\MailPanel::class,
            ],
            'timeline' => [
                'class' => \yii\debug\panels\TimelinePanel::class,
            ],
            'user' => [
                'class' => \yii\debug\panels\UserPanel::class,
            ],
            'router' => [
                'class' => \yii\debug\panels\RouterPanel::class,
            ],
        ],
        'allowedIPs' => [
            '*',
        ],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => \yii\gii\Module::class,
        'generators' => [
            'module' => [
                'class' => \yii\gii\generators\module\Generator::class,
                'messageCategory' => 'system',
                'templates' => [
                    'paperDashboard' => '@themes/gii/module',
                ],
                'template' => 'paperDashboard',
            ],
            'model' => [
                'class' => \yii\gii\generators\model\Generator::class,
                'generateQuery' => true,
                'useTablePrefix' => true,
                'messageCategory' => 'system',
                'templates' => [
                    'paperDashboard' => '@themes/gii/model',
                ],
                'template' => 'paperDashboard',
            ],
            'crud' => [
                'class' => \yii\gii\generators\crud\Generator::class,
                'enableI18N' => true,
                'baseControllerClass' => \krok\system\components\backend\Controller::class,
                'messageCategory' => 'system',
                'templates' => [
                    'paperDashboard' => '@themes/gii/crud',
                ],
                'template' => 'paperDashboard',
            ],
        ],
        'allowedIPs' => [
            '127.0.0.1',
            '::1',
            '172.72.*.*',
        ],
    ];
}

return \yii\helpers\ArrayHelper::merge(require(__DIR__ . DIRECTORY_SEPARATOR . 'common.php'), $config);
