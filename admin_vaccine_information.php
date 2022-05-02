<?php include('server.php')?>
<?php if(!empty($_SESSION['admin_id'])):?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Tonic</title>
    <link rel="stylesheet" href="css\admin_home.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
    <div class="m-4">
        <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a href="#" class="navbar-brand">
                    <label>
                        Admin
                    </label>
                </a>
                <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav">
                        <a href="admin_homepage.php" class="nav-item nav-link ">Dashboard</a>
                        <a href="admin_vaccine_information.php" class="nav-item nav-link active">Vaccine Information</a>
                        <a href="admin_vaccine_catagories.php" class="nav-item nav-link ">Vaccine Catagories</a>                
                    </div>
                    <div class="navbar-nav ms-auto">
                        <a href="logout.php" class="nav-item nav-link">Logout</a>
                    </div>
                </div>
            </div>
        </nav>
    </div>
    <form action="admin_vaccine_information.php" method="POST">
        <div class="form_grid">
            <div class="row">

                <div class="col">
                    <div class="form" id="approve">
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
                            Vaccine Name:
                        </label>
                        <input type="text" name="vaccine_name_add" >
                        <br>
                        <label class = "entry">
                            Vaccine Dose:
                        </label>
                        <input type="number" name="vaccine_dose_add" >
                        
                        <div class = "select_box">
                        <label class = "label_info">Select Vaccine Catagory  : </label>
                            <select name="select_vac_cat_to_add" id="svca1">
                                <option value=""></option>
                                <?php
                                    $list = mysqli_query($con,"SELECT *from vaccine_catagories");
                                    $options= '';
                                    while($row_list = mysqli_fetch_assoc($list)){
                                        $options .=  "<option value=\"". $row_list["catagory_id"] ."\">" . $row_list["catagory_name"]."</option>";
                                    }
                                    echo $options;
                                ?>
                            </select>
                        </div>
                        <div class="form_button">
                            <button class="btn btn-success" name="add_vaccine_info" >ADD</button>
                        </div>
                        
                        
                    </div>


                </div>

                <div class="col">
                    <div class="form" id="approve">
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
                            <label class = "label_info">Vaccine ID  : </label>
                            <select name="select_vac_id_to_update" id="svcu1">
                                <option value=""></option>
                                <?php
                                    $list = mysqli_query($con,"SELECT *from vaccine");
                                    $options= '';
                                    while($row_list = mysqli_fetch_assoc($list)){
                                        $options .=  "<option value=\"". $row_list["vaccine_id"] ."\">" . $row_list["vaccine_id"]."</option>";
                                    }
                                    echo $options;
                                ?>
                            </select>
                        </div>
                        <label class = "entry">
                            Vaccine Name:
                        </label>
                        <input type="text" name="vaccine_name_update" >
                        <br>
                        <label class = "entry">
                            Vaccine Dose:
                        </label>
                        <input type="number" name="vaccine_dose_update" >
                        
                        <div class = "select_box">
                        <label class = "label_info">Vaccine Catagory  : </label>
                            <select name="select_vac_cat_to_update" id="svca1">
                                <option value=""></option>
                                <?php
                                    $list = mysqli_query($con,"SELECT *from vaccine_catagories");
                                    $options= '';
                                    while($row_list = mysqli_fetch_assoc($list)){
                                        $options .=  "<option value=\"". $row_list["catagory_id"] ."\">" . $row_list["catagory_name"]."</option>";
                                    }
                                    echo $options;
                                ?>
                            </select>
                        </div>
                        <div class="form_button">
                            <button class="btn btn-success" name="update_vaccine_info">UPDATE</button>
                        </div>
                        
                        
                    </div>


                </div>

            </div>
        </div>

        <div class="form" id="table">
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>Vaccine ID</th>
                        <th>Vaccine Name</th>
                        <th>Dose</th>
                        <th>Catagory</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $list = mysqli_query($con,"SELECT * from vaccine");
                        while($row_list = mysqli_fetch_assoc($list)){
                            $cat_id = $row_list['catagory_id'];
                            $fetched_cat_info = mysqli_fetch_assoc(mysqli_query($con,"SELECT * From vaccine_catagories where catagory_id='$cat_id' limit 1"));
                            echo "<tr><td>".$row_list['vaccine_id']."</td><td>".$row_list['vaccine_name']."</td><td>".$row_list['vaccine_dose']."</td><td>".$fetched_cat_info['catagory_name']."</td></tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>

    </form>
    
</body>
<?php endif; ?>
</html>