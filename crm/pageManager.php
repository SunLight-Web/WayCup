
<?php

class element {
  public $href      = 'example.php';
  public $classname = 'icon-example';
  public $name      = 'Пример'; 
  public $isInNav   =  true;
  public $perms     =  false;

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

  function block() {
    $this->href = 'norights.php';
  }

  function __construct($href, $classname, $name, $isInNav, $perms) {
    $this->href      = $href;
    $this->classname = $classname;
    $this->name      = $name;
    $this->isInNav   = $isInNav;
    $this->perms     = $perms;
  }
}

function newElement($arrayToPushIn, $href, $classname, $name, $isInNav, $perms) {
  $singleElement = new element($href, $classname, $name, $isInNav, $perms);
  array_push($arrayToPushIn, $singleElement);
  return $arrayToPushIn;
}

//
//  Жекина CMS 1.0
//      vk.com/zhekaognemet
//
//
//                                          Все страницы:

$navElements = array();
//                                       ссылка на файл,   класс иконки,         название    в навигации?    нужны права? 
$navElements = newElement($navElements, 'dashboard.php',  'icon-th-list',       'Дашбоард',   true,            false);
$navElements = newElement($navElements, 'menu.php',       'icon-list-alt',      'Заказ',      true,            false);
$navElements = newElement($navElements, 'clients.php',    'icon-user',          'Клиенты',    true,            false);
$navElements = newElement($navElements, 'sales.php',      'icon-shopping-cart', 'Продажи',    true,            false);
$navElements = newElement($navElements, 'check.php',      'icon-tag',           'Закупка',    true,            false);
$navElements = newElement($navElements, 'expenses.php',   'icon-tags',          'Затраты',    true,            false);
$navElements = newElement($navElements, 'warehouse.php',  'icon-home',          'Склад',      true,            false);
$navElements = newElement($navElements, 'admin.php',      'icon-wrench',        'Админка',    true,            true);
$navElements = newElement($navElements, 'profile.php',    '',                   'Бариста',    false,           false);


?>