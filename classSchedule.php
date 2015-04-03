<html>
    <head>
        <meta charset="UTF-8">
        <title>Class Schedule Form</title>
        <link rel="stylesheet" href="css\classSchedule.css">
        <style type="text/css">
            #Text1
            {
                height: 0px;
            }
        </style>
    </head>
    <?php
    session_start();
    if (isset($_POST['jac'])){
        $jac = $jac = test_input($_POST['jac']);
    }
    else if (isset($_SESSION['jac'])){
        $jac = $_SESSION['jac'];
    }
    else{
        $jac = 123456789;
    }
    $servername = $_SESSION['servername'];
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];
    $dbname = $_SESSION['dbname'];

    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $filters = array
            (
            "subject" => FILTER_SANITIZE_STRING,
            "num" => FILTER_SANITIZE_STRING,
            "prof" => FILTER_SANITIZE_STRING,
            "loc" => FILTER_SANITIZE_STRING,
            "start" => FILTER_SANITIZE_STRING,
            "end" => FILTER_SANITIZE_STRING
            );
        if (is_array($_POST['class'])){
            $classes = $_POST['class'];
            foreach($classes as $class){
                $result = filter_var_array($class, $filters);
                $subject = test_input($result['subject']);
                $num = test_input($result['num']);
                $prof = test_input($result['prof']);
                $loc = test_input($result['loc']);
                $start12 = test_input($result['start']);
                $end12 = test_input($result['end']);
                $start = date("H:i", strtotime($start12));
                $end = date("H:i", strtotime($end12));
                if (!($subject === "" || $num === "")){
                    if (!ISSET($class['m'])){
                        $mon = 0;
                    }
                    else{
                        $mon = $class['m'];
                    }
                    if (!ISSET($class['t'])){
                        $tue = 0;
                    }
                    else{
                        $tue = $class['t'];
                    }
                    if (!ISSET($class['w'])){
                        $wed = 0;
                    }
                    else{
                        $wed = $class['w'];
                    }
                    if (!ISSET($class['th'])){
                        $thu = 0;
                    }
                    else{
                        $thu = $class['th'];
                    }
                    if (!ISSET($class['f'])){
                        $fri = 0;
                    }
                    else{
                        $fri = $class['f'];
                    }
                    
                    $subject = strtoupper($subject);
                    $year = 2015;
                    $semester = "Spring";
                    
                    $sql = "INSERT INTO class_schedule (eID, subject, number, professor,
                                location, start_time, end_time, mon, tue, wed, thu, fri, year, semester)
                                VALUES ($jac, '$subject', '$num', '$prof', 
                                '$loc', '$start', '$end', $mon, $tue, $wed, $thu, $fri, $year, '$semester')";
                    if ($conn->query($sql) === TRUE) {
                        $_SESSION["jac"] = $jac;
                        //header("Location: classSchedule.php");
                        echo "Record created successfully";
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                }
            }
            $conn->close();
        }
    }

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    ?>
    <body>
        <img src="img/dukes.png" style="width:225px;height:200px">
        <h1><center>JMU Scheduling Form</center></h1>
        If a class meets at multiple times during the week please add each time as a separate class.<br>
        If the Subject or Class Number is left empty then the class will not be counted.<br>
        <form id='classSchedule' method='post' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >
            <div class="ChangeEID">
                <table id='ChangeEID'>
                    <tr>
                        <td>Your JAC number is:</td>
                        <td><input type="text" name="jac" id="jac" placeholder="<?php echo $jac?>" disabled/></td>
                        <td><input type="button" id="enableEID" value="Change eID" onclick="changeEID()"/></td>
                    </tr>
                </table>
            </div>
            
            
            <table id="ClassTable">
                <thead>
                    <tr>
                        <td>Subject</td>
                        <td>Class Number</td>
                        <td>Professor</td>
                        <td>Class Location</td>
                        <td>Start Time</td>
                        <td>End Time</td>
                        <td>Class Days</td>
                    </tr>
                    <tr>
                        <td>MATH</td>
                        <td>220</td>
                        <td>Dr. Professor</td>
                        <td>Miller 0001</td>
                        <td>12:30 PM</td>
                        <td>1:45 PM</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody id="tbody">
                    <tr>
                        <td><input type="text" name="class[1][subject]" id="subject" placeholder="Subject" size=10/></td>
                        <td><input type="text" name="class[1][num]" id="num" placeholder="Class Number" size=10/></td>
                        <td><input type="text" name="class[1][prof]" id="prof" placeholder="Professor" size=10/></td>
                        <td><input type="text" name="class[1][loc]" id="loc" placeholder="Class Location" size=10/></td>
                        <td><input type="time" name="class[1][start]" id="start" placeholder="Start Time" size=10/></td>
                        <td><input type="time" name="class[1][end]" id="end" placeholder="End Time" size=10/></td>
                        <td>
                            <p class="days">M T W Th F</p>
                            <p class="boxes">
                            <input type="checkbox" name="class[1][m]" id="mon" size=10 value="1"/>
                            <input type="checkbox" name="class[1][t]" id="tue" size=10 value="1"/>
                            <input type="checkbox" name="class[1][w]" id="wed" size=10 value="1"/>
                            <input type="checkbox" name="class[1][th]" id="thu" size=10 value="1"/>
                            <input type="checkbox" name="class[1][f]" id="fri" size=10 value="1"/>
                            </p>
                        </td>
                        <p class="buttons">
                        <td><input type="button" id="addClass" value="Add Class" onclick="insRow()" size=10/></td>
                        <td></td>
                        </p>
                    </tr>
                </tbody>
            </table>
            <center><p><input type='submit' value='Continue'/></p></center>
        </form>
        <script language="JavaScript" src="javascript/modifyRow.js" type="text/javascript"></script>
    </body>
</html>

