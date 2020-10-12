<?php

define('DB_SERVER', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'root');
define('DB_NAME', 'php_calendar');
define('DB_PORT', '3307');

function db_connect() {
  $connection = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME, DB_PORT);
  confirm_db_connect($connection);
  return $connection;
}

function confirm_db_connect($connection) {
  if($connection->connect_errno) {
    $msg = "Database connection failed: ";
    $msg .= $connection->connect_error;
    $msg .= " (" . $connection->connect_errno . ")";
    exit($msg);
  }
}

function db_disconnect($connection) {
  if(isset($connection)) {
    $connection->close();
  }
}

$db = db_connect();

// If I have the users datetime, I should only get the available date/time slots one month in the future from the users datetime

// How?

// Get the available datetime slots between the start of the users datetime and one month ahead

if( $_POST['action'] == 'get_datetime_slots' ){

  $data = json_decode($_POST['user_datetime']);



  $sql = 'SELECT * FROM second_appointment ';
  $sql .= 'WHERE start_datetime > "' . $db->real_escape_string($data) . '"';
  $result = $db->query($sql);
  $rows = $result->fetch_all();
  $result->free();

  echo json_encode($rows);

}



  



// $sql = 'SELECT * FROM second_appointment';

// $result = $db->query($sql);
// $row = $result->fetch_all();
// echo '<pre>';
// print_r($row);
// echo '</pre>';

// echo 'Start DateTime'.'<br>';
// $sd = new DateTime($row['start_datetime']);
// echo $sd->format('D, M d Y h:i a T').'<br>';

// echo 'End DateTime'.'<br>';
// $ed = new DateTime($row['end_datetime']);
// echo $ed->format('D, M d Y h:i a T').'<br>';

// echo 'DateTime Difference'.'<br>';
// $diff = $sd->diff($ed);
// echo $diff->format('%h hours %i minutes %s seconds').'<br>';

// $result->free();





?>