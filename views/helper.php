<?php
    function renderHelper($type){
        $output = '';
        if($type == 0) return $output;
        else if($type == 1) {
            $filename = 'helper-3.svg';
            $output .= '<div id="helper-left-eye" class="helper-eye"></div>
                <div id="helper-right-eye" class="helper-eye"></div>
                <div id="helper-body"></div>';
        } else if($type == 2) {
            $filename = 'helper-2.svg';
            $output .= '
            <div id="helper-body"></div>';
        }
        else if($type == 3) {
            $output .= '<div id="helper-left-eye" class="helper-eye"></div>
            <div id="helper-right-eye" class="helper-eye"></div>';
        }
        if(!$output) return $output;
        return '<div id="helper-wrapper" class="initializing" data-type="'.$type.'" data-on="-1">' . $output . '</div>';
    }
    function renderHelperMessage($messages, $index=1, $attr=[]){
        // var_dump($index);
        $output = '';
        foreach($messages as $key => $m) {
            if($key != $index) continue;
            $links = $m['links'] ? '<div class="message-link-container">' . implode('', $m['links']) . '</div>' : '';
            $cls = 'helper-message active';
            $output .= '<div class="'.$cls.'"><div class="message-body body">' . $m['body'] . '</div>' . $links . '<div class="bar-button small bold message-close-button">關閉</div></div>';
        }
        if(isset($attr['data-message-style']) && $attr['data-message-style'] == 2) {
            $output .= '<svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 168 125" preserveAspectRatio="none" overflow="visible"><polygon id="message-poly" points="" /></svg>';
        }
        $attr_str = arrayToAttr($attr);
        $output = '<div id="helper-message-wrapper" class="feedback-container" '.$attr_str.' >' . $output . '</div>';
        return $output;
    }
    function handleMessageNotes($notes){
        if($notes) {
            $output = preg_split('/\r?\n|<br\s*\/?>/i', strip_tags($notes, '<br>'));
            foreach($output as $key => $line) {
                if(!trim($line)) {
                    unset($output[$key]);
                    continue;
                }
                $output[$key] = '<div class="message-link-wrapper small bold with-icon"><a class="message-link" href="#">' . trim($line) . '<div class="icon arrow-head-right-icon" data-color="green" data-size="small"></div></a></div>';
            }
        } else
            $output = [];
        
        $output = array_values($output);
        
        return $output;
    }
    function getHelperMessages(){
        global $db;
        $sql = "SELECT o.body, o.notes 
            FROM objects o
            JOIN wires w 
                ON w.toid = o.id 
                AND w.active = 1 
            JOIN objects o_1 
                ON o_1.id = w.fromid 
                AND o_1.active = 1 
                AND o_1.name1 NOT LIKE '\.%'
                AND o_1.url = 'messages'
            JOIN wires w_1 
                ON w_1.toid = o_1.id 
                AND w_1.active = 1 
            JOIN objects o_2 
                ON o_2.id = w_1.fromid 
                AND o_2.active = 1 
                AND o_2.name1 NOT LIKE '\.%'
                AND o_2.url = 'helper'
            JOIN wires w_2 
                ON w_2.toid = o_2.id 
                AND w_2.active = 1 
                AND w_2.fromid = 0
            WHERE o.name1 NOT LIKE '\.%'";
        $result = $db->query($sql);
        $output = array();
        while($row = $result->fetch_assoc()) {
            $m = array(
                'body' => $row['body'],
                'links' => handleMessageNotes($row['notes'])
            );
            $output[] = $m;
        }
        return $output;
    }
    $helper_type = $_GET['helper-type'] ?? 1;
    $helper_message = $_GET['helper-message'] ?? 0;
    $helper_message_style = $_GET['helper-message-style'] ?? 1;
    $helper_link_style = $_GET['helper-link-style'] ?? 1;
    $demo_helper_animation = $_GET['demo-helper-animation'] ?? 0;

    $helper_html = renderHelper($helper_type);
    echo $helper_html;

    
    if($helper_html) {
        $helper_attr = [
            'data-message-style' => $helper_message_style,
            'data-link-style'    => $helper_link_style
        ];
        $messages = getHelperMessages();
        echo renderHelperMessage($messages, $helper_message, $helper_attr);
    }
    
