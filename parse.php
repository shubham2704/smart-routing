<?php
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["file"]["name"]);
$uploadOk = 1;
$sheetFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


// Check file size
if ($_FILES["file"]["size"] > 500000) {
  header("HTTP/1.0 500 Internal Server Error");
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($sheetFileType != "csv" && $sheetFileType != "xlsx" ) {
    header("HTTP/1.0 500 Internal Server Error");
    echo "Sorry, only CSV & xlsx files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";

} else {
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["file"]["name"]). " has been uploaded.";
    } else {
        header("HTTP/1.0 500 Internal Server Error");
        echo "Sorry, there was an error uploading your file.";
    }
}
?>
