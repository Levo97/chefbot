<?php
include_once 'include/db.con.php'
?>

<!DOCTYPE html>
<html lang="hun">
<head>
    <title>ShéfBot</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <style>
        .row.content {height: 100vh;}
        .sidenav {
            background-color: #f1f1f1;
            height: 100%;
        }
        footer {
            background-color: #555;
            color: white;
            padding: 15px;
        }
        @media screen and (max-width: 767px) {
            .sidenav {
                height: auto;
                padding: 15px;
            }
            .row.content {height: auto;}
        }
        .doboz{
            background-color: aliceblue;
            border-radius: 5px 5px 5px 5px;
            margin-bottom: 2%;
            margin-left: 2%;
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
        }
        .menu{
            background-color: #6F8AA1;
        }
        .menu a{
            color:white;
        }
        .menu a:hover{
            color:darkblue;
        }
        body{
            background-color: #04213A;
        }
        .mssgBox{
            margin-right: 10%;
            margin-left: 10%;
            margin-bottom: 2%;
            background-color: #829eb5;
            border-radius: 15px 15px 15px 15px;
            padding: 0.1% 2% 0.1% 2%;
            color: white;
        }
        .kozep{
            margin-left: auto;
            margin-right: auto;
            width: 30%;
            text-align: center;
        }
    </style>
</head>
<body>

<script>

    const urlParams = new URLSearchParams(window.location.search);
    const out = urlParams.get('out');

    if (out==1){
        alert("Sikeres kijelentkezés!");
    }
</script>

<div class="container-fluid">
    <div class="row content">
        <div class="col-sm-3 sidenav menu">
            <h2 style="color:white">SéfBot</h2>

            <ul class="nav nav-pills nav-stacked">
                <li class="active"><a href="index.php">Főoldal</a></li>
                <li><?php if(isset($_SESSION["user"])){
                        echo "Helló, ".$_SESSION['user']."!";
                        echo "<a href='profile.php''>Profil</a>";
                    } ?></li>
                <li><?php if(isset($_SESSION["user"])){
                    echo "<a href='ujrecept.php'>Új Recept</a>";
                    } ?></li>
                <li> <?php if(!isset($_SESSION["user"])){
                        echo "<a href='login.php'>Bejelentkezés</a>";
                    }else{
                        echo "<a href='logout.php'>Kijelentkezés</a>";
                    } ?> </li>
            </ul><br>
            <form method="post" action="kereses.php">
            <div class="input-group">
                <input type="text" name="keres" id="keres" class="form-control" placeholder="Keresés..">
                <span class="input-group-btn">
          <button class="btn btn-default" type="submit">
            <span class="glyphicon glyphicon-search"></span>
          </button>
        </span>

            </div></form>
            <a href="#">részeketes keresés</a>

        </div>
        <div class="col-sm-9 tartalom">