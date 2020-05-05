<?php
include_once 'include/menu.php';

if (isset($_SESSION["id"])) {
    $felhasznalo = $_SESSION["id"];
    $sql = "SELECT x.id as uzenet_id,x.ticket_id as ticket_id,z.tema as tema ,x.user_boolean as user_boolean,x.uzenet as uzenet,x.mikor as mikor,x.olvasott as olvasott, x.visszavonhato
FROM uzenetek as x, uzenetek_ticket as y , uzenetek_temak as z
where x.ticket_id=y.id and z.ID=y.tema_id and  y.felhasznalo_id=$felhasznalo  and y.closed=0 order by tema,mikor desc";
    $result = $conn->query($sql);
    $uzenetek = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            array_push($uzenetek, array('uzenet_id' => $row["uzenet_id"], 'ticket_id' => $row["ticket_id"], 'user_boolean' => $row["user_boolean"], 'uzenet' => $row["uzenet"], 'mikor' => $row["mikor"], 'olvasott' => $row["olvasott"], 'tema' => $row["tema"]));
        }


        echo "
<style>
body {
background-color: #60929c;
}
</style>
<body>
<div class=\"container\">
<div class=\"messaging\">
      <div class=\"inbox_msg\" style='border-style: solid; border-width: 7px; border-color: #818181; background-color: #ced1d8'>
        <div class=\"inbox_people col-sm-4\">
          <div class=\"headind_srch\" style='background-color: #ced1d8; border-style: solid; border-width: 1px; border-color: #818181;'>
            <div class=\"recent_heading\">
              <h4>Üzenetek</h4>
            </div>
       
          </div>
          <div class=\"inbox_chat \" style=\"background-color: #ced1d8;\">";
        $kategoriak = array();
        $kategoriak[0][0] = $uzenetek[0]["tema"];
        $kategoriak[0][1] = 0;
        $kategoria_szamlalo = 0;
        $tema = $uzenetek[0]["tema"];


        for ($i = 1; $i < count($uzenetek); $i++) {
            if ($tema != $uzenetek[$i]["tema"]) {
                $tema = $uzenetek[$i]["tema"];
                $kategoria_szamlalo++;
                $kategoriak[$kategoria_szamlalo][0] = $uzenetek[$i]["tema"];
                $kategoriak[$kategoria_szamlalo][1] = $i;


            }
        }

        for ($i = 0; $i < count($kategoriak); $i++) {
            echo " <form method='post' action='uzenetek.php'><button  type=\"submit\"  id=\"uzenet\" name=\"uzenet\"   value='";
            echo $kategoriak[$i][0];
            echo "'> <div class=\"chat_people\">";
            if ($i == 0) {
                echo " <div >";
            } else {
                echo "<div >";
            }
            echo "
           
                <div class=\"chat_img\"> <img src=\"include/img/logo.png\" alt=\"sunil\"> </div>
                <div class=\"chat_ib\">";
            if ($uzenetek[$kategoriak[$i][1]]["olvasott"] == 0) {
                echo "<h5 style=\"color:red;\">";
            } else {
                echo "<h5>";
            }
            echo "ChefBot - " . $kategoriak[$i][0] . " <span class=\"chat_date\">";
            echo $uzenetek[$kategoriak[$i][1]]["mikor"];
            echo "</span></h5>";

            echo "      <p>";
            echo substr($uzenetek[$kategoriak[$i][1]]["uzenet"], 0, 100);
            echo "..";
            echo "</p>
                </div>
              </div>
            </div></button></form>
        
        ";
        }

        if (isset($_POST["open_ticket"]) || isset($_POST["uzenet_kuldes"])) {

            if (isset($_POST["open_ticket"])) {
                $uzenet_id = $_POST["open_ticket"];
                $tiltott_komment = $_POST["open_ticket_0"];

            } else {
                $uzenet_id = $_POST["uzenet_kuldes"];
                $tiltott_komment = $_POST["open_ticket_1"];

            }


            echo "   </div>
        </div><div class=\"mesgs\" style='background-color: #ced1d8  '>
          <div class=\"msg_history\">";

            $sql = "SELECT visszavonhato FROM uzenetek where id='$uzenet_id' ";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class=\"incoming_msg\"><div class=\"received_msg\"> <div class=\"received_withd_msg\">";

                    if ($row["visszavonhato"] == 1) {
                        $szoveg = "Szia!
A hozzászólásodat levettük az üzenőfalról, mivel többen jelezték hogy nem helyénvaló.
 Ha felvetésed van ezzel kapcsoladban, kérlek írd meg nekünk itt.";

                    } elseif ($row["visszavonhato"] == 2) {
                        $szoveg = "Szia!
A moderátoraink letiltották a felhasználódat. A tiltás a többszörös helytelen viselkedés okából adódhat.
 Ha felvetésed van ezzel kapcsoladban, kérlek írd meg nekünk itt.";

                    }
                    echo "<p>" . $szoveg . " </p>";
                    echo "</div></div></div>   ";
                    if (isset($_POST["uzenet"])) {
                        $tema_id = $row["visszavonhato"];
                        $user = $_SESSION["id"];
                        $sq4 = "SELECT id FROM uzenetek_ticket where felhasznalo_id=$user and tema_id=$tema_id and closed=0";
                        $z = $conn->query($sq4);
                        if ($z->num_rows > 0) {
                            while ($row4 = $z->fetch_assoc()) {

                                echo '<script language="javascript">';
                                echo 'alert("Már van egy elbírálási folyamatod indítva ebben a témába. Kérlek várd meg amíg döntés születik.")';
                                echo '</script>';
                            }
                        } else {


                            $uzenet_visszanyitas = $_POST["uzenet_kuldes"];
                            $sql = " UPDATE  uzenetek set visszavonhato=0 where id=$uzenet_visszanyitas ";
                            $update = $conn->query($sql);

                            $uzenet = $_POST["uzenet"];

                            $uzenet = trim($uzenet);
                            $uzenet = stripslashes($uzenet);
                            $uzenet = htmlspecialchars($uzenet);

                            $valasz = "Köszönjük, hogy jelezted felénk. Amint feldolgozásra kerűl az a felvetésed jelezni fogjuk a döntést.";

                            echo "<div class=\"outgoing_msg\"><div class=\"sent_msg\"> 
                    <p> $uzenet <br>
                    </div></div>
                    
                    <div class=\"incoming_msg\"><div class=\"received_msg\"> <div class=\"received_withd_msg\">
                    <p>" . $valasz . " </p></div></div></div>
                    
                    ";


                            $sq3 = "INSERT INTO uzenetek_ticket (felhasznalo_id,tema_id) VALUES ($user,$tema_id )";
                            $z = $conn->query($sq3);
                            $sq4 = "SELECT id FROM uzenetek_ticket where felhasznalo_id=$user and tema_id=$tema_id and closed=0";
                            $z = $conn->query($sq4);
                            if ($z->num_rows > 0) {
                                while ($row4 = $z->fetch_assoc()) {
                                    $ticket_id = $row4["id"];
                                    $ido = date("Y-m-d H:i:s");
                                    $sq3 = "INSERT INTO uzenetek (ticket_id,user_boolean,uzenet,mikor,olvasott) VALUES ($ticket_id,0,'$szoveg','$ido',1)";
                                    $y = $conn->query($sq3);
                                    if ($tiltott_komment > 0) {
                                        $sq3 = "INSERT INTO uzenetek (ticket_id,user_boolean,uzenet,mikor,olvasott,comment) VALUES ($ticket_id,1,'$uzenet','$ido',1,$tiltott_komment)";
                                        $y = $conn->query($sq3);
                                    } else {

                                        $sq3 = "INSERT INTO uzenetek (ticket_id,user_boolean,uzenet,mikor,olvasott) VALUES ($ticket_id,1,'$uzenet','$ido',1)";
                                        $y = $conn->query($sq3);
                                    }

                                    $sq3 = "INSERT INTO uzenetek (ticket_id,user_boolean,uzenet,mikor,olvasott) VALUES ($ticket_id,0,'$valasz','$ido',1)";
                                    $y = $conn->query($sq3);


                                }
                            }
                        }
                    }


                    echo "    </div>";
                    if (!(isset($_POST["uzenet"]))) {
                        echo "          
<form method='post' action='uzenetek.php'>  <div class=\"type_msg\">
            <div class=\"input_msg_write\">
              <input type=\"text\" name=\"uzenet\" class=\"write_msg\"  minlength=\"20\" placeholder=\"Írd meg nekünk egy üzenetben a felvetésed\" />
              <button class=\"msg_send_btn\" name=\"uzenet_kuldes\" value='$uzenet_id' type=\"submit\"><i class=\"fa fa-paper-plane-o\" aria-hidden=\"true\"></i></button>
            </div><input type='hidden' name='open_ticket_1' id='open_ticket_1' value='" . $tiltott_komment . "'>
          </div></form>";
                    }

                }
            }


        }
        if (isset($_POST["uzenet"])) {
            $tema_post = $_POST["uzenet"];
            echo "   </div>
        </div><div class=\"table-wrapper-scroll-y my-custom-scrollbar\" style='background-color: #ced1d8  float: left;
            padding: 46px 15px 0 25px;
            height: 600px'>
          <div class=\"msg_history\">";

            $sql = "SELECT x.id as uzenet_id,x.ticket_id as ticket_id,z.tema as tema ,x.user_boolean as user_boolean,x.uzenet as uzenet,x.mikor as mikor,x.olvasott as olvasott , x.visszavonhato 
, x.comment as comment FROM uzenetek as x, uzenetek_ticket as y , uzenetek_temak as z
where x.ticket_id=y.id and z.ID=y.tema_id and  y.felhasznalo_id=$felhasznalo and y.closed=0 and tema  like '$tema_post' order by x.id  ";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $uzenet_id = $row["uzenet_id"];
                    $sql = " UPDATE  uzenetek set olvasott=1 where id=$uzenet_id  and user_boolean=0";
                    $update = $conn->query($sql);

                    if ($row["user_boolean"] == 0) {
                        echo "<div class=\"incoming_msg\"><div class=\"received_msg\"> <div class=\"received_withd_msg\">";
                    } else {
                        echo "<div class=\"outgoing_msg\"><div class=\"sent_msg\">";
                    }
                    echo " 
                  <p>" . $row["uzenet"] . "</p>";
                    if ($row["visszavonhato"] != 0) {
                        echo "<form method='post' action='uzenetek.php'> <button name=\"open_ticket\" type=\"submit\" value='$uzenet_id' class=\"btn btn-light\"> vétózás <span class=\"glyphicon glyphicon-exclamation-sign\"></span>
</button> <input type='hidden' name='open_ticket_0' id='open_ticket_0' value='" . $row["comment"] . "'> </form>";
                    }

                    echo "   <span class=\"time_date\">" . $row["mikor"] . "</span></div></div>";
                    if ($row["user_boolean"] == 0) {
                        echo "   </div>";
                    }


                }
            }

        } elseif (!isset($_POST["open_ticket"])) {
            echo "</div></div><div align='middle' class='col-sm-8' >  <img  src='include/img/postman.png' style='height: auto; max-width: 100%;' >  </div></div>";
        }

        echo " 
          
          </div>
          
        
          
          
        </div>
      </div>
      
            
    </div></div>";
    } else {
        echo "<div align='middle' ><div style='max-width:500px;'>  <img src='include/img/nomail.png' > </br>
                <h1><font color='white' >hmmm... úgy néz ki még nincs értesítésed</font></h1></div></div>
    ";

    }
} else {
    echo "<div align='middle' ><div style='max-width:500px;'>  <img src='include/img/lost.png' > </br>
                <h1><font color='white' >hmmm... valami nincs itt rendben</font></h1></div></div>
    ";
    $conn->close();
}