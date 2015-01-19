<?php 
function telephonePrepare($jumble) {
	if (strlen($jumble) == 11) {
		$jumble = substr_replace($jumble, '(', 1, 0);
		$jumble = substr_replace($jumble, ')', 5, 0);
		$jumble = substr_replace($jumble, '-', 9, 0);
		$jumble = substr_replace($jumble, '-', 12, 0);
	} else {
		$jumble = '-/-';
	}
	return $jumble;
}

class client_clients {

	public $card;
	public $lastname;
	public $name;
	public $middlename;
	public $telephone;
	public $coffees;
	public $bonuses;

	function __construct($card, $name, $middlename, $lastname, $telephone, $coffees) {
		$this->card  		= $card;
		$this->name 		= $name;
		$this->middlename 	= $middlename;
		$this->lastname 	= $lastname;
		$this->telephone 	= telephonePrepare($telephone);
		$this->coffees		= $coffees;
		$this->bonuses 		= $coffees % 6;
		
	}

	function show() {
              echo "<tr>";
                  echo "<td>" . $this->card . "</td>";
                  echo "<td>" . $this->lastname . " " . $this->name . " " . $this->middlename . "</td>";
                  echo "<td>" . $this->telephone . "</td>";
                  echo "<td>";
                    for ($coffee=1; $coffee <= $this->bonuses; $coffee++) { 
                      echo "<i></i>";
                    }
                  echo "</td>";
                  echo "<td>" . $this->coffees . "</td>";
                echo "</tr>";
	}
}

$clients = array();
if (isset($_GET['show'])){
	$rowToShow = $_GET['show'];
} else {
	$rowToShow = 10;
}
if (!$stmt = $mysqli->query("SELECT id, card, lastname, name, middlename, telephone, email, coffees
                                  FROM clients
                                  ORDER BY -coffees, -card DESC
                                  LIMIT $rowToShow;
                                  ")) {
echo '<h2>Сорян, что-то пошло не так :С</h2>';
die();
} else {
    while ($row = $stmt->fetch_assoc()) {
    	$anElement = new client_clients($row['card'], $row['name'], $row['middlename'], $row['lastname'], $row['telephone'], $row['coffees']);
    	array_push($clients, $anElement);
    }

}
?>

