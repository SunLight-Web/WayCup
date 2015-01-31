<?php include('item_check.php'); ?>
       <div class="span10">
         <div class="main-content">
				<h3 class="main-title">Продажи</h3>
				<div class="date-picker">
					 <a href="?page=<?php echo $pageID; ?>&date=<?php echo date('Y-m-d', strtotime('-1 days', strtotime($date)));?>">< Туда</a>
					 <label><input type="date" onchange="window.location.replace('?page=<?php echo $pageID;?>&date=' + this.value);" name="date" value="<?php echo date('Y-m-d', strtotime($date));?>"></label>
			         <a href="?page=<?php echo $pageID; ?>&date=<?php echo date('Y-m-d', strtotime('+1 days', strtotime($date)));?>">Сюда ></a>
				</div>

<?php if (count($checks) != 0) { ?>

         <div class="table-client">
	         <table id='summary-table'>
		         <thead>
		         	<tr>
		         		<td>Клиент</td>
		         		<td>Заказы</td>
		         		<td>Сумма</td>
		         		<td>Время транзакции</td>
		         		<td>Бариста</td>
		         	</tr>
		         </thead>
		         <tbody>
					<?php
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
<?php } else { ?>
		<div class='empty-table'>
			<h4>Нихуя не продали в этот день.</h4>
		</div>
<?php }?>
         </div>
       </div>





