<?php
require_once(__DIR__. '/../static/php/handleDiary.php');
require_once(__DIR__. '/../static/php/renderDiaryEntryV2.php');
require_once(__DIR__ . '/include/mask.php');

$title_styles = [1, 2, 3 ,4];
$current_title_style = $_GET['title-style'] ?? 0;

function processConversation($raw){
    if(!$raw) return '';
    $output = '';
    $pattern = '/\[(.*?)\]/';
    preg_match_all($pattern, $raw, $matches);
    foreach($matches[1] as $key => $content){
        $user = $key % 2 === 0 ? 'ai' : 'user';
        $output .= '<div class="conversation-bubble body" data-subject="'.$user.'">' . $content . '</div>';
    }
    return $output;
}



$body = '';
$thumbnail_src = '';
$thumbnail_caption = '';
$sql = "SELECT * FROM media WHERE `object`=$item[id] AND active = 1";
$result = $db->query($sql);
while($m = $result->fetch_assoc()) {
    if(!$thumbnail_src) $thumbnail_src = m_url($m);
    if(strpos( $m['caption'], '[thumbnail]') !== false) {
        $thumbnail_src = m_url($m);
        $thumbnail_caption = str_replace('[thumbnail]', '', $m['caption']);
        break;
    }
}
$diaries = array();
if($item['state']) {
    $sql = "SELECT 
        o.*
        , (
            SELECT CONCAT('[', GROUP_CONCAT(
                JSON_OBJECT(
                    'id', m.id,
                    'type', m.type,
                    'hasWebFormat', m.weight,
                    'caption', REPLACE(CONVERT(m.caption USING utf8), '\\r\\n', '')
                )
                ORDER BY m.rank, m.id
            ), ']')
            FROM media m
            WHERE m.object = o.id AND m.active = 1
        ) AS media
        FROM objects o 
        WHERE o.id IN ($item[state]) AND active = 1";
    $result = $db->query($sql);
    
    while($object = $result->fetch_assoc()) {
        $diaries[] = handleDiary($object);
    }

}

$db->close();
function renderThumbnail($src, $caption=''){
    $caption = $caption ? '<figcaption class="essay-detail-thumbnail-caption small">'.$caption.'</figcaption>' : '';
    return '<figure class="essay-detail-section essay-detail-thumbnail">
        <img class="" src="'.$src.'">
            '.$caption.'
        </figure>';
}
function renderPoemHeader($title, $content){
    return '<div id="essay-detail-header" class="essay-detail-section">
            <div class="essay-detail-section-content essay-title">' . $title . '</div>
            <div class="essay-detail-section-content medium essay-detail-punchline">'.$content.'</div>
        </div>';
}
function renderSummary($content){
    return '<div class="essay-detail-section essay-detail-summary">
        <div class="essay-detail-section-content summary-content body">'.$content.'</div>
        </div>';
}
function renderDiaries($diaries){
    $body = '';
    foreach($diaries as $d) {
        $body .= renderDiaryEntryV2($d);
    }
        
    return '<div id="essay-detail-diaries" class="essay-detail-section">
            '.$body.'
        </div>';
}

// function renderConversation($content){
//     return '';
// }
if($thumbnail_src)
    $body .= renderThumbnail($thumbnail_src, $thumbnail_caption);
else {
    $body .= '<div class="dummy-thumbnail"></div>';
}
$deck = $item['deck'] ?? '';
$name2 = $item['name2'] ? str_replace(' ', '', $item['name2']) : '';

if(strtotime($name2)){
    $time = strtotime($name2);
    $time_formatted = [
        'year' => date('Y', $time),
        'month' => date('m', $time),
        'day' => date('d', $time),
        'day-of-week' => date('D', $time) . '.'
    ];
    // $title = [];
    // foreach($time_formatted as $key => $t) {
    //     $title[] = '<span class="essay-title-' . $key . '">' . $t . '</span>';
    // }
    $title = '<span class="essay-title-year">' . $time_formatted['year'] . '</span><span class="date-separator"></span>' .
            '<span class="essay-title-month">' . $time_formatted['month'] . '</span><span class="date-separator"></span>' .
            '<span class="essay-title-day">' . $time_formatted['day'] . '</span>' . 
            '<span class="essay-title-day-of-week">' . $time_formatted['day-of-week'] . '</span>';
} else {
    $title = $item['name2'];
}

$body .= renderPoemHeader($title, $deck);
    
if(count($diaries))
    $body .= renderDiaries($diaries);

$body .= renderSummary($item['body']);

// $titleFont = $_GET['title-font'] ?? 'serif';
// $titleFontSize = $_GET['title-font'] ?? 1;
// $page_attr = array(
//     'data-title-font' => $titleFont
// );
// $page_attr_str = arrayToAttr($page_attr);
?>
<div id="<?php echo $view; ?>" class="page" >
    <?php echo $body; ?>
</div>
<?php echo renderMask(); ?>
<script src="/static/js/Popup.js"></script>
<script src="/static/js/Header.js"></script>
<script src="/static/js/LargePopup.js"></script>
<script>
    const morePopup = new Popup({
        id: 'more-popup',
        text: '更多操作',
        mount: app,
        buttons: [
            {
                display: 'style 1',
                slug: 'title-style-1',
                callback: () => {
                    window.location.href="?v=2&title-style=1"
                }
            },
            {
                display: 'style 2',
                slug: 'title-style-2',
                callback: (instance) => {
                    window.location.href="?v=2&title-style=2"
                }
            },
            {
                display: 'style 3',
                slug: 'title-style-3',
                callback: (instance) => {
                    window.location.href="?v=2&title-style=3"
                }
            },
            {
                display: 'style 4',
                slug: 'title-style-4',
                callback: (instance) => {
                    window.location.href="?v=2&title-style=4"
                }
            },
            {
                display: '從相簿選擇照片',
                slug: 'change-image',
                callback: (instance) => {
                    instance.hide();
                }
            },
            {
                display: '刪除照片',
                slug: 'remove-image',
                callback: (instance) => {
                    instance.hide();
                }
            },
            {
                display: '查看梳理紀錄',
                slug: 'show-conversation',
                callback: (instance) => {
                    instance.hide();
                }
            },
            {
                display: '取消',
                slug: 'cancel'
            }
        ]
    });
    const more_button = document.querySelector('.header-right .more-icon');
    if(more_button) {
        more_button.addEventListener('click', () => {
            morePopup.show();
        });
    }
    const conversation_button = document.querySelector('#more-popup .popup-button[data-action="show-conversation"]');
    const conversation = '<?php echo processConversation($item['notes']); ?>';
    const conversationPopup = new LargePopup({
        id: 'conversation-popup',
        content: conversation,
        mount: app,
        header: {
            'left': ['esc'],
            'center': '梳理紀錄',
            'right': []
        },
        headerColorTheme: 'dark'
    });
    if(conversation_button) {
        conversation_button.addEventListener('click', () => {
            conversationPopup.show();
        });
    }
    const header_esc_button = document.querySelector('#main-header .esc-icon');
    header_esc_button.addEventListener('click', () => {
        history.back();
    })

   
    const thumbnail = document.querySelector('.essay-detail-thumbnail');
    if(thumbnail) {
         const vh = window.innerHeight;
         thumbnail.style.setProperty('--thumbnail-height', (vh * 0.5) + 'px');
    }
</script>
<style>
    .popup-button[data-action="title-style-<?php echo $current_title_style; ?>"] {
        background-color: var(--green);
        color: #fff;
    }
</style>