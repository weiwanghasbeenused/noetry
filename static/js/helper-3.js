class Helper3 extends Helper {
    constructor(parent_id, action="rest-1") {
        super(parent_id, action);
        this.blinker = typeof HelperBlinker === 'function' ? new HelperBlinker(this.parent, true) : null;
        this.config = {
            'rest-1': {
                'size': { w: 72, h: 72 },
                'points': [
                    {
                        x: 47, y: 65
                    },
                    {
                        x: 30, y: 70
                    },
                    {
                        x: 18, y: 57
                    },
                    {
                        x: 19, y: 48
                    },
                    {
                        x: 21, y: 44
                    },
                    {
                        x: 24, y: 40
                    },
                    {
                        x: 30, y: 37
                    },
                    {
                        x: 38, y: 36
                    },
                    {
                        x: 44.5, y: 41
                    },
                    {
                        x: 43, y: 48
                    },
                    {
                        x: 40, y: 49
                    },
                    {
                        x: 36, y: 53
                    },
                    {
                        x: 30, y: 55
                    },
                    {
                        x: 27, y: 55.5
                    },
                    {
                        x: 22, y: 56
                    },
                    {
                        x: 18, y: 57
                    },
                    {
                        x: 11.5, y: 52
                    },
                    {
                        x: 10, y: 46
                    },
                    {
                        x: 16, y: 36
                    },
                    {
                        x: 22, y: 34
                    },
                    {
                        x: 26, y: 34.2
                    },
                    {
                        x: 30, y: 36
                    },
                    {
                        x: 31, y: 39
                    },
                    {
                        x: 30, y: 41
                    },
                    {
                        x: 28, y: 44
                    },
                    {
                        x: 22, y: 47
                    },
                    {
                        x: 14, y: 48
                    },
                    {
                        x: 8, y: 46
                    },
                    {
                        x: 5, y: 44
                    },
                    {
                        x: 2, y: 39
                    },
                    {
                        x: 2, y: 33
                    },
                    {
                        x: 4, y: 25
                    },
                    {
                        x: 12, y: 12
                    },
                    {
                        x: 20, y: 8
                    },
                    {
                        x: 28, y: 8.5
                    },
                    {
                        x: 31, y: 12
                    },
                    {
                        x: 31.5, y: 20
                    },
                    {
                        x: 30.5, y: 25
                    },
                    {
                        x: 28, y: 30
                    },
                    {
                        x: 25, y: 33
                    },
                    {
                        x: 21.5, y: 34
                    },
                    {
                        x: 18.5, y: 33
                    },
                    {
                        x: 16.5, y: 30
                    },
                    {
                        x: 15.5, y: 25
                    },
                    {
                        x: 16.5, y: 20
                    },
                    {
                        x: 19, y: 15
                    },
                    {
                        x: 23, y: 11.5
                    },
                    {
                        x: 26, y: 10
                    },
                    {
                        x: 30, y: 8.5
                    },
                    {
                        x: 36, y: 8
                    },
                    {
                        x: 42, y: 9.5
                    },
                    {
                        x: 44.5, y: 12
                    },
                    {
                        x: 47, y: 15
                    },
                    {
                        x: 48, y: 20
                    },
                    {
                        x: 47.2, y: 25
                    },
                    {
                        x: 46, y: 28
                    },
                    {
                        x: 43, y: 32
                    },
                    {
                        x: 41, y: 33
                    },
                    {
                        x: 39, y: 33.5
                    },
                    {
                        x: 36.5, y: 32.5
                    },
                    {
                        x: 35, y: 31
                    },
                    {
                        x: 34, y: 29
                    },
                    {
                        x: 33, y: 26
                    },
                    {
                        x: 33.2, y: 23
                    },
                    {
                        x: 33.2, y: 20
                    },
                    {
                        x: 33.5, y: 19
                    },
                    {
                        x: 34, y: 17
                    },
                    {
                        x: 36, y: 13.5
                    },
                    {
                        x: 37.5, y: 11
                    },
                    {
                        x: 39, y: 9
                    },
                    {
                        x: 42, y: 7
                    },
                    {
                        x: 46, y: 5.5
                    },
                    {
                        x: 49, y: 4.8
                    },
                    {
                        x: 53, y: 5.2
                    },
                    {
                        x: 55, y: 7
                    },
                    {
                        x: 56.5, y: 8.5
                    },
                    {
                        x: 57, y: 9.5
                    },
                    {
                        x: 58.5, y: 12
                    },
                    {
                        x: 59, y: 14
                    },
                    {
                        x: 59.2, y: 18
                    },
                    {
                        x: 58.5, y: 24.5
                    },
                    {
                        x: 58, y: 28
                    },
                    {
                        x: 56.8, y: 31
                    },
                    {
                        x: 55, y: 35
                    },
                    {
                        x: 53.5, y: 38
                    },
                    {
                        x: 52, y: 39.5
                    },
                    {
                        x: 50, y: 41
                    },
                    {
                        x: 49, y: 42
                    },
                    {
                        x: 48, y: 42.5
                    },
                    {
                        x: 46.5, y: 43
                    },
                    {
                        x: 45, y: 42
                    },
                    {
                        x: 45, y: 40
                    },
                    {
                        x: 46.4, y: 36.5
                    },
                    {
                        x: 48, y: 34.5
                    },
                    {
                        x: 50, y: 32.5
                    },
                    {
                        x: 52, y: 31
                    },
                    {
                        x: 54, y: 30
                    },
                    {
                        x: 58, y: 28
                    },
                    {
                        x: 62, y: 27
                    },
                    {
                        x: 65, y: 26
                    },
                    {
                        x: 66.5, y: 26
                    },
                    {
                        x: 68.5, y: 26.5
                    },
                    {
                        x: 70, y: 28
                    },
                    {
                        x: 70, y: 29.5
                    },
                    {
                        x: 70, y: 31
                    },
                    {
                        x: 69.5, y: 33
                    },
                    {
                        x: 69, y: 35
                    },
                    {
                        x: 67, y: 39
                    },
                    {
                        x: 65, y: 41
                    },
                    {
                        x: 62, y: 45
                    },
                    {
                        x: 59, y: 48
                    },
                    {
                        x: 56, y: 50.5
                    },
                    {
                        x: 52, y: 53.5
                    },
                    {
                        x: 47, y: 56
                    },
                    {
                        x: 44, y: 58
                    },
                    {
                        x: 42, y: 58.5
                    },
                    {
                        x: 40, y: 59
                    },
                    {
                        x: 38, y: 59.5
                    },
                    {
                        x: 35, y: 60
                    },
                    {
                        x: 32, y: 59.5
                    },
                    {
                        x: 30, y: 59
                    },
                    {
                        x: 29, y: 58
                    },
                    {
                        x: 28, y: 56.3
                    },
                    {
                        x: 27, y: 56
                    },
                    {
                        x: 27, y: 55
                    },
                    {
                        x: 27.5, y: 52
                    },
                    {
                        x: 29, y: 50.5
                    },
                    {
                        x: 31, y: 49
                    },
                    {
                        x: 33, y: 48.5
                    },
                    {
                        x: 35, y: 48
                    },
                    {
                        x: 38, y: 47.5
                    },
                    {
                        x: 42, y: 47.2
                    },
                    {
                        x: 46, y: 47.5
                    },
                    {
                        x: 48.5, y: 47.7
                    },
                    {
                        x: 50, y: 48
                    },
                    {
                        x: 54, y: 48.5
                    },
                    {
                        x: 58, y: 49
                    },
                    {
                        x: 62, y: 50.5
                    },
                    {
                        x: 64, y: 51.2
                    },
                    {
                        x: 66, y: 52
                    }
                ]
            }
        }
        this.scale = 0.8;
        this.weight = 3 * this.scale;
        this.shift_w = 1.4;
        this.grow_acc = 6;
        this.updateAction(action);
    }

    // rest() {
    //     let points = this.generatePoints(this.currentPoints);
    //     this.draw(points);
    // }

    init(){
        if (this.blinker) this.blinker.start();
        super.init();
    }
}
const parent_id = 'helper-wrapper';

const tangley = new Helper3(parent_id);

function setup() {
//   frameRate(30);
  frameRate(30);
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