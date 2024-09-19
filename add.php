<?php

include('config.php');


if (isset($_POST['submit'])) {

    $u_card = mysqli_real_escape_string($con, $_POST['card_no']);
    $u_f_name = mysqli_real_escape_string($con, $_POST['user_first_name']);
    $u_l_name = mysqli_real_escape_string($con, $_POST['user_last_name']);
    $u_father = mysqli_real_escape_string($con, $_POST['user_father']);
    $u_aadhar = mysqli_real_escape_string($con, $_POST['user_aadhar']);
    $u_birthday = mysqli_real_escape_string($con, $_POST['user_dob']);
    $u_gender = mysqli_real_escape_string($con, $_POST['user_gender']);
    $u_email = mysqli_real_escape_string($con, $_POST['user_email']);
    $u_phone = mysqli_real_escape_string($con, $_POST['user_phone']);
    $u_state = mysqli_real_escape_string($con, $_POST['state']);
    $u_dist = mysqli_real_escape_string($con, $_POST['dist']);
    $u_village = mysqli_real_escape_string($con, $_POST['village']);
    $u_police = mysqli_real_escape_string($con, $_POST['police_station']);
    $u_pincode = mysqli_real_escape_string($con, $_POST['pincode']);
    $u_mother = mysqli_real_escape_string($con, $_POST['user_mother']);
    $u_family = mysqli_real_escape_string($con, $_POST['family']);
    $u_staff_id = mysqli_real_escape_string($con, $_POST['staff_id']);

    $msg = "";
    $image = $_FILES['image']['name'];
    $target = "upload_images/" . basename($image);

 
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
  
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $file_type = mime_content_type($_FILES['image']['tmp_name']);
        
        if (in_array($file_type, $allowed_types) && $_FILES['image']['size'] < 5 * 1024 * 1024) { // 5MB limit
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                $msg = "Image uploaded successfully";
            } else {
                $msg = "Failed to upload image";
            }
        } else {
            $msg = "Invalid file type or file size too large";
        }
    } else {
        $msg = "No file uploaded or upload error";
        $image = ''; 
    }

  
    $stmt = $con->prepare("INSERT INTO student_data (u_card, u_f_name, u_l_name, u_father, u_aadhar, u_birthday, u_gender, u_email, u_phone, u_state, u_dist, u_village, u_police, u_pincode, u_mother, u_family, staff_id, image, uploaded) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
    

    $stmt->bind_param('sssssssssssssssss', $u_card, $u_f_name, $u_l_name, $u_father, $u_aadhar, $u_birthday, $u_gender, $u_email, $u_phone, $u_state, $u_dist, $u_village, $u_police, $u_pincode, $u_mother, $u_family, $u_staff_id, $image);

   
    if ($stmt->execute()) {
        echo "Data inserted successfully. " . $msg;
    } else {
        echo "Failed to insert data: " . $stmt->error;
    }


    $stmt->close();
    $con->close();
}
?>
