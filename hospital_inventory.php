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
                    <a href="hospital_inventory.php" class="nav-item nav-link active">Inventory</a>
                    <a href="hospital_staff.php" class="nav-item nav-link ">Staff</a>                </div>
                <div class="navbar-nav ms-auto">
                    <a href="hospital_profile_modify.php" class="nav-item nav-link">Profile</a>
                    <a href="logout.php" class="nav-item nav-link">Logout</a>
                </div>
            </div>
        </div>
    </nav>
    </div>
    <form action="hospital_inventory.php" method="POST">
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
                        <div class = "select_box">
                            <label class = "label_info">Select Vaccine  :</label>
                            <select name="select_vaccine_to_add" id="sva1" required>
                                <option value=""></option>
                                <?php
                                    $list = mysqli_query($con,"SELECT *from vaccine");
                                    $options= '';
                                    while($row_list = mysqli_fetch_assoc($list)){
                                         $options .=  "<option value=\"". $row_list["vaccine_id"] ."\">" . $row_list["vaccine_name"]."</option>";
                                    }
                                    echo $options;
                                ?>
                            </select>
                        </div>
                        <div class="entry">
                            <label class="label_info">Enter Quantity:</label>
                            <input type="number" name="entry_quantity">
                        </div>
                        <div class="form_button">
                            <button class="btn btn-success" name="add_vac_hospital">ADD VACCINE</button>
                            <button class="btn btn-success" name="update_vac_hospital">UPDATE QUANTITY</button>
                        </div>
                        
                        
                    </div>
                </div>

            </div>
        </div>


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