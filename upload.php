<?php
include_once 'include/menu.php'
?>
<p style="color: white">
    <?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["nev"])) {
            echo "<script>window.location.href = 'ujrecept.php';</script> ";
        } else {
            $nev = test_input($_POST["nev"]);
        }



        if (empty($_POST["egyeb"])) {
            echo "<script>window.location.href = 'ujrecept.php';</script> ";
        } else {
            $egyeb = test_input($_POST["egyeb"]);
        }



        if (empty($_POST["azonosito"])) {
            echo "<script>window.location.href = 'ujrecept.php';</script> ";
        } else {
            $azonosito = test_input($_POST["azonosito"]);
        }
    }

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $kategoriak = ($_POST["kategoriak"]);

    $leiras=$_POST["szoveg"];
    $maxid = 0;
    $kategoriak=array();

    $hozzavalok=array();





    for ($x=1; $x<=($azonosito); $x+=3){

        $mennyiseg=$_POST[$x+1];
        $mertek=$_POST[$x+2];


        if ($mertek=="dkg" || $mertek=="cl" ){
            $mennyiseg=$mennyiseg*10;

        }elseif ($mertek=="dl"){
            $mennyiseg=$mennyiseg*100;

        }
        elseif ($mertek=="kg" || $mertek=="l"){
            $mennyiseg=$mennyiseg*1000;

        }


        array_push($hozzavalok, array('hozzavalo_id'  =>$_POST[$x], 'mennyiseg' =>$mennyiseg));

    }


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
    // Mivel a szerkesztésnél kell ez a funkció
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
            //Ha sikerült a kép jöhetnek az adatok
            $uid=$_SESSION['id'];
            if (strlen($egyeb)<2){
                $sql = "INSERT INTO recept (szerzo_id, neve, leiras,missing_data)VALUES ($uid,'$nev','$leiras',null )";

            }else{  $sql = "INSERT INTO recept (szerzo_id, neve, leiras,missing_data)VALUES ($uid,'$nev','$leiras','$egyeb')";}

            if ($conn->multi_query($sql) === TRUE) {
                $recept=0;

                $stmt = $conn->prepare("select id as id  from recept where szerzo_id=? and neve like ? and  leiras like ? ");
                $stmt->bind_param("sss", $uid , $nev, $leiras);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $recept=$row['id'];
                    }

                    $sql = "select id from uzenetek_ticket where felhasznalo_id=$uid and tema_id=0";
                    $x = $conn->query($sql);
                    if ($x->num_rows > 0) {
                        while($sor = $x->fetch_assoc()) {
                            $ido=date("Y-m-d H:i:s");
                            $sql = "insert into unenetek (ticket_id,uzenet,mikor) values (".$sor['id']." ,'Sikeresen rögzítetted a ".$nev." receptet. Amint a séf jóváhagyja megy a menüre.', $ido)";
                            $x = $conn->query($sql);

                        }}else{
                        $sql = "insert into uzenetek_ticket (felhasznalo_id) values ($uid)";
                        $x = $conn->query($sql);
                    }

                foreach ($hozzavalok as $hozzavalo){
                    $sql = "INSERT INTO hozzavalok  (recept_id, alapanyag_id, mennyiseg)VALUES (".$recept.",".$hozzavalo['hozzavalo_id'].",".$hozzavalo['mennyiseg'].")";
                    $result = $conn->query($sql);

                }
                for ($i=0; $i < (count($kategoriak)); $i++ ){
                    $sql = "INSERT INTO kategoriak  (kategoria_id, recept_id)VALUES (".$kategoriak[$i].",".$recept." )";
                    $result = $conn->query($sql);
                }}

            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            $conn->close();
          //   echo "<script>window.location.href = 'index.php';</script> ";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
    ?>
</p>
