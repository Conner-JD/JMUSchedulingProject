<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>JMU Scheduling Form</title>
        <link rel="stylesheet" href="css\main.css">
        <style type="text/css">
            #Text1
            {
                height: 0px;
            }
            .error {color: #FF0000;}
        </style>
    </head>
    <body>
        <?php
            session_start();
            $servername = "127.0.0.1";
            $username = "labops";
            $password = "XmAs24";
            $dbname = "labOps";
            $_SESSION["servername"] = $servername;
            $_SESSION["username"] = $username;
            $_SESSION["password"] = $password;
            $_SESSION["dbname"] = $dbname;
            
            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);
            // define variables and set to empty values
            $fname = $lname = $phone = $address = $jac = $back2back = $bothlocation = $location = $onCampus = $email = "";
            $fnameErr = $lnameErr = $phoneErr = $emailErr = $jacErr = $locErr = $bothErr = $back2Err = $campusErr = $addressErr = "";
            
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (empty($_POST["fname"])){
                    $fnameErr = "First name is required";
                }
                if (empty($_POST["lname"])){
                    $lnameErr = "Last name is required";
                }
                if (empty($_POST["phone"])){
                    $phoneErr = "Phone number is required";
                }
                if (empty($_POST["email"])){
                    $emailErr = "Email is required";
                }
                if (empty($_POST["back2back"])){
                    $back2Err = "Please choose an option";
                }
                if (empty($_POST["bothlocation"])){
                    $bothErr = "Please choose an option";
                }
                if (empty($_POST["location"])){
                    $locErr = "Please choose a preferred location";
                }
                if (empty($_POST["onCampus"])){
                    $campusErr = "Do you live on campus?";
                }
                if (empty($_POST["address"])){
                    $addressErr = "Local address is required";
                }
                if (empty($_POST["jac"])){
                    $jacErr = "JAC number is required";
                }
                if (empty($_POST["car"])){
                    $addressErr = "Please choose an option";
                }
                if (!($fnameErr !== "" || $lnameErr !== "" || $jacErr !== "" || 
                        $phoneErr !== "" || $emailErr !== "" || $back2Err !== "" ||
                        $locErr !== "" || $bothErr !== "" || $addressErr !== "" ||
                        $campusErr !== "")) {
                    
                    $filters = array
                    (
                        "jac" => FILTER_VALIDATE_INT,
                        "fname" => FILTER_SANITIZE_STRING,
                        "lname" => FILTER_SANITIZE_STRING,
                        "phone" => FILTER_SANITIZE_STRING,
                        "email" => FILTER_VALIDATE_EMAIL,
                        "address" => FILTER_SANITIZE_STRING,
                        "back2back" => FILTER_VALIDATE_BOOLEAN,
                        "bothlocation" => FILTER_VALIDATE_BOOLEAN,
                        "location" => FILTER_SANITIZE_STRING,
                        "onCampus" => FILTER_VALIDATE_BOOLEAN,
                        "car" => FILTER_VALIDATE_BOOLEAN
                    );
                    $result = filter_input_array(INPUT_POST, $filters);
                    $fname = test_input($result["fname"]);
                    $lname = test_input($result["lname"]);
                    $phone = test_input($result["phone"]);
                    $phone = preg_replace('/\D+/', '', $phone);
                    $address = test_input($result["address"]);
                    $jac = test_input($result["jac"]);
                    $back2back = test_input($result["back2back"]);
                    $bothlocation = test_input($result["bothlocation"]);
                    $location = test_input($result["location"]);
                    $onCampus = test_input($result["onCampus"]);
                    $email = test_input($result["email"]);
                    $car = test_input($result['car']);
                    
                    if ($jac !== "" && strlen((string)$jac) === 9){

                        if ($onCampus === ""){
                            $onCampus = 0;
                        }
                        if ($back2back === ""){
                            $back2back = 0;
                        }

                        if($bothlocation === ""){
                            $bothlocation = 0;
                        }
                        
                        if($car === ""){
                            $car = 0;
                        }
                        
                        $jacsql = "SELECT eID FROM employee WHERE eID = '$jac'";
                        $result = ($conn->query($jacsql));
                        if($result->num_rows > 0) {
                            $sql = "UPDATE employee
                                   SET first='$fname', last='$lname', phone ='$phone',"
                                    . "email='$email', local_address='$address', "
                                    . "location='$location', car=$car, "
                                    . "onCampus=$onCampus, back_to_back=$back2back, "
                                    . "both_labs=$bothlocation "
                                    . "WHERE eID=$jac;";
                            if ($conn->query($sql) === TRUE) {
                                $_SESSION["jac"] = $jac;
                                echo "Record updated successfully";
                                header("Location: classSchedule.php");
                            } else {
                                echo "Error: " . $sql . "<br>" . $conn->error;
                            }
                        }
                        else {
                            $sql = "INSERT INTO employee (eID, first, last, phone, email,
                                    local_address, location, car, onCampus, back_to_back, both_labs)
                                    VALUES ($jac, '$fname', '$lname', $phone, '$email', '$address',
                                    '$location', $car, $onCampus, $back2back, $bothlocation)";
                            if ($conn->query($sql) === TRUE) {
                                $_SESSION["jac"] = $jac;
                                echo "Record created successfully";
                                header("Location: classSchedule.php");
                            } else {
                                echo "Error: " . $sql . "<br>" . $conn->error;
                            }
                        }
                        $conn->close();
                        
                    }
                    else {
                        $jacErr = "Invalid eID";
                    }
                }                       
            }
            
            function test_input($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }
        ?>
        <img src="img/dukes.png" style="width:225px;height:200px">
        <h1><center>JMU Scheduling Form</center></h1>
        <p>The following form will help us determine the work schedule for the labs. Please respond truthfully.Your answers will help us create a work schedule that is better tailored to everyone's preferrences.</p></br>
        <hr class=style-1>
        <p><strong><center>Please be aware that you may not get every shift you prefer, but you will have a higher possibility of getting your preferred shifts if you fill out the form correctly.</center></strong></p>
        <hr class=style-1></br>
        <p><span class="error">* required field.</span></p>

        <form id='employeeinfo' method='post' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >
            <h5>Employee Information:  </h5>
            <input type="text" name="jac" placeholder="JAC Number" style="margin-left: 30px;" value="<?php echo $jac;?>" />
            <span class="error">* <?php echo $jacErr;?></span></br>
            
            <input type="text" name="fname" placeholder="First Name" style="margin-left: 30px;" value="<?php echo $fname;?>"/>
            <span class="error">* <?php echo $fnameErr;?></span></br>
            
            <input type="text" name="lname" placeholder="Last Name" style="margin-left: 30px;" value="<?php echo $lname;?>"/>
            <span class="error">* <?php echo $lnameErr;?></span></br>
            
            <input type="text" name="phone" placeholder="Phone" style="margin-left: 30px;" value="<?php echo $phone;?>"/>
            <span class="error">* <?php echo $phoneErr;?></span></br>
            
            <input type="text" name="address" placeholder="Local Address" style="margin-left: 30px;" value="<?php echo $address;?>"/>
            <span class="error">* <?php echo $addressErr;?></span></br>
            
	    <input type="text" name="email" placeholder="Email" style="margin-left: 30px;" value="<?php echo $email;?>" />
            <span class="error">* <?php echo $emailErr;?></span></br>
         
            <h5>Do you live on Campus?  <span class="error">* <?php echo $campusErr;?></span></h5>
            <p><input type="radio" name="onCampus" style="margin-left: 34px" value="yes"/>Yes</p>
            <p><input type="radio" name="onCampus" style="margin-left: 34px" value="no"/>No</p>
            
            <h5>Do you have a car?  <span class="error">* <?php echo $carErr;?></span></h5>
            <p><input type="radio" name="car" style="margin-left: 34px" value="yes"/>Yes</p>
            <p><input type="radio" name="car" style="margin-left: 34px" value="no"/>No</p>
            
            <h5>Are back to back shifts preferred? <span class="error">* <?php echo $back2Err;?></span></h5>
            <p><input type="radio" name="back2back" style="margin-left: 34px" value="yes"/>Yes</p>
            <p><input type="radio" name="back2back" style="margin-left: 34px" value="no"/>No</p>
            
            <h5>Are you okay with working at both locations (Showker/Hillside) <span class="error">* <?php echo $bothErr;?></span></h5>
            <p><input type="radio" name="bothlocation" style="margin-left: 34px" value="yes"/>Yes</p>
            <p><input type="radio" name="bothlocation" style="margin-left: 34px" value="No"/>No</p>
            
            <h5>Preferred Location:  <span class="error">* <?php echo $locErr;?></span></h5>
            <select name="location" 
                    style="height: 24px; width: 88px; margin-left: 30px; margin-top: 0px">
                <option value="Showker">Showker</option>
                <option value="Hillside">Hillside</option>
            </select></br></br></br>
            <p><input type='submit' name='submit' value='Continue'/></p>
        </form>
    </body>
</html>
