<?php
    function renderHelper($type, $version=1){
        $output = '';
        if($type == 0) return $output;
        else if($type == 1) {
            if($version == 1)
                $filename = 'helper-1.svg';
            else if($version == 2)
                $filename = 'helper-1-rounded.svg';
            else return '';
            $output .= '<div id="helper-line-wrapper"><img src="/media/svg/'.$filename.'" /></div>
                <div id="helper-left-eye" class="helper-eye"></div>
                <div id="helper-right-eye" class="helper-eye"></div>
                <div id="helper-body"></div>';
        } else if($type == 2) {
            if($version == 1)
                $filename = 'helper-2.svg';
            else if($version == 2)
                $filename = 'helper-2-rounded.svg';
            else return '';
            $output .= '<div id="helper-lightbulb-wrapper"><img src="/media/svg/'.$filename.'" /></div>
            <div id="helper-body"></div>';
        }
        if(!$output) return $output;
        return '<div id="helper-wrapper" data-type="'.$type.'">' . $output . '</div>';
    }
    $helper_type = $_GET['helper-type'] ?? 0;
    $helper_version = $_GET['helper-version'] ?? 1;
    $demo_helper_animation = $_GET['demo-helper-animation'] ?? 0;

    $helper_html = renderHelper($helper_type, $helper_version);
    echo $helper_html;
?>
<script>
    const demo_helper_animation = <?php echo $demo_helper_animation == 1 ? 'true' : 'false'; ?>;
    <?php if($helper_type == 1) :?>
        function getIdle(min, max) {
            return Math.random() * (max - min) + min;
        }
        function getDoubleBlink(isConsecutive){
            const rate = isConsecutive ? 0.2 : 0.5;
            return Math.random() < rate;
        }
        function blink(isConsecutive=false, isStatic=false){
            wrapper.classList.add('blinking');
            const isDouble = getDoubleBlink(isConsecutive);
            
            setTimeout(()=>{
                wrapper.classList.remove('blinking');
                if(isStatic) return;
                let idle = isDouble ? 0 : getIdle(idle_min, idle_max);
                isConsecutive = isDouble;
                setTimeout(()=>{
                    blink(isConsecutive);
                }, idle);
                
                
            }, blink_duration);
        }
        const blink_duration = 100;
        const wrapper = document.getElementById('helper-wrapper');
        let idle_max = 8000;
        let idle_min = 2000;
        let idle = demo_helper_animation ? 0 : getIdle(idle_min, idle_max);
        console.log(idle);
        setTimeout(()=>{
            blink();
        }, idle);
        
    <?php endif; ?>
</script>


<style>
    #helper-wrapper {
        --size: 60px;
        width: var(--size);
        height: var(--size);
        position: fixed;
        z-index: 1000;
        right: 20px;
        bottom: calc(var(--nav-height) + 10px);
    }
    #helper-line-wrapper {
        position: absolute;
        top: 10%;
        left: -18%;
        width: 133%;
    }
    #helper-line-wrapper img {
        width: 100%;
    }
    #helper-body {
        background-color: #fff;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        box-shadow: 0px 0px 5px 0px rgba(0, 0, 0, 0.5);
    }
    .helper-eye {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: var(--green);
        position: absolute;
        transform-origin: bottom center;
        transition: transform 100ms;
        /* transition-timing-function: steps(4, end); */
    }
    #helper-left-eye {
        top: 30%;
        left: 18%;
    }
    #helper-right-eye {
        top: 30%;
        right: 20%;
    }
    #helper-wrapper.blinking .helper-eye {
        /* animation: blink 200ms linear forwards; */
        transform: scale(1, 0);
    }

    @keyframes blink {
        0% {
            transform: scale(1, 1);
        }
        50% {
            transform: scale(1, 0);
        }
        100% {
            transform: scale(1, 1);
        }
    }

    #helper-lightbulb-wrapper {
        width: 75%;
        position: absolute;
        /* top: 0; */
        left: 50%;
        bottom: 12px;
        transform: translate(-50%, 0);
    }
    #helper-lightbulb-wrapper img {
        display: block;
        width: 100%;
    }
</style>