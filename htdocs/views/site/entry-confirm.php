<?php
use yii\helpers\Html;
?>
<p>�� ����� ��������� ����������:</p>

<ul>
    <li><label>Name</label>: <?= Html::encode($model->name) ?></li>
    <li><label>Email</label>: <?= Html::encode($model->email) ?></li>
</ul>