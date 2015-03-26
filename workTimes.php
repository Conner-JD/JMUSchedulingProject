<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Work Schedule form</title>
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
        //$jac = $_SESSION['jac'];
        $jac = 1234;
        $servername = $_SESSION['servername'];
        $username = $_SESSION['username'];
        $password = $_SESSION['password'];
        $dbname = $_SESSION['dbname'];

        $conn = new mysqli($servername, $username, $password, $dbname);
        
        if ($_SERVER["REQUEST_METHOD"] == "POST"){
            $filters = array (
              "reason" => FILTER_SANITIZE_STRING  
            );
        }
        
        if(is_array($_POST['day'])){
            $days = $_POST['day'];
            foreach($days as $day){
                foreach ($day as $shift){
                    $time = $shift;
                }
            }
        }
        ?>
        <form id='classSchedule' method='post' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >
        <table id="schedTable">
            <h2><center>Preferred Work Times</center></h2>
            Fill out the following table.</br>
            If you are available during a specific shift, select the "Yes" dial.
            Otherwise, select the "No" dial. </br>
            If you prefer the specific shift, select "Yes" under Preferred. If you wish to not work the shift, select "No" </br></br>

            <tr>
                <th></th>
                <th>Monday</th>
                <th>Tuesday</th>		
                <th>Wednesday</th>
                <th>Thursday</th>
                <th>Friday</th>
            </tr>
            <?php
                $shiftTimes = [
                    '7:45' => '10:00',
                    '10:00' => '12:00',
                    '12:00' => '14:00',
                    '14:00' => '16:00',
                    '16:00' => '18:00',
                    '18:00' => '20:00',
                    '20:00' => '22:00',
                    '22:00' => '00:15'
                ];
                $milToStandTime = [
                    '7:45' => '7:45',
                    '10:00' => '10:00',
                    '12:00' => '12:00',
                    '14:00' => '2:00',
                    '16:00' => '4:00',
                    '18:00' => '6:00',
                    '20:00' => '8:00',
                    '22:00' => '10:00',
                    '00:15' => '12:15'
                ];
                $days = ['mon', 'tue', 'wed', 'thu', 'fri'];
                
                foreach($shiftTimes as $key => $value) {
                    $startTime = $key;
                    $endTime = $value;
                    echo '<tr>';
                    echo "<th>$milToStandTime[$startTime] - $milToStandTime[$endTime]</th>";
                    foreach($days as $day){
                        if (!($day === "fri" && ($startTime === '16:00' || $startTime === '18:00' ||
                                $startTime === '20:00' || $startTime === '22:00'))){
                            echo "<td>";
                                echo "<center>";
                                    echo "Available?";
                                    echo "<br>";
                                    echo "<input type=\"radio\" name=\"day[$day][$startTime][available]\" value=\"yes\" checked onClick=\"removeReason(this)\">Yes";
                                    echo "<input type=\"radio\" name=\"day[$day][$startTime][available]\" value=\"No\" onClick=\"addReason(this)\">No ";
                                    echo "<br>";
                                    echo "Preferred?";
                                    echo "<br>";
                                    echo "<select name=\"day[$day][$startTime][preferred]\">";
                                        echo "<option value=\"neither\">No Preference</option>";
                                        echo "<option value=\"yes\">Yes</option>";
                                        echo "<option value=\"no\">No</option>";
                                    echo "</select>";
                                echo "</center>";
                            echo "</td>";
                        }
                    }
                    echo '</tr>';
                }
            ?>
        </table>
            <center><p><input type='submit' value='Submit'/></p></center>
        </form>
        <script language="JavaScript" src="javascript/workTimes.js" type="text/javascript"></script>
    </body>
</html>
