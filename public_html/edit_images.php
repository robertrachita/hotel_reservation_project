<!doctype html>
<html lang="en">

<head>
    <title>Admin Panel</title>
    <link rel='stylesheet' href='css/styles.css' type="text/css">
    <meta charset="utf-8">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src='js/script.js'></script>
</head>

<body>
    <?php include 'php/header.php' ?>
    <div class="edit_images">
        <?php
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== TRUE ||  $_SESSION['authorisation'] !== 1) {
            echo "Your account does not have the authorisation to view this page.";
            header("refresh:1;url=index.php?");
                            die();
        }
        error_reporting(E_ERROR | E_PARSE);
        $id = filter_input(INPUT_GET, 'id');
        $delete = filter_input(INPUT_GET, 'delete');
        $header = filter_input(INPUT_GET, 'header');
        $fileToChange = filter_input(INPUT_GET, 'file');
        $file_count = filter_input(INPUT_GET, 'filecount');
        $submit = $_POST['submit'];
        if ($submit && !empty(array_filter($_FILES['images']['name']))) {
            
            $file_number = $file_count - 1;
            $success = 0;
            $file_path = "images/apartments/".$id ;
            if (!file_exists($file_path)) {
                mkdir($file_path, 0777, true);
            }
            $file_path .= '/';
            foreach ($_FILES['images']['tmp_name'] as $key => $value) {
                $file_name = $_FILES['images']['name'][$key];
                $file_size = $_FILES['images']['size'][$key];
                $file_tmp = $_FILES['images']['tmp_name'][$key];
                $file_type = $_FILES['images']['type'][$key];

                if ($file_type == 'image/jpeg' || $file_type == 'image/jpg' || $file_type == 'image/png' || $file_type == 'image/gif') {
                    if ($file_size > 5242880) {
                        die("Please upload a smaller file. Max size is 5MB");
                    } else {
                        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
                        $file_name = 'image_' . $file_number . "." . $ext;
                        move_uploaded_file($file_tmp, $file_path . $file_name);
                        $success = 1;
                       
                        $file_number++;
                    }
                } else {
                    echo "File type not allowed";
                }
            }
            if ($success == 1)
            {
                echo "Files uploaded";
                header("refresh:1;url=edit_images.php?id=".$id);
                die();
            }
        }
        if ($id) {
            $path = "images/apartments/" . $id . "/";
            $file_count = 0;
            if (is_dir($path)) {
                $folder = scandir($path);
                unset($folder[0]);
                unset($folder[1]);
                foreach ($folder as $file) {
                    $file_count++;
                    if (str_contains($file, 'header_image') !== false) {
                        echo "<div class='edit_images_box'>
                <img src='" . $path . $file . "' alt='error'>
                <form method='POST' action='edit_images.php?header=" . $id . "&file=" . $file . "'>
                <input type='submit' name='useless_button'  value='Current Header' disabled>
                </form>
                <form method='POST' action='edit_images.php?delete=" . $id . "&file=" . $file . "'>
                <button type='submit' class='redonhover' name='delete' >Delete Image</button>
                </form>
                </div>";
                    } else {
                        echo "<div class='edit_images_box'>
                <img src='" . $path . $file . "' alt='error'>
                <form method='POST' action='edit_images.php?header=" . $id . "&file=" . $file . "'>
                <input type='submit' name='header'  value='Choose as Header'>
                </form>
                <form method='POST' action='edit_images.php?delete=" . $id . "&file=" . $file . "'>
                <button type='submit' class='redonhover' name='delete' >Delete Image</button>
                </form>
                </div>";
                    }
                }
            } else {
                echo "There are no images linked with this apartment";
            }
            echo "<div style='margin-top: 25px'><form method='POST' action='edit_images.php?id=" . $id . "&filecount=" . $file_count . "' enctype='multipart/form-data'>
                <input type='file' name='images[]' id='images' multiple><br>
                <input type='submit' name='submit' value='Add new Images'>
            </form></div>";
        }
        if ($delete) {
            $path = "images/apartments/" . $delete . "/" . $fileToChange;
            unlink($path);
            echo "File deleted! You will be redirected shortly back to the previous panel";
            header("refresh:1;url=edit_images.php?id=" . $delete . "");
            die();
        }
        if ($header) {
            $scan = scandir("images/apartments/" . $header . "/");
            foreach ($scan as $file) {
                if (str_contains($file, 'header_image') !== false) {
                    $ext_old = pathinfo($file, PATHINFO_EXTENSION);
                    //echo $ext_old;
                    break;
                }
            }
            $old_name = $fileToChange;
            $path = "images/apartments/" . $header . "/" . $fileToChange;
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $fileToChange = substr($fileToChange, 0, strlen($fileToChange) - strlen($ext));
            rename("images/apartments/" . $header . "/header_image." . $ext_old, "images/apartments/" . $header . "/tmp." . $ext_old);
            rename($path, "images/apartments/" . $header . "/header_image." . $ext);
            rename("images/apartments/" . $header . "/tmp." . $ext_old, "images/apartments/" . $header . "/" . $fileToChange . $ext_old,);
            echo "Changes were successful! You will be redirected shortly back to the previous panel";
            header("refresh:1;url=image_redirect.php?id=" . $header . "");
            die();
        }
        ?>
    </div>
    <?php include 'php/footer.php' ?>
</body>

</html>