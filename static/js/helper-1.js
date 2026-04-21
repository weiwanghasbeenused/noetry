class Helper{
    constructor(parent_id){
        this.parent_id = parent_id;
        this.parent = document.getElementById(parent_id);
        this.blinker = typeof HelperBlinker === 'function' ? new HelperBlinker(this.parent, true) : null;
        this.padding = 0;
        this.sizes = {
            'rest-1':{
                w: 60, h:60
            }
        }
        this.scale = 1;
        this.points = {
            'rest-1': [
                {
                    x: 1.5, y: 30
                },
                
                {
                    x: 6, y: 23
                },
                {
                    x: 10, y: 20
                },
                {
                    x: 14, y: 18
                },
                {
                    x: 18, y: 17
                },
                {
                    x: 23, y: 18
                },
                {
                    x: 25, y: 19.5
                },
                {
                    x: 27, y: 22
                },
                {
                    x: 28.5, y: 25
                },
                {
                    x: 28.5, y: 30
                },
                {
                    x: 27.5, y: 33
                },
                {
                    x: 26.5, y: 35
                },
                {
                    x: 25, y: 37
                },
                {
                    x: 23.5, y: 38
                },
                {
                    x: 22, y: 38
                },
                {
                    x: 21, y: 36
                },
                {
                    x: 20.5, y: 35.5
                },
                {
                    x: 20.8, y: 34
                },
                {
                    x: 21, y: 32
                },
                {
                    x: 22, y: 29
                },
                {
                    x: 24, y: 25
                },
                {
                    x: 27, y: 21
                },
                {
                    x: 30, y: 19
                },
                {
                    x: 33, y: 17
                },
                {
                    x: 37, y: 16
                },
                {
                    x: 40, y: 15.5
                },
                {
                    x: 43, y: 16
                },
                {
                    x: 45.4, y: 17
                },
                {
                    x: 47, y: 18.7
                },
                {
                    x: 49, y: 20
                },
                {
                    x: 50, y: 23.5
                },
                {
                    x: 50.5, y: 26
                },
                {
                    x: 50, y: 29
                },
                {
                    x: 49.5, y: 30
                },
                {
                    x: 48.8, y: 31
                },
                {
                    x: 48.6, y: 32
                },
                {
                    x: 48, y: 32.2
                },
                {
                    x: 47.5, y: 33.5
                },
                {
                    x: 46, y: 33
                },
                {
                    x: 45.4, y: 32.3
                },
                {
                    x: 44.5, y: 31.5
                },
                {
                    x: 44.5, y: 29
                },
                {
                    x: 44.8, y: 27
                },
                {
                    x: 46, y: 24
                },
                {
                    x: 48, y: 21
                },
                {
                    x: 50.5, y: 18.5
                },
                {
                    x: 53, y: 17.3
                },
                {
                    x: 55, y: 16
                },
                {
                    x: 57, y: 15.5
                },
                {
                    x: 59, y: 15
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
        // stroke('#fff');
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
        let w = 0.8;
        let x = prev.x + (Math.random() - 0.5) * w;
        let y = prev.y + (Math.random() - y_bias) * w;
        if(y > height - this.padding) y = height - this.padding;
        else if(y < 0) y = this.padding;
        return {x, y};
    }
    generatePoints(){
        const output = [];
        let direction_x = (Math.random() - 0.5);
        let direction_y = -1;

        for (let i = 0; i < this.pointCount - 1; i++) {
            if(i < this.currentPoints.length) {
                let point = this.shiftPoint(this.currentPoints[i]);
                output.push(point);
            } else {
                const bias = approachN(this.pointCount, 0.1, 0.2);
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
        let points = this.generatePoints();
        this.draw(points);
        // this.draw(this.currentPoints);
    }
    grow(idx=0){
        console.log('grow', idx);
        let acc = 2;
        idx = idx * acc;
        idx = idx || 1;
        let points = this.applyScaleToPoints(this.points[this.currentStatus].slice(0, idx));
        this.draw(points);
        if(idx >= this.pointCount) {
            this.init()
            
            return;
        }
    }
    animate(count){
        if(!this.initialized) {
            console.log('growing');
            
            this.grow(count);
        } else {
            frameRate(10);
            this.rest();
        }
    }
    init(){
        if(this.blinker ) this.blinker.start();
        openHelperMessage();
        this.initialized = true; 
        this.parent.classList.remove('initializing');
    }
}
const parent_id = 'helper-wrapper';

const tangley = new Helper(parent_id);

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