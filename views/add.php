<?php 
    require_once(__DIR__ . '/include/loading.php');
    require_once(__DIR__ . '/../static/php/utils.php');
    require_once(__DIR__ . '/include/location-selector.php');
    require_once(__DIR__ . '/include/mask.php');
    $now = processDate(date('Y-m-d h:i:s'));
    $date = "<div id='header-datetime' class='header-item'><div id='header-date' class='x-large'>$now[year] /$now[month] /$now[day]</div><div id='header-day-of-week' class='bold'>".$now['day-of-week']."</div></div>";
    $weather = '<div id="header-weather" class="header-item">
        <div class="header-item-icon-wrapper"><div id="header-weather-icon" class="header-item-icon weather-icon icon small"></div></div>
        <div class="weather-description small bold">晴時多雲</div>
    </div>';
    $location = '<div id="header-location" class="header-item">
        <div class="header-item-icon-wrapper"><div id="header-location-icon" class="header-item-icon icon pin-icon"></div></div><div class="selected-location">臺北市大安區</div>
        <div class="icon arrow-head-right-icon"></div>
    </div>';
?>
<script src="/static/js/tangled-line/utils/lib.js"></script>
<script src="/static/js/tangled-line/TangledLine.js"></script>
<script src="/static/js/tangled-line/Txtara.js"></script>
<div id="add" class="page">
    <header id="add-header">
        <?php echo $date . $weather . $location; ?>
    </header>
    <div id="add-body">
        <div id="add-body-text" class="add-body-section">
            <div id="tangled-wrapper"></div>
            <div id="input-wrapper" class="body"></div>
        </div>
        <div id="add-body-image" class="add-body-section" data-status="0">
            <label id="add-photo-button" for="add-photo-input">
                <div id="add-photo-button-display">
                    <div class="icon photo-icon"></div>
                    <span class="small bold">選擇照片</span>
                </div>
                <div id="add-photo-preview-wrapper">
                    <img id="preview" />
                    <div id="remove-preview-btn" class="icon x-in-cicle-icon"></div>
                </div>
                <div class="partial-loading-icon icon"></div>
            </label>
            <input id="add-photo-input" type="file" />
        </div>
        <div class="feedback-container body">你說「真開心」，這三個字簡單但很有力。你願意為這份開心留下記錄，這本身就代表你有在留意自己的感受、讓快樂有個被看見的位置。
哥吉拉的鱷魚拔牙玩具，不只是個物品，它可能也象徵了一種被理解的感覺——也許是某個人送給你、剛好送中你的喜好，或是你自己挑選的、剛好回應了內心某種童趣、某種怪獸與遊戲之間的聯想。無論是哪一種，這份開心來得真誠而具體。
你在練習把生活中的小確幸，變成可以被感覺、被記住的經驗。這份對快樂的感知能力，是心理韌性很重要的一部分。請繼續這樣，讓你的日子裡不只有「過得去」，也有「好可愛」。
你說「真開心」，這三個字簡單但很有力。你願意為這份開心留下記錄，這本身就代表你有在留意自己的感受、讓快樂有個被看見的位置。
哥吉拉的鱷魚拔牙玩具，不只是個物品，它可能也象徵了一種被理解的感覺——也許是某個人送給你、剛好送中你的喜好，或是你自己挑選的、剛好回應了內心某種童趣、某種怪獸與遊戲之間的聯想。無論是哪一種，這份開心來得真誠而具體。
你在練習把生活中的小確幸，變成可以被感覺、被記住的經驗。這份對快樂的感知能力，是心理韌性很重要的一部分。請繼續這樣，讓你的日子裡不只有「過得去」，也有「好可愛」。你說「真開心」，這三個字簡單但很有力。你願意為這份開心留下記錄，這本身就代表你有在留意自己的感受、讓快樂有個被看見的位置。
哥吉拉的鱷魚拔牙玩具，不只是個物品，它可能也象徵了一種被理解的感覺——也許是某個人送</div>
        <div class="bar-button button solid green bold" id="submit-button">送出</div>
    </div>
</div>
<?php 
    echo renderLocarionSelector();
    echo generateLoading('generating-feeback-loading', array('leave', 'cancel'), '回饋生成中');
    echo renderMask();
