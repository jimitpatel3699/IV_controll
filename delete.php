<?php
        session_start(); 
        
        if(!isset($_SESSION['uname']) && !isset($_SESSION['id'] ))
        {
            header("Location: index.php?error=Login required to delete data");
            echo 'login required to delete data';
            exit();
        }
       
?>
<?php
if(!isset($_REQUEST['pid']))
{
    header("Location: index.php?error=Login required to delete data");
            echo 'login required to delete data';
            exit();
}
else{
    $patient_id=$_REQUEST['pid'];
    echo $patient_id;
}

?>
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
            //echo "Connected to mysql database. ";
        }
        $sql = "DELETE FROM patients_current_data WHERE patient_id='".$patient_id."'";

                if ($conn->query($sql) === TRUE) {
                    header("Location: currentadmitted.php");
                    exit();
                    } else {
                              echo "Error deleting record: " . $conn->error;
                            }

            $conn->close();
    ?>