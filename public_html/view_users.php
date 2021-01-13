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
        header("refresh:1;url=index.php?");
        die();
    }
    $submit = filter_input(INPUT_POST, 'submit');
    if (isset($submit)) {
        $mode = filter_input(INPUT_POST, 'auth_level', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }
    else {
        $mode = 'all';
    }
    ?>
    <div class="reservation_box">
        <h2>Users</h2>
        <form method="POST">
            <label for="auth">View by authorisation level: </label>
            <select name="auth_level" id="auth">
                <option value="all">All</option>
                <option value="admin">Admin</option>
                <option value="regular">Regular</option>s
            </select>
            <input type="submit" name="submit" value="Sort">
        </form>
        <?php
        $selected = filter_input(INPUT_GET, 'user');
        $config = parse_ini_file('../config.ini');
        $conn = new mysqli($config['db_host'], $config['db_user'], $config['db_pass']);
        if ($conn->connect_error) {
            die("Conection failed: " . $conn->connect_errno);
        }
        $conn->select_db($config['db_name'])
            or die("Could not load database: " . $conn->errno);
        if ($mode == 'all') {
            $sql = "SELECT * FROM `users` ;";
        }
        if ($mode == 'admin') {
            $sql = "SELECT * FROM `users` WHERE authorisation = 1 ;";
        }
        if ($mode == 'regular') {
            $sql = "SELECT * FROM `users` WHERE authorisation = 0 ;";
        }
        if ($stmt = $conn->prepare($sql)) {
            $stmt->execute()
                or die("Could not run query: " . $conn->error);
            $stmt->bind_result($user['id'], $user['last_name'], $user['first_name'], $user['date_of_birth'], $user['country'], $user['city'], $user['street'], $user['postal_code'], $user['house_number'], $user['telephone_number'], $user['email'], $user['password'], $user['authorisation']);
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                if ($selected == $user['id']){
                    echo 'yeah';
                }
                echo "<table><tr>
                    <th>User id</th><th>Last Name</th><th>First name</th><th>Email</th><th>Date of birth</th><th>Country</th><th>City</th><th>Street</th><th>Postal Code</th><th>House Number</th><th>Telephone Number</th><th>Authorisation</th><th>Make admin?</th>
                </tr>";
                while ($stmt->fetch()) {
                    echo "<tr>
                        <td>" . $user['id'] . "</td> <td>" . $user['last_name'] . "</td> <td>" . $user['first_name'] . "</td> <td>" . $user['email'] . "</td> <td>" . $user['date_of_birth'] . "</td> <td>" . $user['country'] . "</td> <td>" . $user['city'] . "</td> <td>" . $user['street'] . "</td> <td>" . $user['postal_code'] . "</td> <td>" . $user['house_number'] . "</td> <td>" . $user['telephone_number'] . "</td> <td>" . $user['authorisation'] . "</td>" ;
                    if ($user['authorisation'] == 0) {
                        echo "<td><a href='make_admin.php?id=" . $user['id'] . "&mode=yes'>Yes, Make Admin</a></td>";
                    }
                    if ($user['authorisation'] == 1) {
                        echo "<td><a href='make_admin.php?id=" . $user['id'] . "&mode=no'>Remove Admin</a></td>";
                    }
                    echo "</tr>";
                }
                echo "</table></div>";
            } else {
                echo "There are no users.";
            }
        } else {
            die("Could not prepare statement: " . $conn->error);
        }
        ?>
    </div>
    <?php include 'php/footer.php' ?>
</body>

</html>