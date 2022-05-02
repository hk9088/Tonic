<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require "connection.php";

session_start();
$errors = array();
date_default_timezone_set('asia/dhaka');
$from = '';
$pass_mail = '';
if(isset($_POST['reg_user'])){
   
    

    $username =      $_POST['Username'];
    $password_1 =    $_POST['Password_1'];
    $password_2 =    $_POST['Password_2'];
    $email =         $_POST['Email'];
    $nid =           $_POST['NID'];
    $dob =           $_POST['Dob'];


    if($password_1 != $password_2)          $errors['password'] = "Password doesn't match\n";

    $sql = "SELECT * from users where username = '$username' OR email = '$email' OR nid = '$nid' limit 1  ";

    $result = mysqli_query($con,$sql);
    
    $uresult = mysqli_fetch_assoc($result);


    if(mysqli_num_rows($result)){
        if(mysqli_num_rows(mysqli_query($con,"SELECT * from users where username = '$username'  limit 1  ")))     $errors['username'] = "Username already exists\n";
        else if(mysqli_num_rows(mysqli_query($con,"SELECT * from users where email = '$email'  limit 1  ")))      $errors['email'] = "Email already registered";
        else if(mysqli_num_rows(mysqli_query($con,"SELECT * from users where nid = '$nid' limit 1  ")))           $errors['nid'] = "NID already registered";
    }

    else{

        
        $code = rand(999999, 111111);
        $password = md5($password_1); 
        $status = "notverified";
        $bool = '1';
        $sql = "INSERT INTO users(username,password,email,nid,dob,status,code,first_time) VALUES('$username','$password','$email','$nid','$dob','$status','$code','$bool')";
        $data_check = mysqli_query($con,$sql);
        if($data_check){

            
            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = '587';
            $mail->SMTPAuth = true;
            $mail->Username = $from;
            $mail->Password = $pass_mail;
            $mail->SMTPSecure = 'tls';
            $mail->From = $from;
            $mail->FromName = $from;
            $mail->AddAddress($email);
            $mail->WordWrap = 50;
            $mail->IsHTML(true);
            $mail->Subject = 'Verification code for Verify Your Email Address';

            $message_body = $message = "Your verification code is $code";
            $mail->Body = $message_body;

            
            if($mail->Send())
            {
                $info = "We've sent a verification code to your email - $email";
                $_SESSION['info'] = $info;
                $_SESSION['Username'] = $username;
                $_SESSION['success'] ="You are now logged in";
                $_SESSION['Email'] = $email;
                
                header('Location: otp.php');

            }
            else
            {
                
                $errors['otp-error'] = "Failed while sending code!";
            }
        }else{
            
            $errors['db-error'] = "Failed while inserting data into database!";
        }

    }

}



//LOGIN USER

if(isset($_POST['login_user'])){
    

    $host = "localhost";
    $user = "root";
    $password = "";
    $db = "tonic";

    $con = mysqli_connect($host,$user,$password,$db);


    $username = $_POST['Username'];
    $password = $_POST['Password_1'];
    $password = md5($password);
    
   
        
    $sql = "select * from users where username = '$username'   limit 1  ";
    $result = mysqli_query($con,$sql);

    if(mysqli_num_rows($result)){
        $fetch = mysqli_fetch_assoc($result);
            $fetch_pass = $fetch['password'];
            $email = $fetch['email'];
            if($password == $fetch_pass){
                $_SESSION['Username'] = $username;
                $status = $fetch['status'];
                $bool = $fetch['first_time'];
                if($status == 'verified'){
                    $_SESSION['Username'] = $username; 
                    $_SESSION['success'] ="You are now logged in";
                    $_SESSION['password'] = $password;
                    $_SESSION['user_id'] = $fetch['user_id'];
                    $_SESSION['search_cat'] = "";
                    $_SESSION['user_search_status'] = '';
                    $_SESSION['user_search_date'] = '';
                    if($bool == '1')
                    {
                        header('Location: user_profile.php');       
                    }
                    else{
                        header('Location: user_homepage.php');
                    }
                 
                }else{
                    $info = "It's look like you haven't still verify your email - $email";
                    $_SESSION['info'] = $info;
                    header('Location: otp.php');
                }

        
        
            }
            else
            {
                $errors['email'] = "Incorrect username or password!";
            }
            
    }else{
        $errors['email'] = "It's look like you're not yet a member! Click on the signup.";
    }
   
    
}

