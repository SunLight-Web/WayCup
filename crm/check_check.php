<?php
// Переделать быдлокод: 
// 1) поменять return of getOrderedList. Вместо массива строк возвращать массив item объектов.

class item {
	public $id;
	public $name;
	public $price;
	public $quanity;
	function __construct($id, $name, $price, $quanity) {
		$this->id = $id;
		$this->name = $name;
		$this->price = $price;
		$this->quanity = $quanity;
	}

}

class item_check {
	public $id;
	public $baristaid;
	public $orderlist;
	public $cash;
	public $timecode;

	function __construct($id, $baristaid, $orderlist, $cash, $timecode) {
		$this->id 				= $id;
		$this->baristaid		= $baristaid;
		$this->orderlist 		= $orderlist;
		$this->cash 			= $cash;
		$this->timecode 		= substr($timecode, 8, strlen($timecode));

		
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
			$query = "SELECT `id`,`name` FROM `rawMaterials` WHERE `id` = " . $value;
			$stmt  = $mysqli->query($query);
			$row = $stmt->fetch_assoc();
			$element = new item($row['id'], $row['name'], 0 ,$repeats[$value]);
			$string = '';

			$string .= $element->name . ' ';
			$string .= '  x' . $element->quanity;
			$string .= '<br/>';
			array_push($preparedStrings, $string);

		}
		$preparedStrings = $preparedStrings;
		return $preparedStrings;
	}

	function show() {
	$mysqli = $GLOBALS['mysqli'];
	$query 		  = "SELECT `nicename` FROM `members` WHERE `id` = $this->baristaid";
	$baristaInfo  = $mysqli->query($query);
	$baristaInfo  = $baristaInfo->fetch_assoc();


              echo "<tr>";
				echo "<td>" . $baristaInfo['nicename'] . "</td>";
              	echo "<td>";
    // foreach for preapred array of orders goes here.
              	$preparedStrings = $this->getOrderedList();
              		foreach ($preparedStrings as $string) {
              			echo $string;
              		}
              	echo "</td>";
              	echo "<td>" . $this->cash . "₽</td>";
              	echo "<td>" . $this->timecode . "</td>";
              echo "</tr>";
	}
}

$checks = array();

$nextMonth     = date("Ymd", mktime(0, 0, 0, date("m")+1, date("d"),   date("Y")));
$previousMonth = date("Ymd", mktime(0, 0, 0, date("m")-1, date("d"),   date("Y")));

$query  = "SELECT `id`, `baristaid`, `items`, `cash`, `timecode` FROM `expenses` WHERE `timecode` BETWEEN '". $previousMonth  . "' AND '" . $nextMonth . "'	";
if (!$stmt = $mysqli->query($query)) {
echo '<h2>Сорян, что-то пошло не так :С</h2>';
die();
} else {
    while ($row = $stmt->fetch_assoc()) {
    	$anElement = new item_check($row['id'], $row['baristaid'], $row['items'], $row['cash'], $row['timecode']);
    	array_push($checks, $anElement);
    }

}
$totalMoney = 0;
$oneBigIdSet = '';
?>