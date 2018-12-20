<?php

/* https://api.telegram.org/botXXXXXXXXXXXXXXXXXXXXXXX/getUpdates,
где, XXXXXXXXXXXXXXXXXXXXXXX - токен вашего бота, полученный ранее */

$name = $_POST['user_name'];
// $phone = $_POST['user_phone'];
// $email = $_POST['user_email'];
$message = $_POST['user_message'];
$token = "638820730:AAF5gPV8kc061YHjFMwHRSip9VKy8bwj-9U";
$chat_id = "-247451964";
$arr = array(
  'Имя пользователя: ' => $name,
//   'Телефон: ' => $phone,
//   'Email' => $email,
  'Сообщение пользователя: ' => $message,
);

foreach($arr as $key => $value) {
  $txt .= "<b>".$key."</b> ".$value."%0A";
};

$sendToTelegram = fopen("https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chat_id}&parse_mode=html&text={$txt}","r");

if ($sendToTelegram) {
  header('Location: thank-you.html');
} else {
  echo "Error";
}
?>