if(isset($_POST['check'])){
    $_SESSION['info'] = "";
    $otp_code = mysqli_real_escape_string($con, $_POST['otp']);
    $check_code = "SELECT * FROM users WHERE code = $otp_code";
    $code_res = mysqli_query($con, $check_code);
    if(mysqli_num_rows($code_res) > 0){
        $fetch_data = mysqli_fetch_assoc($code_res);
        $fetch_code = $fetch_data['code'];
        $email = $fetch_data['email'];
        $code = 0;
        $status = 'verified';
        $update_otp = "UPDATE users SET code = '$code', status = '$status' WHERE code = '$fetch_code'";
        $update_res = mysqli_query($con, $update_otp);
        if($update_res){
            $_SESSION['Username'] = $username;
            header('Location: homepage.php');
            exit();
        }else{
            $errors['otp-error'] = "Failed while updating code!";
        }
    }else{
        $errors['otp-error'] = "You've entered incorrect code!";
    }
}


if(isset($_POST['vac_status'])){
    $_SESSION['search_cat'] = "";
    header('Location: user_homepage.php');
}

if(isset($_POST['vac_info_user'])){
    header('Location: user_info.php');
}

if(isset($_POST['vac_reg'])){
    $_SESSION['reg_vac_id'] = $_POST['vac_reg'];
    header('Location: user_registration.php');
    
}

if(isset($_POST['update_user'])){

    $f_name = $_POST['Full_name'];
    $mobile = $_POST['Mobile_no'];
    $address = $_POST['Address'];
    $username = $_SESSION['Username'];

    $sql = "UPDATE users set name = '$f_name' , mobile = '$mobile' ,address = '$address' , first_time='0' where username= '$username'";
    $data_check = mysqli_query($con,$sql);
    if($data_check){
        header('Location: user_homepage.php');
    }
    else{
        $errors['db-error'] = "Failed while inserting data into database!";
        echo $errors['db-error'];
    }
    
}

if(isset($_POST['update_otp'])){
    $username = $_SESSION['Username'];
    $sql = "select * from users where username = '$username'  limit 1  ";

    $result = mysqli_query($con,$sql);
    
    $uresult = mysqli_fetch_assoc($result);

    
    $email = $uresult['email'];
    
    
    $code = rand(999999, 111111);
    $status = "notverified";
    $sql = "UPDATE users set code = '$code', status = '$status'  where username = '$username'";
    $data_check = mysqli_query($con,$sql);
    if($data_check){

        
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = '587';
        $mail->SMTPAuth = true;
        $mail->Username = $from;
        $mail->Password = $pass_mail;
        $mail->SMTPSecure = 'tls';
        $mail->From = $from;
        $mail->FromName = $from;
        $mail->AddAddress($email);
        $mail->WordWrap = 50;
        $mail->IsHTML(true);
        $mail->Subject = 'Verification code for Verify Your Email Address';

        $message_body = $message = "Your verification code is $code";
        $mail->Body = $message_body;

        
        if($mail->Send())
        {
            $info = "We've sent a verification code to your email - $email";
            $_SESSION['info'] = $info;
            $_SESSION['Username'] = $username ;
            header('Location: user_otp_password.php');

        }
        else
        {
            
            $errors['otp-error'] = "Failed while sending code!";
            echo $errors['otp-error'];
        }
    }else{
        
        $errors['db-error'] = "Failed while inserting data into database!";
        echo $errors['db-error'];
    }

}
if(isset($_POST['check_pass_otp'])){
    $_SESSION['info'] = "";
    $otp_code = mysqli_real_escape_string($con, $_POST['otp']);
    $check_code = "SELECT * FROM users WHERE code = $otp_code";
    $code_res = mysqli_query($con, $check_code);
    if(mysqli_num_rows($code_res) > 0){
        $fetch_data = mysqli_fetch_assoc($code_res);
        $fetch_code = $fetch_data['code'];
        $email = $fetch_data['email'];
        $code = 0;
        $status = 'verified';
        $update_otp = "UPDATE users SET code = '$code', status = '$status' WHERE code = '$fetch_code'";
        $update_res = mysqli_query($con, $update_otp);
        if($update_res){
            header('Location: update_user_pass.php');
            
        }else{
            $errors['otp-error'] = "Failed while updating code!";
        }
    }else{
        $errors['otp-error'] = "You've entered incorrect code!";
        echo $errors['otp-error'];
    }
}

