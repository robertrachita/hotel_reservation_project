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
        <div class='unchecked'>
            <h2>Apartment</h2>
        </div>
        <div class='unchecked'>
            <h2>Account</h2>
        </div>
        <div class='unchecked'>
            <h2>Summary</h2>
        </div>
    </div>
    <div class='reservation_apartments'>
        <?php
        include 'php/functions.php';
        $submit = filter_input(INPUT_POST, 'submit');
        $arrival = filter_input(INPUT_POST, 'arrival');
        $departure = filter_input(INPUT_POST, 'departure');
        if (!isset ($submit))
        {
            die("This page is not available at this time.");
        }
        if ($submit && (empty($arrival) || empty($departure))) {
            echo "Please select the arrival and departure dates!";
            header("refresh:2;url=index.php?");
            die();
        }
        if ($submit) {
            $_SESSION['tempdata']['arrival'] = $arrival;
            $_SESSION['tempdata']['departure'] = $departure;
            $today = date("Y-m-d");
            if (strtotime($arrival) < strtotime($today)) {
                die("You cannot make a reservation for a date in the past!");
            }
            if ($arrival >= $departure) {
                die("The departure date cannot be before the arrival!");
            }
            if ($arrival == $departure) {
                die("You must make a reservation for at least two nights!");
            }
            $config = parse_ini_file('../config.ini');
            $conn = new mysqli($config['db_host'], $config['db_user'], $config['db_pass']);
            if ($conn->connect_error) {
                die("Conection failed: " . $conn->connect_errno);
            }
            $conn->select_db($config['db_name'])
                or die("Could not load database: " . $conn->errno);
            $sql = "SELECT * FROM `apartments` ORDER BY `capacity` ASC;";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->execute()
                    or die("Could not send the data to the database: " . $conn->errno);
                $stmt->bind_result($apartment['id'], $apartment['name'], $apartment['description'], $apartment['capacity'], $apartment['price_night_regular'], $apartment['price_week_regular'], $apartment['price_weekend_regular'], $apartment['price_night_season'], $apartment['price_week_season'], $apartment['price_weekend_season'], $apartment['price_night_vacation'], $apartment['price_week_vacation'], $apartment['price_weekend_vacation']);
                $stmt->store_result();
            } else {
                die("Could not prepare statement: " . $conn->errno);
            }
            if ($stmt->num_rows > 0) {
                while ($stmt->fetch()) {
                    $path = "images/apartments/" . $apartment['id'] . "/header_image.{jpeg,gif,png,jpg}";
                    $image = glob($path, GLOB_BRACE);
                    $sql = "SELECT `order_id` FROM `orders` WHERE apartment_id = " . $apartment['id'] . " AND ( ( ('" . $arrival . "' >=  DATE(date_start) AND '" . $arrival . "' < DATE(date_end) ) AND ('" . $departure . "' >  DATE(date_start) AND '2021-01-09' <= DATE(" . $departure . ") ))
                    OR ( '" . $arrival . "' >= DATE(date_start) AND '" . $arrival . "' < DATE(date_end) )
                    OR ( '" . $departure . "' > DATE(date_start) AND '" . $departure . "' <= DATE(date_end) )
                    OR ( '" . $arrival . "' <= DATE(date_start) AND '" . $departure . "' >= DATE(date_end) ) ) AND `status` <> 'declined' ; ";
                    if ($result = $conn->prepare($sql)) {
                        $result->execute()
                            or die("Could not send the data to the database: " . $conn->errno);
                        $result->bind_result($order_id);
                        $result->store_result();
                        if ($result->num_rows == 0) {
                           $price =  calc_price($arrival, $departure, $apartment);
                            echo "<div class='reservation_apartments_box'>
                            <img src='" . $image[0] . "' alt='Header Image' width='375' height='250'>
                            <h2>" . $apartment['name'] . "</h2>
                            <p>Suitable for " . $apartment['capacity'] . " persons</p>
                            <p>Price for selected period: " . $price . "</p>
                                <form method='POST' action='reservation_account.php'>
                                    <input type='hidden' name='apart_id' value='".$apartment['id']."'>
                                    <input type='submit' name='selected_ap' value='Select this property'>
                                </form>
                            </div>";
                        } else {
                            echo "<div class='reservation_apartments_box_unavailable'>
                            <img src='" . $image[0] . "' alt='Header Image' width='375' height='250'>
                            <h2>" . $apartment['name'] . "</h2>
                            <p>Suitable for " . $apartment['capacity'] . " persons</p>
                            <p>Not available for selected period!</p>
                                <form method='POST'>
                                    <input type='submit' name='useless' value='Not available' disabled>
                                </form>
                            </div>";
                        }
                    } else {
                        die("Could not prepare statement: " . $conn->errno);
                    }
                }
            } else {
                echo "There are no apartments available for the selected period.";
            }
            $stmt->close();
            $conn->close();
        }


        ?>
    </div>
    <?php include 'php/footer.php' ?>
</body>

</html>