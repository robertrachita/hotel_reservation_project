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
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== TRUE ||  $_SESSION['authorisation'] !== 1) {
        echo "Your account does not have the authorisation to view this page.";
        header("refresh:2;url=index.php?");
        die();
    }
    $id = filter_input(INPUT_GET, 'id');
    $mode = filter_input(INPUT_GET, 'mode');
    if (empty($id) || empty($mode)) {
        echo "You are not supposed to be here.";
        header("refresh:2;url=index.php?");
        die();
    }
    if (!empty($id) && !empty($mode)) {
        $config = parse_ini_file('../config.ini');
        $conn = new mysqli($config['db_host'], $config['db_user'], $config['db_pass']);
        if ($conn->connect_error) {
            die("Conection failed: " . $conn->connect_errno);
        }
        $conn->select_db($config['db_name'])
            or die("Could not load database: " . $conn->errno);
        if ($mode == 'yes'){
        $sql = "UPDATE `orders` SET status = 'ACCEPTED' WHERE order_id = ".$id." ;";
        }
        else if ($mode == 'no'){
        $sql = "UPDATE `orders` SET status = 'DECLINED' WHERE order_id = ".$id." ;";
        }
        if ($stmt = $conn->prepare($sql)){
            $stmt->execute()
                or die ("Could not execute the statement: ".$conn->error);
                echo "Successfuly change reservation status!";
            header("refresh:2;url=reservations.php");
                die();
        }
        else {die ("Could not prepare statement ".$conn->error);}
    }

    ?>
    </div>
    <?php include 'php/footer.php' ?>
</body>

</html>