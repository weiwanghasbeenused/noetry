class Helper1 extends Helper {
    constructor(parent_id, action='rest-1') {
        super(parent_id, action);
        this.blinker = typeof HelperBlinker === 'function' ? new HelperBlinker(this.parent, true) : null;
        this.config = {
            'rest-1': {
                'size': { w: 60, h: 60 },
                'points': [
                    { x: 1.5, y: 30 }, { x: 6, y: 23 }, { x: 10, y: 20 }, { x: 14, y: 18 },
                    { x: 18, y: 17 }, { x: 23, y: 18 }, { x: 25, y: 19.5 }, { x: 27, y: 22 },
                    { x: 28.5, y: 25 }, { x: 28.5, y: 30 }, { x: 27.5, y: 33 }, { x: 26.5, y: 35 },
                    { x: 25, y: 37 }, { x: 23.5, y: 38 }, { x: 22, y: 38 }, { x: 21, y: 36 },
                    { x: 20.5, y: 35.5 }, { x: 20.8, y: 34 }, { x: 21, y: 32 }, { x: 22, y: 29 },
                    { x: 24, y: 25 }, { x: 27, y: 21 }, { x: 30, y: 19 }, { x: 33, y: 17 },
                    { x: 37, y: 16 }, { x: 40, y: 15.5 }, { x: 43, y: 16 }, { x: 45.4, y: 17 },
                    { x: 47, y: 18.7 }, { x: 49, y: 20 }, { x: 50, y: 23.5 }, { x: 50.5, y: 26 },
                    { x: 50, y: 29 }, { x: 49.5, y: 30 }, { x: 48.8, y: 31 }, { x: 48.6, y: 32 },
                    { x: 48, y: 32.2 }, { x: 47.5, y: 33.5 }, { x: 46, y: 33 }, { x: 45.4, y: 32.3 },
                    { x: 44.5, y: 31.5 }, { x: 44.5, y: 29 }, { x: 44.8, y: 27 }, { x: 46, y: 24 },
                    { x: 48, y: 21 }, { x: 50.5, y: 18.5 }, { x: 53, y: 17.3 }, { x: 55, y: 16 },
                    { x: 57, y: 15.5 }, { x: 59, y: 15 }
                ]
            }
        }
        this.updateAction(action);
    }
    init(){
        if (this.blinker) this.blinker.start();
        super.init();
    }
}
const parent_id = 'helper-wrapper';

const tangley = new Helper1(parent_id);

function setup() {
  frameRate(40);
//   frameRate(10);
  randomSeed(2);
  const canvas = createCanvas(tangley.currentSize.w, tangley.currentSize.h, P2D, true);
  canvas.parent(tangley.parent_id);
  draw();
}

function draw() {
    // background(255, 255, 0);
    clear();
    tangley.animate(frameCount);
}