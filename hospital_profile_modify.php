<?php include('server.php')?>
<?php $h_id     =  $_SESSION['h_id'];?>
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
                $fecth =mysqli_fetch_assoc(mysqli_query($con,"SELECT * from hospitals where hospital_id ='$h_id'"));
                echo $fecth['hospital_name']." [Admin]";
                ?>
            </label>
            </a>
            <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav">
                    <a href="hospital_homepage.php" class="nav-item nav-link ">Dashboard</a>
                    <a href="hospital_inventory.php" class="nav-item nav-link ">Inventory</a>
                    <a href="hospital_staff.php" class="nav-item nav-link">Staff</a>
                </div>
                <div class="navbar-nav ms-auto">
                    <a href="hospital_profile_modify.php" class="nav-item nav-link active">Profile</a>
                    <a href="logout.php" class="nav-item nav-link">Logout</a>                
                </div>
            </div>
        </div>
    </nav>
    </div>

    <form action="hospital_profile_modify.php" method="POST">
        <div class="form_grid">
            <div class="row">
                <?php $fethed_hospital_info = mysqli_fetch_assoc(mysqli_query($con,"SELECT * From hospitals where hospital_id = '$h_id'"));?>
                <div class="col">
                    <div class = "form">
                        <?php if(isset($_SESSION['info'])){ ?>
                            <div class="alert alert-success text-center">
                                <?php echo $_SESSION['info']; ?>
                            </div>
                        <?php }?>
                        <?php unset($_SESSION['info']) ;?>
                        <div class = "entry">
                            <label>Hospital Name            : <?php echo $fethed_hospital_info['hospital_name']?></label>
                        </div>
                        <div class = "entry">
                            <label>Hospital Email           : <?php echo $fethed_hospital_info['h_email']?></label>
                        </div>
                        <div class = "entry">
                            <label>Hospital License Number  : <?php echo $fethed_hospital_info['h_license_number']?></label>
                        </div>
                        <div class = "entry">
                            <label>Hospital Contact : </label>
                            <input type="text" name ="h_contact" placeholder="Contact Number" value="<?php echo $fethed_hospital_info['h_contact']?>">
                        </div>
                        <div class = "entry">
                            <label>Hospital Address : </label>
                            <input type="text" name ="h_address" placeholder="Address" value="<?php echo $fethed_hospital_info['h_address']?>">
                        </div>
                        <div class = "form_button">
                            <button class ="btn btn-success" name ="udate_hospital_info">UPDATE</button>
                            <button class ="btn btn-success" name ="go_to_chage_pass">CHANGE PASSWORD</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </form>



    








    
</body>
</html>