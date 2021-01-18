<!doctype html>
<html lang="en">

<head>
    <title>Reservations</title>
    <link rel='stylesheet' href='css/styles.css' type="text/css">
    <meta charset="utf-8">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src='js/script.js'></script>
</head>

<body>
    <?php include 'php/header.php';
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== TRUE) {
        echo "Your are not logged in";
        header("refresh:2;url=index.php?");
        die();
    }
    ?>
    <div class="reservation_box">
        <h2>My Reservations</h2>
        <?php
            $config = parse_ini_file('../config.ini');
            $conn = new mysqli($config['db_host'], $config['db_user'], $config['db_pass']);
            if ($conn->connect_error) {
                die("Conection failed: " . $conn->connect_errno);
            }
            $conn->select_db($config['db_name'])
                or die("Could not load database: " . $conn->errno);
            $sql = "SELECT `apartment_id`, `name` FROM `apartments` ;";
            if ($stmt = $conn->prepare($sql)){
                $stmt->execute()
                    or die("Could not run query: ".$conn->error);
                $stmt->bind_result($ap['id'], $ap['name']);
                $stmt->store_result();
                if ($stmt->num_rows > 0){
                    while ($stmt->fetch()){
                        $apartments[$ap['id']] = $ap['name'];
                    }
                }

            }
            else {
                die ("Could not prepare statement: ".$conn->error);
            }
            $stmt->close();
            $sql = "SELECT * from `orders` WHERE `user_id` = ".$_SESSION['user_id']." ;";
            if ($stmt = $conn->prepare($sql)){
                $stmt->execute()
                    or die("Could not run query: ".$conn->error);
                $stmt->bind_result($order['order_id'], $order['date_created'], $order['date_start'], $order['date_end'], $order['status'], $order['total_price'], $order['apartment_id'], $order['user_id']);
                $stmt->store_result();
                if ($stmt->num_rows > 0){
                    echo "<div style='overflow-x:auto;'>";
                    echo "<table><tr>
                    <th>Order ID</th><th>Date of creation</th><th>Date of reservation beginning</th><th>Date of reservation ending</th><th>Status</th><th>Total Price</th><th>Apartment</th>";
                    echo "</tr>";
                    while ($stmt->fetch()){
                        echo "<tr>
                        <td>".$order['order_id']."</td> <td>".$order['date_created']."</td> <td>".$order['date_start']."</td> <td>".$order['date_end']."</td> <td>".$order['status']."</td> <td>".$order['total_price']."</td><td>".$apartments[$order['apartment_id']]."</td>";
                        
                        echo "</tr>";
                    }
                    echo "</table></div>";

                }
                else {
                    echo "There are no records.";
                }
            }
            else {
                die ("Could not prepare statement: ".$conn->error);
            }
        ?>
    </div>
    <?php include 'php/footer.php' ?>
</body>

</html>