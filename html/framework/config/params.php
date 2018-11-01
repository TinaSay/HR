<?php

return [
    'email' => getenv('EMAIL'),
    'emailConfigDir' => '@runtime/emailConfig/',
    'HTMLPurifier' => [
        'Attr.AllowedFrameTargets' => [
            '_blank',
            '_self',
            '_parent',
            '_top',
        ],
        'HTML.Trusted' => true,
        'Filter.YouTube' => true,
    ],
    'menu' => [
        [
            'label' => 'Content',
            'icon' => 'ti-files',
            'items' => [
                [
                    'label' => 'Content',
                    'url' => ['/content/default'],
                ],
                [
                    'label' => 'Logging',
                    'url' => ['/logging/default'],
                ],
                [
                    'label' => 'Example',
                    'url' => ['/example/default'],
                ],
                [
                    'label' => 'Backup Manager',
                    'url' => ['/backupManager/default'],
                ],
            ],
        ],
        [
            'label' => 'Html',
            'url' => ['/html/html'],
        ],
        [
            'label' => 'Cabinet',
            'items' => [
                [
                    'label' => 'Client',
                    'url' => ['/cabinet/client'],
                ],
                [
                    'label' => 'Settings mail',
                    'url' => ['/cabinet/settings-mail'],
                ],
                [
                    'label' => 'Log',
                    'url' => ['/cabinet/log'],
                ],
                [
                    'label' => 'Client Video',
                    'url' => ['/cabinet/client-video'],
                ],
            ],
        ],
        [
            'label' => 'Questionary',
            'items' => [
                [
                    'label' => 'Questions',
                    'url' => ['/questionary/question'],
                ],
                [
                    'label' => 'Questions Fields',
                    'url' => ['/questionary/question-field'],
                ],
                [
                    'label' => 'Questions Fields Values',
                    'url' => ['/questionary/question-field-value'],
                ],
                [
                    'label' => 'View',
                    'url' => ['/questionary/result'],
                ],
            ],
        ],
    ],
];
