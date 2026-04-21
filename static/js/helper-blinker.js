class HelperBlinker {
    constructor(wrapper, blinkImmeditately=false){
        this.wrapper = wrapper;
        this.blink_duration = 100;
    
        this.idle_max = 8000;
        this.idle_min = 2000;
        this.idle = blinkImmeditately ? 0 : getIdle(this.idle_min, this.idle_max);

        this.timer = null;
    }
    getIdle(min, max) {
        return Math.random() * (max - min) + min;
    }
    getDoubleBlink(isConsecutive){
        const rate = isConsecutive ? 0.2 : 0.5;
        return Math.random() < rate;
    }
    blink(isConsecutive=false, isStatic=false){
        this.wrapper.classList.add('blinking');
        const isDouble = this.getDoubleBlink(isConsecutive);
        
        this.timer = setTimeout(()=>{
            this.wrapper.classList.remove('blinking');
            if(isStatic) return;
            this.idle = isDouble ? 0 : this.getIdle(this.idle_min, this.idle_max);
            isConsecutive = isDouble;
            this.timer = setTimeout(()=>{
                this.blink(isConsecutive);
            }, this.idle);
            
            
        }, this.blink_duration);
    }
    start(){
        this.timer = setTimeout(()=>{
            this.blink();
        }, this.idle);
    }
    // console.log(idle);
    
}