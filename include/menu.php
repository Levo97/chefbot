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

    <nav class="navbar navbar-inverse">
        <span style="font-size:30px;cursor:pointer; color:#eaeded " onclick="openNav()">&#9776;</span>

        <div class="container-fluid" style="float: right;">
            <div class="navbar-header" style>
                <a class="navbar-brand" href="#">SéfBot
                    <a href="index.php"><img src='include/img/logo.png' height="42" width="42" ></a></a>
            </div>
        </div>
    </nav>
    <style>
        body {
            font-family: "Lato", sans-serif;
            background-color: rgba(4, 4, 9, 0.87);

        }


        .sidenav {
            height: 100%;
            width: 0;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            background-color: #111;
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 60px;
        }

        .sidenav a {
            padding: 8px 8px 8px 32px;
            text-decoration: none;
            color: #818181;
            display: block;
            transition: 0.3s;
        }

        .sidenav a:hover {
            color: #040409;
        }

        .sidenav .closebtn {
            position: absolute;
            top: 0;
            right: 25px;
            font-size: 36px;
            margin-left: 50px;
        }

        #main {
            transition: margin-left .5s;
            padding: 16px;
        }

        @media screen and (max-height: 450px) {
            .sidenav {padding-top: 15px;}
            .sidenav a {font-size: 18px;}
        }

        .mssgBox {
            margin-right: 10%;
            margin-left: 10%;
            margin-bottom: 2%;
            background-color: rgba(41, 36, 45, 0.54);
            border-radius: 15px 15px 15px 15px;
            padding: 0.1% 2% 0.1% 2%;
            color: white;
        }

        .kozep {
            margin-left: auto;
            margin-right: auto;
            width: 30%;
            text-align: center;
        }

        .doboz {
            background-color: #eaeded;
            border-radius: 5px 5px 5px 5px;
            margin-bottom: 2%;
            padding: 0.1% 2% 0.1% 2%;


        }

        .doboz a {
            text-decoration: none;
        }

        .doboz img {
            width: 99%;
            padding-top: 0.1%;
            padding-bottom: 0.1%;
        }

        .box {
            border-radius: 5px 5px 5px 5px;
            margin-bottom: 2%;
            margin-left: 15%;
            margin-right: 2%;
            padding: 0.1% 2% 0.1% 2%;

        }

        .box a {
            text-decoration: none;
        }

        .box img {
            width: 99%;
            padding-top: 0.1%;
            padding-bottom: 0.1%;
        }

        .error {
            display: none;
            font: italic medium sans-serif;
            color: red;
        }

        input[pattern]:required:invalid ~ .error {
            display: block;
        }

        .my-custom-scrollbar {
            position: relative;
            height: 200px;
            overflow: auto;
        }

        .table-wrapper-scroll-y {
            display: block;
        }

        #alapanyag, #mennyi, #mertekegyseg {
            margin-right: 10px;
            margin-bottom: 5px;
            width: 200px;
            display: inline;
        }

        img {
            max-width: 100%;
            height: auto;
            width: auto \9;
        }.container{max-width:1170px; margin:auto;}
        img{ max-width:100%;}
        .inbox_people {
            background: #f8f8f8 none repeat scroll 0 0;
            float: left;
            overflow: hidden;
            width: 40%; border-right:1px solid #c4c4c4;
        }
        .inbox_msg {
            border: 1px solid #c4c4c4;
            clear: both;
            overflow: hidden;
        }
        .top_spac{ margin: 20px 0 0;}

        .recent_heading h4 {
            color: #05728f;
            font-size: 21px;
            margin: auto;
        }


        .chat_ib h5{ font-size:15px; color:#464646; margin:0 0 8px 0;}
        .chat_ib h5 span{ font-size:13px; float:right;}
        .chat_ib p{ font-size:14px; color:#989898; margin:auto}
        .chat_img {
            float: left;
            width: 11%;
        }
        .chat_ib {
            float: left;
            padding: 0 0 0 15px;
            width: 88%;
        }

        .chat_people{ overflow:hidden; clear:both;}
        .chat_list {
            border-bottom: 1px solid #c4c4c4;
            margin: 0;
            padding: 18px 16px 10px;
        }

        .active_chat{ background:#ebebeb;}

        .incoming_msg_img {
            display: inline-block;
            width: 6%;
        }
        .received_msg {
            display: inline-block;
            padding: 0 0 0 10px;
            vertical-align: top;
            width: 92%;
        }
        .received_withd_msg p {
            background: #ebebeb none repeat scroll 0 0;
            border-radius: 3px;
            color: #646464;
            font-size: 14px;
            margin: 0;
            padding: 5px 10px 5px 12px;
            width: 100%;
        }
        .time_date {
            color: #747474;
            display: block;
            font-size: 12px;
            margin: 8px 0 0;
        }
        .received_withd_msg { width: 57%;}
        .mesgs {
            float: left;
            padding: 30px 15px 0 25px;
            width: 60%;
        }

        .sent_msg p {
            background: #05728f none repeat scroll 0 0;
            border-radius: 3px;
            font-size: 14px;
            margin: 0; color:#fff;
            padding: 5px 10px 5px 12px;
            width:100%;
        }
        .outgoing_msg{ overflow:hidden; margin:26px 0 26px;}
        .sent_msg {
            float: right;
            width: 46%;
        }
        .input_msg_write input {
            background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
            border: medium none;
            color: #4c4c4c;
            font-size: 15px;
            min-height: 48px;
            width: 100%;
        }

        .type_msg {border-top: 1px solid #c4c4c4;position: relative;}
        .msg_send_btn {
            background: #05728f none repeat scroll 0 0;
            border: medium none;
            border-radius: 50%;
            color: #fff;
            cursor: pointer;
            font-size: 17px;
            height: 33px;
            position: absolute;
            right: 0;
            top: 11px;
            width: 33px;
        }
        .messaging { padding: 0 0 50px 0;
            background-color: #eaeded;


        }
        .msg_history {
            height: 516px;
            overflow-y: auto;
        }

    </style>
</head>
<body>
<script>
    function openNav() {
        document.getElementById("mySidenav").style.width = "250px";
        document.getElementById("main").style.marginLeft = "250px";
    }

    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
        document.getElementById("main").style.marginLeft= "0";
    }
</script>
<script>


    if (out == 1) {
        alert("Sikeres kijelentkezés!");
    }
</script>

<div id="mySidenav" class="sidenav">

    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

    <ul class="nav nav-pills nav-stacked">
        <li class="active"><a href="index.php">Főoldal</a></li>
        <li><?php if (isset($_SESSION["user"])) {

                echo "<font color='aliceblue' >Helló, " . $_SESSION['user'] . "! </font>";
                echo "<a href='profile.php''>Profil</a>";
            } ?></li>
        <li><?php if (isset($_SESSION["user"])) {
                echo "<a href='ujrecept.php'>Új Recept</a>";
            } ?></li>
        <li><?php if (isset($_SESSION["user"])) {
                echo "<a href='sajat.php'>Recepteim</a>";
            } ?></li>
        <li><?php if (isset($_SESSION["user"])) {

                $felhasznalo = $_SESSION["id"];
                $sql = "SELECT count(*) as db FROM uzenetek_ticket where felhasznalo_id= $felhasznalo and closed!=1";
                $result = $conn->query($sql);
                $ertesites = array();

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {

                        $ertesites = array_merge($ertesites, array('db' => $row["db"]));

                    }
                } else {
                    $ertesites["db"] = 0;
                }

                echo "<a href='uzenetek.php'>Üzenetek <span class='badge badge-primary badge-pill\'>" . $ertesites["db"] . " </span></a>";
            } ?></li>

        <li><?php if (isset($_SESSION["user"])) {

                $sql = "SELECT * FROM jogok WHERE felhasznalok_id=" . $_SESSION["id"] . " ";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    echo "<a href='kezeles.php'>Kezelés</a>";

                }

            } ?></li>


        <li><a href='tagcloud.php'>Katalógus</a></li>
        <li><a href='points.php'>Ranglista</a></li>
        <li> <?php if (!isset($_SESSION["user"])) {
                echo "<a href='login.php'>Bejelentkezés</a>";
            } else {
                echo "<a href='logout.php'>Kijelentkezés</a>";
            } ?> </li>
    </ul>
    <br>
    <form method="post" action="kereses.php">
        <div class="input-group">
            <input type="text" name="keres" pattern=".{3,}" id="keres" class="form-control" placeholder="Keresés..">
            <span class="input-group-btn">

        </span>

        </div>
    </form>
    <a href="reszletes.php">részeketes keresés</a>

</div>
<div id="main">
