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
        <div>
            <h2>Account</h2>
        </div>
        <div class='unchecked'>
            <h2>Summary</h2>
        </div>
    </div>
    <div class='reservation_box'>
        <?php
        include 'php/functions.php';
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === TRUE && isset($_SESSION['tempdata']['arrival']) && isset($_SESSION['tempdata']['departure']) && isset($_SESSION['tempdata']['apartment_id'])) {
            $confirm = filter_input(INPUT_POST, 'confirm');
            $discard = filter_input(INPUT_POST, 'discard');
            if (isset($confirm)) {
                $config = parse_ini_file('../config.ini');
                $conn = new mysqli($config['db_host'], $config['db_user'], $config['db_pass']);
                if ($conn->connect_error) {
                    die("Conection failed: " . $conn->connect_errno);
                }
                $conn->select_db($config['db_name'])
                    or die("Could not load database: " . $conn->errno);
                $sql = "INSERT INTO `orders` (date_created, date_start, date_end, total_price, apartment_id, user_id) VALUES (?, ?, ?, ?, ?, ?);";
                if ($stmt = $conn->prepare($sql)){
                    $today = date("Y-m-d"); 
                    $stmt->bind_param("sssdii", $today, $_SESSION['tempdata']['arrival'], $_SESSION['tempdata']['departure'], $_SESSION['tempdata']['price'], $_SESSION['tempdata']['apartment_id'], $_SESSION['user_id']);
                    $stmt->execute() 
                        or die ("Could not execute the query: ".$conn->error);
                    $stmt->close();
                    $conn->close();
                    echo "<h3>Your reservation was successfuly created and it's now awaiting confirmation. Thank you!</h3>";
                    header("refresh:5;url=index.php");
                    die();
                }
                else {
                    die ("Could not prepare statement: ".$conn->error);
                }
                
            }
            if (isset($discard)) {
                unset($_SESSION['tempdata']['arrival']);
                unset($_SESSION['tempdata']['departure']);
                unset($_SESSION['tempdata']['apartment_id']);
                //unset($_SESSION['tempdata']['price']);

                echo "<h3>Your reservation was not completed.</h3>";
                header("refresh:5;url=index.php");
                die();
            }
            if (!isset($confirm) && !isset($discard)) {
                $config = parse_ini_file('../config.ini');
                $conn = new mysqli($config['db_host'], $config['db_user'], $config['db_pass']);
                if ($conn->connect_error) {
                    die("Conection failed: " . $conn->connect_errno);
                }
                $conn->select_db($config['db_name'])
                    or die("Could not load database: " . $conn->errno);
                $sql = "SELECT * FROM `apartments` WHERE `apartment_id` = '" . $_SESSION['tempdata']['apartment_id'] . "' ;";
                if ($stmt = $conn->prepare($sql)) {
                    $stmt->execute()
                        or die("could not send the data to the database: " . $conn->error);
                    $stmt->bind_result($apartment['id'], $apartment['name'], $apartment['description'], $apartment['capacity'], $apartment['price_night_regular'], $apartment['price_week_regular'], $apartment['price_weekend_regular'], $apartment['price_night_season'], $apartment['price_week_season'], $apartment['price_weekend_season'], $apartment['price_night_vacation'], $apartment['price_week_vacation'], $apartment['price_weekend_vacation']);
                    $stmt->store_result();
                    $stmt->fetch();
                } else {
                    echo "There was an error: " . $conn->error;
                }
                $_SESSION['tempdata']['price'] = calc_price($_SESSION['tempdata']['arrival'], $_SESSION['tempdata']['departure'], $apartment);
                $interval = date_diff(date_create($_SESSION['tempdata']['arrival']), date_create($_SESSION['tempdata']['departure']));
                $nights = $interval->format('%a');
                $nights = (int)$nights;
                
                echo "<h3>Your reservation summary:</h3><br>";
                echo "<h4>Apartment: </h4><p>" . $apartment['name'] . " </p>
                <h4>Date of arrival: <p>" . $_SESSION['tempdata']['arrival'] . "</p></h4>
                <h4>Date of departure: <p>" . $_SESSION['tempdata']['departure'] . "</p></h4>
                <h4>Your reservation is valid for ".$nights." nights</h4>
                <h4>and ammounts to ".$_SESSION['tempdata']['price']."€</h4><br><br>
                ";
                echo "<h3>Do you want to complete your reservation?</h3>";
                echo "<form method='POST'>
                <input type='submit' name='confirm' value='Yes, finish my reservation'>
                </form>
                <form method='POST'>
                <input type='submit' class='negative' name='discard' value='No, cancel my reservation'>
                </form>";
                $conn->close();
            }
        } else {
            echo "You are not supposed to be here";
        }
        ?>
    </div>
    <?php include 'php/footer.php' ?>
</body>

</html>