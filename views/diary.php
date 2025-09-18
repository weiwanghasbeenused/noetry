<?php 
require_once __DIR__ . '/../static/php/getDiaryList.php';
$item_style = $attrs['data-item-style'] ?? 0;

function renderDiaryEntry($diary, $idx=-1){
    global $item_style;
    $style = '';
    $background = '';
    if($item_style == 2 && $idx !== 0) {
        $background = '<div class="svg-background">
                    <?xml version="1.0" encoding="UTF-8"?><svg xmlns="http://www.w3.org/2000/svg" width="360" height="108" viewBox="0 0 360 108" preserveAspectRatio="none"><defs><style>.cls-1{fill:#fff;}</style></defs><polygon class="cls-1" points="'.$diary['address1'].'"/></svg>
                </div>';        
    }
    $cls = array('list-entry', 'diary-entry');
    if($idx === 0)
        $cls[] = 'add-new';
    $tangled = $diary['tangled'] ? '<div class="tangled-wrapper"><img class="tangled" src="'.$diary['tangled']['src'].'" /></div>': '';
    $thumbnail = '';
    if($diary['thumbnail']) {
        $thumbnail = '<div class="thumbnail-wrapper diary-thumbnail-wrapper"><img class="thumbnail" src="'.$diary['thumbnail']['src'].'"></div>';
    }
    $output = '<div class="' . implode(' ', $cls) . '" style="'.$style.'">' .$background.$tangled . '<div class="diary-content "><div class="entry-content-header entry-time diary-time small bold">'.$diary['time'].'</div><div class="list-text diary-text body">' . $diary['body']. '</div></div>'.$thumbnail.'</div>';
    return $output;
}
$diary_list = getDiaryList($db, $item['id']);

?>
<div id="<?php echo $item['url']; ?>" class="page">
    <ul class="list">
    <?php 
        $diary_count = 0;
        foreach($diary_list as $year => $months) {
            echo '<li class="list-section list-year-section diary-section diary-year-section"><h2 class="list-section-title list-year-section-title diary-section-title diary-year-section-title">' . $year . '</h2>';
            foreach($months as $month => $days) {
                echo '<div class="list-section list-month-section diary-section diary-month-section"><h2 class="list-section-title list-month-section-title diary-section-title diary-month-section-title">' . $month . '<span class="month-note list-date-note diary-date-note small">月</span></h2>';
                foreach($days as $day => $diaries) {
                    [$day_of_month, $day_of_week] = explode('-', $day);
                    echo '<div class="list-section list-day-section diary-section diary-day-section">
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
    </ul>
</div>
<?php