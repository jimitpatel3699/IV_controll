<?php
        session_start(); 
        
        if(!isset($_SESSION['uname']) && !isset($_SESSION['id'] ))
        {
            header("Location: index.php?error=Login required to see live data");
            echo 'login required to see live data';
            exit();
        }
       
?>
<!DOCTYPE html>
<html lang="en">

<head>
    
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dash Board</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>

<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <center>
                <div class="h2"><?php echo 'Welcome '.$_SESSION['uname']; ?></div>
                <div class="h1">Add Current Admitted Patients Data</div>
            </center>
        </div>
    </div>
    
    <div class="row">
        <div class="col-sm-12">
           <hr />
        </div>
    </div>
    
<form action="#" method="post">
 
<div class="form-group">
    <label for="exampleInputPassword1">Patient_Id</label>
    <input type="number" name="pid" class="form-control" id="exampleInputPassword1" placeholder="Patient Id" required>
  </div>


<div class="form-group">
    <label for="exampleInputPassword1">Patient_Name</label>
    <input type="text" name="pname" class="form-control" id="exampleInputPassword1" placeholder="Patient Name" required>
  </div>

<div class="form-group">
    <label for="exampleInputPassword1">Admit_Date</label>
    <input type="date" name="date" class="form-control" id="exampleInputPassword1" placeholder="date" required>
  </div>

  <div class="form-group">
    <label for="exampleInputPassword1">Admit_Time</label>
    <input type="time" name="time" class="form-control" id="exampleInputPassword1" placeholder="time" required>
  </div>

<div class="form-group">
    <label for="exampleInputEmail1">Room Number:</label>
    <input type="number" name="roomno" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Room Number" required>
  </div>
 
  <div class="row">
        <div class="col-sm-12">
           <hr />
        </div>
    </div>
  <div class="form-group">
  <div class="d-grid gap-4 col-12 mx-auto">
  <button type="submit" name="submit" class="btn btn-primary">Submit</button>
  </div>
  </div>
</form>
<div class="row">
        <div class="col-sm-12">
           <hr />
        </div>
    </div>
<div class="row">
        <div class="col-sm-12">
            
                <a href="home.php">
                    <div class="d-grid gap-4 col-12 mx-auto">
                    <button class="btn btn-success btn-lg" type="button">home</button>
                    </div>               
                </a>          
        </div>
    </div>
<div class="row">
        <div class="col-sm-12">
           <hr />
        </div>
    </div>
<div class="row">
        <div class="col-sm-12">
           <hr />
        </div>
    </div>

    <?php
        if(isset($_REQUEST['submit']))
        {
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

        $pid=$_REQUEST['pid'];
        $pname=$_REQUEST['pname'];
        $admit_date=$_REQUEST['date'];
        $admit_time=$_REQUEST['time'];
        $roomno=$_REQUEST['roomno'];


        $sql = "INSERT INTO patients_current_data(patient_id,patient_name,admit_date,admit_time,room_no) VALUES ('".$pid."','".$pname."','".$admit_date."','".$admit_time."','".$roomno."')";
        if ($conn->query($sql) === TRUE) {
            // If the query returns true, it means it ran successfully
            echo "Values inserted ";
           
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
           
        }

// Close MySQL connection
            $conn->close();
        }
    ?>

</div>       


</body>

</html>