<?php include('server.php')?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Tonic</title>
    <link rel="stylesheet" href="css\user_home.css">
</head>

<body>
<div class="form" >
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>Hospital Name</th>
                        <th>Contact</th>
                        <th>Email</th>
                        <th>Address</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $status = "verified";
                        $result = mysqli_query($con,"SELECT * from hospitals where h_status = '$status'");
                        while($list_of_hospital = mysqli_fetch_assoc($result)){
                            echo "<tr><td>".$list_of_hospital['hospital_name']."</td><td>".$list_of_hospital['h_contact']."</td><td>".$list_of_hospital['h_email']."</td><td>".$list_of_hospital ['h_address']."</td></tr>";
                        }
                        
                    ?>
                </thbody>
            </table>
        </div>


</body>

</html>