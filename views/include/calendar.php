<?php

function renderCalendar($datestr, $entries, $id = '', $extra_class=array()) {
    global $calendar;
    
    $showhide = ($calendar) ? "flex" : "none";
    $cls = array(...$extra_class, 'calendar-picker');
    $cls_str = implode(' ', $cls);
    $out = '<div class="'.$cls_str.'" id="'.$id.'" style="">';
    // $out .='<div id="'.$id.'">';
    $dateComponents = getdate(strtotime($datestr));
    $today = $dateComponents['mday'];
    // if ($date_argument) {
    //     // dont underline a date  if no day give in $date_argument
    //     // $today returns NULL if only year-month given
    //     $date_arguments = explode('-', $date_argument);
    //     $today = isset($date_arguments[2]) ? $date_arguments[2] : false;    
    // }
    $month = $dateComponents['mon'];
    $year = $dateComponents['year'];
    $month_padded = str_pad($month, 2, "0", STR_PAD_LEFT);
    // var_dump($month);
    $entries_filtered = array();
    if(isset($entries[$year]) && isset($entries[$year][$month_padded]))
        $entries_filtered = $entries[$year][$month_padded];
    $out .= build_calendar($today, $month, $year, $entries_filtered);
    // $out .= '</div>';
    $out .= '</div>';
    return $out;
}

function build_calendar($today, $month, $year, $entries_filtered) {
    /* based on https://css-tricks.com/snippets/php/build-a-calendar-table */
    $entries_formatted = array();
    foreach($entries_filtered as $day => $entries) {
        [$day_of_month, $day_of_week] = explode('-', $day);
        $entries_formatted['d-' . $day_of_month] = $entries;
    }
    $days_of_week = array('Sun.','Mon.','Tue.','Wed.','Thur.','Fri.','Sat.');
    $firstDayOfMonth = mktime(0,0,0,$month,1,$year);
    $numberDays = date('t',$firstDayOfMonth);
    $dateComponents = getdate($firstDayOfMonth);
    $monthName = $dateComponents['month'];
    $day_of_week = $dateComponents['wday'];   // index (0-6) of first day of month
    // start html
    // $lastMonth = date('Y-m-d', strtotime(date('Y-m-d', $firstDayOfMonth) . ' - 1 month'));
    // $nextMonth = date('Y-m-d', strtotime(date('Y-m-d', $firstDayOfMonth) . ' + 1 month'));
    $lastMonth = date('Y-m', strtotime(date('Y-m-d', $firstDayOfMonth) . ' - 1 month'));
    $nextMonth = date('Y-m', strtotime(date('Y-m-d', $firstDayOfMonth) . ' + 1 month'));

    $calendar = '';
    $calendar .= "<div class='month bold'>";
    $calendar .= "<div class='month-arrow prev-month-arrow icon arrow-head-left-icon' ></div>";
    $calendar .= $monthName . " ".$year;
    $calendar .= "<div class='month-arrow next-month-arrow icon arrow-head-right-icon' ></div>";
    $calendar .= "</div>";
    $calendar .= "<table class='calendar'>";
    $calendar .= "<tr>";

    // days of the week
    foreach($days_of_week as $d) {
        $calendar .= "<th class='days_of_the_week small bold'><div class='block'>$d</div></th>";
    }

    // days
    $current_day = 1;
    $calendar .= "</tr><tr>";
    if ($day_of_week > 0) {
        $calendar .= "<td colspan='$day_of_week'></td>";
    }
    $month = str_pad($month, 2, "0", STR_PAD_LEFT);
    while ($current_day <= $numberDays) {
        if ($day_of_week == 7) {
            $day_of_week = 0;
            $calendar .= "</tr><tr>";
        }
        $current_day_rel = str_pad($current_day, 2, "0", STR_PAD_LEFT);
        $date = "$year-$month-$current_day_rel";
        $marks = '';
        if(isset($entries_formatted['d-' . $current_day_rel])) {
            $mark_count = count($entries_formatted['d-' . $current_day_rel]);
            $marks .= '<div class="calendar-entry-mark" data-count="'.$mark_count.'"></div>';
        }
        if ($current_day == $today)
            $calendar .= "<td class='day today' rel='$date'><div class='block'>$current_day<div class='today-underline'>$current_day</div></div>$marks</td>";
        else
            $calendar .= "<td class='day' rel='$date'><div class='block'>$current_day</div>$marks</td>";
        $current_day++;
        $day_of_week++;
    }
    if ($day_of_week != 7) {
         $remainingDays = 7 - $day_of_week;
         $calendar .= "<td colspan='$remainingDays'></td>";
    }
    $calendar .= "</tr>";
    $calendar .= "</table>";
    
    return $calendar;
}
?>