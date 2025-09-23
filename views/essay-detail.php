<?php
require_once(__DIR__. '/../static/php/handleDiary.php');
require_once(__DIR__. '/../static/php/renderDiaryEntry.php');
require_once(__DIR__ . '/include/mask.php');
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
$sql = "SELECT * FROM media WHERE `object`=$item[id] AND active = 1";
$result = $db->query($sql);
while($m = $result->fetch_assoc()) {
    if(!$thumbnail_src) $thumbnail_src = m_url($m);
    if(strpos( $m['caption'], '[thumbnail]') !== false) {
        $thumbnail_src = m_url($m);
        break;
    }
}
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
$diaries = array();
while($object = $result->fetch_assoc()) {
    
    $diaries[] = handleDiary($object);
}
$db->close();

function renderThumbnail($src){
    return '<div class="essay-detail-section essay-detail-thumbnail">
        <img class="" src="'.$src.'">
        </div>';
}
function renderPoem($title, $content){
    return '<div class="essay-detail-section essay-detail-poem">
        <div class="essay-section-style-wrapper">
            <div class="essay-detail-section-title poem-title bold large">' . $title . '</div>
            <div class="essay-detail-section-content poem-content body medium">'.$content.'</div>
        </div></div>';
}
function renderSummary($content){
    return '<div class="essay-detail-section essay-detail-summary">
        <div class="essay-section-style-wrapper">
        <div class="essay-detail-section-content summary-content body">'.$content.'</div>
        </div></div>';
}
function renderDiaries($diaries){
    $body = '';
    foreach($diaries as $d) {
        $body .= renderDiaryEntry($d);
    }
        
    return '<div class="essay-detail-section essay-detail-diaries">
            <div class="essay-detail-section-title small bold">碎片</div>
            '.$body.'
        </div>';
}

// function renderConversation($content){
//     return '';
// }
if($thumbnail_src)
    $body .= renderThumbnail($thumbnail_src);
else {
    $body .= 'cant find thumbnail';
}
if($item['deck'])
    $body .= renderPoem($item['name2'], $item['deck']);

$body .= renderSummary($item['body']);

// $body .= renderConversation();

if(count($diaries))
    $body .= renderDiaries($diaries);
?>
<div id="<?php echo $view; ?>" class="page">
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
</script>