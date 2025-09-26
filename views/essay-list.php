<?php 
require_once __DIR__ . '/../static/php/getEssayList.php';
require_once __DIR__ . '/include/calendar.php';
$item_style = $attrs['data-item-style'] ?? 0;

function renderPoemEntry($entry, $list_type, $idx=-1){
    global $item_style;
    $id = 'essay-entry-' . $idx;
    $style = 'z-index: ' . 50 - $idx . ';';
    $body = '';
    $background = '';
    $thumbnail = '';
    if($item_style == 'keep') {
        $temp = array_map(function($p){ return implode(' ', $p); }, $entry['points']);
        $points_str = implode(' ', $temp);
        $background = '<div class="svg-background">
                    <?xml version="1.0" encoding="UTF-8"?><svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" preserveAspectRatio="none" viewBox="0 0 360 108"><defs><style>.cls-1{fill:#fff;}</style></defs><polygon class="cls-1" points="'.$points_str.'"/></svg>
                </div>';        
    }
    $cls = array('list-entry', 'essay-entry');
    
    if($entry['thumbnail'] && $list_type !== 'grid') {
        $thumbnail = '<div class="thumbnail-wrapper essay-thumbnail-wrapper"><img class="thumbnail" src="'.$entry['thumbnail']['src'].'"></div>';
    }
    if($entry['name2'] && $entry['deck']) {
        $body = "<div class='entry-body essay-body'><div class='essay-title bold'>$entry[name2]</div><div class='list-text essay-text body'>$entry[deck]</div></div>";
    } else {
        $cls[] = 'no-essay';
        $body = "<div class='entry-body essay-body'><div class='essay-body body'><div class='list-text essay-text body'>$entry[body]</div></div></div>";
    }
    $time = '';
    if($list_type === 'rows' || $list_type === 'calendar')
        $time = '<div class="entry-header entry-time essay-time small bold">'.$entry['time'].'</div>';
    else if($list_type === 'grid') {
        $date = str_replace('/', '<span class="date-separator"> / </span>', $entry['date']);
        $time = '<div class="entry-header entry-time essay-time small bold">'.$date.'</div>';
    }
    $body = $time . $body;
    $output = '<div id="'.$id.'" class="' . implode(' ', $cls) . '" style="'.$style.'" data-slug="'.$entry['url'].'" data-date="'.str_replace('/', '-', $entry['date']).'">'.$background.'<div class="entry-inner essay-inner">'.$body.$thumbnail.'</div></div>';
    return $output;
}
$essay_list = getPoemList($db, $item['id']);
$points = array();
$view_options = array(
    'rows', 'grid', 'calendar'
);
$list_view = $_GET['view'] ?? $view_options[0]; 
$essay_items = array();
?>
<div class="sub-header fixed full-vw">
    <div class="header-section header-left">
        <div class="search-icon icon button" data-href="/search"></div>
        <div class="current-keyword"></div>
    </div>
    <div id="view-options" class="header-section header-right">
        <?php 
            foreach($view_options as $option) {
                // $active = $list_view  === $option;
                $cls = array('view-option', 'icon');
                $cls[] = 'view-' .$option. '-icon';
                if($list_view  === $option) $cls[] = 'active';
                echo '<div class="' . implode(' ', $cls) . '" data-value="'.$option.'"></div>';
            }
        ?>
    </div>
