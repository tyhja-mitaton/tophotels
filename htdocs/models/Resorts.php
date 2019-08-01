<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;

class Resorts extends ActiveRecord {
	
	public static function getDb() {
    return Yii::$app->pgdb;
	}
	
	public static function tableName()
	{
		return 'dict.dict_resort';
	}
	
	public function filterByCountry($id) {
		$filtrd_resorts = self::find()->where(['country' => $id])->orderBy("name ASC")->all();
		return $filtrd_resorts;
	}
}