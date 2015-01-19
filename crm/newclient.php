
<div class="block-border-new-client">
<?php
if (isset($_POST['sent'])){
	if (isset($_POST['surname'])){
		$surname = $_POST['surname'];
	} else {
		$surname = '';
	}

	if (isset($_POST['name'])){
		$name = $_POST['name'];
	} else {
		$name = '';
	}

	if (isset($_POST['middlename'])){
		$middlename = $_POST['middlename'];
	} else {
		$middlename = '';
	}

	if (isset($_POST['tele'])){
		$tele = $_POST['tele'];
	} else {
		$tele = '';
	}

	if (isset($_POST['email'])){
		$email = $_POST['email'];
	} else {
		$email = '';
	}

	if (isset($_POST['cardnum'])){
		$cardnum = $_POST['cardnum'];
	}



	$query   = "UPDATE `clients` SET `lastname` = '$surname', `name` = '$name', `middlename` = '$middlename', `telephone` = '$tele', `email` = '$email' WHERE `card` = '$cardnum'";
	echo "<i>";
	if ($qry_result = $mysqli->query($query)) {
		echo 'Клиент успешно добавлен!';
	} else {
		echo 'Что-то пошло не так, клиент не добавлен!';
	}
	echo "</i><hr/>";
}
?>
		<form name="update-client" method="post" action="">
			<table>
				<tr>
					<td>
						<label for="cardnum">Номер карты</label>
					</td>
					<td>
<<<<<<< HEAD
						<input type="text" required name="cardnum" placeholder="0777"/>
=======
						<input type="text" required name="cardnum" placeholder="777"/>
>>>>>>> FETCH_HEAD
					</td>
				</tr>
				<tr>
					<td>
						<label>Фамилия</label>
					</td>
					<td>
						<input type="text" name="surname" placeholder="Седаков"/>
					</td>
				</tr>
				<tr>
					<td>
						<label>Имя</label>
					</td>
					<td>
						<input type="text" name="name" placeholder="Михаил"/>
					</td>
				</tr>
				<tr>
					<td>
						<label>Отчество</label>
					</td>
					<td>
						<input type="text" name="middlename" placeholder="Сергеевич"/>
					</td>
				</tr>
				<tr>
					<td>
						<label>Телефон</label>
					</td>
					<td>
						<input type="text" name="tele" placeholder="89198998238"/>
					</td>
				</tr>
				<tr>
					<td>
						<label>Email</label>
					</td>
					<td>
						<input type="text" name="email" placeholder="wedontgiveashit@way-cup.ru"/>
					</td>
				</tr>
				<tr>
					<td>
					</td>
					<td>
					<input type="submit" name="sent" value="Добавить" style="float:right;"/>
					</td>
				</tr>
			</table>
		</form>
<<<<<<< HEAD
	</div>
=======
</div>
>>>>>>> FETCH_HEAD
