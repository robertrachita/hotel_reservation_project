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
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== TRUE) {
            echo "You are not logged in.";
            header("refresh:1;url=index.php?");
                            die();
        }
        echo "   hello there, ".$_SESSION['email'];
        /*features to do
            *-view account details/edit details
            *-change password
            *-view past/current reservations
            */
        ?>
    </div>
    <?php include 'php/footer.php' ?>
</body>

</html>