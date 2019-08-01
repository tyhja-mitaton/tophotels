<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class OrderComplexForm extends ActiveRecord{
	
	public function rules(){
		return [
			['direction', 'string'],
			['body', 'string'],
		];
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