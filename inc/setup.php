<?php
function showErrorMessage($message) {
	if ($message == "") {
		echo 'Something went terrebly wrong!';
	} else {
		echo 'Error! ' . $message;
	}
	echo '<br/><br/>';
	echo '<a href="?step=0"><button>Get Back!</button></a>';
	die();
}

function doesConnect($dbDetails) {
	$mysqli = new mysqli($dbDetails['hostname'], $dbDetails['username'], $dbDetails['password'], $dbDetails['dbname']);
	if ($mysqli->connect_error) {
		showErrorMessage($mysqli->connect_error);
		return false;
	} else {
		$mysqli->close();
		return true;
	}
}
?>


<div class="main"></div>
<div class="centered">
	<p>In order to work properly, the application needs to be initialized.</p>
</div>
<div class="centered">
<?php
if (isset($_GET['step'])) { $step = $_GET['step']; } else { $step = 0; }
	switch ($step) {
		case 1:
		?>
		<form method="post" name="dbDefenitions" action="?step=2">
			<table style="margin: 0 auto;">
				<tbody>
					<tr>
						<th>Database host</th>
						<td><input type="text" name="hostname" value="localhost"/></td>
						<td>If the suggested option does not apply, please contact your web host</td>
					</tr>
					<tr>
						<th>Database name:</th>
						<td><input type="text" name="dbname" value="new_database"/></td>
						<td>The name of the db you want to use</td>
					</tr>
					<tr>
						<th>Database username</th>
						<td><input type="text" name="username" value="username"/></td>
						<td>MySQL username. Be sure to GRANT all required rights.</td>
					</tr>
					<tr>
						<th>Database password</th>
						<td><input type="password" name="password" value="123456"/></td>
						<td>MySQL password.</td>
					</tr>
					<tr>
						<th><input type="submit" name="send" value="Submit!"/></th>
						<td></td>
						<td></td>
						<input type="hidden" name="theFormHasBeenSent" value="true"/>
					</tr>
				</tbody>
			</table>
		</form>
		<?php
			break;

		case 2:

		$dbDetails = array('hostname' => $_POST['hostname'],
						   'username' => $_POST['username'],
						   'password' => $_POST['password'],
						   'dbname'   => $_POST['dbname']);

			if (isset($_POST['theFormHasBeenSent']) && (doesConnect($dbDetails))) {
				if (!is_writable('inc/config.php')) { 
					showErrorMessage('There was a problem opening \'config.php\'. <br/>
									Please make sure you have rights for this file. <br/>
									'); 
					die();

				} else {
$newConfigFile = fopen('inc/config.php', 'w');
$newConfigFileContent = "
<?php 

// Configuration file.
define('SETUP_MODE', false);
define('HOST', '"     . $dbDetails['hostname'] . "');
define('USER', '" 	  . $dbDetails['username'] . "');    // The database username. 
define('PASSWORD', '" . $dbDetails['password'] . "');    // The database password. 
define('DATABASE', '" . $dbDetails['dbname']   . "');    // The database name.
 
define('CAN_REGISTER', 'any');
define('DEFAULT_ROLE', 'member');
 
define('SECURE', FALSE);    			   		     // FOR DEVELOPMENT ONLY!!!!

?>
				";
		fwrite($newConfigFile, $newConfigFileContent);
		fclose($newConfigFile);
		// UI FOR SUCCESFUL DB CONNECT GOES HERE:
?>
			<h3>Ok...</h3>
			<p>Login as admin/admin.</p>
			<a href=""><button>Start!</button></a>
<?php
				}

			} else {
				showErrorMessage("Could not connect to the database using your details. Please contact your webhost or try again!");	
			}
			break;
		default:
		$step = 0;
?> 
	<p>You'll be asked to enter the following info:</p>
	<ol style="text-align: left;">
		<li>Database host</li>
		<li>Database name</li>
		<li>Database username</li>
		<li>Database password</li>
	</ol>
	<hr/>
	<p>Please press the button whenever ready.</p>
	<a href="<?php $step++; echo '?step=' . $step; ?>"><button>Next step</button></a>

<?php
			break;
	}
?>
</div>