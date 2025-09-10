<?php 
require_once __DIR__ . '/../static/php/getDiaryList.php';


function renderDiaryEntry($diary, $idx=-1){
    global $attrs;
    $style = '';
    if(isset($attrs['data-item-style']) && isset($attrs['data-item-style']) == 2 && $idx !== 0) {
        $diary_item_bg_v2_filename = 'diary-item-bg-v2';
        $diary_item_bg_v2_count = 6;
        $background_idx = $idx % $diary_item_bg_v2_count;
        $style .= "background-image: url(/media/svg/$diary_item_bg_v2_filename-$background_idx.svg);";
    }
    $cls = array('diary-entry');
    if($idx === 0)
        $cls[] = 'add-new';
    $thumbnail = $diary['thumbnail'] ? '<div class="thumbnail-wrapper"><img class="thumbnail" src="'.m_url($diary['thumbnail']).'" /></div>': '';
    $output = '<div class="' . implode(' ', $cls) . '" style="'.$style.'">' .$thumbnail . '<div class="diary-content "><div class="diary-time">'.$diary['time'].'</div><div class="diary-text body">' . $diary['body']. '</div></div></div>';
    return $output;
}
$diary_list = getDiaryList($db, $item['id']);

?>
<div id="<?php echo $item['url']; ?>" class="page">
    <ul>
    <?php 
        $diary_count = 0;
        foreach($diary_list as $year => $months) {
            echo '<div class="diary-section diary-year-section"><h2 class="diary-section-title diary-year-section-title x-large">' . $year . '</h2>';
            foreach($months as $month => $days) {
                echo '<div class="diary-section diary-month-section"><h2 class="diary-section-title diary-month-section-title x-large">' . $month . '<span class="month-note diary-date-note small">月</span></h2>';
                // echo $month . '<br>';
                foreach($days as $day => $diaries) {
                    echo '<div class="diary-section diary-day-section"><h2 class="diary-section-title diary-day-section-title x-large">' . $day . '<span class="day-note diary-date-note small">日</span></h2>';
                    foreach($diaries as $diary) {
                        echo renderDiaryEntry($diary, $diary_count);
                        $diary_count ++;
                    }
                    echo '</div>';
                }
                echo '</div>';
            }
            echo '</div>';
        }
    ?>
    </ul>
</div>