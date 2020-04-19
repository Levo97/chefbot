<?php
include_once 'include/db.con.php';

$id=$_POST['id'];
$pont=$_POST['pont'];
$uid=$_SESSION["id"];


$sql1 = "SELECT * FROM pontozas where ki='$uid' AND mit='$id'";
$sql2 = "UPDATE pontozas SET pont=".$pont." WHERE ki=".$uid." AND mit=".$id." ";
$sql3 = "INSERT into pontozas values('$uid','$id','$pont')";

$result = $conn->query($sql1);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($pont!=$row["pont"]){
        echo $pont;
        $conn->query($sql2);
    };

} else {
    $conn->query($sql3);
}

echo "<script>window.location.href = 'recept.php?id=".$id."';</script>";
?>
