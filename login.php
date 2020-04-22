<?php
include_once 'include/db.con.php'
?>
<!DOCTYPE html>
<html lang="hu">


<head>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

    <title>Bejelentkezés</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


</head>
<body>

<?php
$username = $email = $password =$logname =$logpass = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {



/*
 * Regisztráció
 */
    if ($_POST["reg"]==0) {
        $username = test_input($_POST["username"]);
        $email = test_input($_POST["email"]);
        $password = test_input($_POST["password"]);
        $hash = hash('sha256',$password);

        $sql = "select COUNT(username) as ertek from felhasznalok where username='$username' or email='$email'";
        $felhasznalok = $conn->query($sql);

        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number    = preg_match('@[0-9]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);
        $specialChars2 = preg_match('@[^\w]@', $username);



        $sql = "INSERT INTO felhasznalok (username, jelszo, email)

VALUES ('$username', '$hash', '$email')";
        $letezo_userek=0;
        while($row = $felhasznalok->fetch_assoc()) {
            $letezo_userek= $row["ertek"];
        }
if ($letezo_userek != 0){
    echo '<script language="javascript">';
    echo ' alert("Ez a felhasználó már létezik!"); ';
    echo '</script>';        }else{

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<script language="javascript"> alert("Hibás email formátum!");</script>';
}else{
   if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
            echo '<script language="javascript"> alert("A jelszónak legalább 8 karakter hosszúnak kell lennie kis és nagy betűkkel, valamint legalább egy speciális karakterrel");</script>';
        }else{
       if (!$specialChars2 || $username >= 6){
    if ($conn->query($sql) === TRUE) {
        echo '<script language="javascript">';
        echo 'alert("Sikeres regisztráció!");';
        echo '</script>';    }
       }else{
               echo '<script language="javascript"> alert("A felhasználónévnek legalább 6 karakter hosszúnak kell lennie és nem tartalmazhat speciális karaktereket");</script>';

       } }}}

/*
 * Bejelentkezés
 */
    }else if ($_POST["reg"]==1) {
        $logname = test_input($_POST["logname"]);
        $logpass = test_input($_POST["logpass"]);
        $loghash= hash('sha256',$logpass);



        $sq2 = "SELECT id, username, tiltott FROM felhasznalok WHERE '$loghash'=jelszo AND '$logname'=username";
        $result = $conn->query($sq2);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                    $_SESSION["tiltott"] = $row["tiltott"];
                $_SESSION["user"] = $row["username"];
                $_SESSION["id"] = $row["id"];
                $ido=date("Y-m-d H:i:s");
                $sq2 = "Update  felhasznalok  set bejelentkezve='$ido' WHERE '$loghash'=jelszo AND '$logname'=username";
                $result = $conn->query($sq2);
                echo "<script>window.location.href = 'index.php';</script> ";



                }
        } else {
            echo " <p style='color:red'>Hibás adatok bejelentkezéskor!</p>";
        }


    $conn->close();

}}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}



?>


<div class="container-fluid">
    <div class="container">

        <hr>
        <div class="row">
            <div class="col-md-5">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <input type="hidden" name="reg" value="0"/>
                <fieldset>
                        <p class="text-uppercase pull-center"> Regisztráció: </p>
                        <div class="form-group">
                            <input type="text" name="username" id="username" class="form-control input-lg" placeholder="felhasználónév">
                        </div>

                        <div class="form-group">
                            <input type="email" name="email" id="email" class="form-control input-lg" placeholder="email cím">
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" id="password" class="form-control input-lg" placeholder="jelszó">
                        </div>


                        <div>
                            <input type="submit" class="btn btn-md"   value="Regisztráció">
                        </div>
                    </fieldset>
                </form>
            </div>

            <div class="col-md-2">
                <!-------null------>
            </div>

            <div class="col-md-5">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <input type="hidden" name="reg" value="1"/>

                    <fieldset>
                        <p class="text-uppercase"> Bejelentkezés: </p>

                        <div class="form-group">
                            <input type="text" name="logname" id="logname" class="form-control input-lg" placeholder="felhasználónév">
                        </div>
                        <div class="form-group">
                            <input type="password" name="logpass" id="logpass" class="form-control input-lg" placeholder="jelszó">
                        </div>
                        <div>
                            <input type="submit" class="btn btn-md" value="Bejelentkezés">
                        </div>

                    </fieldset>
                </form>
            </div>
        </div>
    </div>

</div>
</body>


</html>