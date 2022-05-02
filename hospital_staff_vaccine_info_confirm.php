<?php include('server.php')?>
<?php $s_id =  $_SESSION['staff_id'];?>
<?php $u_id =  $_SESSION['u_id'];?>
<?php $fethed_user_info = mysqli_fetch_assoc(mysqli_query($con,"SELECT * From users where user_id ='$u_id'"));?>
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
                    <label>Name : <?php echo $fethed_user_info['name'];?></label>
                </div>
                <div class = "entry">
                    <label>NID : <?php echo $fethed_user_info['nid'];?></label>
                </div>
                <div class = "entry">
                    <label>Date of Birth : <?php echo $fethed_user_info['dob'];?></label>
                </div>
                <div class = "entry">
                    <label>Address : <?php echo $fethed_user_info['address'];?></label>
                </div>
                <div class = "form_button">
                    <button class="btn btn-success" name = "vaccination_confirm">Confirm</button>
                </div>

            </div>
            
        </div>
      
    </form>


    








    
</body>
</html>