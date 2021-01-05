<!doctype html>
<html lang="en">

<head>
    <title>Register</title>
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
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === TRUE) {
            echo "You are already logged in";
            header("refresh:1;url=myaccount.php?");
            die();
        }
        $submit = filter_input(INPUT_POST, 'submit');
        if (isset($submit)) {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = filter_input(INPUT_POST, 'password');
            $re_password = filter_input(INPUT_POST, 're_password');
            if ($password !== $re_password)
            {
                echo "Passwords do not match!";
                header("refresh:3;url=register.php?");
                die();
            }
            $last_name = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING);
            $first_name = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING);
            $date_of_birth = filter_input(INPUT_POST, 'date_of_birth');
            $country = filter_input(INPUT_POST, 'country', FILTER_SANITIZE_STRING);
            $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING);
            $street = filter_input(INPUT_POST, 'street', FILTER_SANITIZE_STRING);
            $postal_code = filter_input(INPUT_POST, 'postal_code', FILTER_SANITIZE_STRING);
            $house_number = filter_input(INPUT_POST, 'house_number', FILTER_SANITIZE_NUMBER_INT);
            $telephone_number = filter_input(INPUT_POST, 'telephone_number', FILTER_SANITIZE_SPECIAL_CHARS);
            $password = password_hash($password, PASSWORD_DEFAULT);

            if (!empty($email) && !empty($password) && !empty($last_name) && !empty($first_name) && !empty($date_of_birth) && !empty($country) && !empty($postal_code) && !empty($telephone_number)) {
                if (empty($city))
                {
                    $city=" ";
                }
                if (empty($street))
                {
                    $street=" ";
                }
                if (empty($house_number))
                {
                    $house_number=" ";
                }
                $config = parse_ini_file('../config.ini');
                $conn = new mysqli($config['db_host'], $config['db_user'], $config['db_pass']);
                if ($conn->connect_error) {
                    die("Conection failed: " . $conn->connect_errno);
                }
                $conn->select_db($config['db_name'])
                    or die("Could not load database: " . $conn->errno);
                $sql = "INSERT INTO `users` (last_name, first_name, date_of_birth, country, city, street, postal_code, house_number, telephone_number, email, password) values ('".$last_name."', '".$first_name."', '".$date_of_birth."', '".$country."', '".$city."', '".$street."', '".$postal_code."', '".$house_number."', '".$telephone_number."', '".$email."', '".$password."') ;";
                if ($stmt = $conn->prepare($sql))
                {
                    $stmt->execute()
                        or die("could not finish the registration process: " . $conn->error);
                    echo "Successfully Registered!";
                    $_SESSION['loggedin'] = TRUE;
                    $_SESSION['email'] = $email;
                    $_SESSION['authorisation'] = 0; 
                    $stmt->close();
                    $conn->close();
                    header("refresh:1;url=myaccount.php?");
                            die();
                }
                else {
                    die ("An error has occured: ".$conn->error);
                }
            } else {
                echo "Please fill in all the required parameters!";
                header("refresh:3;url=register.php?");
                die();
            }
        } else {
            echo "<form method='POST'>
                <p><label for='email'>Email*</label></p>
                <input type='email' id='email' name='email' required>
                <p><label for='password'>Password*</label></p>
                <input type='password' id='password' name='password' required>
                <p><label for='re_password'>Retype Password*</label></p>
                <input type='password' id='re_password' name='re_password' required>
                <p><label for='last_name'>Last Name*</label></p>
                <input type='text' id='text' name='last_name' required>
                <p><label for='first_name'>First Name*</label></p>
                <input type='text' id='text' name='first_name' required>
                <p><label for='date_of_birth'>Date of Birth*</label></p>
                <input type='date' id='date_of_birth' name='date_of_birth' required>
                <p><label for='country'>Country*</label></p>
                <input type='text' id='country' name='country' required>
                <p><label for='city'>City</label></p>
                <input type='text' id='city' name='city'>
                <p><label for='street'>Street</label></p>
                <input type='text' id='street' name='street'>
                <p><label for='postal_code'>Postal Code*</label></p>
                <input type='text' id='postal_code' name='postal_code' required>
                <p><label for='house_number'>House number</label></p>
                <input type='text' id='house_number' name='house_number'>
                <p><label for='telephone_number'>Telephone number*</label></p>
                <input type='text' id='telephone_number' name='telephone_number' required><br>
                <input type='submit' name='submit' value='Register'>
                <input type='reset' name='reset' value='Reset'>    
                </form>";
        }
        ?>
    </div>
    <?php include 'php/footer.php' ?>
</body>

</html>