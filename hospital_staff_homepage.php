<?php include('server.php')?>
<?php $s_id =  $_SESSION['staff_id'];?>
<?php $fethed_staff_info = mysqli_fetch_assoc(mysqli_query($con,"SELECT * From hospital_staff where staff_id ='$s_id'"));?>
<?php $h_id = $fethed_staff_info['hospital_id'];?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Tonic</title>
    <link rel="stylesheet" href="css\hospital_home.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="m-4">
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a href="#" class="navbar-brand">
            <label>
                <?php
                $fecth_hospital_info =mysqli_fetch_assoc(mysqli_query($con,"SELECT * from hospitals where hospital_id ='$h_id'"));
                echo $fecth_hospital_info['hospital_name']." [Staff]";
                ?>
            </label>
            </a>
            <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav">
                    <a href="hospital_staff_homepage.php" class="nav-item nav-link active">Inventory</a>
                    <a href="hospital_staff_vaccine_confirm.php" class="nav-item nav-link ">Confirm vaccination</a>
                </div>
                <div class="navbar-nav ms-auto">
                    <a href="#" class="nav-item nav-link"><?php echo $fethed_staff_info['staff_username'];?></a>
                    <a href="logout.php" class="nav-item nav-link">Logout</a>
                </div>
            </div>
        </div>
    </nav>
    </div>
    <form action="hospital_staff_homepage.php" method="POST">
        <div class="form" >
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>Inventory ID</th>
                        <th>Vaccine Name</th>
                        <th>Catagory</th>
                        <th>Available Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $list = mysqli_query($con,"SELECT * from inventory where hospital_id ='$h_id'");
                        while($row_list = mysqli_fetch_assoc($list)){
                            $v_id = $row_list['vaccine_id'];
                            $fecth_vac_info = mysqli_fetch_assoc(mysqli_query($con,"SELECT * from vaccine where vaccine_id = '$v_id' "));
                            $cat_id = $fecth_vac_info['catagory_id'];
                            $fecth_cat_info = mysqli_fetch_assoc(mysqli_query($con,"SELECT * from vaccine_catagories where catagory_id = '$cat_id' "));
                            
                            echo "<tr><td>".$row_list['inventory_id']."</td><td>".$fecth_vac_info['vaccine_name']."</td><td>".$fecth_cat_info['catagory_name']."</td><td>".$row_list['available_quantity']."</td></tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
      
    </form>


    








    
</body>
</html>