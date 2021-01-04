<!doctype html>
<html lang="en">

<head>
    <title>Admin Panel</title>
    <link rel='stylesheet' href='css/styles.css' type="text/css">
    <meta charset="utf-8">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src='js/script.js'></script>
    <!--<meta name="viewport" content="width=device-width, initial-scale=1.0">-->
</head>

<body>
    <?php include 'php/header.php' ?>
    <div>
        <?php
        error_reporting(E_ERROR | E_PARSE);
        $id = filter_input(INPUT_GET, 'id');
        $delete = $_POST['delete'];
        if ($delete) {
            $config = parse_ini_file('../config.ini');
            $conn = new mysqli($config['db_host'], $config['db_user'], $config['db_pass']);
            if ($conn->connect_error) {
                die("Conection failed: " . $conn->connect_errno);
            }
            $conn->select_db($config['db_name'])
                or die("Could not load database: " . $conn->errno);

            $sql = "DELETE FROM `apartments` WHERE `apartment_id` = " . $id . " ; ";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->execute()
                    or die("could not send the data to the database: " . $conn->error);
                $stmt->close();
                $conn->close();
                echo "Entry deleted successfully!";
                header("refresh:1;url=admin.php");
                die();
            }
        } else {
            echo "<h3>Are you sure you want to delete this apartment?</h3>";
            echo "<form method='POST' action='admin.php'>
            <input type='submit' value='No, go back' name='return' />
            </form>";
            echo "<form method='POST' action='delete_ap.php?id=" . $id . "'>
            <button type='submit' class='negative'  name='delete' >Yes, Delete Apartment</button>
            </form>";
        }
        ?>
    </div>
    <?php include 'php/footer.php' ?>
</body>

</html>