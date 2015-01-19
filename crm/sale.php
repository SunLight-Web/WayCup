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
?>
       <div class="span10">
         <div class="main-content">
			<h3 class="main-title">Продажи</h3><br/>
			<div class="date-picker">
			<!-- ПОФИКСИТЬ! ТУТ ХУЙНЯ! -->
				 <a href="?page=4&date=<?php echo date('Y-m-d', strtotime('-1 days', strtotime($date)));?>">< Туда</a>
				 	<form method="get" action="?page=4">
				         <label for="date">Выберите день
				         <input type="date" onchange="this.form.submit();" name="date" value="<?php echo date('Y-m-d', strtotime($date));?>"></label>
		         	</form>
		    <!-- ПОФИКСИТЬ! -->
		         <a href="?page=4&date=<?php echo date('Y-m-d', strtotime('+1 days', strtotime($date)));?>">Сюда ></a>
			</div>

         <div class="table-client">
         <table id='summary-table'>
         <thead>
         	<tr>
         		<td>Клиент</td>
         		<td>Заказы</td>
         		<td>Сумма</td>
         		<td>Время транзакции</td>
         		<td>Х</td>
         	</tr>
         </thead>
         <tbody>
<?php
$total = 0;
$totalMoney = 0;
$totalCups = 0;

    foreach ($checks as $singleCheck) {
    	$singleCheck->show();
    	$totalMoney += $singleCheck->cash;
    	$totalCups += $singleCheck->cups;
    	$total++;
    }
?>
		</tbody>
		</table>
		</div>
	
	<div class="day-stat table-client">
		<h4>Всего за день:</h4>
		<table>
				<thead>
					<tr>
						<td>Заказов</td>
						<td>Стаканов</td>
						<td>Касса</td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><?php echo '<b>' . $total . '</b>'; ?></td>
						<td><?php echo '<b>' . $totalCups . '</b>';?></td>
						<td><?php echo '<b>' . $totalMoney . '</b>₽'; ?></td>
					
					</tr>
				</tbody>
		</table>
		</div>
         </div>
       </div>