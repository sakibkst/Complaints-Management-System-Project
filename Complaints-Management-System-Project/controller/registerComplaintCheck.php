<?php
session_start();
include_once('../model/complaintsModel.php');
$complaint_details = $_POST['complaint_details'];
$status = 'received';

// Handle file upload
$targetDirectory = "path/to/upload/directory/";
$targetFile = $targetDirectory . basename($_FILES["file"]["name"]);

if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
    // File uploaded successfully, now insert complaint with file details
    addComplaint($userId, $category, $subcategory, $status, $complaint_details, $complaint_type, $district, $_FILES["file"]["name"]);
    echo "complaint done";
} else {
    echo "Error uploading file";
}
    $userId=$_SESSION['id'];
    $category=$_POST['category'];
    $subcategory=$_POST['subcategory'];
    $complaint_type=$_POST['complaint_type'];
    $district=$_POST['district'];
    $complaint_details=$_POST['complaint_details'];
    $status='received';
    if($category=="not selected"){
        echo "invalid category";
    }
    else if($subcategory=="not selected"){
        echo "invalid subcategory";
    }
    else if($complaint_type=="not selected"){
        echo "invalid complaint_type";
    }
    else if($district=="not selected"){
        echo "invalid district";
    }
    else if($complaint_details==""){
        echo "invalid complaint_details";
    }
    else{
        addComplaint($userId,$category,$subcategory,$status,$complaint_details,$complaint_type,$district);
        echo "complaint done";
    }

?>