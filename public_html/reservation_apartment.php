<!doctype html>
<html lang="en">

<head>
    <title>Reservation</title>
    <link rel='stylesheet' href='css/styles.css' type="text/css">
    <meta charset="utf-8">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src='js/script.js'></script>
    <!--<meta name="viewport" content="width=device-width, initial-scale=1.0">-->
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
            <h2>Summary</h2>
        </div>
        <div class='unchecked'>
            <h2>Details</h2>
        </div>
    </div>
    <div class='reservation_apartments'>
        <?php
        $submit = filter_input(INPUT_POST, 'submit');
        if ($submit) {
            $arrival = filter_input(INPUT_POST, 'arrival');
            $departure = filter_input(INPUT_POST, 'departure');
           // echo $arrival;
           // echo "<br>";
            //echo $departure;
            $config = parse_ini_file('../config.ini');
            $conn = new mysqli($config['db_host'], $config['db_user'], $config['db_pass']);
            if ($conn->connect_error) {
                die("Conection failed: " . $conn->connect_errno);
            }
            $conn->select_db($config['db_name'])
                or die("Could not load database: " . $conn->errno);
            $sql = "SELECT `apartment_id` , `name` , `capacity` FROM `apartments` ;";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->execute()
                    or die("Could not send the data to the database: " . $conn->errno);
                $stmt->bind_result($apartment['id'], $apartment['name'], $apartment['capacity']);
                $stmt->store_result();
            } else {
                die("Could not prepare statement: " . $conn->errno);
            }
            if ($stmt->num_rows > 0) {
                while ($stmt->fetch()) {
                    $path = "images/apartments/" . $apartment['id'] . "/header_image.{jpeg,gif,png,jpg}";
                    $image = glob($path, GLOB_BRACE);
                    $sql = "SELECT `order_id` FROM `orders` WHERE apartment_id = " . $apartment['id'] . " AND (( '" . $arrival . "' < DATE(date_start) AND '" . $departure . "' <= DATE(date_start)) OR ('" . $arrival . "' >= DATE(date_end) AND '" . $departure . "' > DATE(date_end)))";
                    if ($result = $conn->prepare($sql)) {
                        $result->execute()
                            or die("Could not send the data to the database: " . $conn->errno);
                        $result->bind_result($order_id);
                        $result->store_result();
                        if ($result->num_rows == 0) {
                            echo "<div class='reservation_apartments_box'>
                            <img src='" . $image[0] . "' alt='Header Image' width='375' height='250'>
                            <h2>" . $apartment['name'] . "</h2>
                            <p>Suitable for " . $apartment['capacity'] . " persons</p>
                            <p>Price for selected period: ".$price."</p>
                                <form method='POST' action='apartment'>
                                    <input type='submit' name='selected_ap' value='More Information'>
                                </form>
                            </div>";
                        }
                    } else {
                        die("Could not prepare statement: " . $conn->errno);
                    }
                    echo "<div class='reservation_apartments_box'>
                <img src='" . $image[0] . "' alt='Header Image' width='375' height='250'>
                <h2>" . $apartment['name'] . "</h2>
                <p>Suitable for " . $apartment['capacity'] . " persons</p>";
                    echo  "<form method='POST' action='apartment'>
                        <input type='submit' name='button_info' value='More Information'>
                    </form>";
                    echo "</div>";
                }
            } else {
                echo "There are no apartments available for the selected period.";
            }
        }

        ?>
    </div>
    <?php include 'php/footer.php' ?>
</body>

</html>