</div>
<div id="<?php echo $view; ?>" class="page" data-list-view="<?php echo $list_view; ?>">
    <ul class="list" data-list-type="rows" data-loading="0">
        <div class="list-content">
        <?php 
            $essay_count = 0;
            foreach($essay_list as $year => $months) {
                echo '<li class="list-section list-year-section essay-section essay-year-section"><h2 class="list-section-title list-year-section-title essay-section-title essay-year-section-title">' . $year . '</h2>';
                foreach($months as $month => $days) {
                    echo '<div class="list-section list-month-section essay-section essay-month-section"><h2 class="list-section-title list-month-section-title essay-section-title essay-month-section-title">' . $month . '<span class="month-note list-date-note essay-date-note small">月</span></h2>';
                    foreach($days as $day => $essays) {
                        [$day_of_month, $day_of_week] = explode('-', $day);
                        echo '<div class="list-section list-day-section essay-section essay-day-section">
                            <div class="list-section-title list-day-section-title essay-section-title essay-day-section-title">
                                <h2 class="list-day essay-day x-large">' . $day_of_month . '<span class="day-note list-date-note essay-date-note small">日</span></h2>
                                <div class="list-day-of-week essay-day-of-week bold small">'.$day_of_week.'.</div></div>';
                        foreach($essays as $essay) {
                            echo renderPoemEntry($essay, 'rows', $essay_count);
                            $essay_items[] = $essay; 
                            $points[] = array(
                                'id' => 'essay-entry-' . $essay_count,
                                'points' => $essay['points']
                            );
                            $essay_count ++;
                        }
                        echo '</div>';
                    }
                    echo '</div>';
                }
                echo '</li>';
            }
        ?>
        </div>
        <div class="partial-loading-icon full-center-icon icon" data-color="black"></div>
    </ul>
    <div class="list" data-list-type="grid" data-loading="0">
        <div class="list-content">
        <?php 
            foreach($essay_items as $essay){
                echo renderPoemEntry($essay, 'grid');
            }
        ?>
        </div>
        <div class="partial-loading-icon full-center-icon icon" data-color="black"></div>
    </div>
    <?php echo renderCalendar(date('Y-m-d',strtotime('now')), $essay_list, 'essay-calendar'); ?>
    <ul class="list" data-list-type="calendar" data-loading="0">
        <div class="list-content">
        <?php 
            foreach($essay_items as $essay){
                echo renderPoemEntry($essay, 'calendar');
            }
        ?>
        </div>
        <div class="partial-loading-icon full-center-icon icon" data-color="black"></div>
    </ul>
    <ul id="search-result-list" class="list" data-list-type="default" data-loading="0">
        <div class="list-content">
        <?php 
            foreach($essay_items as $essay){
                echo renderPoemEntry($essay, 'calendar');
            }
        ?>
        </div>
        <div class="partial-loading-icon full-center-icon icon" data-color="black"></div>
    </ul>
