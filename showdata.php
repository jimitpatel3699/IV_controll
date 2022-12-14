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
    <meta http-equiv="refresh" content="3">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dash Board</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>

<body>

    <div class="container-fluid">
        <center>
        <div class="h2"><?php echo 'Welcome '.$_SESSION['uname']; ?></div>
         <div class="h1">LIVE DASH BOARD</div>
        </center>
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
        ?>
        <?php
        // Query the single latest entry from the database. -> SELECT * FROM table_name ORDER BY col_name DESC LIMIT 1
        //$sql = "SELECT * FROM patients_history GROUP BY room_no desc ORDER BY id DESC LIMIT 5";
        $sql = "SELECT * FROM patients_history WHERE id IN (SELECT  MAX(id) FROM patients_history GROUP BY room_no)ORDER BY room_no";
        $result = $conn->query($sql);
       

        ?>
            <section class="intro">
                <div class="bg-image h-100" style="background-color: #f5f7fa;">
                    <div class="mask d-flex align-items-center h-100">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body p-0">
                                            <div class="table-responsive table-scroll" data-mdb-perfect-scrollbar="true" style="position: relative; height: 700px">
                                                <table class="table table-striped mb-0">
                                                    <thead style="background-color: #7d99c3;">
                                                        <tr>
                                                            <th scope="col">Room No </th>
                                                            <th scope="col">Date/Time </th>
                                                            <th scope="col">Fluid_level</th>
                                                            <th scope="col">Temperature</th>
                                                            <th scope="col">Heart rate</th>
                                                            <th scope="col">Spo2</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php 
                                                     if ($result->num_rows > 0) {
                                                        //Will come handy if we later want to fetch multiple rows from the table
                                                    while($row = $result->fetch_assoc()) 
                                                    {
                                                    
                                                    ?> 
                                                    
                                                        <tr>
                                                                
                                                                 <td><?php echo $row["room_no"] ?></td>
                                                                 <td><?php echo $row["date"].'__' .$row["time"] ?></td>

                                            <?php
                                             if($row["fluid_level"]<=150)
                                                {
                                            ?>
                                                            <td style="background-color:red ;"><?php echo $row["fluid_level"].' ML' ?></td>
                                             <?php
                                                }
                                           else{
                                                ?>
                                                            <td><?php echo $row["fluid_level"].' ML' ?></td>
                                                    
                                             <?php
                                               }
                                             ?>

                                            <?php
                                             if($row["temp"]>99)
                                                {
                                            ?>
                                                            <td style="background-color:red ;"><?php echo $row["temp"] .' &#x2109'?></td>
                                             <?php
                                                }
                                           else{
                                                ?>
                                                            <td><?php echo $row["temp"] .' &#x2109'?></td>
                                                    
                                             <?php
                                               }
                                             ?>


                                            <?php
                                             if($row["bpm"]>80 ||$row["bpm"]<50 )
                                                {
                                            ?>
                                                            <td style="background-color:red ;"><?php echo $row["bpm"] .' BPM'?></td>
                                             <?php
                                                }
                                           else{
                                                ?>
                                                           <td><?php echo $row["bpm"] .' BPM'?></td>
                                                    
                                             <?php
                                               }
                                             ?>
                                               
                                               
                                            <?php
                                             if($row["spo2"]<94)
                                                {
                                            ?>
                                                            <td style="background-color:red ;"><?php echo $row["spo2"].' &#37'?></td>
                                             <?php
                                                }
                                           else{
                                                ?>
                                                          <td><?php echo $row["spo2"].' &#37'?></td>
                                                    
                                             <?php
                                               }
                                             ?>
                                                            
                                                            
                                                            
                                                        </tr>
                                                     <?php
                                                        }
                                                                                    } 
                                                    else {
                                                         echo "0 results";
                                                         }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
    </div>





</body>

</html>
