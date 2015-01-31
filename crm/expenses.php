<?php include('check_check.php'); ?>
       <div class="span10">
         <div class="main-content">
				<h3 class="main-title">Затраты</h3>
<?php if (count($checks) != 0) { ?>

         <div class="table-client">
	         <table id='summary-table'>
		         <thead>
		         	<tr>
		         		<td>Бариста</td>
		         		<td>Список покупок</td>
		         		<td>Сумма</td>
		         		<td>День<br>Время</td>
		         	</tr>
		         </thead>
		         <tbody>
					<?php
					    foreach ($checks as $singleCheck) {
					    	$singleCheck->show();
					    	$totalMoney += $singleCheck->cash;
					    	$oneBigIdSet .= '.' . $singleCheck->orderlist;
					    }
					?>
				</tbody>
			</table>
		</div>
	
	<div class="day-stat table-client">
		<h4>В этом месяце на всякое говно ушло <?php echo $totalMoney; ?> &#8381:</h4>

<?php
		$oneBigIdSet = substr($oneBigIdSet, 1, strlen($oneBigIdSet));
		$ordered = explode('.',$oneBigIdSet);
		$repeats = array_count_values($ordered);
		$ordered = array_unique($ordered);

		foreach ($ordered as $value) {
			$query = "SELECT `id`,`name`, `price` FROM `rawMaterials` WHERE `id` = " . $value;
			$stmt  = $mysqli->query($query);
			$row = $stmt->fetch_assoc();
			$element = new item($row['id'], $row['name'], $row['price'], $repeats[$value]);
			$string = '';

			$string .= $element->name . ' – ';
			$string .= $element->quanity . ' шт – ' . $element->price*$element->quanity . ' руб';
			$string .= '<br/>';
			echo $string;

		}

?>


	</div>
<?php } else { ?>
		<div class='empty-table'>
			<h4>Нихуя не купили.</h4>
		</div>
<?php }?>
         </div>
       </div>