</div>
<script src="/static/js/Header.js"></script>
<script src="/static/js/LargePopup.js"></script>
<script src="/static/js/Search.js"></script>
<script>
    const page = document.querySelector('.page');
    const points = <?php echo json_encode($points); ?>;
    for(const point of points) {
        if(point['points'].length === 0) continue;
        const entry = document.getElementById(point['id']);
        
        const last_p = point['points'][point['points'].length-1];
        let prev_p = last_p;
        const canvas = document.createElement('canvas');
        canvas.width = 360;
        canvas.height = 108;
        const ctx = canvas.getContext("2d");
        ctx.fillStyle = "#ffffff";
        ctx.beginPath();
        ctx.moveTo(last_p[0], last_p[1]); // Starting point
        
        for(const p of point['points']) {
            ctx.quadraticCurveTo(p[0], p[1], (prev_p[0] + p[0]) / 2, (prev_p[1] + p[1]) / 2); // Two control points, one end point
            prev_p = p;
        }
        
        ctx.fill();
        const svg = entry?.querySelector('svg');
        if(svg) {
            svg.parentNode.replaceChild(canvas, svg);
        }
    }
    const entries = document.getElementsByClassName('list-entry');
    for(const entry of entries) {
        const slug = entry.getAttribute('data-slug');
        // const queryParams = 
        if(!slug) continue;
        entry.addEventListener('click', ()=>{
            window.location.href = '/essays/' + slug;
        })
    }
    let list_view = '<?php echo $list_view; ?>';
    const view_options = document.querySelectorAll('.view-option');
    for(const option of view_options) {
        option.addEventListener('click', ()=>{
            const view = option.getAttribute('data-value');
            if(view === list_view) return;
            const activeView = document.querySelector('.view-option.active');
            if(activeView) activeView.classList.remove('active');
            list_view = view;
            page.setAttribute('data-list-view', list_view);
            option.classList.add('active');
            if (history.pushState) {
                const searchParams = new URLSearchParams(window.location.search);
                searchParams.set('view', list_view);
                const newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?' + searchParams.toString();
                window.history.pushState({path:newurl},'',newurl);
            }
        });
    }
    const calendar_days = document.querySelectorAll('.day[rel]');
    // const calendar_entries = document.querySelectorAll('[data-list-type="calendar"] .essay-entry');
    for (const day of calendar_days) {
        day.addEventListener('click', ()=>{
            const active_day = document.querySelector('.day[rel].active');
            if(active_day) active_day.classList.remove('active');

            const visible_entries = document.querySelectorAll('.list[data-list-type="calendar"] .essay-entry.visible');
            for(const entry of visible_entries) {
                entry.classList.remove('visible');
            }
            const date = day.getAttribute('rel');
            const matching_entries = document.querySelectorAll('.list[data-list-type="calendar"] .essay-entry[data-date="' + date + '"]');
            if(matching_entries.length === 0) return;
            
            day.classList.add('active');
            for(const entry of matching_entries) {
                entry.classList.add('visible');
            }
        });
    }
    const searchContent = `<div class="search-bar-wrapper large-popup-section" data-empty="1"></div>
        <div class="large-popup-section">
            <div class="large-popup-section-title small bold">推薦關鍵字</div>
            <div class="tag-list" data-loading="0">
                <div class="tag reverse">春天</div>
                <div class="tag reverse">颱風</div>
                <div class="tag reverse">冰淇淋</div>
                <div class="tag reverse">螞蟻</div>
                <div class="tag reverse">滷肉飯</div>
                <div class="partial-loading-icon full-center-icon icon" data-color="black"></div>
            </div>
        </div>`;
    const searchPopup = new LargePopup({
        id: 'search-popup',
        content: searchContent,
        mount: app,
        header: {
            'left': [''],
            'title': '搜尋篇章',
            'right': ['cancel-text']
        }
    });
    const searchButton = document.querySelector('.search-icon');
    searchButton.addEventListener('click', ()=>{
        searchPopup.show();
    });
    const searchBar = new Search({
        root: '#search-popup .search-bar-wrapper',
        responsiveSection: '#search-popup .tag-list',
        onKeywordSelect: applySearchKeyword
    });

    const current_keyword = document.querySelector('.sub-header .current-keyword');
    console.log(current_keyword);
    function applySearchKeyword(keyword){
        searchPopup.hide();
        page.setAttribute('data-list-view', 'search');
        current_keyword.innerHTML = '<div class="tag removable-tag reverse">' + keyword + '</div>';
        const current_keyword_tag = current_keyword.querySelector('.tag');
        const current_list = document.querySelector('#search-result-list');
        if(keyword.toLowerCase() === 'not found')
            current_list.classList.add('no-result');
        else
            current_list.classList.remove('no-result');
        current_keyword_tag.addEventListener('click', removeSearchKeyword);
        const active_view_option = document.querySelector('.view-option.active');
        if(active_view_option) active_view_option.classList.remove('active');
        current_list.setAttribute('data-loading', 1);
        setTimeout(()=>{
            current_list.setAttribute('data-loading', 0);
        }, 2000);
        
    }
    function removeSearchKeyword(){
        current_keyword.innerHTML = '';
        page.setAttribute('data-list-view', list_view);
        const current_list = document.querySelector('.list[data-list-type="'+list_view+'"]');
        const original_view_option = document.querySelector('.view-option[data-value="'+list_view+'"]');
        console.log(original_view_option);
        if(original_view_option) original_view_option.classList.add('active');
        current_list.setAttribute('data-loading', 1);
        setTimeout(()=>{
            current_list.setAttribute('data-loading', 0);
            // page.setAttribute('data-list-view', list_view);
            
        }, 1000);
    }
</script>
<?php