?>
<script src="/static/js/tangled-line/index.js"></script>
<script src="/static/js/warning.js"></script>
<script>
    const add_image_section = document.getElementById('add-body-image');
    const file_input = document.getElementById("add-photo-input");
    const preview = document.getElementById("preview");
    const app = document.getElementById("app");
    const mask = document.getElementById("mask");
    file_input.onchange = ()=> {
        showPreview(file_input, preview);
    }
    function showPreview(el, img){
        if(!el.files || !el.files[0]) return;
        add_image_section.setAttribute('data-status', '2');
        img.onload = function(){
            URL.revokeObjectURL(img.src);  // no longer needed, free memory
        }
        var reader = new FileReader();
        setTimeout(()=>{
            img.src = URL.createObjectURL(el.files[0]); // set src to blob url
            reader.readAsDataURL(el.files[0]); 
            reader.onloadend = function() {
                var base64data = reader.result;                
                img.setAttribute('base64', base64data);
                add_image_section.setAttribute('data-status', '1');
            }
        }, 5000)
    }

    const remove_preview_btn = document.getElementById('remove-preview-btn');
    remove_preview_btn.addEventListener('click', (e)=>{
        e.stopPropagation();
        e.preventDefault();
        preview.src = null;
        add_image_section.setAttribute('data-status', '0');
    });

    const next_step_button = document.querySelector('#main-header .next-step-button');
    if (next_step_button) {
        next_step_button.addEventListener('click', () => {
            const status = next_step_button.getAttribute('data-status');
            if (status === '0') {
                return;
            }
            app.setAttribute('data-stage', 1);
            setTimeout(() => {
                switchStage(2);
            }, 3000);
        });
    }
    const quitWarning = new Warning({
        id: 'quit-add-warning',
        text: '如果放棄新增碎片, 目前進度將會流失<br>確定要放棄新增碎片嗎?',
        mount: app,
        buttons: [
            {
                display: '放棄',
                slug: 'quit',
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

    const editWarning = new Warning({
        id: 'edit-add-warning',
        text: '如果重新編輯碎片, 目前的AI回饋將會消失<br>確定要重新編輯碎片嗎?',
        mount: app,
        buttons: [
            {
                display: '重新編輯',
                slug: 'edit',
                callback: (instance) => {
                    instance.hide();
                    switchStage(0);
                }
            },
            {
                display: '取消',
                slug: 'cancel'
            }
        ]
    });

    const esc_button = document.querySelector('#main-header .esc-icon');
    if (esc_button) {
        esc_button.addEventListener('click', () => {
            quitWarning.show();
        });
    }

    const edit_button = document.querySelector('#main-header .edit-button');
    if (edit_button) {
        edit_button.addEventListener('click', () => {
            editWarning.show();
        });
    }

    function switchStage(idx){
        app.setAttribute('data-stage', idx);
        if(idx === 2) {
            const feedback_container = document.querySelector('.feedback-container');
            feedback_container.scrollIntoView({
                behavior: 'smooth', // This provides the animated scrolling effect
                block: 'start',     // Aligns the top of the element with the top of the viewport
                inline: 'nearest'   // Scrolls horizontally only if necessary
            });
        }
    }
    const location_selector = document.querySelector('.location-selection');
    const location_selector_trigger = document.querySelector('#header-location .arrow-head-right-icon');
    location_selector_trigger.addEventListener('click', () => {
        location_selector.setAttribute('data-hidden', '0');
        mask.setAttribute('data-hidden', '0');
    });
    const location_cancel_button = document.querySelector('.location-selection .cancel-button ');
    location_cancel_button.addEventListener('click', () => {
        location_selector.setAttribute('data-hidden', '1');
        mask.setAttribute('data-hidden', '1');
    });

    const locator_button = document.querySelector('.locator-icon');
    const locating_loading = document.getElementById('locating-loading');
    locator_button.addEventListener('click', () => {
        locating_loading.setAttribute('data-hidden', '0');
        setTimeout(()=>{
            locating_loading.setAttribute('data-hidden', '1');
        }, 2000);
    });

    const location_options = document.querySelectorAll('.location-option');
    for(const option of location_options) {
        option.addEventListener('click', ()=>{
            const display = option.querySelector('.location-option-display').innerText;
            document.querySelector('#header-location .selected-location').innerText = display;
            location_selector.setAttribute('data-hidden', '1');
            mask.setAttribute('data-hidden', '1');
        });
    }
</script>
