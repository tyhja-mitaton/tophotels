<?php

namespace app\models;

use yii\base\Object;
use yii\base\BaseObject;

class WriteJob extends BaseObject implements \yii\queue\JobInterface
{
    public $text;
    public $file;

    public function execute($queue)
    {
		//Yii::debug('tesssst');
		file_put_contents($this->file, $this->text);
    }
}