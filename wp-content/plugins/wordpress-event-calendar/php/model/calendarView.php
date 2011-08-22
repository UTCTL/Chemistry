<?php 
class calendarView {
    var $givenDate;
    var $month;
    
    function __construct($timestamp) {
        $this->givenDate = $timestamp;
        
        //Create an array for this month
        $this->write_current_month_array();
        
    }
    
    private function write_current_month_array() {
        $timeManager = new dateTimeManager();
        
        //Get the current year
        $year = date('Y', $this->givenDate);
        
        //Get the current month
        $month = date('n', $this->givenDate);
        
        //Get the current day of the month
        $day = date('j', $this->givenDate);
        
        //Get the number of days in the current month
        $daysInCurrentMonth = date("t", mktime(0, 0, 0, $month, 1, $year));
        
        //Get the array index of the first day of the month
        $arrayOffsetForFirstDayOfMonth = date("w", mktime(0, 0, 0, $month, 1, $year));
        
        //Find out how many weeks are in this current month
        $weeksInCurrentMonth = ceil(($daysInCurrentMonth + $arrayOffsetForFirstDayOfMonth) / 7);
        
        $dayNumberOfMonth = 1;
        
        //Fill up the days until the first day of the month
        for ($i = 0; $i < $arrayOffsetForFirstDayOfMonth; $i++) {
            $this->month[0][$i] = 0;
        }
        
        //Write the first line for the month
        for ($i = $arrayOffsetForFirstDayOfMonth; $i < 7; $i++) {
            //This code will generate a timestamp for this date.
            $thisDay = $dayNumberOfMonth.' '.$timeManager->getMonthName($this->givenDate).' '.$timeManager->getYear($this->givenDate);
            
            $dayOfMonth = strtotime($thisDay);
            
            $this->month[0][$i]['timestamp'] = $dayOfMonth;
            $this->month[0][$i]['timestampTomorrow'] = $dayOfMonth + 86400;
            $this->month[0][$i]['dayNumber'] = $dayNumberOfMonth;

            
            $dayNumberOfMonth++;
        }
        
        //Write each week line, until we're full
        for ($i = 1; $i < $weeksInCurrentMonth; $i++) {
            //Write each entry in a week line
            for ($j = 0; $j < 7; $j++) {

            
                if ($dayNumberOfMonth < $daysInCurrentMonth + 1) {
                    //This code will generate a timestamp for this date.
                    $thisDay = $dayNumberOfMonth.' '.$timeManager->getMonthName($this->givenDate).' '.$timeManager->getYear($this->givenDate);
                    
                    $dayOfMonth = strtotime($thisDay);
                    
                    $this->month[$i][$j]['timestamp'] = $dayOfMonth;
                    $this->month[$i][$j]['timestampTomorrow'] = $dayOfMonth + 86400;
                    $this->month[$i][$j]['dayNumber'] = $dayNumberOfMonth;

                    
                    $dayNumberOfMonth++;
                } else {
                    $this->month[$i][$j] = 0;
                }
            }
        }
    }
    
    function writeCalendar() {

    
    }
    
}

?>
