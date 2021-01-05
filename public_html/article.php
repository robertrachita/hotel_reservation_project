<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Articles</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src='js/script.js'></script>
</head>
<body>
    <?php include 'php/header.php' ?>
    <article>
        <h1>Articles</h1> <br><br><br>
        <div class="top">
            <div>
                <a href=""><img src="images/travel.jpg">
                <h3>Explore Netherlands</h3></a> 
            </div>
            <div>
                <a href=""><img src="images/winter.jpg"></a>
                <a href=""><h3>It's Getting Colder in Netherlands</h3></a>
            </div>
            <div>
                <a href=""><img src="images/party.jpg"></a>
                <a href=""><h3>Nightlife in Netherlands</h3></a>
            </div>
            <div>
                <a href=""><img src="images/money.jpg"></a>
                <a href=""><h3>Cost of Life in Netherlands</h3></a>
            </div> 
        </div><br><br><br><hr><br><br>
        <div class="bottom">
            <div class="left">
                <div class="news">
                    <img src="images/scc.jpg">
                    <div>
                        <a href=""><h2>Why Study Career Coaching is Important for Your Life</h2>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci esse quos aliquam ea fugiat explicabo rerum veritatis! Quaerat, alias nisi!</p>
                        </a>
                    </div>
                </div>
                <br><br><hr><br>
                <div class="news">
                    <img src="images/brain.png">
                    <div>
                        <a href=""><h2>Too Much Coding Can Harm Your Brain</h2>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde dicta culpa asperiores enim sapiente cupiditate illum, corporis, ullam nisi aliquid accusamus ipsam sit quae, reprehenderit cumque possimus nam aut. Explicabo.</p>
                        </a>     
                    </div>
                </div>
                <br><br><hr><br>
                <div class="news">
                    <img src="images/cyber.jpg">
                    <div>
                        <a href=""><h2>Cybernatic Arms for Humans</h2>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatum, iure?</p>
                        </a>     
                    </div>
                </div>
                <br><br><hr><br>
            </div>
            <div class="right">
                <h1>Covid News</h1>
                <div>
                    <a href="news1.php"><img src="images/covid.jpg">
                    <h2>Vaccine for Covid-19</h2></a>
                </div>
                <br><br>
                <div>
                    <a href=""><img src="images/covid-19.jpg">
                    <h2>Covid-19 Cases in Netherlands</h2></a>
                </div>
            </div>
        </div>
    </article>
    <?php include 'php/footer.php' ?>
</body>
</html>