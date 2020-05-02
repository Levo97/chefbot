<?php

$dbServername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "szakdolgozat";

$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName) or die("Nem sikerült csatlakozni az adatbázishoz");
$conn->set_charset("utf8");
$conn->query("SET lc_time_names = 'hu_HU'");
session_start();
