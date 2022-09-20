<?php
// connection database
$conn = mysql_connect("localhost", "root", "", "coffeestore") or die("Database Error");

// getting user messages through ajax
$getMesg = mysqli_real_escape_string($conn, $_POST['text']);

//checking user query to database query
$check_data = "SELECT replies FROM chatbot WHERE queries LIKE '%$getMesg%'";
$run_query = mysqli_query($conn, $check_data) or die("Error");

if(mysqli_num_rows($run_query) > 0) {

} else {
    echo 'Sorry cant be able to understand you!';
}

?>