<?php

    $host = "localhost"; 
    $dbname = "smart_iv_controll";    // Database name
    $username = "root";                    // Database username
    $password = "";                        // Database password
    
    $conn = new mysqli($host, $username, $password, $dbname);
    // Check if connection established successfully
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        echo "Connected to mysql database. ";
    }
 //$_POST is a PHP Superglobal that assists us to collect/access the data, that arrives in the form of a post request made to this script.
  // If values sent by NodeMCU are not empty then insert into MySQL database table
  if(!empty($_POST['room_no']) ){
        
            //$temperature = $_POST['sendval'];
            //$humidity = $_POST['sendval2'];

            $room_no = $_POST['room_no'];
            settype($room_no, 'int');

            $fluid_level = $_POST['fluid_level'];
            settype($fluid_level, 'float');

            $temp = $_POST['temp'];
            settype($temp, 'int');

            $bpm = $_POST['bpm'];
            settype($bpm, 'int');

            $spo2 = $_POST['spo2'];
            settype($spo2, 'int');

            $date= date("Y/m/d");
            
            date_default_timezone_set('Asia/Kolkata');
            $time = date('h:i:sa');
           
            

        // Update your tablename here
        // A SQL query to insert data into table -> INSERT INTO table_name (col1, col2, ..., colN) VALUES (' " .$col1. " ', '".col2."', ..., ' ".colN." ')
                $sql = "INSERT INTO patients_history(room_no,date,time,fluid_level,temp,bpm,spo2) VALUES ('".$room_no."','".$date."','".$time."','".$fluid_level."','".$temp."','".$bpm."','".$spo2."')";
                        if ($conn->query($sql) === TRUE) {
                            // If the query returns true, it means it ran successfully
                            echo "Values inserted in MySQL database table.";
                            echo "Room_no ".$room_no ."<br />";
                            echo "Date ".$date ."<br />";
                            echo "time ".$time ."<br />";
                            echo "fluid_level ".$fluid_level ."<br />";
                            echo "temp ".$temp ."<br />";
                            echo "bpm ".$bpm ."<br />";
                            echo "spo2 ".$spo2 ."<br />";
                        } else {
                            echo "Error: " . $sql . "<br>" . $conn->error;
                            echo "Room no ".$room_no ."<br />";
                            echo "date ".$date ."<br />";
                            echo "time ".$time ."<br />";
                            echo "fluid level".$fluid_level ."<br />";
                            echo "temp ".$temp ."<br />";
                            echo "bpm ".$bpm ."<br />";
                            echo "spo2 ".$spo2 ."<br />";
                        }
            }
    // Close MySQL connection
    $conn->close();
?>