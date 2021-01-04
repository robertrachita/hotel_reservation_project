<!doctype html>
<html>    
    <head>    
        <title>Sign In</title>    
    </head>    
    <body>    
        <link href = "styles.css" type = "text/css" rel = "stylesheet" />  
        
        <h2>Sign In</h2>    
        <form action="VerUser.php" method = "post">    
            <div class = "containers">    
                
                
                <div class = "form_group">    
                    <label>ID Number:</label>    
                    <input type = "text" name = "idNum" value = "" />    
                </div>    
                
                <div class = "form_group">    
                    <label>Password:</label>    
                    <input type = "password" name = "password" value = "" />    
                </div>
                 
               
                <input type = "submit" name = "submit" value = "Submit"/>  
            </div>    
        </form>    
    </body>    
</html>   
 