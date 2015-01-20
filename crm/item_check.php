<?php
// Переделать быдлокод: 
// 1) поменять return of getOrderedList. Вместо массива строк возвращать массив item объектов.
class item {
	public $id;
	public $name;
	public $amount;
	public $category;
	public $quanity;
	function __construct($id, $name, $amount, $category, $quanity) {
		$this->id = $id;
		$this->name = $name;
		$this->amount = $amount;
		$this->category = $category;
		$this->quanity = $quanity;
	}

}

class item_check {
	public $id;
	public $clientid;
	public $orderlist;
	public $cash;
	public $timecode;
	public $cups = 0;

	function __construct($id, $clientid, $orderlist, $cash, $timecode) {
		$this->id 				= $id;
		$this->clientid  		= $clientid;
		$this->orderlist 		= $orderlist;
		$this->cash 			= $cash;
		$this->timecode 		= substr($timecode, 10, strlen($timecode));

		
	}

	function kEbenyam(){
		$mysqli = $GLOBALS['mysqli'];
		$query = "DELETE FROM `checks` WHERE `id` = " . $this->id;
		$mysqli->query($query);
	}

	function getOrderedList(){
		$mysqli = $GLOBALS['mysqli'];
		$ordered = explode('.',$this->orderlist);
		$repeats = array_count_values($ordered);
		$ordered = array_unique($ordered);
		$preparedStrings = array();
		

		foreach ($ordered as $value) {
			$query = "SELECT `id`,`name`,`amount`,`category` FROM `menu` WHERE `id` = " . $value;
			$stmt  = $mysqli->query($query);
			$row = $stmt->fetch_assoc();
			$element = new item($row['id'], $row['name'], $row['amount'], $row['category'], $repeats[$value]);
			$string = '';

			$string .= $element->name . ' ';
			if ($element->category == 1) { $string .= $element->amount . 'мл'; $this->cups += 1*$element->quanity;} 
			$string .= '  x' . $element->quanity;
			$string .= '<br/>';
			array_push($preparedStrings, $string);

		}
		$preparedStrings['strings'] = $preparedStrings;
		$preparedStrings['cups']    = $this->cups;
		return $preparedStrings;
	}

	function show() {
	$mysqli = $GLOBALS['mysqli'];
	$cleintInfo   = $mysqli->query("SELECT `card`, `name`, `lastname` FROM `clients` WHERE `id` = '$this->clientid'");
	$cleintInfo   = $cleintInfo->fetch_assoc();


              echo "<tr>";
              	echo "<td>" . $cleintInfo['card'] . '<br/>' . $cleintInfo['name'] . ' ' . $cleintInfo['lastname'] .   "</td>";
              	echo "<td>";

    // foreach for preapred array of orders goes here.
              	$preparedStrings = $this->getOrderedList();

              		foreach ($preparedStrings['strings'] as $string) {
              			echo $string;
              		}

              	echo "</td>";
              	echo "<td>" . $this->cash . "₽</td>";
              	echo "<td>" . $this->timecode . "</td>";
              	echo "<td>" . "<a ondblclick='alert(\"Я пока не реализовал это дерьмо\")'>x</a>" . "</td>";
                echo "</tr>";
	}
}

$checks = array();
if (isset($_GET['date'])) {
	$date = $_GET['date'];
} else {
	$date = date('Y-m-d');
}

$today     = date('Ymd', strtotime('+1 days', strtotime($date)));
$yesterday = date('Ymd', strtotime($date));

$query  = "SELECT `id`, `clientid`, `orderlist`, `cash`, `timecode` FROM `check` WHERE `timecode` BETWEEN '". $yesterday  . "' AND '" . $today . "'	";
if (!$stmt = $mysqli->query($query)) {
echo '<h2>Сорян, что-то пошло не так :С</h2>';
die();
} else {
    while ($row = $stmt->fetch_assoc()) {
    	$anElement = new item_check($row['id'], $row['clientid'], $row['orderlist'], $row['cash'], $row['timecode']);
    	array_push($checks, $anElement);
    }

}
		$total = 0;
		$totalMoney = 0;
		$totalCups = 0;

?>