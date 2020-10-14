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

  $data = json_decode($_POST['the_date']);

  $sql = 'SELECT * FROM second_appointment ';
  $sql .= 'WHERE start_datetime > "' . $db->real_escape_string($data) . '"';
  $result = $db->query($sql);
  $rows = $result->fetch_all();
  $result->free();

  echo json_encode($rows);

}

function build_calendar($month,$year) {

  // Create array containing abbreviations of days of week.
  $daysOfWeek = array('S','M','T','W','T','F','S');

  // What is the first day of the month in question?
  $firstDayOfMonth = mktime(0,0,0,$month,1,$year);

  // How many days does this month contain?
  $numberDays = date('t',$firstDayOfMonth);

  // Retrieve some information about the first day of the
  // month in question.
  $dateComponents = getdate($firstDayOfMonth);

  // What is the name of the month in question?
  $monthName = $dateComponents['month'];

  // What is the index value (0-6) of the first day of the
  // month in question.
  $dayOfWeek = $dateComponents['wday'];

  // Create the table tag opener and day headers

  $calendar = "<table class='calendar'>";
  $calendar .= "<caption data-month-name='$monthName' data-year-int='$year'><a href='javascript:;' class='previous_month'><<</a> <span class='c_month'>$monthName</span> <span class='c_year'>$year</span> <a href='javascript:;' class='next_month'>>></a></caption>";
  $calendar .= "<tr>";

  // Create the calendar headers

  foreach($daysOfWeek as $day) {
    $calendar .= "<th class='header'>$day</th>";
  } 

  // Create the rest of the calendar

  // Initiate the day counter, starting with the 1st.

  $currentDay = 1;

  $calendar .= "</tr><tr>";

  // The variable $dayOfWeek is used to
  // ensure that the calendar
  // display consists of exactly 7 columns.

  if ($dayOfWeek > 0) { 
    $calendar .= "<td colspan='$dayOfWeek'>&nbsp;</td>"; 
  }
  
  $month = str_pad($month, 2, "0", STR_PAD_LEFT);

  while ($currentDay <= $numberDays) {

    // Seventh column (Saturday) reached. Start a new row.

    if ($dayOfWeek == 7) {

      $dayOfWeek = 0;
      $calendar .= "</tr><tr>";

    }
    
    $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
    
    $date = "$year-$month-$currentDayRel";

    $calendar .= "<td class='day'><a href='javascript:;' rel='$date'>$currentDay</a></td>";

    // Increment counters

    $currentDay++;
    $dayOfWeek++;

  }

  // Complete the row of the last week in month, if necessary

  if ($dayOfWeek != 7) { 
  
    $remainingDays = 7 - $dayOfWeek;
    $calendar .= "<td colspan='$remainingDays'>&nbsp;</td>"; 

  }
  
  $calendar .= "</tr>";

  $calendar .= "</table>";

  return $calendar;

}


if($_POST['action'] == 'get_month'){

  $the_date = json_decode($_POST['the_date']);

  $month = date('m', strtotime( $the_date) ); 			     
  $year = date('Y', strtotime( $the_date) );

  $the_calendar = build_calendar($month, $year);

  echo json_encode($the_calendar);
}

if( $_GET['action'] == 'get_day_available_time_slots' ){

  $day_selected = json_decode($_GET['day_selected']);
  // $day_selected = '2020-10-21';
  $next_day = date('Y-m-d', strtotime($day_selected . ' +1 day'));
  $sql = "SELECT * FROM second_appointment WHERE start_datetime >= '$day_selected' AND start_datetime < '$next_day'";
  
  $result = $db->query($sql);
  $row = $result->fetch_all();
  $result->free();
  echo json_encode($row);
  // print_r($row);

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