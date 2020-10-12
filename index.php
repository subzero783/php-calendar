<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHP Calendar</title>
    <!-- <link rel="stylesheet" href="./dist/css/style.css"> -->
  </head>
  <body class="" style="background:lightgray;">
    <div class="container my-auto mx-auto d-block">
      <?php 
      function build_calendar($month,$year,$dateArray) {

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
        $calendar .= "<caption>$monthName $year</caption>";
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
   
             $calendar .= "<td class='day' rel='$date'>$currentDay</td>";
   
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
   $dateComponents = getdate();

   $month = $dateComponents['mon']; 			     
   $year = $dateComponents['year'];

   echo build_calendar($month,$year,$dateArray);   
      ?>
      <form id="calendar" class="mt-5 mb-5" action="./calendar/">
        <div class="row mb-4">
          <div class="col-xl-12">
          </div>
        <div>
      </form>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
      jQuery(document).ready(function($){

        // var formDataJson = toJSONString(document.getElementById("job_search_form"));

        var new_date = new Date();

        var userDateTimeObj = {
          "user_datetime" : new_date
        };

        // console.log(userDateTimeObj);


        var user_date_time = JSON.stringify(new_date);

        console.log(user_date_time);

        $.ajax({ 
          type: 'POST', 
          url: 'http://localhost/php-google-calendar/calendar/',
          data: {
            action: 'get_datetime_slots',
            user_datetime: user_date_time
          },
          dataType: 'json',
          cache: false
        })
        .done(function(response){
          console.log('Success: ');
          console.log(response);
        }) 
        .fail(function(error){
          console.log('Error: ');
          console.log(error);
        });
      });
    </script>
    <!-- <script src="./dist/js/all.js"></script> -->
  </body>
</html>
