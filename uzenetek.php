<?php
include_once 'include/menu.php';
if (isset($_SESSION["id"])){
$felhasznalo = $_SESSION["id"];
$sql = "SELECT x.id as uzenet_id,x.ticket_id as ticket_id,z.tema as tema ,x.user_boolean as user_boolean,x.uzenet as uzenet,x.mikor as mikor,x.olvasott as olvasott, x.visszavonhato
FROM uzenetek as x, uzenetek_ticket as y , uzenetek_temak as z
where x.ticket_id=y.id and z.ID=y.tema_id and  y.felhasznalo_id=2 order by tema,mikor desc";
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
        <div class=\"inbox_people\">
          <div class=\"headind_srch\" style='background-color: #ced1d8; border-style: solid; border-width: 1px; border-color: #818181;'>
            <div class=\"recent_heading\">
              <h4>Üzenetek</h4>
            </div>
       
          </div>
          <div class=\"inbox_chat\" style=\"background-color: #ced1d8;\">";
$kategoriak=array();
    $kategoriak[0][0]=$uzenetek[0]["tema"];
    $kategoriak[0][1]=0;
$kategoria_szamlalo=0;
    $tema=$uzenetek[0]["tema"];


for ($i=1;$i < count($uzenetek);$i++){
if ($tema != $uzenetek[$i]["tema"]){
    $tema=$uzenetek[$i]["tema"];
    $kategoria_szamlalo++;
    $kategoriak[$kategoria_szamlalo][0]=$uzenetek[$i]["tema"];
    $kategoriak[$kategoria_szamlalo][1]=$i;


}
}

for($i=0;$i < count($kategoriak);$i++){
echo" <form method='post' action='uzenetek.php'><button  type=\"submit\"  id=\"uzenet\" name=\"uzenet\"   value='";echo $kategoriak[$i][0]; echo"'> <div class=\"chat_people\">";
 if($i==0){echo " <div >";} else{ echo"<div >";} echo"
           
                <div class=\"chat_img\"> <img src=\"include/img/logo.png\" alt=\"sunil\"> </div>
                <div class=\"chat_ib\">";
                 if ($uzenetek[$kategoriak[$i][1]]["olvasott"]==0){echo"<h5 style=\"color:red;\">";}else{echo "<h5>";}
                 echo "ChefBot - ".$kategoriak[$i][0]." <span class=\"chat_date\">"; echo $uzenetek[$kategoriak[$i][1]]["mikor"] ; echo"</span></h5>";

    echo"      <p>";  echo substr($uzenetek[$kategoriak[$i][1]]["uzenet"],0,100);echo"..";  echo"</p>
                </div>
              </div>
            </div></button></form>
        
        ";}

    if(isset($_POST["open_ticket"]) || isset($_POST["uzenet_kuldes"])){
       if (isset($_POST["open_ticket"])){ $uzenet_id=$_POST["open_ticket"];}
        else{ $uzenet_id=$_POST["uzenet_kuldes"];}
        echo "   </div>
        </div><div class=\"mesgs\" style='background-color: #ced1d8  '>
          <div class=\"msg_history\">";

        $sql = "SELECT visszavonhato FROM uzenetek where id='$uzenet_id' ";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo"<div class=\"incoming_msg\"><div class=\"received_msg\"> <div class=\"received_withd_msg\">";

                if ($row["visszavonhato"]==1){
                    echo"<p>Szia! <br>
A hozzászólásodat levettük az üzenőfalról, mivel többen jelezték hogy nem helyénvaló.<br>
 Ha felvetésed van ezzel kapcsoladban, kérlek írd meg nekünk itt.</p>";

                } elseif ($row["visszavonhato"]==2){
                    echo"<p>Szia! <br>
A moderátoraink letiltották a felhasználódat. A tiltás a többszörös helytelen viselkedés okából adódhat.</br>
 Ha felvetésed van ezzel kapcsoladban, kérlek írd meg nekünk itt.</p>";

                }
                echo "</div></div></div>   ";
                if (isset($_POST["uzenet"])){
                    $uzenet=$_POST["uzenet"];
                    $uzenet = trim($uzenet);
                    $uzenet = stripslashes($uzenet);
                    $uzenet = htmlspecialchars($uzenet);

                    echo"<div class=\"outgoing_msg\"><div class=\"sent_msg\"> 
                    <p> $uzenet <br>
                    </div></div>
                    
                    <div class=\"incoming_msg\"><div class=\"received_msg\"> <div class=\"received_withd_msg\">
                    <p>Köszönjük, hogy jelezted felén. Amint feldolgozásra kerűl az a felvetésed jelezni fogjuk a döntést. </p></div></div></div>
                    
                    ";

                }


                echo "             </div>
<form method='post' action='uzenetek.php'>  <div class=\"type_msg\">
            <div class=\"input_msg_write\">
              <input type=\"text\" name=\"uzenet\" class=\"write_msg\" placeholder=\"Írd meg nekünk egy üzenetben a felvetésed\" />
              <button class=\"msg_send_btn\" name=\"uzenet_kuldes\" value='$uzenet_id' type=\"submit\"><i class=\"fa fa-paper-plane-o\" aria-hidden=\"true\"></i></button>
            </div>
          </div></form>";

            }
            }





    }
            if (isset($_POST["uzenet"])){
              $tema_post= $_POST["uzenet"];
                echo "   </div>
        </div><div class=\"table-wrapper-scroll-y my-custom-scrollbar\" style='background-color: #ced1d8  float: left;
            padding: 46px 15px 0 25px;
            width: 60%;  height: 600px'>
          <div class=\"msg_history\">";

                $sql = "SELECT x.id as uzenet_id,x.ticket_id as ticket_id,z.tema as tema ,x.user_boolean as user_boolean,x.uzenet as uzenet,x.mikor as mikor,x.olvasott as olvasott , x.visszavonhato 
FROM uzenetek as x, uzenetek_ticket as y , uzenetek_temak as z
where x.ticket_id=y.id and z.ID=y.tema_id and  y.felhasznalo_id=$felhasznalo and tema like '$tema_post' order by mikor ";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $uzenet_id=$row["uzenet_id"];
                        $sql = " UPDATE  uzenetek set olvasott=1 where id=$uzenet_id  and user_boolean=0";
                        $update = $conn->query($sql);

if ($row["user_boolean"]==0){echo"<div class=\"incoming_msg\"><div class=\"received_msg\"> <div class=\"received_withd_msg\">";}else{echo"<div class=\"outgoing_msg\"><div class=\"sent_msg\">"; }
             echo" 
                  <p>".$row["uzenet"]."</p>";
                        if ($row["visszavonhato"]!=0){echo"<form method='post' action='uzenetek.php'> <button name=\"open_ticket\" type=\"submit\" value='$uzenet_id' class=\"btn btn-light\"> vétózás <span class=\"glyphicon glyphicon-exclamation-sign\"></span></button></form>";}

echo"   <span class=\"time_date\">".$row["mikor"]."</span></div></div>";
       if ($row["user_boolean"]==0){ echo"   </div>";}


                    }
                }

            }elseif(!isset($_POST["open_ticket"])){
echo "<div align='middle'>  <img src='include/img/postman.png' >  </div></div>";
            }

          echo" 
          
          </div>
          
        
          
          
        </div>
      </div>
      
            
    </div></div>"; }
else {
    echo "<div align='middle' ><div style='max-width:500px;'>  <img src='include/img/nomail.png' > </br>
                <h1><font color='white' >hmmm... úgy néz ki még nincs értesítésed</font></h1></div></div>
    ";

}
}else{
    echo "<div align='middle' ><div style='max-width:500px;'>  <img src='include/img/lost.png' > </br>
                <h1><font color='white' >hmmm... valami nincs itt rendben</font></h1></div></div>
    ";
}