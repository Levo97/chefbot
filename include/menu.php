<?php
include_once 'include/db.con.php'
?>

<!DOCTYPE html>
<html lang="hun">
<head>
    <title>ShéfBot</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <style>
        body {
            font-family: "Lato", sans-serif;
            background-color: rgba(4, 4, 9, 0.87);
            margin-left: 350px;


        }

        .sidenav {

            height: 100%;
            width: 350px;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            background-color: #111;
            overflow-x: hidden;
            padding-top: 20px;
        }

        .sidenav a {
            padding: 6px 8px 6px 16px;
            font-size: 17px;
            color: #818181;
            display: block;
        }

        .sidenav a:hover {
            color:darkblue;
        }

        .main {
            margin-left: 160px; /* Same as the width of the sidenav */
            font-size: 28px; /* Increased text to enable scrolling */
            padding: 0px 10px;
        }

        @media screen and (max-height: 450px) {
            .sidenav {padding-top: 15px;}
            .sidenav a {font-size: 18px;}
        }.mssgBox{
             margin-right: 10%;
             margin-left: 10%;
             margin-bottom: 2%;
             background-color: rgba(41, 36, 45, 0.54);
             border-radius: 15px 15px 15px 15px;
             padding: 0.1% 2% 0.1% 2%;
             color: white;
         }
        .kozep{
            margin-left: auto;
            margin-right: auto;
            width: 30%;
            text-align: center;
        }.doboz{
             background-color: aliceblue;
             border-radius: 5px 5px 5px 5px;
             margin-bottom: 2%;
             margin-right: 2%;
             padding: 0.1% 2% 0.1% 2%;

         }
        .doboz a{
            text-decoration: none;
        }
        .doboz img{
            width: 99%;
            padding-top:0.1%;
            padding-bottom: 0.1%;
        }.box{
             border-radius: 5px 5px 5px 5px;
             margin-bottom: 2%;
             margin-left: 15%;
             margin-right: 2%;
             padding: 0.1% 2% 0.1% 2%;

         }
        .box a{
            text-decoration: none;
        }
        .box img{
            width: 99%;
            padding-top:0.1%;
            padding-bottom: 0.1%;
        }.error {
             display: none;
             font: italic medium sans-serif;
             color: red;
         }
        input[pattern]:required:invalid ~ .error {
            display: block;
        }.my-custom-scrollbar {
             position: relative;
             height: 200px;
             overflow: auto;
         }
        .table-wrapper-scroll-y {
            display: block;
        }
        #alapanyag, #mennyi, #mertekegyseg{
            margin-right: 10px;
            margin-bottom: 5px;
            width: 200px;
            display: inline;
        }

    </style>
</head>
<body>

<script>


   if (out==1){
        alert("Sikeres kijelentkezés!");
    }
</script>
<div class="sidenav " >

            <h2 style="color:white">SéfBot</h2>

            <ul class="nav nav-pills nav-stacked">
                <li class="active"><a href="index.php">Főoldal</a></li>
                <li><?php if(isset($_SESSION["user"])){

                        echo "<font color='aliceblue' >Helló, ".$_SESSION['user']."! </font>";
                        echo "<a href='profile.php''>Profil</a>";
                    } ?></li>
                <li><?php if(isset($_SESSION["user"])){
                    echo "<a href='ujrecept.php'>Új Recept</a>";
                    } ?></li>
                <li><?php if(isset($_SESSION["user"])){
                        echo "<a href='sajat.php'>Recepteim</a>";
                    } ?></li>

                <li><?php if(isset($_SESSION["user"])){

                        $sql = "SELECT * FROM jogok WHERE felhasznalok_id=" . $_SESSION["id"] . " ";
                        $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        echo "<a href='kezeles.php'>Kezelés</a>";

                    }

                    } ?></li>


                <li><a href='tagcloud.php'>Katalógus</a></li>
                <li><a href='points.php'>Ranglista</a></li>
                <li> <?php if(!isset($_SESSION["user"])){
                        echo "<a href='login.php'>Bejelentkezés</a>";
                    }else{
                        echo "<a href='logout.php'>Kijelentkezés</a>";
                    } ?> </li>
            </ul><br>
            <form method="post" action="kereses.php">
            <div class="input-group">
                <input type="text" name="keres"  pattern=".{3,}" id="keres" class="form-control" placeholder="Keresés..">
                <span class="input-group-btn">

        </span>

            </div></form>
            <a href="reszletes.php">részeketes keresés</a>

        </div>
