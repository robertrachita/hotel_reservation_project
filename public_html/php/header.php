<header>
    <div class="menu">
        <button onclick="toggleMenu()" class="dropbtn" id="buttonImage"> </button>
        <div id="myDropdown" class="dropdown-content">
            <a href="admin.php">Admin DELETE THIS LATER</a>
            <a href="index.php">Home</a>
            <a href="myaccount.php">My account</a>
            <a href="about.php">About</a>
            <a href="article.php">News</a>
            <a href="#contact">Contact</a>
        </div>
    </div>
    <div class="banner">
        <a href="index.php"><img src="images/banner2.png" alt="banner" width="568.42x" height="120px"></a>
    </div>
    <div class="account">
       <button onclick="toggleMenuRight()" class="dropbtn" id="buttonImageAccount"> </button>
        <div id="dropdownRight" class="dropdown-content-right">
         <?php
            session_start();
            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === TRUE) {
                echo "<a href='user.php?mode=logout'>Log Out</a>";
                echo "<a href='register.php?mode=editinfo'>Edit Info</a>";
                echo "<a href='register.php?mode=changepass'>Change Password</a>";
            } else {
                echo "<a href='user.php'>Login</a>";
            }
            ?>
            <a href="register.php">Register</a>
        </div>
    </div>
</header>