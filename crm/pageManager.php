
<?php

class element {
  public $href      = 'example.php';
  public $classname = 'icon-example';
  public $name      = 'Пример'; 

  function isActive() {

    if (isset($GLOBALS['pagetitle'])) {
      $pagetitle = $GLOBALS['pagetitle'];
    } else {
      $pagetitle = '';
    }

    if ($pagetitle == $this->name) {
      return 'id = "active"';
    } else {
      return '';
    }
  }

  function __construct($href, $classname, $name) {
    $this->href      = $href;
    $this->classname = $classname;
    $this->name      = $name;
  }
}

function newElement($arrayToPushIn, $href, $classname, $name) {
  $singleElement = new element($href, $classname, $name);
  array_push($arrayToPushIn, $singleElement);
  return $arrayToPushIn;
}

$navElements = array();
//                                       ссылка на файл,   класс иконки,         название    
$navElements = newElement($navElements, 'dashboard.php',  'icon-th-list',       'Дашбоард');
$navElements = newElement($navElements, 'menu.php',       'icon-list-alt',      'Заказ');
$navElements = newElement($navElements, 'clients.php',    'icon-user',          'Клиенты');
$navElements = newElement($navElements, 'warehouse.php',  'icon-home',          'Склад');
$navElements = newElement($navElements, 'sales.php',       'icon-shopping-cart', 'Продажи');
$navElements = newElement($navElements, 'admin.php',      'icon-wrench',        'Админка');

?>