<?php
require_once ('./validation.php');
require_once ('../model/userModel.php');
if(!isset($_POST['userRegistration'])){header('location: ../view/userRegistration.php');};
$role='';
$firstName=$_POST['firstName'];
$lastName=$_POST["lastName"];
$userName=$_POST['userName'];
$email=$_POST['email'];
$phone=$_POST['phone'];
$password=$_POST["password"];
$confirmPassword=$_POST['confirmPassword'];
$gender='';
$address=$_POST['address'];


if(!isset($_POST['role'])) {
    header("location: ../view/userRegistration.php?errorMsgRole=Field is empty&firstName={$firstName}&lastName={$lastName}&userName={$userName}&email={$email}&phone={$phone}&submit=true"); 
    exit();
}

else{
        $role = $_POST['role'];
}


if(empty($firstName)) {
    header("location: ../view/userRegistration.php?errorMsgFirstName=Field is empty&firstName={$firstName}&lastName={$lastName}&userName={$userName}&email={$email}&phone={$phone}&submit=true"); 
    exit();
}
else{
    if(!isValidName($firstName)){
        header("location: ../view/userRegistration.php?errorMsg=invalidFirstName&firstName={$firstName}&lastName={$lastName}&userName={$userName}&email={$email}&phone={$phone}&submit=true"); 
        exit();
    }
}

if(empty($lastName)) {
    header("Location: ../view/userRegistration.php?errorMsgLastName=Field is empty&firstName={$firstName}&lastName={$lastName}&userName={$userName}&email={$email}&phone={$phone}&submit=true");
    exit();
}
else{
    if(!isValidName($lastName)){
        header("location: ../view/userRegistration.php?errorMsg=invalidLastName&firstName={$firstName}&lastName={$lastName}&userName={$userName}&email={$email}&phone={$phone}&submit=true"); 
        exit();
    }
}

if(empty($userName)){
    header("Location: ../view/userRegistration.php?errorMsgUserName=Field is empty&firstName={$firstName}&lastName={$lastName}&userName={$userName}&email={$email}&phone={$phone}&submit=true");
    exit();
}
else{
    if(!isValidUserName($userName)){
        header("location: ../view/userRegistration.php?errorMsg=invalidUserName&firstName={$firstName}&lastName={$lastName}&userName={$userName}&email={$email}&phone={$phone}&submit=true"); 
        exit();
    }
}

if(empty($email)) {
    header("location: ../view/userRegistration.php?errorMsgEmail=Field is empty&firstName={$firstName}&lastName={$lastName}&userName={$userName}&email={$email}&phone={$phone}&submit=true"); 
    exit();
}
else{
    if(!isValidEmail($email)){
        header("location: ../view/userRegistration.php?errorMsg=invalidEmail&firstName={$firstName}&lastName={$lastName}&userName={$userName}&email={$email}&phone={$phone}&submit=true"); 
        exit();
    }
}
if(isUserExist($userName,$email)){
        header("location: ../view/userRegistration.php?errorMsg=userExisted&firstName={$firstName}&lastName={$lastName}&userName={$userName}&email={$email}&phone={$phone}&submit=true"); 
        exit();
}
if(empty($phone)) {
    header("location: ../view/userRegistration.php?errorMsgPhone=Field is empty&firstName={$firstName}&lastName={$lastName}&userName={$userName}&email={$email}&phone={$phone}&submit=true"); 
    exit();
}
else{
    if(!isValidPhone($phone)){
        header("location: ../view/userRegistration.php?errorMsg=invalidPhone&firstName={$firstName}&lastName={$lastName}&userName={$userName}&email={$email}&phone={$phone}&submit=true"); 
        exit();
    }
}
if(empty($password)) {
    header("location: ../view/userRegistration.php?errorMsgPassword=Field is empty&firstName={$firstName}&lastName={$lastName}&userName={$userName}&email={$email}&phone={$phone}&submit=true"); 
    exit();
}
else{
    if(!isValidPassword($password)){
        header("location: ../view/userRegistration.php?errorMsg=invalidPassword&firstName={$firstName}&lastName={$lastName}&userName={$userName}&email={$email}&phone={$phone}&submit=true"); 
        exit();
    }
}

if(empty($confirmPassword)) {
    header("location: ../view/userRegistration.php?errorMsgConfirmPassword=Field is empty&firstName={$firstName}&lastName={$lastName}&userName={$userName}&email={$email}&phone={$phone}&submit=true"); 
    exit();
}
else{
    if(!isValidConfirmPassword($password,$confirmPassword)){
        header("location: ../view/userRegistration.php?errorMsg=invalidConfirmPassword&firstName={$firstName}&lastName={$lastName}&userName={$userName}&email={$email}&phone={$phone}&submit=true"); 
        exit();
    }
}
if(!isset($_POST['gender'])) {
    header("location: ../view/userRegistration.php?errorMsgGender=Field is empty&firstName={$firstName}&lastName={$lastName}&userName={$userName}&email={$email}&phone={$phone}&submit=true"); 
    exit();
}
else{
    $gender = $_POST['gender'];
}
if(empty($_POST['district'])) {
    header("location: ../view/userRegistration.php?errorMsgDistrict=Field is empty&firstName={$firstName}&lastName={$lastName}&userName={$userName}&email={$email}&phone={$phone}&submit=true"); 
    exit();
}
else{
    $district = $_POST['district'];
}
if(empty($address)) {
    header("location: ../view/userRegistration.php?errorMsgAddress=Field is empty&firstName={$firstName}&lastName={$lastName}&userName={$userName}&email={$email}&phone={$phone}&submit=true"); 
    exit();
}
else{
    if(!isValidAddress($address)){
        header("location: ../view/userRegistration.php?errorMsg=invalidAddress&firstName={$firstName}&lastName={$lastName}&userName={$userName}&email={$email}&phone={$phone}&submit=true"); 
        exit();
    }
}

if (empty($_FILES['profile']['name'])) {
    header("Location: ../view/userRegistration.php?errorMsgProfile=Field is empty&firstName={$firstName}&lastName={$lastName}&userName={$userName}&email={$email}&phone={$phone}&submit=true");
    exit();
}
else{
   if(!isValidFile($_FILES['profile']['name'],$_FILES['profile']['size'])){
    header("Location: ../view/userRegistration.php?errorMsg=invalidType&firstName={$firstName}&lastName={$lastName}&userName={$userName}&email={$email}&phone={$phone}&submit=true");
    exit();
   }
}
if(!isset($_POST['agreement'])) {
    header("location: ../view/userRegistration.php?errorMsgAgreement=Field is empty&firstName={$firstName}&lastName={$lastName}&userName={$userName}&email={$email}&phone={$phone}&submit=true"); 
    exit();
}

$profile = '';


    if($_FILES['profile']['size'] > 0){
        $profile = $_FILES['profile']['name'];
        $profile_src = $_FILES['profile']['tmp_name'];
        $profile_des = "../images/images".$_FILES['profile']['name'];
        if(move_uploaded_file($profile_src, $profile_des)){}
        else header('location: ../view/userRegistration.php?file_err=true');
    }
    else $profile = 'default.jpg';

    $status = addUser($userName, $firstName, $lastName, $email, $phone, $gender,$district, $address, $password, $role, $profile);

    if($status){
        header('location: ../view/signIn.php?success=created');
    }
    else{
        header('location: ../view/userRegistration.php?unknown=true');
    }
?>