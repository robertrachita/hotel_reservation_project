<!doctype html>
<html lang="en">

<head>
    <title>Login</title>
    <link rel='stylesheet' href='css/styles.css' type="text/css">
    <meta charset="utf-8">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src='js/script.js'></script>
    <!--<meta name="viewport" content="width=device-width, initial-scale=1.0">-->
</head>

<body>
    <?php include 'php/header.php' ?>
    <div class='formulier'>
        <?php
        $config = parse_ini_file('../config.ini');
        $conn = new mysqli($config['db_host'], $config['db_user'], $config['db_pass']);
        if ($conn->connect_error) {
            die("Conection failed: " . $conn->connect_errno);
        }
        $conn->select_db($config['db_name'])
            or die("Could not load database: " . $conn->errno);
        $mode = filter_input(INPUT_GET, 'mode');
        $login = filter_input(INPUT_POST, 'login');
        if ($mode == 'logout') {
            unset($_SESSION['loggedin']);
            unset($_SESSION['email']);
            unset($_SESSION['authorisation']);
            echo "Logged Out Successfully!";
            header("refresh:1;url=index.php?");
            die();
        } else if (isset($login)) {
            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_EMAIL);
            $password = filter_input(INPUT_POST, 'password');

            if (!empty($username) && !empty($password)) {
                $sql = "SELECT `email`, `password`, `authorisation` FROM `users` WHERE email='" . $username . "' ;";
                if ($stmt = $conn->prepare($sql)) {
                    $stmt->execute()
                        or die("could not send the data to the database: " . $conn->error);
                    $stmt->bind_result($retrievedData['email'], $retrievedData['password'], $retrievedData['authorisation']);
                    $stmt->store_result();
                    $stmt->fetch()
                        or die("Could not retrieve data Or the user does not exists");
                    if ($stmt->num_rows == 1) {
                        if (password_verify($password, $retrievedData['password'])) {
                            echo "Welcome!";
                            $_SESSION['loggedin'] = TRUE;
                            $_SESSION['email'] = $retrievedData['email'];
                            $_SESSION['authorisation'] = $retrievedData['authorisation'];
                            header("refresh:1;url=myaccount.php?");
                            die();
                        } else {
                            die("Incorrect Password!");
                        }
                    }
                } else {
                    die("An error has occured: " . $conn->error);
                }
            } else {
                echo "Please fill in both username and password";
                exit;
            }
            $stmt->close();
            $conn->close();
        } else {
            echo "<form method='POST'>
                    <p><label for='username'>Username</label></p>
                    <input id='username' type='email' name='username' placeholder='Your username' required />
                    <p><label for='password'>Password</label></p>
                    <input id='password' type='password' name='password' placeholder='Your password' required /><br>
                    <input type='submit' name='login' value='Login'>
            </form>";
        }
        ?>
    </div>
    <?php include 'php/footer.php' ?>
</body>

</html>