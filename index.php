<?php
/**
 * Реализовать проверку заполнения обязательных полей формы в предыдущей
 * с использованием Cookies, а также заполнение формы по умолчанию ранее
 * введенными значениями.
 */

// Отправляем браузеру правильную кодировку,
// файл index.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');

// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  // Массив для временного хранения сообщений пользователю.
  $messages = array();

  // В суперглобальном массиве $_COOKIE PHP хранит все имена и значения куки текущего запроса.
  // Выдаем сообщение об успешном сохранении.
  if (!empty($_COOKIE['save'])) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('save', '', 100000);
    setcookie('login', '', 100000);
    // Выводим сообщение пользователю.
    $messages[] = 'Спасибо, результаты сохранены.';
    // Если в куках есть пароль, то выводим сообщение.
  }


  // Складываем признак ошибок в массив.
  $errors = array();
  $errors['name'] = !empty($_COOKIE['name_error']);
  $errors['email'] = !empty($_COOKIE['email_error']);
  $errors['date'] = !empty($_COOKIE['date_error']);
  $errors['ultimate'] = !empty($_COOKIE['ultimate_error']);
  $errors['bio'] = !empty($_COOKIE['bio_error']);
  $errors['radio-group-1'] = !empty($_COOKIE['radio-group-1_error']);
  $errors['radio-group-2'] = !empty($_COOKIE['radio-group-2_error']);

  // TODO: аналогично все поля.

  // Выдаем сообщения об ошибках.
  if ($errors['name']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('name_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните корректно имя.</div>';
  }
  if ($errors['email']) {
    setcookie('email_error', '', 100000);
    $messages[] = '<div class="error">Заполните корректно email.</div>';
  }
  if ($errors['date']) {
    setcookie('date_error', '', 100000);
    $messages[] = '<div class="error">Вы забыли заполнить дату.</div>';
  }
  if ($errors['ultimate']) {
    setcookie('ultimate_error', '', 100000);
    $messages[] = '<div class="error">Вы забыли выбрать суперспособность.</div>';
  }
  if ($errors['bio']) {
    setcookie('io_error', '', 100000);
    $messages[] = '<div class="error">Вы забыли рассказать о себе.</div>';
  }
  if ($errors['radio-group-1']) {
    setcookie('radio-group-1_error', '', 100000);
    $messages[] = '<div class="error">Вы забыли указать пол.</div>';
  }
  if ($errors['radio-group-2']) {
    setcookie('radio-group-2_error', '', 100000);
    $messages[] = '<div class="error">Вы забыли указать количество конечностей.</div>';
  }
  


  // TODO: тут выдать сообщения об ошибках в других полях.

  // Складываем предыдущие значения полей в массив, если есть.
  $values = array();
  
  // TODO: аналогично все поля.
  $values['name'] = empty($_COOKIE['name_value']) ? '' : strip_tags($_COOKIE['name_value']);
  $values['email'] = empty($_COOKIE['email_value']) ? '' : strip_tags($_COOKIE['email_value']);
  $values['date'] = empty($_COOKIE['date_value']) ? '' : strip_tags($_COOKIE['date_value']);
  $values['ultimate'] = empty($_COOKIE['ultimate_value']) ? '' : strip_tags($_COOKIE['ultimate_value']);
  $values['bio'] = empty($_COOKIE['bio_value']) ? '' : strip_tags($_COOKIE['bio_value']);
  $values['radio-group-1'] = empty($_COOKIE['radio-group-1_value']) ? '' : strip_tags($_COOKIE['radio-group-1_value']);
  $values['radio-group-2'] = empty($_COOKIE['radio-group-2_value']) ? '' : strip_tags($_COOKIE['radio-group-2_value']);
 
  // Включаем содержимое файла form.php.
  // В нем будут доступны переменные $messages, $errors и $values для вывода 
  // сообщений, полей с ранее заполненными данными и признаками ошибок.
  include('form.php');
}
// Иначе, если запрос был методом POST, т.е. нужно проверить данные и сохранить их в XML-файл.
else {
  // Проверяем ошибки.
  $errors = FALSE;
  if (empty($_POST['name']) || preg_match('/[^(\x7F-\xFF)|(\s)]/', $_POST['name'])) {
    // Выдаем куку на день с флажком об ошибке в поле fio.
    setcookie('name_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('name_value', $_POST['name'], time() + 30 * 24 * 60 * 60);
  }

  if (empty($_POST['email'])) {
    setcookie('email_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('email_value', $_POST['email'], time() + 30 * 24 * 60 * 60);
  }

  if (empty($_POST['date'])) {
    setcookie('date_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('date_value', $_POST['date'], time() + 30 * 24 * 60 * 60);
  }

  if (empty($_POST['ultimate'])) {
    setcookie('ultimate_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    $t=implode('',$_POST['ultimate']);
    setcookie('ultimate_value', $t, time() + 30 * 24 * 60 * 60);
  }
  if (empty($_POST['bio'])) {
    setcookie('bio_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('bio_value', $_POST['bio'], time() + 30 * 24 * 60 * 60);
  }

  if (empty($_POST['radio-group-1'])) {
    setcookie('radio-group-1_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('radio-group-1_value', $_POST['radio-group-1'], time() + 30 * 24 * 60 * 60);
  }
  if (empty($_POST['radio-group-2'])) {
    setcookie('radio-group-2_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('radio-group-2_value', $_POST['radio-group-2'], time() + 30 * 24 * 60 * 60);
  }

// *************
// TODO: тут необходимо проверить правильность заполнения всех остальных полей.
// Сохранить в Cookie признаки ошибок и значения полей.
// *************

  if ($errors) {
    // При наличии ошибок перезагружаем страницу и завершаем работу скрипта.
    header('Location: index.php');
    exit();
  }
  else {
    // Удаляем Cookies с признаками ошибок.
    setcookie('name_error', '', 100000);
    // TODO: тут необходимо удалить остальные Cookies.
    setcookie('email_error', '', 100000);
    setcookie('date_error', '', 100000);
    setcookie('ultimate_error', '', 100000);
    setcookie('bio_error', '', 100000);
    setcookie('radio-group-1_error', '', 100000);
    setcookie('radio-group-2_error', '', 100000);
  }
  $user = 'u47744';
$pass = '9352325';
$db = new PDO('mysql:host=localhost;dbname=u47744', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
$stmt = $db->prepare("INSERT INTO application_2 SET name = ?, email = ?, DataBr = ?, sex = ?, hands = ?, ult = ?, bio = ?");
$stmt -> execute([$_POST['name'],$_POST['email'],$_POST['date'],$_POST['radio-group-1'],$_POST['radio-group-2'],$_POST['bio']]);
$stmt = $db->prepare("INSERT INTO ult SET user_id = ?, nomer = ?");
$id = $db->lastInsertId();
foreach ($_POST['ultimate'] as $per) { 
  $stmt-> execute([$id,$per]);
} 

    // TODO: Сохранение данных формы, логина и хеш md5() пароля в базу данных.
    // ...
  
 

  // Сохранение в XML-документ.
  // ...

  // Сохраняем куку с признаком успешного сохранения.
  setcookie('save', '1');

  // Делаем перенаправление.
  header('Location: index.php');
}
