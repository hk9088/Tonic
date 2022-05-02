<?php include('server.php')?>
<?php $h_id =  $_SESSION['h_id'];?>
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
                    <a href="hospital_staff.php" class="nav-item nav-link active">Staff</a>
                </div>
                <div class="navbar-nav ms-auto">
                    <a href="hospital_profile_modify.php" class="nav-item nav-link">Profile</a>
                    <a href="logout.php" class="nav-item nav-link">Logout</a>
                </div>
            </div>
        </div>
    </nav>
    </div>
    <form action="hospital_staff.php" method="POST">
        <div class="form_grid">
            <div class="row">

                <div class="col">
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
                        <label class = "entry">
                            Stuff Username:
                        </label>
                        <input type="text" name="staff_username_add" >
                        <br>
                        <label class = "entry">
                            Stuff Password:
                        </label>
                        <input type="text" name="staff_password_add" >
                        <div class="form_button">
                            <button class="btn btn-success" name="add_stuff_info" >ADD</button>
                        </div>
                        
                        
                    </div>


                </div>

                <div class="col">
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
                        <label class = "entry">
                            Stuff ID:
                        </label>
                        <input type="number" name="staff_id_update">
                        <br>
                        <label class = "entry">
                            Stuff Username:
                        </label>
                        <input type="text" name="staff_username_update">
                        <br>
                        <label class = "entry">
                            Stuff Password:
                        </label>
                        <input type="text" name="staff_password_update">
                        <div class="form_button">
                            <button class="btn btn-success" name="update_stuff_info">UPDATE</button>
                        </div>
                        
                        
                    </div>


                </div>

            </div>
        </div>


        <div class="form" >
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>Staff ID</th>
                        <th>Staff Username</th>
                        <th>Staff Password</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $list = mysqli_query($con,"SELECT * from hospital_staff where hospital_id ='$h_id'");
                        while($row_list = mysqli_fetch_assoc($list)){
                            echo "<tr><td>".$row_list['staff_id']."</td><td>".$row_list['staff_username']."</td><td>".$row_list['staff_password']."</td></tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </form>


    








    
</body>
</html>