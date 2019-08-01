<?php
namespace app\models;

use app\models\OrderFormPlus;
use yii\base\BaseObject;

class SendMailWithDelay extends BaseObject implements \yii\queue\JobInterface
{
	public function execute($queue)
	{
		$model = new OrderFormPlus();
		$model->sendMail(Yii::$app->params['adminEmail']);
	}
}