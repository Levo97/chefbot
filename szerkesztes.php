<?php include_once 'include/menu.php';

if (isset($_POST["recept_az"]) && isset($_SESSION['id'])){

    $uid=$_SESSION['id'];

    $stmt = $conn->prepare('SELECT * FROM jogok where felhasznalok_id= ?');
    $stmt->bind_param('s', $uid);
    $stmt->execute();
    $result = $stmt->get_result();
    $jogom=array();

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {

            $jogom= array_merge($jogom, array('recept' =>$row["recept_moderate"]));
        }

    }

    $recept_id=$_POST["recept_az"];
    $sql="SELECT neve,leiras, szerzo_id FROM recept where id= $recept_id";
    $result = $conn->query($sql);
    $recept=array();


    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {

            $recept= array_merge($recept, array('id'  =>$recept_id, 'neve' =>$row["neve"], 'szerzo_id' =>$row["szerzo_id"],'leiras' =>$row["leiras"]));

        }
    }

    $sql="SELECT * FROM kategoria";
    $result = $conn->query($sql);
    $kategoriak=array();

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {

            array_push($kategoriak, array('id'  =>$row["id"], 'neve' =>$row["neve"]));
        }}



    $sql="SELECT kategoria_id as id , kategoria.neve as neve FROM kategoriak,kategoria where kategoria.id=kategoriak.kategoria_id and recept_id=$recept_id";
    $result = $conn->query($sql);
    $recept_kategoriak=array();

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {

            array_push($kategoriak, array('id'  =>$row["id"], 'neve' =>$row["neve"]));
        }}


    $sql="SELECT * FROM alapanyagok";
    $result = $conn->query($sql);
    $kategoriak=array();

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {

            array_push($kategoriak, array('id'  =>$row["id"], 'neve' =>$row["neve"]));
        }}



    $sql="SELECT hozzavalok.alapanyag_id as id , alapanyagok.neve as neve , mennyiseg FROM hozzavalok,alapanyagok where hozzavalok.alapanyag_id=alapanyagok.id and recept_id=$recept_id";
    $result = $conn->query($sql);
    $recept_kategoriak=array();

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {

            array_push($kategoriak, array('id'  =>$row["id"], 'neve' =>$row["neve"], 'mennyiseg' =>$row["mennyiseg"]));
        }}

if (($recept["szerzo_id"]!=$uid) && $jogom["recept"]!=1 ){
    echo"<div align='middle'>  <img src='include/img/lost.png' > </br>
                <h1><font color='white'>hmmm... valami nincs itt rendben</font></h1></div>
    ";
}



}else{
    echo"<div align='middle'>  <img src='include/img/lost.png' > </br>
                <h1><font color='white'>hmmm... valami nincs itt rendben</font></h1></div>
    ";
}