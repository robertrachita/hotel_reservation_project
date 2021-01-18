<!DOCTYPE html>
<html lang='en'>

<head>
	<title>Contact Us</title>
	<link rel='stylesheet' href='css/styles.css' type="text/css">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src='js/script.js'></script>
	<meta charset="utf-8">
</head>

<body>
	<?php include 'php/header.php';
	if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== TRUE) {
		echo "You are not logged in.";
		header("refresh:1;url=index.php?");
		die();
	}
	$config = parse_ini_file('../config.ini');
	$conn = new mysqli($config['db_host'], $config['db_user'], $config['db_pass']);
	if ($conn->connect_error) {
		die("Conection failed: " . $conn->connect_errno);
	}
	$conn->select_db($config['db_name'])
		or die("Could not load database: " . $conn->errno);

	if (isset($_POST['btn'])) {
		$text = filter_input(INPUT_POST, 'c_text', FILTER_SANITIZE_STRING);
		$user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
		$date = htmlspecialchars($_POST['date']);
		if (!empty($text)) {
			$sql = "INSERT INTO `contact` (`message`, `date`, `user_id_contact`) VALUES ('" . $text . "', '" . $date . "', '" . $user_id . "') ;";
			$success = 0;
			if ($stmt = $conn->prepare($sql)) {
				$stmt->execute()
					or die("could not send the message the database" . $conn->error);
				echo "Successfully sent the message!";
				$success = 1;
				if ($success == 1) {
					echo "Success! You will be redirected shortly back to main page";
					header("refresh:3;url=index.php");
					die();
				}
			} else {
				die("There has been some error" . $conn->error);
			}
		} else {
			echo "Please fill in your text";
		}
	}
	?>
	<div class="c_box">
		<h1>Contact Us</h1>
		<form method="POST" action="">
			<div class="c_textbox">
				<img src="images/text.png" alt='error'>
				<input type="text" name="c_text" placeholder="Enter your text here" autofocus required>
				<input type="hidden" name="user_id" value="<?= $_COOKIE['user_id']; ?>">
				<input type="hidden" name="date" value="<?= date("Y-m-d"); ?>">
			</div>
			<button type="submit" name="btn" class="btn">Submit!</button>
		</form>
		<h2>Developers</h2>
		<div class="c_container">
			<ul class="c_gallery">
				<li>
					<img src="images/rob.png" alt='error'>
					<span>Rob</span>
				</li>
				<li>
					<img src="images/chris.png" alt='error'>
					<span>Chris</span>
				</li>
				<li>
					<img src="images/keanu.png" alt='error'>
					<span>Keanu</span>
				</li>
			</ul>
		</div>
	</div>
	<?php include 'php/footer.php' ?>
</body>

</html>
<?php


?>