if(isset($_POST['update_pass'])){
    $old_pass = $_POST['old_pass'];
    $new_pass = $_POST['new_pass'];
    $confirm_new_pass = $_POST['confirm_new_pass'];
    $username = $_SESSION['Username'];

    $sql = "select * from users where username = '$username'  limit 1  ";

    $result = mysqli_query($con,$sql);
    
    $uresult = mysqli_fetch_assoc($result);

    $fetch_pass = $uresult['password']; 
    
    if(md5($old_pass) == $fetch_pass){
        if($new_pass == $confirm_new_pass){
            $new_pass = md5($new_pass);
            $sql = "UPDATE users set password = '$new_pass'  where username= '$username'";
            $data_check = mysqli_query($con,$sql);
            if($data_check){
                header('Location: user_homepage.php');
            }
            else{
                $errors['db-error'] = "Failed while inserting data into database!";
                echo $errors['db-error'];
            }

        }
        else{
            echo "Password doesn't match";
        }
        
    }
    else{
        $errors['password'] = "Incorrect  password!";
        echo $errors['password'];
    }
    
}

if(isset($_POST['submit_vac_req'])){
    $date = date("Y-m-d");
    $username = $_SESSION['Username'];
    $result = mysqli_fetch_assoc(mysqli_query($con,"SELECT * From users where username = '$username'"));
    
    $h_id = $_POST['select_hospital'];
    $v_id = $_SESSION['reg_vac_id'];
    $u_id = $result['user_id'];
    $req_status = "Pending";

    $fetched_catagory_info = mysqli_fetch_assoc(mysqli_query($con,"SELECT * from vaccine where vaccine_id = '$v_id'"));
    $cat_id = $fetched_catagory_info['catagory_id'];
    $query = mysqli_query($con,"INSERT INTO vaccine_request(user_id,hospital_id,vaccine_id,catagory_id,request_status,applied_date) VALUES('$u_id','$h_id','$v_id','$cat_id','$req_status','$date')");
    if($query){
        unset($_SESSION['reg_vac_id']);
        header('Location: user_homepage.php');
    }
}
    

if(isset($_POST['user_search_by_cat_dashboard'])){
    $_SESSION['search_cat'] = $_POST['select_vac_cat'];
    header('Location: user_homepage.php');
}

if(isset($_POST['user_search_by_date'])){
    $_SESSION['user_search_date'] = $_POST['user-info-date-search'];
}
if(isset($_POST['user_show_all'])){
    $_SESSION['user_search_date'] = '';
}

if(isset($_POST['user_btn_pending'])){
    $_SESSION['user_search_status']='Pending';
    $_SESSION['user_search_date'] = '';
    header('Location: user_info.php');
}
if(isset($_POST['user_btn_approved'])){
    $_SESSION['user_search_status']='Approved';
    $_SESSION['user_search_date'] = '';
    header('Location: user_info.php');
}
if(isset($_POST['user_btn_vaccinated'])){
    $_SESSION['user_search_status']='Vaccinated';
    $_SESSION['user_search_date'] = '';
    header('Location: user_info.php');
}

//Hospital

if(isset($_POST['login_hospital'])){
    


    $h_email = $_POST['h_email'];
    $password = $_POST['h_Password'];
    $password = md5($password);
    
   
        
    $sql = "select * from hospitals where h_email = '$h_email'   limit 1  ";
    $result = mysqli_query($con,$sql);

    if(mysqli_num_rows($result)){
        $fetch = mysqli_fetch_assoc($result);
            $fetch_pass = $fetch['h_password'];
            $email = $fetch['h_email'];
            if($password == $fetch_pass){
                $_SESSION['h_id'] = $fetch['hospital_id'];
                $status = $fetch['h_status'];
                $code = $fetch['h_code'];
                if($code != '0'){
                    $info = "It's look like you haven't still verify your email - $email";
                    $_SESSION['info'] = $info;
                    header('Location: h_otp.php');
                }else{
                    if($status == 'verified'){
                        $_SESSION['success'] ="You are now logged in";
                        $_SESSION['password'] = $password;
                        
                        $_SESSION['search_status']='Pending';
                        $_SESSION['search_date'] = "";
                        header('Location: hospital_homepage.php');
                        
                    }else{
                        $info = "It's look like this hospital haven't been verifed yet";
                        $errors['email'] = $info;
                    }
                 
                }
            }
            else
            {
                $errors['email'] = "Incorrect email or password!";
            }
            
    }else{
        $errors['email'] = "It's look like you're not yet a member! Click on the signup.";
    }
   
    
}

