<<<<<<< HEAD
       <div class="span10">
         	<div class="main-content">
				<h3 class="main-title">Дашборд</h3><br/>
			
			</div>
		</div>
=======
<?php
class item {
	public $id;
	public $name;
	public $amount;
	public $isCoffee;
	public $quanity;
	function __construct($id, $name, $amount, $isCoffee, $quanity) {
		$this->id = $id;
		$this->name = $name;
		$this->amount = $amount;
		$this->isCoffee = $isCoffee;
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
<<<<<<< HEAD

=======
	function getcups(){

	}
>>>>>>> front
	function getOrderedList(){
		$mysqli = $GLOBALS['mysqli'];
		$ordered = explode('.',$this->orderlist);
		$repeats = array_count_values($ordered);
		$ordered = array_unique($ordered);
		$preparedStrings = array();
		

		foreach ($ordered as $value) {
			$query = "SELECT `id`,`name`,`amount`,`isCoffee` FROM `menu` WHERE `id` = " . $value;
			$stmt  = $mysqli->query($query);
			$row = $stmt->fetch_assoc();
			$element = new item($row['id'], $row['name'], $row['amount'], $row['isCoffee'], $repeats[$value]);
			$string = '';

			$string .= $element->name . ' ';
			if ($element->isCoffee == 1) { $string .= $element->amount . 'мл'; $this->cups += 1*$element->quanity;} 
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

    // foreasch for preapred array of orders goes here.
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
	$day = $_GET['date'];
} else {
	$day = 0;
}

$dayString = '+' . $day . 'days';
$today = date('Ymd', strtotime($dayString));

$day++;
$dayString = '+' . $day . 'days';

$yesterday = date('Ymd',strtotime($dayString));

$query  = "SELECT `id`, `clientid`, `orderlist`, `cash`, `timecode` FROM `check` WHERE `timecode` BETWEEN '". $today  . "' AND '" . $yesterday . "'	";	
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
<<<<<<< HEAD
         <h3>Заказы за день #<?php echo $today;?></h3>
         <a href="?date=<?php echo $day-2 ; ?>"><<</a> 		 <a href="?date=0"> сегодня </a>         <a href="?date=<?php echo $day; ?>">>></a>
=======
         <h3 class="main-title">Продажи</h3> 
		
		<div class="date-picker">
			 
			<a href="">< Туда</a>
	         <label for="date">Выберите день
	         <input type="date" name="date"></label>
	         <a href="">Сюда ></a>

		</div>

>>>>>>> front
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
<<<<<<< HEAD
		<h5>Всего говна за день:</h5>
			<?php echo 'Гостей: <b>' . $total . '</b>' . '<br/>';      ?>
			<?php echo 'Бабок: <b>' . $totalMoney . '</b>₽' . '<br/>	'; ?>
			<?php echo 'Стаканов: <b>' . $totalCups . '</b>'; 		   ?>
=======

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
						<td>
						<div id='total'>Считаю...
							<script type="text/javascript">
								var rows = document.getElementById('summary-table').getElementsByTagName("tbody")[0].getElementsByTagName("tr").length;
								var total = document.getElementById('total');
								total.innerHTML = '<b>' + rows + '</b>';
							</script>
						</td>
						<td><?php echo '<b>' . $totalCups . '</b>';?></td>
						<td><?php echo '<b>' . $total . '</b>₽'; ?></td>
					
					</tr>
				</tbody>

			</table>		
		</div>
>>>>>>> front
         </div>
       </div>
>>>>>>> FETCH_HEAD
