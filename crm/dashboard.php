       <div class="span10">
         	<div class="main-content">
				<h3 class="main-title">Дашборд</h3><br/>
				<?php
					include('item_check.php');
					$checks = array();
					$clients = array();
					$totalMoney = 0;
					$query  = "SELECT `id`, `baristaid`, `clientid`, `orderlist`, `cash`, `timecode` FROM `check` ORDER BY `id` ASC";
					if (!$stmt = $mysqli->query($query)) {
					echo '<h2>Сорян, что-то пошло не так :С</h2>';
					die();
					} else {
					    while ($row = $stmt->fetch_assoc()) {
					    	$anElement = new item_check($row['id'], $row['baristaid'] ,$row['clientid'], $row['orderlist'], $row['cash'], $row['timecode']);
					    	array_push($checks, $anElement);
					    }

					}

					foreach ($checks as $singleCheck) {
						$singleCheck->getOrderedList();
						
						if (isset($clients[$singleCheck->clientid])) {
							$clients[$singleCheck->clientid] += $singleCheck->cups;
						} else {
							$clients[$singleCheck->clientid] = $singleCheck->cups;
						}
						$totalMoney += $singleCheck->cash;
						$totalCups  += $singleCheck->cups;
					}

					echo '<br>';
					echo 'Всего заказов оформили: <b>' . count($checks) . '</b><br>';
					echo 'Это <b>' . count($clients) . '</b> уникальных клиентов,' . '<br>';
					echo 'которые принесли в вейкап <b>' . $totalMoney . '</b> деревянных денег' . '<br>';
					echo 'и унесли из него <b>' . $totalCups . '</b> стаканов нашего пиздатого кофана.'. '<br>';
					echo '<br>';
				?>


			</div>
		</div>