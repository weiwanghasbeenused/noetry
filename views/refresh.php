<div id="refresh-icon-wrapper" class="shadow-small fixed">
    <div id="refresh-icon" data-refreshing="0"><img src="/media/svg/refresh.svg" /></div>
</div>
<div id="refresh" class="page">
    <div id="content" class="body medium">
        *下拉以更新*
        <!-- (內容) -->
        
        <div id="stat" class="content-row">
            <div class="stat-row">refresh - <span id="refresh-counter-tracker">0</span></div>
            
            <!-- <div class="stat-row">觸控移動距離: <span id="touch-distance-tracker">0</span>px</div>
            <div class="stat-row">Content 移動距離 (觸控 / 2.5): <span id="content-distance-tracker">0</span>px</div> -->
        </div>
        陰影、icon 動畫都跟 default 稍有不同<br>
        如果太麻煩就用default, 換個 icon 就好 (refresh.svg)
        <!-- <br> -->
        <!-- <div>- Content 移動距離 > 72px (觸控移動距離 180px) 才會觸發更新</div>
        <div>- Refreshing 時, content 彈回 72px 處等 refresh 結束</div> -->
    </div>
</div>
<script>
    
    class Refresher{
        constructor(target){
            this.target = target;
            this.target.classList.add('refresh-target');
            this.touchStartY = 0;
            this.touchDistance = 0;
            this.confirmDistance = document.getElementById('refresh-icon').offsetHeight + 10;
            this.distance_weight = 1 / 2.5;
            this.contentDistance = this.touchDistance * this.distance_weight;
            this.handleTouchStart = this.handleTouchStart.bind(this);
            this.handleTouchMove = this.handleTouchMove.bind(this);
            this.handleTouchEnd = this.handleTouchEnd.bind(this);
            this.timer = null;
            this.transitionDuration = 0;
            this.refreshDuration = 3000;
            this.icon_wrapper = null;
            this.icon = null;
            this.isRefreshing = false;
            this.counter = 0;
            this.init()
        }
        init(){
            this.getElements();
            this.addListeners();
        }
        getElements(){
            this.icon_wrapper = document.getElementById("refresh-icon-wrapper");
            this.icon = document.getElementById("refresh-icon");
            this.counterTracker = document.getElementById("refresh-counter-tracker");
            this.touchDistanceTracker = document.getElementById("touch-distance-tracker");
            this.contentDistanceTracker = document.getElementById("content-distance-tracker");
            this.content = document.getElementById("content");
        }
        addListeners(){
            this.target.addEventListener('touchstart', this.handleTouchStart, {passive: false});
            this.target.addEventListener('touchend', this.handleTouchEnd, {passive: false});
            this.target.addEventListener('touchmove', this.handleTouchMove, {passive: false});
            
            window.addEventListener('load', ()=>{
                this.confirmDistance = document.getElementById('refresh-icon').offsetHeight + 10;
            })
        }
        handleTouchStart(e){
            if(this.isRefreshing) return;
            if(this.timer) {
                clearTimeout(this.timer);
                this.timer = null;
            }
            e.preventDefault();
            this.touchStartY = e.changedTouches[0].screenY;
        }
        handleTouchMove(e){
            e.preventDefault();
            this.touchDistance = e.changedTouches[0].screenY - this.touchStartY;
            this.contentDistance = (this.touchDistance * this.distance_weight).toFixed(1);
            this.icon_wrapper.style.marginTop = this.contentDistance + 'px';
            this.target.style.top = this.contentDistance + 'px';
            let op = this.calculateIconOpacity();
            let dg = this.calculateIconRotate();
            this.icon_wrapper.style.opacity = op;
            this.icon.style.transform = 'rotate(' + dg + 'deg)';;
            this.updateStats();
        }
        handleTouchEnd(e){
            console.log('touchend');
            e.preventDefault();
            if(this.contentDistance > this.confirmDistance) {
                this.refresh();
                // this.isRefreshing = true;
                setTimeout(()=>{
                    this.onRefreshFinish();
                }, this.refreshDuration)
            } else {
                this.resetIcon();
                // this.reset();
            }
            this.resetTarget();
        }
        refresh(){
            if(this.isRefreshing) return;
            this.isRefreshing = true;
            this.updateStats();
            this.icon_wrapper.style.marginTop = this.confirmDistance + 'px';
            this.icon.dataset.refreshing = '1';
        }
        onRefreshFinish(){
            this.isRefreshing = false;
            this.updateContent();
            this.resetIcon();
            // this.reset();
            this.icon_wrapper.style.marginTop = 0 + 'px';
        }
        resetTarget(){
            this.target.classList.add('transitioning');
            this.target.style.top = '0px';
            this.timer = setTimeout(()=>{
                this.timer = null;
                this.target.classList.remove('transitioning');
            }, this.transitionDuration);
        }
        resetIcon(){
            this.icon_wrapper.style.opacity = 0;
            this.icon.dataset.refreshing = '0';
            this.icon.style.transform = 'rotate(0deg)';
        }
        resetValues(){
            this.touchStartY = 0;
            this.touchDistance = 0;
            this.contentDistance = 0;
        }
        updateStats(){
            
            if(this.touchDistanceTracker) this.touchDistanceTracker.textContent = this.touchDistance;
            if(this.contentDistanceTracker) this.contentDistanceTracker.textContent = this.contentDistance;
        }
        updateContent(){
            this.content.classList.add('updating');
            this.counter++;
            if(this.counterTracker) this.counterTracker.textContent = this.counter;
            setTimeout(()=>{
                this.content.classList.remove('updating');
            }, 0);
        }
        calculateIconOpacity(){
            return Math.min(Math.max(((this.contentDistance) / (this.confirmDistance)), 0), 1.0);
        }
        calculateIconRotate(){
            return -1 * this.contentDistance * 6;
        }
    }
    const content = document.getElementById("content");
    const page = document.getElementById("refresh");
    new Refresher(page);
</script>