if(isset($_POST['reg_hospital'])){
   
    

    $h_name =               $_POST['hospital_name'];
    $h_license_number =     $_POST['hospital_license_number'];
    $password_1 =           $_POST['hospital_password_1'];
    $password_2 =           $_POST['hospital_password_2'];
    $h_email =              $_POST['hospital_email'];
    $h_contact =            $_POST['hospital_contact_number'];
    $h_address =            $_POST['hospital_address'];


    if($password_1 != $password_2)          $errors['password'] = "Password doesn't match\n";

    $sql = "SELECT * from hospitals where h_email = '$h_email' OR h_license_number = '$h_license_number' limit 1  ";

    $result = mysqli_query($con,$sql);
    
    $uresult = mysqli_fetch_assoc($result);


    if(mysqli_num_rows($result)){
        if(mysqli_num_rows(mysqli_query($con,"SELECT * from hospitals where h_email = '$h_email'  limit 1  ")))     $errors['email'] = "email already exists\n";
        else if(mysqli_num_rows(mysqli_query($con,"SELECT * from hospitals where h_license_number = '$h_license_number'  limit 1  ")))      $errors['license'] = "license already registered";
    }

    else{

        
        $code = rand(999999, 111111);
        $password = md5($password_1); 
        $status = "notverified";
        $sql = "INSERT INTO hospitals(hospital_name,h_email,h_password,h_license_number,h_contact,h_address,h_status,h_code) VALUES('$h_name','$h_email','$password','$h_license_number','$h_contact','$h_address','$status','$code')";
        $data_check = mysqli_query($con,$sql);
        if($data_check){
            
            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = '587';
            $mail->SMTPAuth = true;
            $mail->Username = $from;
            $mail->Password = $pass_mail;
            $mail->SMTPSecure = 'tls';
            $mail->From = $from;
            $mail->FromName = $from;
            $mail->AddAddress($h_email);
            $mail->WordWrap = 50;
            $mail->IsHTML(true);
            $mail->Subject = 'Verification code for Verify Your Email Address';

            $message_body = $message = "Your verification code is $code";
            $mail->Body = $message_body;
            
            if($mail->Send())
            {
                $info = "We've sent a verification code to your email - $h_email";
                $_SESSION['info'] = $info;
                $_SESSION['success'] ="You are now logged in";
                $_SESSION['Email'] = $h_email;
                
                header('Location: h_otp.php');

            }
            else
            {
                
                $errors['otp-error'] = "Failed while sending code!";
            }
        }else{
            
            $errors['db-error'] = "Failed while inserting data into database!";
        }

    }

}

if(isset($_POST['h_check'])){
    $_SESSION['info'] = "";
    $otp_code = mysqli_real_escape_string($con, $_POST['otp']);
    $code_res = mysqli_query($con, "SELECT * FROM hospitals WHERE h_code = $otp_code");
    if(mysqli_num_rows($code_res) > 0){
        $fetch_data = mysqli_fetch_assoc($code_res);
        $fetch_code = $fetch_data['h_code'];
        $email = $fetch_data['h_email'];
        $code = 0;
        $update_otp = "UPDATE hospitals SET h_code = '$code' WHERE h_code = '$fetch_code'";
        $update_res = mysqli_query($con, $update_otp);
        if($update_res){
            $_SESSION['h_id'] = $fetch['hospital_id'];
            header('Location: hospital_login.php');
            exit();
        }else{
            $errors['otp-error'] = "Failed while updating code!";
        }
    }else{
        $errors['otp-error'] = "You've entered incorrect code!";
    }
}
if(isset($_POST['btn_pending'])){
    $_SESSION['search_status']='Pending';
    $_SESSION['search_date'] = '';
    header('Location: hospital_homepage.php');
}
if(isset($_POST['btn_approved'])){
    $_SESSION['search_status']='Approved';
    $_SESSION['search_date'] = '';
    header('Location: hospital_homepage.php');
}
if(isset($_POST['btn_vaccinated'])){
    $_SESSION['search_status']='Vaccinated';
    $_SESSION['search_date'] = '';
    header('Location: hospital_homepage.php');
}

