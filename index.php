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
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $filters = array
                (
                    "jac" => FILTER_VALIDATE_INT,
                    "fname" => FILTER_SANITIZE_STRING,
                    "lname" => FILTER_SANITIZE_STRING,
                    "phone" => FILTER_VALIDATE_INT,
                    "email" => FILTER_VALIDATE_EMAIL,
                    "address" => FILTER_SANITIZE_STRING,
                    "back2back" => FILTER_VALIDATE_BOOLEAN,
                    "bothlocation" => FILTER_VALIDATE_BOOLEAN,
                    "location" => FILTER_SANITIZE_STRING,
                    "onCampus" => FILTER_VALIDATE_BOOLEAN
                );
                $result = filter_input_array(INPUT_POST, $filters);
                $fname = test_input($result["fname"]);
                $lname = test_input($result["lname"]);
                $phone = test_input($result["phone"]);
                $address = test_input($result["address"]);
                $jac = test_input($result["jac"]);
                $back2back = test_input($result["back2back"]);
                $bothlocation = test_input($result["bothlocation"]);
                $location = test_input($result["location"]);
                $onCampus = test_input($result["onCampus"]);
		$email = test_input($result["email"]);
                
                if ($onCampus === ""){
                    $onCampus = 0;
                }
                if ($back2back === ""){
                    $back2back = 0;
                }
                
                if($bothlocation === ""){
                    $bothlocation = 0;
                }
                
                $sql = "INSERT INTO employee (eID, first, last, phone, email,
                        local_address, location, onCampus, back_to_back, both_labs)
                        VALUES ($jac, '$fname', '$lname', $phone, '$email', '$address',
                        '$location', $onCampus, $back2back, $bothlocation)";
                if ($conn->query($sql) === TRUE) {
                    $_SESSION["jac"] = $jac;
                    echo "Record created successfully";
                    header("Location: classSchedule.php");
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
                $conn->close();
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

        <form id='employeeinfo' method='post' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >
            <h5>Employee Information:  </h5>
            <input type="text" name="fname" placeholder="First Name" style="margin-left: 30px;" value="<?php echo $fname;?>"/></br>
            <input type="text" name="lname" placeholder="Last Name" style="margin-left: 30px;" value="<?php echo $lname;?>"/></br>
            <input type="text" name="phone" placeholder="Phone" style="margin-left: 30px;" value="<?php echo $phone;?>"/></br>
            <input type="text" name="address" placeholder="Address" style="margin-left: 30px;" value="<?php echo $address;?>"/></br>
            <input type="text" name="jac" placeholder="JAC Number" style="margin-left: 30px;" value="<?php echo $jac;?>" /></br>
	    <input type="text" name="email" placeholder="Email" style="margin-left: 30px;" value="<?php echo $email;?>" /></br>
            <h5>Do you live on Campus?  </h5>
            <p><input type="radio" name="onCampus" style="margin-left: 34px" value="yes"/>Yes</p>
            <p><input type="radio" name="onCampus" style="margin-left: 34px" value="no"/>No</p>
            <h5>Are back to back shifts preferred?</h5>
            <p><input type="radio" name="back2back" style="margin-left: 34px" value="yes"/>Yes</p>
            <p><input type="radio" name="back2back" style="margin-left: 34px" value="no"/>No</p>
            <h5>Are you okay with working at both locations (Showker/Hillside)</h5>
            <p><input type="radio" name="bothlocation" style="margin-left: 34px" value="yes"/>Yes</p>
            <p><input type="radio" name="bothlocation" style="margin-left: 34px" value="No"/>No</p>
            <h5>Preferred Location:  </h5>
            <select name="location" 
                    style="height: 24px; width: 88px; margin-left: 30px; margin-top: 0px">
                <option value="Showker">Showker</option>
                <option value="Hillside">Hillside</option>
            </select></br></br></br>
            <p><input type='submit' name='submit' value='Continue'/></p>
        </form>
    </body>
</html>
