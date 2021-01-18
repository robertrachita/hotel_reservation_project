<!doctype html>
<html lang="en">

<head>
    <title>My account</title>
    <link rel='stylesheet' href='css/styles.css' type="text/css">
    <meta charset="utf-8">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src='js/script.js'></script>
</head>

<body>
    <?php include 'php/header.php' ?>
    <div class="reservation_box">
        <?php 
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== TRUE) {
            echo "You are not logged in.";
            header("refresh:1;url=index.php?");
                            die();
        }
        echo "<h4>Hello there, ".$_SESSION['email']. "</h4>";
        /*features to do
            *-view past/current reservations
            */
        ?>
        <form method='POST' action="register.php?mode=editinfo">
            <input type='submit' name='edit' value='Edit your account'>
        </form>
        <form method='POST' action="register.php?mode=changepass">
            <input type='submit' name='change' value='Change Your Password'>
        </form>
        <form method='POST' action="view_res.php">
            <input type='submit' name='view' value='View your reservations'>
        </form>
    </div>
    <?php include 'php/footer.php' ?>
</body>

</html>