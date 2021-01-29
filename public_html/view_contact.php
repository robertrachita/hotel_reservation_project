<!doctype html>
<html lang="en">

<head>
    <title>Contact</title>
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
        <h2>My Contact Messages</h2>
        <?php
        $config = parse_ini_file('../config.ini');
        $conn = new mysqli($config['db_host'], $config['db_user'], $config['db_pass']);
        if ($conn->connect_error) {
            die("Conection failed: " . $conn->connect_errno);
        }
        $conn->select_db($config['db_name'])
            or die("Could not load database: " . $conn->errno);
        if ($_SESSION['authorisation'] == 1) {
            $sql = "SELECT * FROM `contact` ;";
        } else {
            $sql = "SELECT * FROM `contact` WHERE `user_id_contact` = " . $_SESSION['user_id'] . " ;";
        }
        if ($stmt = $conn->prepare($sql)) {
            $stmt->execute()
                or die("Could not run query: " . $conn->error);
            $stmt->bind_result($order['id'], $order['message'], $order['response'], $order['date'],  $order['date_rep'], $order['user_id'],);
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                echo "<div style='overflow-x:auto;'>";
                echo "<table><tr>
                    <th>Contact ID</th><th>Original Message</th><th>Response</th><th>Date of creation</th><th>Date of response</th>";
                if ($_SESSION['authorisation'] == 1) {
                    echo "<th>Respond?</th>";
                }
                echo "</tr>";
                while ($stmt->fetch()) {
                    echo "<tr>
                        <td>" . $order['id'] . "</td> <td>" . $order['message'] . "</td> <td>" . $order['response'] . "</td> <td>" . $order['date'] . "</td> <td>" . $order['date_rep'] . "</td>";
                    if ($_SESSION['authorisation'] == 1) {
                        echo "<td><a href='respond.php?id=" . $order['id'] . "'>Yes</a></td>";
                    }
                    echo "</tr>";
                }
                echo "</table></div>";
            } else {
                echo "There are no records.";
            }
        } else {
            die("Could not prepare statement: " . $conn->error);
        }
        ?>
    </div>
    <?php include 'php/footer.php' ?>
</body>

</html>