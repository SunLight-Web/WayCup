<?php 
class menu_item {

	public $id;
	public $imageSource;
	public $name;
	public $price;
	public $amount;
	public $category;
	public $isLiquid;

	function __construct($id, $imageSource, $name, $price, $amount, $category) {
		$this->imageSource  = $imageSource;
		$this->name 		= $name;
		$this->price 		= $price;
		$this->amount 		= $amount;
		$this->category 	= $category;
		$this->id 			= $id;
		$this->isLiquid = $this->category == 1 ? 'мл' : 'шт';
	}

	function categoryDisplayName(){
		if ($this->category != 0){
			$mysqli = $GLOBALS['mysqli'];
			$query = 'SELECT `name` FROM `menuCategories` WHERE id =' . $this->category;
			$stmt = $mysqli->query($query);
			return $stmt->fetch_assoc();
		} else {
			return array('name' => "Нет категории");
		}
	}

	function showAsLI(){
		echo "<li>";
			echo "<span>" . $this->name . "</span>";
			echo "<br/>";
			echo $this->amount . $this->isLiquid;
			echo "<br/>";
			echo "<i>" . $this->price . "₽</i>";
		echo "</li>";
	}


	function showAsRow(){
		// AHEM!
		$catName = $this->categoryDisplayName();
		         echo "<tr>";
                  echo "<td>" . $this->name . ' ' . $this->amount . $this->isLiquid .  "</td>";
                  echo "<td>" . $this->price . "</td>";
                  echo "<td>" . $catName['name'] . "</td>";
                  echo "<td><a class='icon-wrench' href='singlePosition.php?id=" . $this->id . "'></a></td>"; 
                echo "</tr>";
	}
}

class category {
	public $id;
	public $name;

	function __construct($id, $name){
		$this->id = $id;
		$this->name = $name;
	}
}
// puttin on the elements from the db into an array $menu


function findObject($id, $array){
	foreach ($array as $value) {
		if ($value->id == $id) {
			return $value;
			break;
		}
	}
    return false;
}


$menu = array();
$menu['elements'] = array();
$menu['categories'] = array();

if (!$stmt = $mysqli->query('SELECT id, image, name, price, amount, category FROM menu')) {
	echo '<h2>Сорян, что-то пошло не так с менюхой :С</h2>';
} else {
    while ($row = $stmt->fetch_assoc()) {
    	$anElement = new menu_item($row['id'], $row['image'], $row['name'], $row['price'], $row['amount'], $row['category']);
    	array_push($menu['elements'], $anElement);
    }
}


if (!$stmt = $mysqli->query('SELECT id, name FROM menuCategories')) {
	echo '<h2>Сорян, что-то пошло не так с категориями :С</h2>';
} else {
    while ($row = $stmt->fetch_assoc()) {
    	$anElement = new category($row['id'],$row['name']);
    	array_push($menu['categories'], $anElement);
    }
}

?>

