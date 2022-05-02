<?php include('server.php')?>
<?php if(!empty($_SESSION['h_id'])):?>
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
                    <a href="hospital_homepage.php" class="nav-item nav-link active">Dashboard</a>
                    <a href="hospital_inventory.php" class="nav-item nav-link">Inventory</a>
                    <a href="hospital_staff.php" class="nav-item nav-link ">Staff</a>                </div>
                <div class="navbar-nav ms-auto">
                    <a href="hospital_profile_modify.php" class="nav-item nav-link">Profile</a>
                    <a href="logout.php" class="nav-item nav-link">Logout</a>
                </div>
            </div>
        </div>
    </nav>
    </div>
    <form action="hospital_homepage.php" method="POST">
        <div class="form_grid">
            <div class="row">
                
                <div class="col" >
                    <button class="PENDING" name="btn_pending">
                        PENDING
                        <br>
                        <?php
                            $result = mysqli_query($con,"SELECT *from vaccine_request where hospital_id = '$h_id' and request_status = 'Pending'");
                            echo mysqli_num_rows($result);
                        ?>
                    </button>
                </div>
                
                <div class="col">
                    <button class="APPROVED" name="btn_approved">
                        APPROVED
                        <br>
                        <?php
                            $result = mysqli_query($con,"SELECT *from vaccine_request where hospital_id = '$h_id' and request_status = 'Approved'");
                            echo mysqli_num_rows($result);
                        ?>            
                    </button>
                </div>

                <div class="col">
                    <button class="VACCINATED" name="btn_vaccinated">
                        VACCINATED
                        <br>
                        <?php
                            $result = mysqli_query($con,"SELECT *from vaccine_request where hospital_id = '$h_id' and request_status = 'Vaccinated'");
                            echo mysqli_num_rows($result);
                        ?>
                    </button>
                </div>

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
            <div class = "select_box">
                <label class = "label_info">Select Vaccine to Approve  :</label>
                <select name="select_vaccine_to_approve" id="sva1">
                    <option value=""></option>
                    <?php
                        $list = mysqli_query($con,"SELECT *from inventory where hospital_id = '$h_id' and available_quantity > 0 ");
                        $options= '';
                        while($row_list = mysqli_fetch_assoc($list)){
                            $vaccine_id = $row_list['vaccine_id'];
                            $fecthed_vaccine_info = mysqli_fetch_assoc(mysqli_query($con,"SELECT* from vaccine where vaccine_id ='$vaccine_id' limit 1"));
                            $options .=  "<option value=\"". $fecthed_vaccine_info["vaccine_id"] ."\">" . $fecthed_vaccine_info["vaccine_name"]."</option>";
                        }
                        echo $options;
                    ?>
                </select>
            </div>
            <label  class="labels">Date of Vaccine Distribution</label>
            <input type="date" id="datefield" name="date-vaccine-distribution" min='1899-01-01' max='2000-13-13'>
            <script>
                var today = new Date();
                var dd = today.getDate();
                var mm = today.getMonth() + 1; //January is 0!
                var yyyy = today.getFullYear();

                if (dd < 10) {
                dd = '0' + dd;
                }

                if (mm < 10) {
                mm = '0' + mm;
                } 
                    
                today = yyyy + '-' + mm + '-' + dd;
                document.getElementById("datefield").setAttribute("min", today);
            </script>
            
            <div class="form_button">
                <button type='submit' name='submit_vac_approve' class="btn btn-success">Approve</button>
            </div>
            
        </div>
        <div class="form" id="table">
            <div class = "form_button">
                <div class="entry">
                    <label>Search by Date : </label>
                    <input type="date"  name="date-search-vaccine-distribution">
                    <button class="btn btn-success" name="search_by_date">SEARCH</button>
                    <button class="btn btn-success" name="show_all">SHOW ALL</button>
                </div>
            </div>
            
            <?php $status = $_SESSION['search_status']; ?>
            <?php if($status == 'Approved'):?>
                <table class="styled-table">
                    <thead>
                        <tr>
                            <th>Approved Date</th>
                            <th>Username</th>
                            <th>Vaccine Name</th>
                            <th>Catagory</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if($_SESSION['search_date'] == ''){
                                $list = mysqli_query($con,"SELECT * from vaccine_request where hospital_id ='$h_id' and request_status = 'Approved'");
                            }
                            else{
                                $search_date = $_SESSION['search_date'];
                                $list = mysqli_query($con,"SELECT * from vaccine_request where hospital_id ='$h_id' and request_status = 'Approved' and requested_date='$search_date'");
                            }
                            while($row_list = mysqli_fetch_assoc($list)){
                                $v_id = $row_list['vaccine_id'];
                                $fecth_vac_info = mysqli_fetch_assoc(mysqli_query($con,"SELECT * from vaccine where vaccine_id = '$v_id' "));
                                $cat_id = $fecth_vac_info['catagory_id'];
                                $fecth_cat_info = mysqli_fetch_assoc(mysqli_query($con,"SELECT * from vaccine_catagories where catagory_id = '$cat_id' "));
                                $u_id = $row_list['user_id'];
                                $fecth_user_info = mysqli_fetch_assoc(mysqli_query($con,"SELECT * from users where user_id = '$u_id' "));
                                
                                echo "<tr><td>".$row_list['requested_date']."</td><td>".$fecth_user_info['username']."</td><td>".$fecth_vac_info['vaccine_name']."</td><td>".$fecth_cat_info['catagory_name']."</td><td>".$row_list['request_status']."</td></tr>";
                            }
                        ?>
                    </tbody>
                </table>
            <?php elseif($status == 'Vaccinated'):?>
                <table class="styled-table">
                    <thead>
                        <tr>
                            <th>Vaccinated Date</th>
                            <th>Username</th>
                            <th>Vaccine Name</th>
                            <th>Catagory</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if($_SESSION['search_date'] == ''){
                                $list = mysqli_query($con,"SELECT * from vaccine_request where hospital_id ='$h_id' and request_status = 'Vaccinated'");
                            }
                            else{
                                $search_date = $_SESSION['search_date'];
                                $list = mysqli_query($con,"SELECT * from vaccine_request where hospital_id ='$h_id' and request_status = 'Vaccinated' and vaccinated_date ='$search_date'");
                            }
                            while($row_list = mysqli_fetch_assoc($list)){
                                $v_id = $row_list['vaccine_id'];
                                $fecth_vac_info = mysqli_fetch_assoc(mysqli_query($con,"SELECT * from vaccine where vaccine_id = '$v_id' "));
                                $cat_id = $fecth_vac_info['catagory_id'];
                                $fecth_cat_info = mysqli_fetch_assoc(mysqli_query($con,"SELECT * from vaccine_catagories where catagory_id = '$cat_id' "));
                                $u_id = $row_list['user_id'];
                                $fecth_user_info = mysqli_fetch_assoc(mysqli_query($con,"SELECT * from users where user_id = '$u_id' "));
                                
                                echo "<tr><td>".$row_list['vaccinated_date']."</td><td>".$fecth_user_info['username']."</td><td>".$fecth_vac_info['vaccine_name']."</td><td>".$fecth_cat_info['catagory_name']."</td><td>".$row_list['request_status']."</td></tr>";
                            }
                        ?>
                    </tbody>
                </table>
            <?php else:?>
                <table class="styled-table">
                    <thead>
                        <tr>
                            <th>Applied Date</th>
                            <th>Username</th>
                            <th>Vaccine Name</th>
                            <th>Catagory</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if($_SESSION['search_date'] == ''){
                                $list = mysqli_query($con,"SELECT * from vaccine_request where hospital_id ='$h_id' and request_status = 'Pending'");
                            }
                            else{
                                $search_date = $_SESSION['search_date'];
                                $list = mysqli_query($con,"SELECT * from vaccine_request where hospital_id ='$h_id' and request_status = 'Pending' and applied_date ='$search_date'");
                            }
                            while($row_list = mysqli_fetch_assoc($list)){
                                $v_id = $row_list['vaccine_id'];
                                $fecth_vac_info = mysqli_fetch_assoc(mysqli_query($con,"SELECT * from vaccine where vaccine_id = '$v_id' "));
                                $cat_id = $fecth_vac_info['catagory_id'];
                                $fecth_cat_info = mysqli_fetch_assoc(mysqli_query($con,"SELECT * from vaccine_catagories where catagory_id = '$cat_id' "));
                                $u_id = $row_list['user_id'];
                                $fecth_user_info = mysqli_fetch_assoc(mysqli_query($con,"SELECT * from users where user_id = '$u_id' "));
                                
                                echo "<tr><td>".$row_list['applied_date']."</td><td>".$fecth_user_info['username']."</td><td>".$fecth_vac_info['vaccine_name']."</td><td>".$fecth_cat_info['catagory_name']."</td><td>".$row_list['request_status']."</td></tr>";
                            }
                        ?>
                    </tbody>
                </table>

            <?php endif; ?>
        </div>
    </form>
</body>
<?php endif; ?>
</html>