class Helper2 extends Helper {
    constructor(parent_id, action="rest-1") {
        super(parent_id, action="rest-1");
        this.config = {
            'rest-1': {
                'size': { w: 40, h: 40 },
                'points': [
                    { x: 14.3, y: 30.5 }
                    , { x: 13, y: 23 }
                    , { x: 11, y: 17 }
                    , { x: 9, y: 14 }
                    , { x: 7.8, y: 13.3 }
                    , { x: 6.8, y: 13.3 }
                    , { x: 6.5, y: 14 }
                    , { x: 6.2, y: 15 }
                    , { x: 6.4, y: 16 }
                    , { x: 6.6, y: 18 }
                    , { x: 7.6, y: 20 }
                    , { x: 9.5, y: 22 }
                    , { x: 11.5, y: 24 }
                    , { x: 15, y: 23.5 }
                    , { x: 15.8, y: 22.5 }
                    , { x: 17.2, y: 20.5 }
                    , { x: 17.8, y: 18 }
                    , { x: 18.2, y: 15 }
                    , { x: 17.9, y: 12 }
                    , { x: 17.6, y: 10.5 }
                    , { x: 17.2, y: 10 }
                    , { x: 16.3, y: 9.5 }
                    , { x: 15.5, y: 10.2 }
                    , { x: 14.8, y: 11 }
                    , { x: 14.3, y: 13 }
                    , { x: 14.0, y: 15 }
                    , { x: 14.5, y: 17 }
                    , { x: 15.2, y: 19 }
                    , { x: 15.8, y: 21.3 }
                    , { x: 17.8, y: 23 }
                    , { x: 18.8, y: 23.5 }
                    , { x: 20, y: 22.8 }
                    , { x: 21.8, y: 22 }
                    , { x: 22.3, y: 21 }
                    , { x: 24, y: 19 }
                    , { x: 25.5, y: 16 }
                    , { x: 26.5, y: 13 }
                    , { x: 26.3, y: 11 }
                    , { x: 25.8, y: 8.8 }
                    , { x: 25.6, y: 8.8 }
                    , { x: 24.8, y: 9 }
                    , { x: 23.5, y: 10 }
                    , { x: 22.2, y: 12 }
                    , { x: 21.8, y: 14 }
                    , { x: 21.5, y: 17 }
                    , { x: 21.7, y: 19.5 }
                    , { x: 23, y: 22.5 }
                    , { x: 24, y: 23 }
                    , { x: 25, y: 23 }
                    , { x: 27, y: 22.5 }
                    , { x: 28.5, y: 22 }
                    , { x: 31, y: 20.2 }
                    , { x: 31.8, y: 19 }
                    , { x: 32.8, y: 17 }
                    , { x: 33.5, y: 16 }
                    , { x: 33.6, y: 14 }
                    , { x: 33.6, y: 13 }
                    , { x: 33.4, y: 11.5 }
                    , { x: 33, y: 11.2 }
                    , { x: 32, y: 11.7 }
                    , { x: 31.2, y: 12.5 }
                    , { x: 30, y: 14 }
                    , { x: 28.7, y: 16 }
                    , { x: 28, y: 18 }
                    , { x: 27, y: 20.5 }
                    , { x: 26.7, y: 23 }
                    , { x: 26, y: 25 }
                    , { x: 25.7, y: 27 }
                    , { x: 25.3, y: 30.5 }
                ]
            }
        }
        this.scale = 1;
        this.updateAction(action);
        this.weight = 2 * this.scale;
    }
    off(){
        super.off();
        this.color = '#ddd';
        this.weight = 1.5 * this.scale;
    }
    on(){
        super.on();
        this.color = '#0a774b';
        this.weight = 2 * this.scale;
    }
}
const parent_id = 'helper-wrapper';

const tangley = new Helper2(parent_id);

function setup() {
  frameRate(40);
  randomSeed(2);
  const canvas = createCanvas(tangley.currentSize.w, tangley.currentSize.h, P2D, true);
  canvas.parent(tangley.parent_id);
  draw();
}

function draw() {
    clear();
    tangley.animate(frameCount);
}