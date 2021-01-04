<?php
            if (isset($_POST['submit']))
            {
                //$startIndex = stripslashes($_POST['Start']);
                //TestCon();
                WriteDB();
            }
            function SendQueryDB($query)
            {
                $servername = "localhost";
                $username = "root@localhost";
                $password = "";
                $DB = "hotel_system";
                $conn = new mysqli($servername, $username, $password, $DB);
                $sql = $query;
                
                if (mysqli_query($conn, $sql))
                {
                    printf("Success");
                    
                }
                else{
                     echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
            }
           
            
            function WriteDB()
            {
                $firstName = $_POST['firstName'];
                $lastName = $_POST['lastName'];
                $birthDay = $_POST['birthDay'];
                $country = $_POST['country'];
                $city = $_POST['city'];
                $street = $_POST['street'];
                $postalCode = $_POST['postalCode'];
                $houseNumber = $_POST['houseNumber'];
                $phoneNumber = $_POST['phoneNumber'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                $password2 = $_POST['password2'];
                
                
                if(strlen(trim($firstName)) == 0){
                    echo "All Feilds must be filled";
                }
                else if(preg_match('[@_!#$%-^&*()<>?/|}{~:]', $firstName)){
                    echo "First name contains invalid characters";
                }
                else{
                    if(strlen(trim($lastName)) == 0){
                        echo "All Feilds must be filled";
                    }
                    else if(preg_match('[@_!#$%^&*-()<>?/|}{~:]', $lastName)){
                        echo "Last name contains invalid characters";
                    }
                    else{
                        if(strlen(trim($birthDay)) == 0){
                            echo "All Feilds must be filled";
                        }
                        else if(preg_match('[@_!#$%^&*()<>?|}{~:]', $birthDay)){
                            echo "Date contains invalid characters";
                        }
                        else if(!strtotime($birthDay)){
                                echo"Date is invalid";
                            }
                        else{
                            if(strlen(trim($country)) == 0){
                                echo "All Feilds must be filled";
                            }
                            else if(preg_match('[@_!#$%-^&*()<>?/|}{~:]', $country)){
                                echo "country contains invalid characters";
                            }
                            else{
                                if(strlen(trim($city)) == 0){
                                    echo "All Feilds must be filled";
                                }
                                else if(preg_match('[@_!#$%-^&*()<>?/|}{~:]', $city)){
                                    echo "city contains invalid characters";
                                }
                                else{
                                    if(strlen(trim($street)) == 0){
                                        echo "All Feilds must be filled";
                                    }
                                    else if(preg_match('[@_!#$%-^&*()<>?/|}{~:]', $street)){
                                        echo "street contains invalid characters";
                                    }
                                    else{
                                        if(strlen(trim($postalCode)) == 0){
                                            echo "All Feilds must be filled";
                                        }
                                        else if(preg_match('[@_!#$%-^&*()<>?/|}{~:]', $postalCode)){
                                            echo "postal contains invalid characters";
                                        }
                                        else{
                                            if(strlen(trim($houseNumber)) == 0){
                                                echo "All Feilds must be filled";
                                            }
                                            else if(!is_numeric($houseNumber)){
                                                echo "House number contains invalid characters";
                                            }
                                            else{
                                                if(strlen(trim($phoneNumber)) == 0){
                                                echo "All Feilds must be filled";
                                                }
                                                else if(!is_numeric($phoneNumber)){
                                                    echo "Phone number contains invalid characters";
                                                }
                                                else{
                                                    if(strlen(trim($email)) == 0){
                                                        echo "All Feilds must be filled";
                                                    }
                                                    else if(preg_match('[!#$%^&*()<>?/|}{~:]', $email)){
                                                        echo "Email contains invalid characters";
                                                    }
                                                    else if(!preg_match('[@.]', $email)){
                                                        echo "Email is invalid";
                                                    }
                                                    else{
                                                        if((strlen(trim($password)) == 0) || (strlen(trim($password2)) == 0)){
                                                            echo "All Feilds must be filled";
                                                        }
                                                        else if(preg_match('[@#$%^&*()<>/|}{~:]', $password) || preg_match('[@#$%^&*()<>/|}{~:]', $password2)){
                                                            echo "Passwords contain invalid characters";
                                                        }
                                                        else if(!$password == $password2){
                                                            echo "Passwords do not match";
                                                        }
                                                        else{
                                                             $crypPass = password_hash($password, PASSWORD_BCRYPT);
                                                
                                            
                                                            $sql = "INSERT INTO `users`(`last_name`, `first_name`, `date_of_birth`, `country`, `city`, `street`,"
                                                            . "`postal_code`, `house_number`, `telephone_number`, `email`, `password`)"
                                                            . " VALUES ('" . $lastName . "','" . $firstName . "','" . $birthDay . "','" . $country . "','" . $city . "','" . $street . "','" 
                                                                           . $postalCode . "','" . $houseNumber . "','" . $phoneNumber . "','" . $email . "','" . $crypPass . "')";
                                                           
                                                                   SendQueryDB($sql);
                                                            }
                                                        }
                                                    }
            
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
            }   
         ?>
