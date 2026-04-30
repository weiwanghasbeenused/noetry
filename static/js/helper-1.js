class Helper1 extends Helper {
    constructor(parent_id, animation=0, action='rest-1') {
        super(parent_id, animation, action);
        this.blinker = typeof HelperBlinker === 'function' ? new HelperBlinker(this.parent, true) : null;
        this.config = {
            'rest-1': {
                'size': { w: 60, h: 28 },
                'position': { x: -7, y: 4},
                'points': [
                    {
                        x: 1.5, y: 16.243
                    },
                    {
                        x: 14.432, y: 4.369,
                        h1x: 5.504, h1y: 9.498,
                        h2x: 9.509, h2y: 5.915
                    },
                    {
                        x: 27.826, y: 17.057,
                        h1x: 24.166, h1y: 1.311,
                        h2x: 29.356, h2y: 8.281
                    },
                    {
                        x: 20.678, y: 18.459,
                        h1x: 26.437, h1y: 25.019,
                        h2x: 19.368, h2y: 25.336
                    },
                    {
                        x: 38.618, y: 2.154,
                        h1x: 22.331, h1y: 9.781,
                        h2x: 30.641, h2y: 2.918
                    },
                    {
                        x: 49.457, y: 13.086,
                        h1x: 44.2, h1y: 1.62,
                        h2x: 50.352, h2y: 6.38
                    },
                    {
                        x: 44.075, y: 16.453,
                        h1x: 48.29, h1y: 21.828,
                        h2x: 44.013, h2y: 20.568
                    },
                    {
                        x: 58.5, y: 1.5,
                        h1x: 44.18, h1y: 9.392,
                        h2x: 49.5, h2y: 3.5
                    }
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
  frameRate(30);
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