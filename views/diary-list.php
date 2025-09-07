<?php 
require_once __DIR__ . '/../static/php/getDiaryList.php';
function renderDiaryEntry($diary){
    $output = '<div class="diary-entry"><div class="diary-time">'.$diary['time'].'</div><div class="diary-content body">' .$diary['body']. '</div></div>';
    return $output;
}

$diary_list = getDiaryList($db, $item['id']);
?>
<div id="<?php echo $item['url']; ?>" class="page">
    <ul>
    <?php 
        foreach($diary_list as $year => $months) {
            echo '<div class="diary-section diary-year-section"><h2 class="diary-section-title diary-year-section-title x-large">' . $year . '</h2>';
            foreach($months as $month => $days) {
                echo '<div class="diary-section diary-month-section"><h2 class="diary-section-title diary-month-section-title x-large">' . $month . '<span class="month-note diary-date-note small">月</span></h2>';
                // echo $month . '<br>';
                foreach($days as $day => $diaries) {
                    echo '<div class="diary-section diary-day-section"><h2 class="diary-section-title diary-day-section-title x-large">' . $day . '<span class="day-note diary-date-note small">日</span></h2>';
                    foreach($diaries as $diary)
                        echo renderDiaryEntry($diary);
                    echo '</div>';
                }
                echo '</div>';
            }
            echo '</div>';
        }
    ?>
    </ul>
</div>