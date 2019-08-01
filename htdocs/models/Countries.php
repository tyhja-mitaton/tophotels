<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;

class Countries extends ActiveRecord {
	
	public static function getDb() {
    return Yii::$app->pgdb;
	}
	
	public static function tableName()
	{
		return 'dict.dict_country';
	}
	
}