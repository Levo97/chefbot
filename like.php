<?php
include_once 'include/db.con.php';

$id=$_POST['id'];
$fel=$_POST['fel'];
$uid=$_SESSION["id"];


$sql1 = "SELECT * FROM pontozas where ki='$uid' AND mit='$id'";
$sql2 = "UPDATE pontozas SET fel=".$fel." WHERE ki=".$uid." AND mit=".$id." ";
$sql3 = "INSERT into pontozas values('$uid','$id','$fel')";

$result = $conn->query($sql1);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
            if ($fel!=$row["fel"]){
                 $conn->query($sql2);
            };

} else {
    $conn->query($sql3);
}

$conn->close();
echo "<script>window.location.href = 'recept.php?id=".$id."';</script>";
?>
