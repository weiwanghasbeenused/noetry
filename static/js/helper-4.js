class Helper{
    constructor(parent_id){
        this.parent_id = parent_id;
        this.parent = document.getElementById(parent_id);
        this.blinker = typeof HelperBlinker === 'function' ? new HelperBlinker(this.parent, true) : null;
        this.padding = 0;
        this.sizes = {
            'rest-1':{
                w: 72, h:72
            }
        }
        this.scale = 0.8;
        this.points = {
            'rest-1': [
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
        this.currentStatus = 'rest-1';
        this.currentSize = this.applyScaleToSize(this.sizes[this.currentStatus]);
        this.currentPoints = this.applyScaleToPoints(this.points[this.currentStatus]);
        this.pointCount = this.currentPoints.length;
        this.weight = 3 * this.scale;
        this.center = {
            x: this.currentSize.w / 2,
            y: this.currentSize.h / 2
        }
        this.initialized = false;
    }

    draw(points){
        stroke('#0a774b');
        strokeWeight(this.weight);
        noFill();
        beginShape();
        vertex(points[0].x, points[0].y);
        for (let i = 1; i < points.length - 1; i++) {
            const p1 = points[i];
            const p2 = points[i + 1];
            const mid = {
                x: (p1.x + p2.x) / 2,
                y: (p1.y + p2.y) / 2,
            };
            quadraticVertex(p1.x, p1.y, mid.x, mid.y);
        }
        const last = points[points.length - 1];
        vertex(last.x, last.y);
        endShape();
    }
    pickRandomPointOnCurve(center, bias=0.5) {
        // Pick a random segment (not the last one)
        if(this.currentPoints.length < 3) return { x: (this.start.x + this.end.x) / 2, y: (this.start.y + this.end.y) / 2 };
        const i = floor(random(1, this.currentPoints.length - 1));
        const A = this.currentPoints[i - 1];
        const B = this.currentPoints[i];
        const C = {
            x: (this.currentPoints[i].x + this.currentPoints[i + 1].x) / 2,
            y: (this.currentPoints[i].y + this.currentPoints[i + 1].y) / 2,
        };
        // Pick a random t in (0,1)
        const t = random();

        // Quadratic Bézier formula
        const x = (1 - t) * (1 - t) * A.x + 2 * (1 - t) * t * B.x + t * t * C.x;
        let y = (1 - t) * (1 - t) * A.y + 2 * (1 - t) * t * B.y + t * t * C.y;
        y = lerp(y, this.center.y, bias);
        return {x, y};
    }
    shiftPoint(prev, y_bias=0.5){
        let w = 1.4;
        let x = prev.x + (Math.random() - 0.5) * w;
        let y = prev.y + (Math.random() - y_bias) * w;
        if(y > height - this.padding) y = height - this.padding;
        else if(y < 0) y = this.padding;
        return {x, y};
    }
    generatePoints(points){
        const output = [];
        let count = points.length;
        let direction_x = (Math.random() - 0.5);
        let direction_y = -1;
        const r = 1.5;
        for (let i = 0; i < count; i++) {
            if(i < count) {
                let point = this.shiftPoint(points[i]);
                output.push(point);
            } else {
                const bias = approachN(count, 0.1, 0.2);
                const new_point = this.pickRandomPointOnCurve(this.center, bias);
                output.push(new_point);
            }
            direction_x *= -1;
            direction_y *= -1;
        }

        // if(!this.hideLastPoint) output.push(this.end);
        return output;
    }
    applyScaleToSize(original){
        return {
            'w': original.w * this.scale,
            'h': original.h * this.scale
        };
    }
    applyScaleToPoints(original){
        return original.map((item)=>{
            return {
                x: item.x * this.scale,
                y: item.y * this.scale
            };
        });
    }
    rest(){
        let points = this.generatePoints(this.currentPoints);
        this.draw(points);
        // this.draw(this.currentPoints);
    }
    grow(idx=0){
        idx = idx + 1;
        let points = this.generatePoints(this.applyScaleToPoints(this.points[this.currentStatus].slice(0, idx)));
        this.draw(points);
        if(idx >= this.pointCount) {
            this.init()
            
            return;
        }
    }
    animate(count){
        if(!this.initialized) {
            this.grow(count * 6);
        } else {
            frameRate(10);
            this.rest();
        }
    }
    init(){
        if(this.blinker ) this.blinker.start();
        openHelperMessage();
        this.parent.classList.remove('initializing');
        this.initialized = true; 
    }
}
const parent_id = 'helper-wrapper';

const tangley = new Helper(parent_id);

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