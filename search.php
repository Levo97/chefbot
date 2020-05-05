<?php
include_once 'include/db.con.php';
if (isset($_POST["query"])) {
    $output = '';
    $query = "SELECT * FROM alapanyagok WHERE neve LIKE '%" . $_POST["query"] . "%'";
    $result = mysqli_query($conn, $query);
    $output = '<ul class="list-unstyled">';
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $output .= '<li>' . $row["neve"] . '</li>';
        }
    } else {
        $output .= '<li>Nem találok ilyet alapanyagot</li>';
    }
    $output .= '</ul>';
    echo $output;
}
$conn->close();
?>