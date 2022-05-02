<?php include('server.php')?>


<?php if(!empty($_SESSION['Username'])):?>
<?php $u_id = $_SESSION['user_id'];?>
<head>
    <title>Tonic</title>
    <link rel="stylesheet" href="css\user_home.css">


</head>

<body>
    <form action="user_info.php" method="POST">
        <header>
        <a href="user_homepage.php"><img src="image\logo.png" class="logo"></a>
            <nav>

                <ul class="nav_links">
                    <li><button type='submit' class='btn-nav' name='vac_status'>Dashboard</button></li>
                    <li><button type='submit' class='btn-nav' name='vac_info_user'>Vaccine Information</button></li>

                </ul>
            </nav>
            <div>
                <a href="user_profile_modify.php" title="Profile"><img src="image\user.png" class="profile_icon"></a>
                <a href="logout.php" title="Logout"><img src="image\logout.png" class="logout_icon"></a>
            </div>
        </header>
        <div class="form_grid">
            <div class="row">
                    <button class="PENDING" name="user_btn_pending">
                        PENDING
                        <br>
                        <?php
                            $result = mysqli_query($con,"SELECT *from vaccine_request where   user_id ='$u_id' and request_status = 'Pending'");
                            echo mysqli_num_rows($result);
                        ?>
                    </button>
                
                
                
                    <button class="APPROVED" name="user_btn_approved">
                        APPROVED
                        <br>
                        <?php
                            $result = mysqli_query($con,"SELECT *from vaccine_request where   user_id ='$u_id' and request_status = 'Approved'");
                            echo mysqli_num_rows($result);
                        ?>            
                    </button>
                

                
                    <button class="VACCINATED" name="user_btn_vaccinated">
                        VACCINATED
                        <br>
                        <?php
                            $result = mysqli_query($con,"SELECT *from vaccine_request where  user_id ='$u_id' and request_status = 'Vaccinated'");
                            echo mysqli_num_rows($result);
                        ?>
                    </button>
            </div>
        </div>
        <div class="form" id="table">
            <div class = "form_button">
                <div class="entry">
                    <label>Search by Date : </label>
                    <input type="date"  name="user-info-date-search">
                    <button class="btn-reg" name="user_search_by_date">SEARCH</button>
                    <button class="btn-reg" name="user_show_all">SHOW ALL</button>
                </div>
            </div>
            
            <?php $status = $_SESSION['user_search_status']; ?>
            <?php if($status == 'Approved'):?>
                <table class="styled-table">
                    <thead>
                        <tr>
                            <th>Approved Date</th>
                            <th>Vaccine Name</th>
                            <th>Catagory</th>
                            <th>Status</th>
                            <th>Hospital Name</th>
                            <th>Hospital Contact</th>
                            <th>Hospital Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if($_SESSION['user_search_date'] == ''){
                                $list = mysqli_query($con,"SELECT * from vaccine_request where user_id ='$u_id' and request_status = 'Approved'");
                            }
                            else{
                                $search_date = $_SESSION['user_search_date'];
                                $list = mysqli_query($con,"SELECT * from vaccine_request where user_id ='$u_id' and request_status = 'Approved' and requested_date='$search_date'");
                            }
                            while($row_list = mysqli_fetch_assoc($list)){
                                $v_id = $row_list['vaccine_id'];
                                $fecth_vac_info = mysqli_fetch_assoc(mysqli_query($con,"SELECT * from vaccine where vaccine_id = '$v_id' "));
                                $cat_id = $fecth_vac_info['catagory_id'];
                                $fecth_cat_info = mysqli_fetch_assoc(mysqli_query($con,"SELECT * from vaccine_catagories where catagory_id = '$cat_id' "));
                                $h_id = $row_list['hospital_id'];
                                $fecth_hospital_info = mysqli_fetch_assoc(mysqli_query($con,"SELECT * from hospitals where hospital_id = '$h_id' "));
                                
                                echo "<tr><td>".$row_list['requested_date']."</td><td>".$fecth_vac_info['vaccine_name']."</td><td>".$fecth_cat_info['catagory_name']."</td><td>".$row_list['request_status']."</td><td>".$fecth_hospital_info['hospital_name']."</td><td>".$fecth_hospital_info['h_contact']."</td><td>".$fecth_hospital_info['h_address']."</td></tr>";
                            }
                        ?>
                    </tbody>
                </table>
            <?php elseif($status == 'Vaccinated'):?>
                <table class="styled-table">
                    <thead>
                        <tr>
                            <th>Vaccinated Date</th>
                            <th>Vaccine Name</th>
                            <th>Catagory</th>
                            <th>Status</th>
                            <th>Hospital Name</th>
                            <th>Hospital Contact</th>
                            <th>Hospital Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if($_SESSION['user_search_date'] == ''){
                                $list = mysqli_query($con,"SELECT * from vaccine_request where user_id ='$u_id' and request_status = 'Vaccinated'");
                            }
                            else{
                                $search_date = $_SESSION['user_search_date'];
                                $list = mysqli_query($con,"SELECT * from vaccine_request where user_id ='$u_id' and request_status = 'Vaccinated' and vaccinated_date='$search_date'");
                            }
                            while($row_list = mysqli_fetch_assoc($list)){
                                $v_id = $row_list['vaccine_id'];
                                $fecth_vac_info = mysqli_fetch_assoc(mysqli_query($con,"SELECT * from vaccine where vaccine_id = '$v_id' "));
                                $cat_id = $fecth_vac_info['catagory_id'];
                                $fecth_cat_info = mysqli_fetch_assoc(mysqli_query($con,"SELECT * from vaccine_catagories where catagory_id = '$cat_id' "));
                                $h_id = $row_list['hospital_id'];
                                $fecth_hospital_info = mysqli_fetch_assoc(mysqli_query($con,"SELECT * from hospitals where hospital_id = '$h_id' "));
                                
                                echo "<tr><td>".$row_list['vaccinated_date']."</td><td>".$fecth_vac_info['vaccine_name']."</td><td>".$fecth_cat_info['catagory_name']."</td><td>".$row_list['request_status']."</td><td>".$fecth_hospital_info['hospital_name']."</td><td>".$fecth_hospital_info['h_contact']."</td><td>".$fecth_hospital_info['h_address']."</td></tr>";

                            }
                        ?>
                    </tbody>
                </table>
            <?php else:?>
                <table class="styled-table">
                    <thead>
                        <tr>
                            <th>Applied Date</th>
                            <th>Vaccine Name</th>
                            <th>Catagory</th>
                            <th>Status</th>
                            <th>Hospital Name</th>
                            <th>Hospital Contact</th>
                            <th>Hospital Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if($_SESSION['user_search_date'] == ''){
                                $list = mysqli_query($con,"SELECT * from vaccine_request where user_id ='$u_id' and request_status = 'Pending'");
                            }
                            else{
                                $search_date = $_SESSION['user_search_date'];
                                $list = mysqli_query($con,"SELECT * from vaccine_request where user_id ='$u_id' and request_status = 'Pending' and applied_date='$search_date'");

                            }
                            while($row_list = mysqli_fetch_assoc($list)){
                                $v_id = $row_list['vaccine_id'];
                                $fecth_vac_info = mysqli_fetch_assoc(mysqli_query($con,"SELECT * from vaccine where vaccine_id = '$v_id' "));
                                $cat_id = $fecth_vac_info['catagory_id'];
                                $fecth_cat_info = mysqli_fetch_assoc(mysqli_query($con,"SELECT * from vaccine_catagories where catagory_id = '$cat_id' "));
                                $h_id = $row_list['hospital_id'];
                                $fecth_hospital_info = mysqli_fetch_assoc(mysqli_query($con,"SELECT * from hospitals where hospital_id = '$h_id' "));
                                
                                echo "<tr><td>".$row_list['applied_date']."</td><td>".$fecth_vac_info['vaccine_name']."</td><td>".$fecth_cat_info['catagory_name']."</td><td>".$row_list['request_status']."</td><td>".$fecth_hospital_info['hospital_name']."</td><td>".$fecth_hospital_info['h_contact']."</td><td>".$fecth_hospital_info['h_address']."</td></tr>";

                            }
                        ?>
                    </tbody>
                </table>

            <?php endif; ?>
        </div>

    </form>
</body>


<?php endif; ?>