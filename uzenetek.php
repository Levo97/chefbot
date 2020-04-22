<?php
include_once 'include/menu.php';
$felhasznalo = $_SESSION["id"];
$sql = "SELECT uzenetek_ticket.id as ticket_id, uzenetek.id as uzenet_id, uzenetek_temak.tema, uzenetek.uzenet as uzenet FROM uzenetek_ticket,uzenetek_temak, uzenetek where uzenetek_ticket.tema_id=uzenetek_temak.ID and uzenetek.ticket_id=uzenetek_ticket.id and closed=0 and felhasznalo_id=$felhasznalo GROUP BY ticket_id,uzenet_id ";
$result = $conn->query($sql);
$beszelgetesek = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

        array_push($beszelgetesek, array('id' => $row["id"], 'tema' => $row["tema"]));
    }
}


echo "
<style>
body {
background-color: #eaeded;
}
</style>

<div >
<div >
<div class=\"messaging\">
      <div class=\"inbox_msg\">
        <div class=\"inbox_people\">
           <div >
            <div class=\"chat_list active_chat\">
              <div class=\"chat_people\">
                <div class=\"chat_img\"> <img src=\"https://ptetutorials.com/images/user-profile.png\" alt=\"sunil\"> </div>
                <div class=\"chat_ib\">
                  <h5>ChefBot - értesítések <span class=\"chat_date\">Dec 25</span></h5>
                  <p>Test, which is a new approach to have all solutions 
                    astrology under one roof.</p>
                </div>
              </div>
            </div>
            
            
            
          </div>
        </div>
        <div class=\"mesgs\">
          <div class=\"msg_history\">
            <div class=\"incoming_msg\">
              <div class=\"incoming_msg_img\"> <img src=\"https://ptetutorials.com/images/user-profile.png\" alt=\"sunil\"> </div>
              <div class=\"received_msg\">
                <div class=\"received_withd_msg\">
                  <p>Test which is a new approach to have all
                    solutions</p>
                  <span class=\"time_date\"> 11:01 AM    |    June 9</span></div>
              </div>
            </div>
            <div class=\"outgoing_msg\">
              <div class=\"sent_msg\">
                <p>Test which is a new approach to have all
                  solutions</p>
                <span class=\"time_date\"> 11:01 AM    |    June 9</span> </div>
            </div>
            <div class=\"incoming_msg\">
              <div class=\"incoming_msg_img\"> <img src=\"https://ptetutorials.com/images/user-profile.png\" alt=\"sunil\"> </div>
              <div class=\"received_msg\">
                <div class=\"received_withd_msg\">
                  <p>Test, which is a new approach to have</p>
                  <span class=\"time_date\"> 11:01 AM    |    Yesterday</span></div>
              </div>
            </div>
            <div class=\"outgoing_msg\">
              <div class=\"sent_msg\">
                <p>Apollo University, Delhi, India Test</p>
                <span class=\"time_date\"> 11:01 AM    |    Today</span> </div>
            </div>
            <div class=\"incoming_msg\">
              <div class=\"incoming_msg_img\"> <img src=\"https://ptetutorials.com/images/user-profile.png\" alt=\"sunil\"> </div>
              <div class=\"received_msg\">
                <div class=\"received_withd_msg\">
                  <p>We work directly with our designers and suppliers,
                    and sell direct to you, which means quality, exclusive
                    products, at a price anyone can afford.</p>
                  <span class=\"time_date\"> 11:01 AM    |    Today</span></div>
              </div>
            </div>
          </div>
          <div class=\"type_msg\">
            <div class=\"input_msg_write\">
              <input type=\"text\" class=\"write_msg\" placeholder=\"Type a message\" />
              <button class=\"msg_send_btn\" type=\"button\"><i class=\"fa fa-paper-plane-o\" aria-hidden=\"true\"></i></button>
            </div>
          </div>
        </div>
      </div>
      
            
    </div></div>";