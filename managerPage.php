<!DOCTYPE html>

<html>
    <head>
        <meta name="generator" content=
              "HTML-Kit Tools HTML Tidy plugin">
        <title>
            managerPage
        </title>
        <link rel="stylesheet" href="css/classSchedule.css">
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
            
            $conn = new mysqli($servername, $username, $password, $dbname);
            
            function test_input($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }
        ?>
        <img src="img/dukes.png" style="width:225px;height:200px">
        <form id="chart" method='post' action="availabilityChart.php" >
            <table summary="">
                <tr>
                    <td>
                        <table id="employeeTable">
                            <tbody id="tbody">
                            <tr>
                                <input type="radio" name="people" style="margin-left: 34px" value="Hillside" checked="checked" onclick="disablePeople()"/>Hillside
                                <input type="radio" name="people" style="margin-left: 34px" value="Showker" onclick="disablePeople()"/>Showker
                                <input type="radio" name="people" style="margin-left: 34px" value="everyone"onclick="disablePeople()"/>Everyone
                                <input type="radio" name="people" style="margin-left: 34px" value="custom" onclick="enablePeople()"/>Custom
                                <td>
                                    <select name="person[0]" id="person" disabled>
                                        <?php
                                            $sql = "SELECT eID, first, last FROM employee";
                                            $result = $conn->query($sql);
                                            if ($result->num_rows > 0){
                                                while($row = $result->fetch_assoc()) {
                                                    $id = $row['eID'];
                                                    $name = "{$row['first']} {$row['last']}";
                                                    echo '<option value="' .$id. '">' .$name.'</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                </td>
                                <td>
                                    <input type="button" id="addPerson" value="Add Person" onclick="insPerson()" size=10 disabled/>
                                </td>
                                <td>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                    <td>
                        <table summary="">
                            <tr>
                                <td>
                                    <p class="days">M T W Th F</p>
                                    <p class="boxes">
                                    <input type="checkbox" name="day[Monday]" value="mon" id="mon" checked/>
                                    <input type="checkbox" name="day[Tuesday]" value="tue" id="tue" checked/>
                                    <input type="checkbox" name="day[Wednesday]" value="wed" id="wed" checked/>
                                    <input type="checkbox" name="day[Thursday]" value="thu" id="thr" checked/>
                                    <input type="checkbox" name="day[Friday]" value="fri" id="fri" checked/>
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="submit" value=
                                           "Create Availability Schedule">
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </form>
        <script language="JavaScript" src="javascript/modifyPerson.js" type="text/javascript"></script>
    </body>
</html>
