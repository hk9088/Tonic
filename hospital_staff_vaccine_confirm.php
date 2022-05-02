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
                    <a href="hospital_staff_homepage.php" class="nav-item nav-link ">Inventory</a>
                    <a href="hospital_staff_vaccine_confirm.php" class="nav-item nav-link active">Confirm vaccination</a>
                </div>
                <div class="navbar-nav ms-auto">
                    <a href="#" class="nav-item nav-link"><?php echo $fethed_staff_info['staff_username'];?></a>
                    <a href="logout.php" class="nav-item nav-link">Logout</a>
                </div>
            </div>
        </div>
    </nav>
    </div>
    <form action="hospital_staff_vaccine_confirm.php" method="POST">
    <div class="form_grid">
            <div class="row">
                
                <div class="col">
                    <button class="APPROVED" name="btn_approved" >
                        APPROVED FOR TODAY
                        <br>
                        <?php
                            date_default_timezone_set('asia/dhaka');
                            $t_date = date("Y-m-d");
                            $result = mysqli_query($con,"SELECT *from vaccine_request where hospital_id = '$h_id' and request_status = 'Approved' and requested_date = '$t_date'");
                            echo mysqli_num_rows($result);
                        ?>            
                    </button>
                </div>

                <div class="col">
                    <button class="VACCINATED" name="btn_vaccinated">
                        VACCINATED TODAY
                        <br>
                        <?php
                            $result = mysqli_query($con,"SELECT *from vaccine_request where hospital_id = '$h_id' and request_status = 'Vaccinated' and vaccinated_date = '$t_date'");
                            echo mysqli_num_rows($result);
                        ?>
                    </button>
                </div>

            </div>
            
            <div class="form">
                <?php if(isset($_SESSION['info'])){ ?>
                                <div class="alert alert-success text-center">
                                <?php echo $_SESSION['info']; ?>
                            </div>
                            <?php }?>
                <?php if(count($errors) > 0){?>
                    <div class="alert alert-danger text-center">
                        <?php
                            foreach($errors as $showerror){
                                echo $showerror;
                            }
                        ?>
                    </div>
                <?php } ?>
                <?php unset($_SESSION['info']) ;?>
                
                
                <div class = "entry">
                    <label>Enter Request ID:</label>
                    <input type="number" name="entry_request_id" required>
                </div>
                <div class = "entry">
                    <label>Enter User OTP:</label>
                    <input type="number" name="entry_otp" required>
                </div>
                <div class = "form_button">
                    <button class="btn btn-success" name = "go_to_vaccination_confirm">Confirm</button>
                </div>

            </div>
            
        </div>
      
    </form>


    








    
</body>
</html>