<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$pgdb = require __DIR__ . '/pgdb.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'admin', 'queue'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
		'@img'   => 'web/i',
		'@common/mail' => 'mail',
		'@runtime/queue' => 'runtime/queue',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '75yHq6DUIttctsS8-vBNRp-4J8pmoSrZ',
			'enableCsrfValidation' => false,
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
			'transport' => [
            'class' => 'Swift_SmtpTransport',
            'host' => 'smtp.gmail.com',
            'username' => 'test.th.welcome@gmail.com',
            'password' => 'xsfnqiubaakiaswt',
            'port' => '587',
            'encryption' => 'tls',
            ]
        ],
		'queuemailer' => [
			'class' => 'chulakov\queuemailer\Mailer',
			'messageClass' => 'chulakov\queuemailer\Message',
			'storageClass' => 'chulakov\queuemailer\models\QueueMail',
			'jobClass' => 'chulakov\queuemailer\jobs\MessageJob',
			// Базовый мейлер
			'viewPath' => '@common/mail',
			'useFileTransport' => false,
			//'messageConfig' => [],
			// Настройка компонентов
			'attacheComponent' => 'attachment',
			'mailerComponent' => 'mailer',
			'componentName' => 'queuemailer',
			'queueComponent' => 'queue',
		],
		
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
		
		'pgdb' => $pgdb,
        
        /*'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
			//'/' => 'site/default/index',
            ],
        ],*/
            'queue' => [
            'class' => \yii\queue\file\Queue::class,
            'as log' => \yii\queue\LogBehavior::class,
            'path' => '@runtime/queue',// Индивидуальные настройки драйвера
        ],
    ],
    'params' => $params,
	'modules' => [
        'admin' => [
            'class' => 'app\modules\admin\Module',
            // ... другие настройки модуля ...
        ],
		'debug' => [
            'class' => \yii\debug\Module::class,
            'panels' => [
                'queue' => \yii\queue\debug\Panel::class,
            ],
        ],
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
