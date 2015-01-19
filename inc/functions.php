<?php

function wcp_session_start() {

	if (ini_set('session.use_only_cookies', 1) === FALSE) {
		header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
		exit();
	}
	$cookieParams = session_get_cookie_params();

	session_set_cookie_params(
		$cookieParams['lifetime'],
		$cookieParams['path'],
		$cookieParams['domain'],
		SECURE, /* defined in config.php */
		true /* is http only? */
		);
	session_name('wcp_session');
	session_start();
	session_regenerate_id();
}

function login($username, $password, $mysqli) {
	if ($stmt = $mysqli->prepare('SELECT id, username, nicename, password, salt
								  FROM members 
								  WHERE username = ?
								  LIMIT 1')) {
		$stmt->bind_param('s', $username);
		$stmt->execute();
		$stmt->store_result();

		$stmt->bind_result($userID, $username, $nicename, $dbPassword, $salt);
		$stmt->fetch();

		$password = hash('sha512', $password . $salt);

		if ($stmt->num_rows == 1) { 
		// user exists:
			if (checkbrute($userID, $mysqli) == true) {
				// user was banned for multiple incorrect login attempts
				return false;
			} else {
				if ($dbPassword == $password) {
					// password's correct
					$userBrowser = $_SERVER['HTTP_USER_AGENT'];
					$userID = preg_replace("/[^0-9]+/", "", $userID);
					$_SESSION['userID'] = $userID;
					$username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username);
					$_SESSION['username'] = $username;
					$_SESSION['nicename'] = $nicename;
					$_SESSION['loginString'] = hash('sha512', $password . $userBrowser);
					return true;
				} else {
					$now = time();
					$mysqli->query("INSERT INTO loginAttempts(userID, time) VALUES ('$userID', '$now')");
					return false;
				}
			}
		}
	}
}

function checkbrute($userID, $mysqli) {
	$now = time();

	$valid_attempts = $now - (2 * 60 * 60);
	// $now - (2 * 60 * 60) means past 2 hours. Obviously.

	if ($stmt = $mysqli->prepare("SELECT time 
								  FROM loginAttempts
								  WHERE userID = ?
								  AND time > '$valid_attepmts'")) {
		$stmt->bind_param('i', $userID);

		$stmt->execute();
		$stmt->store_result();

		if ($stmt->num_rows > 5) {
			return true;
		} else {
			return false;
		}
	}
}

function isLoggedIn($mysqli) {
	if (isset($_SESSION['userID'], $_SESSION['username'], $_SESSION['loginString'])) {
		$userID 	 = $_SESSION['userID'];
		$loginString = $_SESSION['loginString'];
		$username    = $_SESSION['username'];

		$userBrowser = $_SERVER['HTTP_USER_AGENT'];

		if ($stmt = $mysqli->prepare("SELECT password
									  FROM members 
									  WHERE id = ? LIMIT 1")) {
			$stmt->bind_param('i', $userID);
			$stmt->execute();
			$stmt->store_result();

			if ($stmt->num_rows == 1) {
				$stmt->bind_result($password);
				$stmt->fetch();
				$loginCheck = hash('sha512', $password . $userBrowser);

				if ($loginCheck == $loginString) {
					// logged in!
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		} else {
			return false;
		}
	} else {
		return false; 
	}
}

function esc_url($url) {
	if ('' == $url) {
		return $url;
	}
	$url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);

	$strip = array('%0d', '%0a', '%0D', '%0A');
	$url = (string)$url;

	$count = 1;
	while ($count) {
		$url = str_replace($strip, '', $url, $count);
	}

	$url = str_replace(';//', '://', $url);
 
    $url = htmlentities($url);
 
    $url = str_replace('&amp;', '&#038;', $url);
    $url = str_replace("'", '&#039;', $url);

    if ($url[0] !== '/') {
    	return '';
    } else {
    	return $url;
    }
}

?>