class Helper1 extends Helper {
    constructor(parent_id, animation=0, action='rest-1') {
        super(parent_id, animation, action);
        this.blinker = typeof HelperBlinker === 'function' ? new HelperBlinker(this.parent, true) : null;
        this.config = {
            'rest-1': {
                'size': { w: 60, h: 32 },
                'position': { x: -7, y: 0},
                'points': [
                    {"x":1.5,"y":20},{"x":6,"y":13},{"x":10,"y":10},{"x":14,"y":8},
                    {"x":18,"y":7},{"x":23,"y":8},{"x":25,"y":9.5},{"x":27,"y":12},
                    {"x":28.5,"y":15},{"x":28.5,"y":20},{"x":27.5,"y":23},{"x":26.5,"y":25},
                    {"x":25,"y":27},{"x":23.5,"y":28},{"x":22,"y":28},{"x":21,"y":26},
                    {"x":20.5,"y":25.5},{"x":20.8,"y":24},{"x":21,"y":22},{"x":22,"y":19},
                    {"x":24,"y":15},{"x":27,"y":11},{"x":30,"y":9},{"x":33,"y":7},
                    {"x":37,"y":6},{"x":40,"y":5.5},{"x":43,"y":6},{"x":45.4,"y":7},
                    {"x":47,"y":8.7},{"x":49,"y":10},{"x":50,"y":13.5},{"x":50.5,"y":16},
                    {"x":50,"y":19},{"x":49.5,"y":20},{"x":48.8,"y":21},{"x":48.6,"y":22},
                    {"x":48,"y":22.2},{"x":47.5,"y":23.5},{"x":46,"y":23},{"x":45.4,"y":22.3},
                    {"x":44.5,"y":21.5},{"x":44.5,"y":19},{"x":44.8,"y":17},{"x":46,"y":14},
                    {"x":48,"y":11},{"x":50.5,"y":8.5},{"x":53,"y":7.3},{"x":55,"y":6},
                    {"x":57,"y":5.5},{"x":59,"y":5}
                ]
            }
        }
        this.updateAction(action);

        if(this.animation === 0) {
            this.staticGrow(()=>{
                this.init();
            })
            
        }
            
    }
    staticGrow(cb){
        const duration = 500;
        const path = this.parent.querySelector('path');
        const length = path.getTotalLength();

        // Setup initial state
        path.style.strokeDasharray = length;
        path.style.strokeDashoffset = length;

        // Trigger animation (via CSS transition or JS)
        path.getBoundingClientRect(); // Trigger reflow
        path.style.transition = `stroke-dashoffset ${duration}ms ease-in-out`;
        path.style.strokeDashoffset = '0';
        if( typeof cb === 'function' ) {
            setTimeout(()=>{
                cb();
            }, duration);
        }
    }
    init(){
        if (this.blinker) this.blinker.start();
        super.init();
    }
}
const parent_id = 'helper-wrapper';

const tangley = new Helper1(parent_id, helper_animation);

function setup() {
  frameRate(40);
  randomSeed(2);
  const canvas = createCanvas(tangley.currentSize.w, tangley.currentSize.h, P2D, true);
  canvas.parent(tangley.parent_id);
  tangley.setCanvas(canvas.elt);
  if(this.animation !== 0)
    draw();
}

function draw() {
    clear();
    // background(255, 255, 0, 100);
    
    tangley.animate(frameCount);
}