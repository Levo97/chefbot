<?php
include_once 'include/menu.php'
?>
<p style="color: white">
<?php
$nev = $_POST["nev"];
$alapanyag = $_POST["alapanyag"];
$leiras = $_POST["szoveg"];
$maxid = 0;
/*echo $nev."<br>";
echo $alapanyag."<br><ol>";
echo $leiras."</ol><br>";*/

$sql = "SELECT MAX(id) AS maxi FROM recept";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $maxid=$row["maxi"]+1;
    }
} else {
    echo "0 results";
}


$target_dir = "include/img/";
$target_file = $target_dir . $maxid.".jpg";
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" ) {
    echo "Sorry, only JPG file is allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        //Ha sikerült a kép jöhetnek az adatok
        $uid=$_SESSION['id'];
        $sql = "INSERT INTO recept (szerzo_id, neve, leiras)VALUES ($uid,'$nev','$leiras')";
        echo $sql;
        if ($conn->multi_query($sql) === TRUE) {
            echo "New records created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        $conn->close();
        echo "<script>window.location.href = 'index.php';</script> ";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>
</p>
