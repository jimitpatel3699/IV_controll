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
            </center>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
           <hr />
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            
                <a href="showdata.php">
                    <div class="d-grid gap-4 col-12 mx-auto">
                    <button class="btn btn-primary btn-lg" type="button">LIVE DASH BOARD</button>
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
            
                <a href="search.php">
                    <div class="d-grid gap-4 col-12 mx-auto">
                    <button class="btn btn-success btn-lg" type="button">Search Patients History</button>
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
            
                <a href="currentdata.php">
                    <div class="d-grid gap-4 col-12 mx-auto">
                    <button class="btn btn-primary btn-lg" type="button">Add Current Patients Data</button>
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
            
                <a href="currentadmitted.php">
                    <div class="d-grid gap-4 col-12 mx-auto">
                    <button class="btn btn-success btn-lg" type="button">Show Current Admitted Patients</button>
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
            
                <a href="patientsdata.php">
                    <div class="d-grid gap-4 col-12 mx-auto">
                    <button class="btn btn-primary btn-lg" type="button">Add Patients History</button>
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
            
                <a href="allpatients.php">
                    <div class="d-grid gap-4 col-12 mx-auto">
                    <button class="btn btn-success btn-lg" type="button">Show All Patients </button>
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
    
    <div class="row">
        <div class="col-sm-12">
            
                <a href="logout.php">
                    <div class="d-grid gap-4 col-12 mx-auto">
                    <button class="btn btn-danger btn-lg" type="button">LOGOUT</button>
                    </div>
                </a>               
                       
        </div>
    </div>


</div>       


</body>

</html>