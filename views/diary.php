<?php 
require_once __DIR__ . '/../static/php/getDiaryList.php';
require_once __DIR__ . '/../static/php/renderDiaryEntry.php';
$item_style = $attrs['data-item-style'] ?? 0;


$diary_list = getDiaryList($db, $item['id']);

?>
<div id="<?php echo $item['url']; ?>" class="page">
    <ul class="list" data-list-type="rows">
        <div class="list-content">
        <?php 
            $diary_count = 0;
            foreach($diary_list as $year => $months) {
                echo '<li class="list-section list-year-section diary-section diary-year-section"><h2 class="list-section-title list-year-section-title diary-section-title diary-year-section-title regular">' . $year . '</h2>';
                foreach($months as $month => $days) {
                    echo '<div class="list-section list-month-section diary-section diary-month-section"><h2 class="list-section-title list-month-section-title diary-section-title diary-month-section-title regular">' . $month . '<span class="month-note list-date-note diary-date-note small">月</span></h2>';
                    foreach($days as $day => $diaries) {
                        [$day_of_month, $day_of_week] = explode('-', $day);
                        $day_count = count($diaries);
                        echo '<div class="list-section list-day-section diary-section diary-day-section" data-day-count="'.$day_count.'">
                            <div class="list-section-title list-day-section-title diary-section-title diary-day-section-title">
                                <h2 class="list-day diary-day x-large">' . $day_of_month . '<span class="day-note list-date-note diary-date-note small">日</span></h2>
                                <div class="list-day-of-week diary-day-of-week bold small">'.$day_of_week.'.</div></div>';
                        foreach($diaries as $diary) {
                            echo renderDiaryEntry($diary, $diary_count);
                            $diary_count++;
                        }
                        echo '</div>';
                    }
                    echo '</div>';
                }
                echo '</li>';
            }
        ?>
        </div>
    </ul>
</div>
<?php