if(isset($_POST['add_vac_hospital'])){
    $h_id = $_SESSION['h_id'];
    $v_id = $_POST['select_vaccine_to_add'];
    $quantity = $_POST['entry_quantity'];
    $result = mysqli_query($con,"SELECT * from inventory where hospital_id = '$h_id' and vaccine_id = '$v_id' ");
    if(mysqli_fetch_assoc($result)){
        $errors['inventory'] = "Vaccine already exits in inventory try UPDATE";
    }
    else{
        $query = mysqli_query($con,"INSERT INTO inventory(hospital_id,vaccine_id,available_quantity) VALUES('$h_id','$v_id','$quantity')");
        if(mysqli_fetch_assoc($query)){
            $_SESSION['info'] = "Vaccine Added";
        }
    }
    
}

if(isset($_POST['update_vac_hospital'])){
    $h_id = $_SESSION['h_id'];
    $v_id = $_POST['select_vaccine_to_add'];
    $quantity = $_POST['entry_quantity'];
    $result = mysqli_query($con,"SELECT * from inventory where hospital_id = '$h_id' and vaccine_id = '$v_id' ");
    if(mysqli_fetch_assoc($result)){
        $fetch_quantity = mysqli_fetch_assoc($result);
        $quantity = (int)$quantity + (int)$fetch_quantity['available_quantity'];
        $query = mysqli_query($con,"UPDATE inventory SET available_quantity = '$quantity' where hospital_id = '$h_id' and vaccine_id = '$v_id' ");
        if(mysqli_fetch_assoc($query)){
            $_SESSION['info'] = "Vaccine Updated";
        }
        
    }
    else{
        $errors['inventory'] = "Vaccine doesn't exits in inventory try ADD";
    }
    
}

if(isset($_POST['submit_vac_approve'])){
    if($_POST['date-vaccine-distribution']!== ""){
        $_SESSION['vac_date'] = $_POST['date-vaccine-distribution'];
        $_SESSION['vac_approve'] = $_POST['select_vaccine_to_approve'];

        header('Location: hospital_vaccine_approve.php');
    }
    else{
        $errors['date'] = "Please select a date";
    }
    
}