?>
<script src="https://cdn.jsdelivr.net/npm/p5@1.9.0/lib/p5.min.js"></script>
<script src="https://unpkg.com/p5.js-svg@1.6.0"></script>
<script src="/static/js/tangled-line/utils/lib.js"></script>
<script src="/static/js/helper-blinker.js"></script>
<script>
    const message_container = document.querySelector('#helper-message-wrapper');
    const message_index = message_container.dataset.messageIndex;
    const message_style = <?php echo $helper_message_style; ?>;
    const message_in_duration = 500;
    const message_out_duration = 300;
    message_container.style.setProperty('--message-in-duration', message_in_duration + 'ms');
    message_container.style.setProperty('--message-out-duration', message_out_duration + 'ms');
    const active_message = document.querySelector('.helper-message.active');
    // active_message.classList.add('active');

    const demo_helper_animation = <?php echo $demo_helper_animation == 1 ? 'true' : 'false'; ?>;
    const wrapper = document.getElementById('helper-wrapper');
    wrapper.style.setProperty('--message-in-duration', message_in_duration + 'ms');
    wrapper.style.setProperty('--message-out-duration', message_out_duration + 'ms');
    const helper_type = <?php echo $helper_type; ?>;
    
    window.addEventListener('load', ()=>{
        message_container.style.setProperty('--active-message-height', parseFloat(active_message.offsetHeight) + 'px');
        message_container.style.setProperty('--off-w', parseFloat(message_container.offsetWidth) * 0.5 + 'px');
        message_container.style.setProperty('--off-h', parseFloat(message_container.offsetHeight) * 0.5 + 'px');
        active_message.style.setProperty('--off-w', parseFloat(message_container.offsetWidth) / 3 + 'px');
        if(message_style === 2) {
            // message_container.style.setProperty('--on-h', parseFloat(message_container.offsetHeight) + 'px');
        }
        wrapper.dataset.on = '0';
        void wrapper.offsetWidth;
        
        // setTimeout(()=>{
        //     if(helper_type != 3 && helper_type != 1) {
        //         wrapper.dataset.on = '1';
        //         wrapper.classList.remove('initializing'); 
        //     }
        // }, 0);
        
    })
    <?php if($helper_type == 1) :?>
        // const helper_blinker = new HelperBlinker(wrapper, demo_helper_animation);
        // helper_blinker.start();
        
    <?php elseif($helper_type == 3): ?>
        const helper_line = document.getElementById('helper-line');
        if(helper_line) {
            const pathData = helper_line.getAttribute('d');
            let animationFrameId = null;

            // Parse SVG path data into array of control points
            
            
            // Uncomment to test:
            // testRoundTrip();
            // animate(5);
        }

    <?endif; ?>
    if(<?php echo $helper_message_style; ?> == 1) {
        window.openHelperMessage = function() {
            if(window.helperMessageIsOpen == true) return;
            wrapper.dataset.on = '1';
            window.helperMessageIsOpen = true;
        }
        window.closeHelperMessage = function() {
            if(window.helperMessageIsOpen == false) return;
            wrapper.dataset.on = '0';
            window.helperMessageIsOpen = false;
        }
        
    }
    else if(<?php echo $helper_message_style; ?> == 2) {
        const messagePoly = document.getElementById('message-poly');
        if(messagePoly) {
            const n = 12;
            const w_begin = 40;
            const h_begin = 40;
            let animatePointsForward, animatePoints, animatePointsBackward, timer = null;
            setTimeout(() => {
                const messageContainer = document.querySelector('#helper-message-wrapper');
                const w_end = messageContainer.offsetWidth;
                const h_end = messageContainer.offsetHeight;

                // const svg = messagePoly.parentElement;
                // svg.setAttribute('viewBox', `0 0 ${w_end} ${h_end}`);

                const centerX = w_end / 2;
                const centerY = h_end / 2;
                const offsetX = w_begin / 2;
                const offsetY = h_begin / 2;

                function generateRandomPoints(count, x_min, x_max, y_min, y_max) {
                    const points = [];
                    for(let i = 0; i < count; i++) {
                        points.push([
                            x_min + Math.random() * (x_max - x_min),
                            y_min + Math.random() * (y_max - y_min)
                        ]);
                    }
                    return points;
                }

                function generateRoundedRectPoints(count, width, height, radius = 18) {
                    radius = Math.min(radius, width / 2, height / 2);
                    const perimeter = [];

                    // Top edge
                    for(let x = radius; x <= width - radius; x += 1) {
                        perimeter.push([x, radius]);
                    }

                    // Top-right corner
                    for(let angle = 0; angle <= Math.PI / 2; angle += 0.05) {
                        perimeter.push([
                            width - radius + radius * Math.cos(angle),
                            radius - radius * Math.sin(angle)
                        ]);
                    }

                    // Right edge
                    for(let y = radius; y <= height - radius; y += 1) {
                        perimeter.push([width - radius, y]);
                    }

                    // Bottom-right corner
                    for(let angle = Math.PI / 2; angle <= Math.PI; angle += 0.05) {
                        perimeter.push([
                            width - radius + radius * Math.cos(angle),
                            height - radius - radius * Math.sin(angle)
                        ]);
                    }

                    // Bottom edge
                    for(let x = width - radius; x >= radius; x -= 1) {
                        perimeter.push([x, height - radius]);
                    }

                    // Bottom-left corner
                    for(let angle = Math.PI; angle <= 3 * Math.PI / 2; angle += 0.05) {
                        perimeter.push([
                            radius + radius * Math.cos(angle),
                            height - radius - radius * Math.sin(angle)
                        ]);
                    }

                    // Left edge
                    for(let y = height - radius; y >= radius; y -= 1) {
                        perimeter.push([radius, y]);
                    }

                    // Top-left corner
                    for(let angle = 3 * Math.PI / 2; angle <= 2 * Math.PI; angle += 0.05) {
                        perimeter.push([
                            radius + radius * Math.cos(angle),
                            radius - radius * Math.sin(angle)
                        ]);
                    }

                    // Sample count points evenly from the perimeter
                    const points = [];
                    for(let i = 0; i < count; i++) {
                        const index = Math.floor(i / count * perimeter.length) % perimeter.length;
                        points.push(perimeter[index]);
                    }

                    return points;
                }

                const startConfigs = [
                    [[82.5, 60.5], [82.5, 56.5], [87.5, 57.5], [89.5, 60.5], [89.5, 63.5], [87.556, 64.472], [86.5, 66.5], [83.5, 66.5], [83.5, 68.5], [80.5, 67.5], [80.5, 64.5], [78.5, 62.5], [82.5, 60.5]],
                    [[82, 63], [82.5, 56.5], [86, 60], [91, 60], [91, 62], [90, 64], [88, 64], [88, 67], [86, 69], [83, 66], [79, 67], [79, 65], [82, 63]],
                    [[83, 60], [85, 58], [88, 59], [87, 62], [90, 66], [87, 66], [85, 65], [84, 68], [80, 67], [81, 64], [79, 62], [80, 58], [83, 60]]
                ];

                const endConfigs = [
                    [[0, 0], [38, 0], [128, 0], [168, 0], [168, 40], [168, 100], [168, 125], [140, 125], [102, 125], [39, 125], [0, 125], [0, 62.5], [0, 0]],
                    [[44, 0], [78, 0], [128, 0], [168, 0], [168, 76], [168, 125], [92, 125], [47, 125], [0, 125], [0, 82], [0, 35], [0, 0], [44, 0]],
                    [[0, 55], [0, 0], [22, 0], [63, 0], [125, 0], [168, 0], [168, 76], [168, 125], [127, 125], [75, 125], [0, 125], [0, 90], [0, 55]]
                ];
                

                function parsePoints(pointsString) {
                    return pointsString.split(' ').map(Number).reduce((pairs, num, i) => {
                        if(i % 2 === 0) pairs.push([num]);
                        else pairs[pairs.length - 1].push(num);
                        return pairs;
                    }, []);
                }

                function pointsToString(points) {
                    return points.map(p => p[0].toFixed(3) + ',' + p[1].toFixed(3)).join(' ');
                }
                let currentPoints, targetPoints
                const duration = 300;
                const frameInterval = 60;
                const frameCount = Math.ceil(duration / frameInterval);
                let currentFrame = 0;

                animatePoints = (backward=false) => {
                    console.log('backward', backward);
                    if(currentFrame > frameCount) {
                        timer = null;
                        currentFrame = 0;
                        return;
                    }

                    const progress = currentFrame / frameCount;
                    const randomIntensity = 30;
                    const animatedPoints = currentPoints.map((currentPoint, i) => {
                        const targetPoint = targetPoints[i];
                        if(!targetPoint) return currentPoint;

                        const randomX = (Math.random() - 0.5) * randomIntensity * (1 - progress);
                        const randomY = (Math.random() - 0.5) * randomIntensity * (1 - progress);

                        return [
                            currentPoint[0] + (targetPoint[0] - currentPoint[0]) * progress + randomX,
                            currentPoint[1] + (targetPoint[1] - currentPoint[1]) * progress + randomY
                        ];
                    });

                    const pointsStr = pointsToString(animatedPoints);
                    messagePoly.setAttribute('points', pointsStr);
                    currentFrame++;
                    timer = setTimeout(()=>{ animatePoints(); }, frameInterval);
                }

                animatePointsBackward = () => {
                    
                    const temp = currentPoints;
                    currentPoints = targetPoints;
                    targetPoints = temp;
                    // console.log('backward', targetPoints[0]);
                    currentFrame = 0;
                    if(timer !== null) {
                        // console.log('backward clear', targetPoints[0]);
                        clearTimeout(timer);
                        timer = null;
                    }
                    animatePoints(true);
                }
                animatePointsForward = () => {
                    // console.log('forward');
                    currentPoints = startConfigs[Math.floor(Math.random() * startConfigs.length)];
                    targetPoints = endConfigs[Math.floor(Math.random() * endConfigs.length)];
                    // console.log('forward', targetPoints[0]);
                    if(timer !== null) {
                        // console.log('forward clear', targetPoints[0]);
                        clearTimeout(timer);
                        timer = null;
                    }
                    animatePoints();
                }
                
            }, 0);
            window.openHelperMessage = function() {
                if(window.helperMessageIsOpen == true) return;
                wrapper.dataset.on = '1';
                window.helperMessageIsOpen = true;
                animatePointsForward();
            }
            window.closeHelperMessage = function() {
                if(window.helperMessageIsOpen == false) return;
                wrapper.dataset.on = '0';
                window.helperMessageIsOpen = false;
                animatePointsBackward();
            }
        }
    }
    window.toggleHelperMessage = function() {
        if(window.helperMessageIsOpen) {
            window.closeHelperMessage();
        } else {
            window.openHelperMessage();
        }
    }
    
</script>
<script src="/static/js/helper.js"></script>
<?php if($helper_type == 1 || $helper_type == 2 || $helper_type == 3): ?>
    <script src="/static/js/helper-<?php echo $helper_type?>.js"></script>
<?php endif; ?>

<style>
    
</style>