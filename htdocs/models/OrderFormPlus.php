<?php

namespace app\models;

use Yii;
//use yii\db\ActiveRecord;
use app\models\OrderForm;

class OrderFormPlus extends OrderForm
{
	public function rules(){
		//$rules_arr = parent::rules();
		return [
		// имя, телефон обязательно
			['name', 'required', 'message' => 'Введите ваше имя'],
            ['phone', 'required', 'message' => 'Введите ваш телефон'],
			['body', 'required', 'message' => 'Введите ваш город'], //сюда пойдёт город туриста
			['email', 'email'],
			//['phone', 'integer', 'integerPattern' => '/^(\s*)?(\+)?([- _():=+]?\d[- _():=+]?){10,14}(\s*)?$/', 'message' => 'Телефон введён некорректно!'],
		];
	}
	
	public function sendMail($email)
	{
		//$cur_time = date('Y-m-d H:i:s');
		//$cur_plus2 = $cur_time+(60*2);
		parent::sendMail($email);
		/*while(true){
			if(date('Y-m-d H:i:s') >= $cur_plus2){
				parent::sendMail($email); break;
			}
				}*/
		/*Yii::$app->queuemailer->compose('order-mail-html', ['name'=>$this->name, 'phone'=>$this->phone, 'email'=>$email])
                ->setTo($email)
                ->setFrom($email) 
                ->setSubject('Добавлена новая заявка')
				//->delay(120)
                ->send();
				Yii::$app->queuemailer->getTransport()->stop();*/
		/*Yii::$app->mailer->compose('order-mail-html', ['name'=>$this->name, 'phone'=>$this->phone, 'email'=>$email])
                ->setTo($email)
                ->setFrom($email) 
                ->setSubject('Добавлена новая заявка')
                ->send();
				Yii::$app->mailer->getTransport()->stop();*/

            return true;
	}
}