<?php
include_once 'include/menu.php';


$stmt = $conn->prepare('SELECT felhasznalok.id,felhasznalok.username, sum(pont)as pontok FROM felhasznalok,pontozas,recept where recept.szerzo_id=felhasznalok.id and recept.id=pontozas.mit GROUP by felhasznalok.id order by pontok DESC limit 10 ');
$stmt->execute();
$result = $stmt->get_result();
$toplista=array();


echo "<h3 style=\"color: white\">A top 10 felhasználó:</h3>";
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {

        array_push($toplista, array('id'  =>$row["id"], 'username' =>$row["username"], 'pont' =>$row["pontok"]));
    }

}

echo "
<div class='doboz '>



<table class=\"table table - striped\">
  <tr>
    <th>Helyezés </th>
    <th>Felhasználó </th>
    <th>Pont </th>

  </tr>";
$helyezes=1;
foreach ($toplista as $toplistas){

echo"
 <tr>
     <td>" . $helyezes. ".</td>
    <td><a href='profile.php?id=".$toplistas["id"]."'>" . $toplistas['username'] ."</a></td>
    <td>" . $toplistas['pont'] . "</td>


  </tr> 
        
    ";
$helyezes++;
}

    echo"
</table>
 </div>
    ";