if(isset($_POST['confirm_vac_distribution'])){
    $quantity =  (int)$_POST['amount_of_approve'];
    $h_id     =  $_SESSION['h_id'];
    $a_date   =  $_SESSION['vac_date'];
    $v_id     =  $_SESSION['vac_approve'];

    $result = mysqli_query($con,"SELECT * from inventory where hospital_id = '$h_id' and vaccine_id = '$v_id' ");
    $fetch_inventory_data = mysqli_fetch_assoc($result);
    $avaiable_quantity = (int)$fetch_inventory_data['available_quantity'];

    $request_count = mysqli_num_rows(mysqli_query($con,"SELECT * FROM vaccine_request where hospital_id = '$h_id' and vaccine_id = '$v_id' and request_status = 'Pending' "));
    if($request_count>0){
        if($quantity > $avaiable_quantity){
            $errors['inventory'] = "This amount of vaccine is not available";
        }
        else{
            $request_info = mysqli_query($con,"SELECT * from vaccine_request where hospital_id = '$h_id' and vaccine_id = '$v_id' and request_status = 'Pending' ");
            $count = 0;
            while($row = mysqli_fetch_assoc($request_info)){
                if($count == $quantity)
                    break;
                $count += 1;
                $u_id = $row['user_id'];
                $fetched_user_info= mysqli_fetch_assoc(mysqli_query($con,"SELECT * from users where user_id = '$u_id' "));
                $email = $fetched_user_info['email'];
                if($fetched_user_info){
                    $id = $row['request_id'];
                    $code = rand(999999, 111111);
                    $mail = new PHPMailer();
                    $mail->IsSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->Port = '587';
                    $mail->SMTPAuth = true;
                    $mail->Username = $from;
                    $mail->Password = $pass_mail;
                    $mail->SMTPSecure = 'tls';
                    $mail->From = $from;
                    $mail->FromName = $from;
                    $mail->AddAddress($email);
                    $mail->WordWrap = 50;
                    $mail->IsHTML(true);
                    $mail->Subject = 'Vaccine Request Approved';
            
                    $message_body = $message = "Your vaccine request was approved.Your verification code is $code and Request id is $id. Please arrive at the hospital at $a_date";
                    $mail->Body = $message_body;
            
                    
                    if($mail->Send())
                    {
                        mysqli_query($con,"UPDATE vaccine_request SET request_status='Approved',code ='$code',requested_date = '$a_date'  where hospital_id = '$h_id' and vaccine_id = '$v_id' and user_id = '$u_id'  ");
                        $info = "We've sent a Approval email to all of selected users";
                        $_SESSION['info'] = $info;
                        unset($_SESSION['vac_date']);
                        unset($_SESSION['vac_approve']);
                        header('Location: hospital_homepage.php');
            
                    }
                    else
                    {
                        
                        $errors['otp-error'] = "Failed while sending email!";
                        echo $errors['otp-error'];
                    }
                }else{
                    
                    $errors['db-error'] = "Failed find user from database!";
                    echo $errors['db-error'];
                }
    
            }
        }
    }
    else{
        $errors['request'] = "No Pending Request";
    }
    

}

if(isset($_POST['add_stuff_info'])){
    $h_id       =  $_SESSION['h_id'];
    $s_username = $_POST['staff_username_add'];
    $s_pass     = $_POST['staff_password_add'];

    $result = mysqli_query($con,"SELECT * from hospital_staff where staff_username = '$s_username' and hospital_id = '$h_id'");
    if(mysqli_fetch_assoc($result))
    {
        $errors['staff'] = "Staff Username already exits try UPDATE";
    }
    else{
        mysqli_query($con,"INSERT INTO hospital_staff(hospital_id,staff_username,staff_password) VALUES('$h_id','$s_username','$s_pass')");
    }
}

if(isset($_POST['update_stuff_info'])){
    $h_id       =   $_SESSION['h_id'];
    $s_id       =   $_POST['staff_id_update'];
    $s_username =   $_POST['staff_username_update'];
    $s_pass     =   $_POST['staff_password_update'];

    $result = mysqli_query($con,"SELECT * from hospital_staff where staff_id = '$s_id' and hospital_id = '$h_id'");
    if(mysqli_fetch_assoc($result))
    {
        mysqli_query($con,"UPDATE hospital_staff SET staff_username = '$s_username',staff_password = '$s_pass ' where staff_id = '$s_id' and hospital_id = '$h_id'");
    }
    else{
        
        $errors['staff'] = "Staff doesn't  exits try ADD";
    }


}

if(isset($_POST['login_hospital_staff'])){
    $h_email = $_POST['h_email'];
    $s_username = $_POST['s_username'];
    $s_pass = $_POST['s_password'];

    $fetch_hospital_info = mysqli_fetch_assoc(mysqli_query($con,"SELECT * From hospitals where h_email = '$h_email'"));
    if($fetch_hospital_info){
        $h_id = $fetch_hospital_info['hospital_id'];

        $fetch_staff_info = mysqli_fetch_assoc(mysqli_query($con,"SELECT * From hospital_staff where staff_username = '$s_username' and staff_password = '$s_pass' and hospital_id ='$h_id'"));
        if($fetch_staff_info){
            $_SESSION['staff_id'] = $fetch_staff_info['staff_id'];
            header('Location: hospital_staff_homepage.php');
        }
        else
        {
            $errors['staff'] = "Staff doesn't exits";
        }
    }
    else{
        $errors['staff'] = "Hospital email doesn't exits";
    }
    
}
if(isset($_POST['go_to_vaccination_confirm'])){
    $request_id = $_POST['entry_request_id'];
    $u_otp = $_POST['entry_otp'];

    $fetched_user_request_info = mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM vaccine_request where request_id = '$request_id' and code = '$u_otp' and request_status = 'Approved'"));
    if($fetched_user_request_info){
        $u_id = $fetched_user_request_info['user_id'];
        $_SESSION['u_id'] = $u_id;
        $_SESSION['u_info'] = $fetched_user_request_info;
        header('Location: hospital_staff_vaccine_info_confirm.php');
    }
    else{
        $errors['request'] = "OTP or Request id  error";
    }
}

