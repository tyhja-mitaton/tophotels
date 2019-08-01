<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'queue'],
    'controllerNamespace' => 'app\commands',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
		'@common/mail' => 'mail',
		'@runtime/queue' => 'runtime/queue',
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
		'queue' => [
            'class' => \yii\queue\file\Queue::class,
            'as log' => \yii\queue\LogBehavior::class,
            'path' => '@runtime/queue',// Индивидуальные настройки драйвера
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
    ],
    'params' => $params,
    /*
    'controllerMap' => [
        'fixture' => [ // Fixture generation command line.
            'class' => 'yii\faker\FixtureController',
        ],
    ],
    */
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
