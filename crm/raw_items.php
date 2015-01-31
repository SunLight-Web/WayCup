<?php 
class raw_item {

	public $id;
	public $name;
	public $price;


	function __construct($id, $name, $price) {
		$this->id    = $id;
		$this->name  = $name;
		$this->price = $price;
	}


	function showAsLI(){
		echo "<li>";
			echo "<span>" . $this->name . "</span>";
			echo "<br>";
			echo "<br>";
			echo "<br>";
			echo "<i>" . $this->price . "₽</i>";
		echo "</li>";
	}


	function showAsRow(){
		// AHEM!
		         echo "<tr>";
                  echo "<td>" . $this->name . "</td>";
                  echo "<td>" . $this->price . "</td>";
                  echo "<td><a class='icon-wrench' href='singlePosition.php?id=" . $this->id . "'></a></td>"; 
                echo "</tr>";
	}
}

// puttin on the elements from the db into an array $menu


$items = array();

if (!$stmt = $mysqli->query('SELECT `id`, `name`, `price` FROM `rawMaterials` WHERE `isActive` = 1')) {
	echo '<h2>Сорян, что-то пошло не так с менюхой :С</h2>';
} else {
    while ($row = $stmt->fetch_assoc()) {
    	$anElement = new raw_item($row['id'], $row['name'], $row['price']);
    	array_push($items, $anElement);
    }
}



?>