if(isset($_POST['vaccination_confirm'])){
    $s_id = $_SESSION['staff_id'];
    $u_id =  $_SESSION['u_id'];
    $fetched_user_request_info = $_SESSION['u_info'];
    

    $fetched_user_info = mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM users where user_id = '$u_id' and status = 'verified' "));
    if($fetched_user_info){
        if($fetched_user_request_info){

            $h_id = $fetched_user_request_info['hospital_id'];
            $v_id = $fetched_user_request_info['vaccine_id'];
            $a_date = date("Y-m-d");

            $result = mysqli_query($con,"SELECT * from inventory where hospital_id = '$h_id' and vaccine_id = '$v_id' ");
            $fetch_inventory_data = mysqli_fetch_assoc($result);
            $avaiable_quantity = (int)$fetch_inventory_data['available_quantity'];

            mysqli_query($con,"UPDATE vaccine_request SET request_status='Vaccinated',code ='0',vaccinated_date = '$a_date', staff_id = '$s_id'  where hospital_id = '$h_id' and vaccine_id = '$v_id' and user_id = '$u_id'  ");
            $avaiable_quantity = $avaiable_quantity - 1;

            mysqli_query($con,"UPDATE inventory SET available_quantity = '$avaiable_quantity' where hospital_id = '$h_id' and vaccine_id = '$v_id' ");

            $info = "User Successfully vaccinated";
            $_SESSION['info'] = $info;
            unset($_SESSION['u_id']);
            unset($_SESSION['u_info']);
            header('Location: hospital_staff_vaccine_confirm.php');


        }
        else{
            $errors['request'] = "OTP or Request id  error";
        }
    }
    else{
        $errors['user'] = "User doesn't exits";
    }
}

if(isset($_POST['search_by_date'])){
    $_SESSION['search_date'] = $_POST['date-search-vaccine-distribution'];
}
if(isset($_POST['show_all'])){
    $_SESSION['search_date'] = '';
}
if(isset($_POST['udate_hospital_info'])){
    $h_id = $_SESSION['h_id'];
    $h_contact = $_POST['h_contact'];
    $h_address = $_POST['h_address'];

    mysqli_query($con,"UPDATE hospitals SET h_contact = '$h_contact', h_address = '$h_address' where hospital_id = '$h_id' ");
    $_SESSION['info'] = "Successfully Updated";
    
}
if(isset($_POST['login_admin'])){
    $username = $_POST['admin_username'];
    $password = $_POST['admin_password'];
    $password = md5($password);

    $result = mysqli_query($con,"SELECT * from admins where username = '$username' and password = '$password' limit 1");

    if(mysqli_num_rows($result)){
        $fetch = mysqli_fetch_assoc($result);
        $_SESSION['admin_id'] = $fetch['id'];
        $_SESSION['search_status']='notverified';
        $_SESSION['search_name'] = '';
        header('Location: admin_homepage.php');
        
    }
    else{
        $errors['password'] = "Invalid information";
    }

}

if(isset($_POST['admin_btn_notverified'])){
    $_SESSION['search_status']='notverified';
    $_SESSION['search_name'] = '';
    header('Location: admin_homepage.php');
}


