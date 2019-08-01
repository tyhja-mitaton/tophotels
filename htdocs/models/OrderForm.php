<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;


class OrderForm extends ActiveRecord
{
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // имя, телефон обязательно
			['name', 'required', 'message' => 'Введите ваше имя'],
            ['phone', 'required', 'message' => 'Введите ваш телефон'],
            // email 
            ['email', 'email'],
			['body', 'string'],
			['phone', 'integer', 'integerPattern' => '/^(\s*)?(\+)?([- _():=+]?\d[- _():=+]?){10,14}(\s*)?$/', 'message' => 'Телефон введён некорректно!'],
			['id', 'integer'],
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return bool whether the model passes validation
     */
    public function sendMail($email)
    {
        if ($this->validate()) {
            Yii::$app->mailer->compose('order-mail-html', ['name'=>$this->name, 'phone'=>$this->phone, 'email'=>$email])
                ->setTo($email)
                ->setFrom($email) 
                ->setSubject('Добавлена новая заявка')
                ->send();
				Yii::$app->mailer->getTransport()->stop();

            return true;
        }
        return false;
    }
	public static function tableName()
	{
		return 'application';
	}
	
	public function behaviours(){
		return [
		'timestamp' => [
                     'class' => 'yii\behaviors\TimestampBehavior',
                     'attributes' => [
                         ActiveRecord::EVENT_BEFORE_INSERT => 'created_at',
									],
					 ],
					[
					'class' => TimestampBehavior::className(),
					'createdAtAttribute' => 'created_at',
					'updatedAtAttribute' => false,
					'value' => date('Y-m-d H:i:s'),
					],
				];
	}
}
