<?php

$config = [
    'id' => 'console',
    'controllerMap' => [
        // Migrations for the specific project's module
        'migrate' => [
            'class' => \yii\console\controllers\MigrateController::class,
            'migrationTable' => '{{%migration}}',
            'interactive' => false,
            'migrationPath' => [
                '@app/migrations',
                '@yii/rbac/migrations',
                '@app/modules/auth/migrations',
                '@app/modules/cabinet/migrations',
                '@app/modules/questionary/migrations',
                '@vendor/yii2-developer/yii2-logging/migrations',
                '@vendor/yii2-developer/yii2-storage/migrations',
                '@vendor/yii2-developer/yii2-content/migrations',
                '@vendor/yii2-developer/yii2-example/migrations',
                '@vendor/yii2-developer/yii2-cabinet/migrations',
                '@vendor/contrib/yii2-html/migrations',
                '@app/modules/html/migrations',
            ],
        ],
        'access' => [
            'class' => \krok\access\AccessController::class,
            'userIds' => [
                1,
            ],
            'rules' => [
                \app\modules\auth\rbac\AuthorRule::class,
            ],
            'roles' => [
                'isViewAnket',
            ],
            'config' => [
                [
                    'name' => 'system',
                    'controllers' => [
                        'default' => [
                            'index',
                            'flush-cache',
                        ],
                    ],
                ],
                [
                    'name' => 'logging',
                    'controllers' => [
                        'default' => [
                            'index',
                            'view',
                        ],
                    ],
                ],
                [
                    'name' => 'imperavi',
                    'controllers' => [
                        'default' => [
                            'file-upload',
                            'file-list',
                            'image-upload',
                            'image-list',
                        ],
                    ],
                ],
                [
                    'name' => 'auth',
                    'controllers' => [
                        'auth' => [
                            'index',
                            'create',
                            'update',
                            'delete',
                            'view',
                            'refresh-token',
                        ],
                        'log' => ['index'],
                        'social' => ['index'],
                        'profile' => ['index'],
                    ],
                ],
                [
                    'name' => 'content',
                    'controllers' => [
                        'default' => [],
                    ],
                ],
                [
                    'name' => 'example',
                    'controllers' => [
                        'default' => [],
                    ],
                ],
                [
                    'name' => 'backupManager',
                    'controllers' => [
                        'default' => [
                            'index',
                            'download',
                        ],
                        'database' => [
                            'backup',
                        ],
                        'filesystem' => [
                            'backup',
                        ],
                    ],
                ],
                [
                    'name' => 'cabinet',
                    'controllers' => [
                        'client' => [
                            'index',
                            'create',
                            'update',
                            'delete',
                            'view',
                            'login-as',
                            'refresh-token',
                        ],
                        'settings-mail' => [
                            'index',
                            'update',
                        ],
                        'log' => [
                            'index',
                        ],
                        'client-video' => [
                            'index',
                            'view',
                            'delete',
                        ],
                    ],
                ],
                [
                    'name' => 'questionary',
                    'controllers' => [
                        'question' => [
                            'index',
                            'create',
                            'update',
                            'delete',
                            'view',
                            'order',
                        ],
                        'question-field' => [
                            'index',
                            'create',
                            'update',
                            'delete',
                            'view',
                            'order',
                        ],
                        'question-field-value' => [
                            'index',
                            'create',
                            'update',
                            'delete',
                            'view',
                        ],
                        'result' => [
                            'index',
                            'view',
                            'download',
                        ],
                    ],
                ],
                [
                    'name' => 'html',
                    'controllers' => [
                        'html' => [
                            'index',
                            'view',
                            'create',
                            'update',
                            'delete',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'modules' => [],
    'components' => [
        'urlManager' => [
            'baseUrl' => '/',
            'hostInfo' => '/',
            'rules' => require(__DIR__ . DIRECTORY_SEPARATOR . 'frontend' . DIRECTORY_SEPARATOR . 'rules.php'),
        ],
        'errorHandler' => [
            'class' => \krok\sentry\console\SentryErrorHandler::class,
            'sentry' => \krok\sentry\Sentry::class,
        ],
    ],
];

return \yii\helpers\ArrayHelper::merge(require(__DIR__ . DIRECTORY_SEPARATOR . 'common.php'), $config);
