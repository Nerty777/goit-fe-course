<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta charset="UTF-8">
  <title>Форма обратной связи</title>
</head>
<body>
  <form method="post" >
<input type="text" name="name" placeholder="Иван">
 <input type="email" name="email" placeholder="адрес электронной почты">
<textarea name="message" rows="5"></textarea>
<input type="submit" value="отправить">
</form>


<?php
// несколько получателей
$to  = 'sirogxod@gmail.com' . ', ';  // обратите внимание на запятую
$to  = 'nerty777@gmail.com' . ', ';
// $to .= 'wez@example.com';

// тема письма
$subject = 'Письмо с моего сайта https://xml.kiev.ua/serg/';

// текст письма
// $message = 'Пользователь ' . $_POST['name'] . ' отправил вам письмо:<br />' . $_POST['message'] . '<br />Связяться с ним можно по email <a href="mailto:' . $_POST['email'] . '">' . $_POST['email'] . '</a>';
$message = "Пользователь  {$_POST['name']} отправил вам письмо: {$_POST['message']} . Его email {$_POST['email']}.";


// Для отправки HTML-письма должен быть установлен заголовок Content-type
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 

// Дополнительные заголовки
$headers .= 'To: Иван <Ivan@example.com>' . "\r\n"; // Свое имя и email
$headers .= 'From: '  . $_POST['name'] . '<' . $_POST['email'] . '>' . "\r\n";
$email = $_POST['email'];
$headers = "From: nerty777@gmail.com \r\n";


// Отправляем
if (empty($email) == false) {mail($to, $subject, $message, $headers);};
if (empty($email) == false) {echo '<span style="font-size: 14px; color: green;">'.'Спасибо! '.'Мы свяжемся с Вами.'.'</span>';}

?>
</body>
</html>