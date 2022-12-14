<?php
 $host = "localhost"; 
 $dbname = "smart_iv_controll";    // Database name
 $username = "root";                    // Database username
 $password = "";                        // Database password
 
 // Establish connection to MySQL database
 $conn = new mysqli($host, $username, $password, $dbname);
 // Check if connection established successfully
 if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
 }else {
     echo "Connected to mysql database. ";
 }


session_start(); 

//include "db_conn.php";

if (isset($_POST['uname']) && isset($_POST['password'])) {

   
    $uname =$_POST['uname'];

    $pass = md5($_POST['password']);
    echo $uname;
    echo '<br />'.$pass;

    $sql = "SELECT * FROM users WHERE uname='$uname' AND password='$pass'";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) === 1) {

            $row = mysqli_fetch_assoc($result);

            if ($row['uname'] === $uname && $row['password'] === $pass) {

                echo "Logged in!";

                $_SESSION['uname'] = $row['uname'];
                $_SESSION['id'] = $row['id'];

                header("Location: home.php");
                //echo 'home .html';
                exit();

            }else{

               header("Location: index.php?error=Incorect User name or password");
               echo 'Incorect User name or password';
               exit();

                }

        }else{

            header("Location: index.php?error=Incorect User name or password");
            echo 'Incorect User name or password';
            exit();

            }

}

else{

    header("Location: index.php?error=Incorect User name or password");

    exit();

}
?>