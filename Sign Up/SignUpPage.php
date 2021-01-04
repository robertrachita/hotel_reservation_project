<!doctype html>
<html>    
    <head>    
        <title>Sign Up</title>    
    </head>    
    <body>    
        <link href = "styles.css" type = "text/css" rel = "stylesheet" />  
        
        <h2>Sign Up</h2>    
        <form action="AddUser.php" method = "post">    
            <div class = "containers">    
                <div class = "form_group">    
                    <label>First Name:</label>    
                    <input type = "text" name = "firstName" value = "" />    
                </div>    
                 <div class = "form_group">    
                    <label>Last Name:</label>    
                    <input type = "text" name = "lastName" value = "" />    
                </div>    
                 <div class = "form_group">    
                    <label>Date of Birth:</label>    
                    <input type = "text" name = "birthDay" value = "" />    
                </div>    
                <div class = "form_group">    
                    <label>Country:</label>    
                    <input type = "text" name = "country" value = "" />    
                </div>    
                <div class = "form_group">    
                    <label>City:</label>    
                    <input type = "text" name = "city" value = "" />    
                </div> 
                <div class = "form_group">    
                    <label>Street:</label>    
                    <input type = "text" name = "street" value = "" />    
                </div>
                <div class = "form_group">    
                    <label>Postal Code:</label>    
                    <input type = "text" name = "postalCode" value = "" />    
                </div>
                <div class = "form_group">    
                    <label>House Number:</label>    
                    <input type = "text" name = "houseNumber" value = "" />    
                </div>
                <div class = "form_group">    
                    <label>Phone Number:</label>    
                    <input type = "text" name = "phoneNumber" value = "" />    
                </div>
                <div class = "form_group">    
                    <label>Email Address: (YYYY-MM-DD)</label>    
                    <input type = "text" name = "email" value = "" />    
                </div>
                <div class = "form_group">    
                    <label>Password:</label>    
                    <input type = "password" name = "password" value = "" />    
                </div>
                 <div class = "form_group">    
                    <label>Repeat Password:</label>    
                    <input type = "password" name = "password2" value = "" />    
                </div>
               
                
                <input type = "submit" name = "submit" value = "Submit"/>  
            </div>    
        </form>    
    </body>    
</html>   
 