if(isset($_POST['admin_btn_verified'])){
    $_SESSION['search_status']='verified';
    $_SESSION['search_name'] = '';
    header('Location: admin_homepage.php');
}
if(isset($_POST['search_hospital_name'])){
    $_SESSION['search_name'] = $_POST['search-hospital-name'];
}
if(isset($_POST['show_all_hospitals'])){
    $_SESSION['search_name'] = '';
}
if(isset($_POST['submit_hos_approve'])){
    if($_POST['select_hospital_to_approve']!== ""){
        $h_id = $_POST['select_hospital_to_approve'];

        $fetch_hospital_info = mysqli_fetch_assoc(mysqli_query($con,"SELECT * From hospitals where hospital_id = '$h_id'"));
        
        if($fetch_hospital_info)
        {
            $h_email = $fetch_hospital_info['h_email'];
            $check = mysqli_query($con,"UPDATE hospitals SET h_status = 'verified' where hospital_id = '$h_id' ");
            
            $code = rand(999999, 111111);
            $password = md5($password_1); 
            if($check){
                
                $mail = new PHPMailer();
                $mail->IsSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->Port = '587';
                $mail->SMTPAuth = true;
                $mail->Username = $from;
                $mail->Password = $pass_mail;
                $mail->SMTPSecure = 'tls';
                $mail->From = $from;
                $mail->FromName = $from;
                $mail->AddAddress($h_email);
                $mail->WordWrap = 50;
                $mail->IsHTML(true);
                $mail->Subject = 'Request Approved';

                $message_body = $message = "Congratulation! Hospital request has beem approved by the administration ";
                $mail->Body = $message_body;
                if($mail->Send())
                {
                    $info = "We've sent a email to - $h_email";
                    $_SESSION['info'] = $info;

                }
                else
                {
                    
                    $errors['mail-error'] = "Failed while sending mail!";
                }
            }else{
                
                $errors['db-error'] = "Failed to update data into database!";
            }


        }
        else{
            $errors['db-error'] = "Hospital Not found";
        }
    }
    else{
        $errors['hospital'] = "Please select a hospital";
    }
}

if(isset($_POST['add_vaccine_info'])){
    $vaccine_name = $_POST['vaccine_name_add'];
    $vaccine_dose = $_POST['vaccine_dose_add'];
    $catagory_id  = $_POST['select_vac_cat_to_add'];

    $result = mysqli_query($con,"SELECT * from vaccine where vaccine_name = '$vaccine_name' and vaccine_dose = '$vaccine_dose' and catagory_id='$catagory_id'");
    if(mysqli_fetch_assoc($result))
    {
        $errors['staff'] = "Vaccine already exits try UPDATE";
    }
    else{
        mysqli_query($con,"INSERT INTO vaccine(vaccine_name,vaccine_dose,catagory_id) VALUES('$vaccine_name','$vaccine_dose','$catagory_id')");
    }
}

if(isset($_POST['update_vaccine_info'])){
    $vaccine_id   = $_POST['select_vac_id_to_update'];
    $vaccine_name = $_POST['vaccine_name_update'];
    $vaccine_dose = $_POST['vaccine_dose_update'];
    $catagory_id  = $_POST['select_vac_cat_to_update'];


    $result = mysqli_query($con,"SELECT * from vaccine where vaccine_id = '$vaccine_id'");
    if(mysqli_fetch_assoc($result))
    {
        mysqli_query($con,"UPDATE vaccine SET vaccine_name = '$vaccine_name',vaccine_dose = '$vaccine_dose ',catagory_id='$catagory_id' where vaccine_id = '$vaccine_id' ");
    }
    else{
        
        $errors['staff'] = "Vaccine doesn't  exits try ADD";
    }


}

if(isset($_POST['add_cat_info'])){
    $catagory_name = $_POST['vaccine_cat_add'];

    $result = mysqli_query($con,"SELECT * from vaccine_catagories where catagory_name = '$catagory_name'");
    if(mysqli_fetch_assoc($result))
    {
        $errors['staff'] = "Catagory already exits try UPDATE";
    }
    else{
        mysqli_query($con,"INSERT INTO vaccine_catagories(catagory_name) VALUES('$catagory_name')");
    }
}

if(isset($_POST['update_cat_info'])){
    $catagory_id   = $_POST['select_cat_id_to_update'];
    $catagory_name = $_POST['vaccine_cat_update'];
    


    $result = mysqli_query($con,"SELECT * from vaccine_catagories where catagory_id = '$catagory_id'");
    if(mysqli_fetch_assoc($result))
    {
        mysqli_query($con,"UPDATE vaccine_catagories SET catagory_name = '$catagory_name' where catagory_id = '$catagory_id' ");
    }
    else{
        
        $errors['staff'] = "Catagory doesn't  exits try ADD";
    }


}
       
        


?>
