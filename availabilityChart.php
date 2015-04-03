<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="css/classSchedule.css">
    </head>
    <body>
        <?php
        session_start();
        $servername = $_SESSION['servername'];
        $username = $_SESSION['username'];
        $password = $_SESSION['password'];
        $dbname = $_SESSION['dbname'];

        $conn = new mysqli($servername, $username, $password, $dbname);

        $days = $_POST['day'];

        $people = $_POST['people'];

        
        $addSQL = "";
        
        if ($people === "custom") {
            $person = $_POST['person'];
            $eIDList = "(";
            foreach ($person as $assist) {
                $eIDList .= "$assist";
                if(!($assist === end($person))){
                    $eIDList .= ", ";
                }
            }
            $eIDList .= ")";
            $eIDSQL = " AND eID IN $eIDList";
            $addSQL .= $eIDSQL;
        }
        
        if($people === "Hillside" || $people === "Showker"){
            $locSQL = " AND location = '$people'";
            $addSQL .= $locSQL;
        }
        
        $_SESSION['addSQL'] = $addSQL;

        function printNames($sql) {
            $servername = $_SESSION['servername'];
            $username = $_SESSION['username'];
            $password = $_SESSION['password'];
            $dbname = $_SESSION['dbname'];

            $conn = new mysqli($servername, $username, $password, $dbname);
            echo '<td>';
            echo '<ul>';
            $sql .= $_SESSION['addSQL'];
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $name = "{$row['first']} {$row['last']}";
                    echo '<li>' . $name . '</li>';
                }
            }
            echo '</ul>';
            echo '</td>';
        }
        
        function createSQL($start, $end, $day){
            $sql = "SELECT first, last from employee "
                . "WHERE eID NOT IN "
                . "("
                    . "SELECT e.eID "
                    . "FROM employee e "
                    . "LEFT JOIN class_schedule c ON e.eID = c.eID "
                    . "where c.$day = 1 AND "
                    . "("
                        . "(c.start_time >= Cast('$start' AS time) AND c.end_time <= Cast('$end' AS time)) OR "
                        . "(c.start_time <= Cast('$start' AS time) AND c.end_time >= Cast('$start' AS time)) OR "
                        . "(c.start_time >= Cast('$start' AS time) AND c.start_time <= Cast('$end' AS time))"
                    . ")"
                . ")";
            return $sql;
        }
        ?>
        <table id="availabilityTable">
            <tr>
                <td></td>
                <?php
                foreach ($days as $day) {
                    switch ($day) {
                        case 'mon':
                            $day = 'Monday';
                            break;
                        case 'tue':
                            $day = 'Tuesday';
                            break;
                        case 'wed':
                            $day = 'Wednesday';
                            break;
                        case 'thu':
                            $day = 'Thursday';
                            break;
                        case 'fri':
                            $day = 'Friday';
                            break;
                    }
                    echo '<td>' . $day . '</td>';
                }
                ?>
            </tr>
            <tr>
                <?php
                $startTimes = ['7:45', '10:00', '12:00', '14:00', '16:00', '18:00', '20:00', '22:00'];
                $endTimes = ['10:00', '12:00', '14:00', '16:00', '18:00', '20:00', '22:00', '23:59'];
                echo '<td>7:45 - 10</td>';
                foreach ($days as $day) {
                    $sql = createSQL('7:45', '10:00', $day);
                    printNames($sql);
                }
                ?>
            </tr>
            <tr>
                <td>10 - 12</td>
                <?php
                foreach ($days as $day) {
                    $sql = createSQL('10:00', '12:00', $day);
                    printNames($sql);
                }
                ?>
            </tr>
            <tr>
                <td>12 - 2</td>
                <?php
                foreach ($days as $day) {
                    $sql = createSQL('12:00', '14:00', $day);
                    printNames($sql);
                }
                ?>
            </tr>
            <tr>
                <td>2 - 4</td>
                <?php
                foreach ($days as $day) {
                    $sql = createSQL('14:00', '16:00', $day);
                    printNames($sql);
                }
                ?>
            </tr>
            <tr>
                <td>4 - 6</td>
                <?php
                foreach ($days as $day) {
                    if ($day !== 'fri'){
                        $sql = createSQL('16:00', '1:00', $day);
                        printNames($sql);
                    }
                }
                ?>
            </tr>
            <tr>
                <td>6 - 8</td>
                <?php
                foreach ($days as $day) {
                    if ($day !== 'fri'){
                        $sql = createSQL('18:00', '20:00', $day);
                        printNames($sql);
                    }
                }
                ?>
            </tr>
            <tr>
                <td>8 - 10</td>
                <?php
                foreach ($days as $day) {
                    if ($day !== 'fri'){
                        $sql = createSQL('20:00', '22:00', $day);
                        printNames($sql);
                    }
                }
                ?>
            </tr>
            <tr>
                <td>10 - 12:15</td>
                <?php
                foreach ($days as $day) {
                    if ($day !== 'fri'){
                        $sql = createSQL('22:00', '23:59', $day);
                        printNames($sql);
                    }
                }
                ?>
            </tr>
        </table>
    </body>
</html>
