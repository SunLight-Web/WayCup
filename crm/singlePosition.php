<?php
include('header.php');
include('menu_items.php')

// Обязательно чё-то придумать, чтобы эта хуйня не была совершено другой страницей.
// Безопасность!!!11


?>
<div class="span8">
     <div class="main-content">
     
<?php
if (isset($_POST['update'])){
	$id = trim($_POST['id']);
	$name = trim($_POST['name']);
	$amount = trim($_POST['amount']);
	$price = trim($_POST['price']);
	$category = trim($_POST['category']);

	$query = "UPDATE `menu` SET `name` = '$name' , `amount` = $amount , `price` = $price , `category` = $category WHERE `id` = $id";
	$stmt = $mysqli->query($query);
}


if (isset($_GET['id'])) {
	$id = $_GET['id'];
} else {
	echo '<h3>ХУЙНЯ СЛУЧИЛАСЬ, Я ХЗ КТО ОТВЕТСТВЕННЫЙ, СОРЯН</h3>';
	die();
}

$singleElement = findObject($id, $menu['elements']);
?>
<h3 class="main-title">Позиция меню:</h3><br/>
<form name='update-form' action="" method="post">
	<br/>
	<input type="hidden" name="id" value="<?php echo $singleElement->id; ?>"/>
	<input type="text" name="name" value="<?php echo $singleElement->name; ?>"/><br/>
	<input type="text" name="amount" value="<?php echo $singleElement->amount; ?>"/> <? echo $singleElement->isLiquid; ?><br/>
	<input type="text" name="price" value="<?php echo $singleElement->price; ?>"/> рублёв<br/>
	<select name="category">
		<?php
			foreach ($menu['categories'] as $singleCategory) {
				$isSelected = $singleElement->category == $singleCategory->id ? 'selected' : '';
				echo "<option value=" . $singleCategory->id . " " . $isSelected . ">" . $singleCategory->name . "</option>";
			}
		?>
	</select>
	<br/>
<input type="submit" name="update" value="Обновить"/>
</form>




	</div>
</div>

<div class="span4 menu-block">
<div class="main-content">
	<ul>
		<?php $singleElement->showAsLI(); ?>
	</ul>
</div>
</div>

<?php include('footer.php'); ?>