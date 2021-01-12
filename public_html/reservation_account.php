<!doctype html>
<html lang="en">

<head>
    <title>Reservation</title>
    <link rel='stylesheet' href='css/styles.css' type="text/css">
    <meta charset="utf-8">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src='js/script.js'></script>
</head>

<body>
    <?php include 'php/header.php' ?>
    <div class='reservation_bar'>
        <div>
            <h2>Date</h2>
        </div>
        <div>
            <h2>Apartment</h2>
        </div>
        <div class='unchecked'>
            <h2>Account</h2>
        </div>
        <div class='unchecked'>
            <h2>Summary</h2>
        </div>
    </div>
    <div class='reservation_box'>
        <?php
        $submit = filter_input(INPUT_POST, 'selected_ap');
        if (isset($submit)) {
            $_SESSION['tempdata']['apartment_id'] = filter_input(INPUT_POST, 'apart_id');
            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === TRUE) {
                $config = parse_ini_file('../config.ini');
                $conn = new mysqli($config['db_host'], $config['db_user'], $config['db_pass']);
                if ($conn->connect_error) {
                    die("Conection failed: " . $conn->connect_errno);
                }
                $conn->select_db($config['db_name'])
                    or die("Could not load database: " . $conn->errno);
                $sql = "SELECT `last_name`, `first_name` FROM `users` WHERE `email` = '" . $_SESSION['email'] . "' ;";
                if ($stmt = $conn->prepare($sql)) {
                    $stmt->execute()
                        or die("could not send the data to the database: " . $conn->error);
                    $stmt->bind_result($l_name, $f_name);
                    $stmt->store_result();
                    if ($stmt->num_rows == 1) {
                        $stmt->fetch();
                        echo "<p>Hello, ".$l_name." ".$f_name." !</p>";
                        echo "<form method='POST' action='registration_confirmation.php'>
                        <input type='hidden' name='apart_id' value='". $_SESSION['tempdata']['apartment_id']."'>
                        <input type='submit' name='proceed' value='Continue logged in as ".$_SESSION['email']."'>
                        </form>";
                        $stmt->close();
                        $conn->close();

                    }
                } else {
                    echo "Could not prepare statement " . $conn->error;
                }
            } else {
                echo "<h3>You need to log in or register to complete your reservation!</h3>";
                echo "<h3>Would you like to login or register?</h3><br>";
                echo "<p><form method='POST' action='user.php?mode=redirect'>
                <input type='submit' name='button0' value='Login'>
                </form>
                <form method='POST' action='register.php?mode=redirect'>
                <input type='submit' name='button0' value='Register'>
                </form></p>";

            }
        }


        ?>
    </div>
    <?php include 'php/footer.php' ?>
</body>

</html>