<header>
    <div class="menu">
        <button onclick="toggleMenu()" class="dropbtn" id="buttonImage"> </button>
        <div id="myDropdown" class="dropdown-content">
            <?php 
             session_start();
             if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === TRUE &&  $_SESSION['authorisation'] == 1) {
                echo "<a href='admin.php'>Admin Panel</a>";
             }
            ?>
            <a href="index.php">Home</a>
            <a href="myaccount.php">My account</a>
            <a href="about.php">About</a>
            <a href="article.php">News</a>
            <a href="contact.php">Contact</a>
        </div>
    </div>
    <div class="banner">
        <a href="index.php"><img src="images/banner2.png" alt="banner" width="568.42x" height="120px"></a>
    </div>
    <div class="account">
       <button onclick="toggleMenuRight()" class="dropbtn" id="buttonImageAccount"> </button>
        <div id="dropdownRight" class="dropdown-content-right">
         <?php
           
            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === TRUE) {
                echo "<a href='user.php?mode=logout'>Log Out</a>";
                echo "<a href='myaccount.php'>My account</a>";
            } else {
                echo "<a href='user.php'>Login</a>";
                echo "<a href='register.php'>Register</a>";
            }
            ?>
        </div>
    </div>
</header>