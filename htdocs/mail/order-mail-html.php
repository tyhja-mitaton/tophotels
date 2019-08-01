<?php
use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this \yii\web\View view */
/* @var $message \yii\mail\BaseMessage */
/* @var $name \app\models\OrderForm */
/* @var $phone \app\models\OrderForm */
/* @var $email \app\models\OrderForm */
?>


<table border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#f0f4f5" style="height:100%"><tbody>
<tr><td valign="top" style="padding-top:30px">
<div style="margin:0 auto;max-width:600px;min-width:320px">
<table border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#ffffff"><tbody><tr>
<td style="border-bottom:1px solid #f0f4f5">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr><td style="padding:20px 0 20px 30px">
<img src="http://i.lightsoft.ru/th/logo0001.png" alt="" border="0" style="width:141px;height:53px" class="CToWUd">
</td><td style="padding:0 30px 25px 10px;font-family:Arial,sans-serif;font-size:16px;text-align:right;vertical-align:bottom;color:#292d96;font-weight:700">
Welcome.TopHotels.team</td></tr></tbody>
</table></td></tr>
<tr><td style="font:16px Arial,sans-serif;line-height:20px;padding:35px 30px 20px;text-align:center">Здравствуйте!</td>
</tr>
<tr><td style="font:16px Arial,sans-serif;line-height:20px;padding:0 30px 10px">
Вы получили новую заявку на подбор тура от пользователя - <a href="http://vanchugov.tophotels.site/?r=admin%2Fapplication%2Findex&page=1&per-page=10" style="font:16px Arial,sans-serif;line-height:20px;color:#318cc6;text-decoration:none" target="_blank">
№ <?= Yii::$app->db->getLastInsertID('application')?></a> Рекомендуем Вам скорее ее обработать и связаться с туристом.</td>
</tr>
<tr><td style="padding-bottom:20px;padding-top:20px">
<a href="http://vanchugov.tophotels.site/?r=admin%2Fapplication%2Findex&page=1&per-page=10" style="font:16px Arial,sans-serif;line-height:20px;display:block;width:230px;text-align:center;text-transform:uppercase;text-decoration:none;font-weight:bold;color:#ffffff;background-color:#00a551;margin:0 auto;padding:14px 0;border-radius:3px" target="_blank">
Просмотреть заявку</a></td>
</tr></tbody></table>
<table border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#ffffff" style="padding:15px"><tbody>
<tr><td style="border:1px solid #d4d8d9"><table border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
<tr><td style="font:16px Arial,sans-serif;line-height:20px;font-weight:bold;text-align:center;padding:15px">
Полезная информация</td></tr>
<tr><td style="font:15px Arial,sans-serif;line-height:20px;padding:0 15px 5px">
Ваш клиент: <a href="#" style="font:15px Arial,sans-serif;line-height:20px;color:#318cc6;text-decoration:none"><?= $name ?></a>
</td></tr>
<tr><td style="font:15px Arial,sans-serif;line-height:20px;padding:0 15px 5px">Телефон:
<a href="#" style="font:15px Arial,sans-serif;line-height:20px;color:#000000;text-decoration:none"><?= $phone?></a>
</td></tr></tbody></table></td></tr></tbody></table>
<table border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr>
 <td style="font-family:Arial,sans-serif;font-size:16px;text-align:center;padding:40px 5px">
Присоединяйтесь к нам в социальных сетях:</td></tr><tr><td style="text-align:center"><div style="max-width:300px;margin:0 auto">
<table border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr>
<td align="center"><a href="https://vk.com/tophotels" target="_blank">
<img src="http://i.lightsoft.ru/th/soc-vk2.png" alt="" style="width:38px;height:38px" class="CToWUd"></a></td>
<td align="center"><a href="https://www.facebook.com/TopHotels" target="_blank">
<img src="http://i.lightsoft.ru/th/soc-fb2.png" alt="" style="width:38px;height:38px" class="CToWUd"></a></td>
<td align="center"><a href="https://ok.ru/tophotels" target="_blank">
<img src="http://i.lightsoft.ru/th/soc-ok2.png" alt="" style="width:38px;height:38px" class="CToWUd"></a></td>
<td align="center"><a href="https://twitter.com/tophotels" target="_blank">
<img src="http://i.lightsoft.ru/th/soc-tw2.png" alt="" style="width:38px;height:38px" class="CToWUd"></a></td>
<td align="center"><a href="https://www.instagram.com/tophotels/" target="_blank">
<img src="http://i.lightsoft.ru/th/soc-in2.png" alt="" style="width:38px;height:38px" class="CToWUd"></a></td>
</tr></tbody></table></div></td></tr></tbody></table>
<table border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
<tr>
<td style="font-family:Arial,sans-serif;font-size:12px;line-height:16px;color:#999999;text-align:center;padding:30px 5px">
Это письмо отправлено на адрес <?= $email ?> автоматически. При возникновении вопросов вы можете 
обратиться в <a href="https://tophotels.ru/feedback">техподдержку TopHotels</a>
</td>
</tr></tbody></table></div></td></tr></tbody></table>

