class Helper {
    constructor(parent_id, animation, action) {
        this.canvas = null;
        this.parent_id = parent_id;
        this.currentAction = action;
        this.animation = parseInt(animation);
        this.parent = document.getElementById(parent_id);
        this.padding = 0;
        this.config = {
            'rest-1': {
                'size': { w: 60, h: 60 },
                'position': {x: 'auto', y: 'auto'},
                'points': [],
            }
        }
        this.scale = 1;
        this.weight = 3 * this.scale;
        this.shift_w = 0.8;
        this.grow_acc = 2;
        this.shakeWhenRest = true;
        this.color = '#0a774b';
        this.initialized = false;
        this.status = -1;
        this.closeButtons = document.querySelectorAll('.message-close-button');
        this.addListeners();
    }
    addListeners(){
        this.parent.addEventListener('click', ()=>{
            toggleHelperMessage();
            if(this.status != 1) {
                this.on();
            } else if(this.status == 1) {
                this.off();
            }
        });
        for(const btn of this.closeButtons) {
            btn.addEventListener('click', ()=>{
                closeHelperMessage();
            });
        }
    }
    draw(points) {
        stroke(this.color);
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
    updateAction(a){
        console.log('updateAction')
        if(typeof this.config[a] == 'undefined') return;
        const config = this.config[a];
        this.currentAction = a;
        this.currentSize = this.applyScaleToSize(config['size']);
        this.currentPoints = this.applyScaleToPoints(config['points']);
        this.currentPosition = this.applyScaleToPosition(config['position']);
        this.pointCount = this.currentPoints.length;
        this.center = {
            x: this.currentSize.w / 2,
            y: this.currentSize.h / 2
        };
    }
    updateCanvasPosition(){
        console.log('updateCanvasPosition', this.canvas);
        if(!this.canvas) return;
        if(this.currentPosition.x !== 'auto')
            this.canvas.style.left = this.currentPosition.x + 'px';
        if(this.currentPosition.y !== 'auto')
            this.canvas.style.top = this.currentPosition.y + 'px';
    }
    pickRandomPointOnCurve(center, bias = 0.5) {
        if (this.currentPoints.length < 3) return { x: (this.start.x + this.end.x) / 2, y: (this.start.y + this.end.y) / 2 };
        const i = floor(random(1, this.currentPoints.length - 1));
        const A = this.currentPoints[i - 1];
        const B = this.currentPoints[i];
        const C = {
            x: (this.currentPoints[i].x + this.currentPoints[i + 1].x) / 2,
            y: (this.currentPoints[i].y + this.currentPoints[i + 1].y) / 2,
        };
        const t = random();
        const x = (1 - t) * (1 - t) * A.x + 2 * (1 - t) * t * B.x + t * t * C.x;
        let y = (1 - t) * (1 - t) * A.y + 2 * (1 - t) * t * B.y + t * t * C.y;
        y = lerp(y, this.center.y, bias);
        return { x, y };
    }

    shiftPoint(prev, y_bias = 0.5) {
        let x = prev.x + (Math.random() - 0.5) * this.shift_w;
        let y = prev.y + (Math.random() - y_bias) * this.shift_w;
        if (y > height - this.padding) y = height - this.padding;
        else if (y < 0) y = this.padding;
        return { x, y };
    }

    generatePoints(points) {
        const output = [];
        let count = points.length;
        let direction_x = (Math.random() - 0.5);
        let direction_y = -1;
        for (let i = 0; i < count; i++) {
            if (i < count) {
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
        return output;
    }

    applyScaleToSize(original) {
        return {
            'w': original.w * this.scale,
            'h': original.h * this.scale
        };
    }

    applyScaleToPoints(original) {
        return original.map((item) => {
            return {
                x: item.x * this.scale,
                y: item.y * this.scale
            };
        });
    }
    applyScaleToPosition(original) {
        return {
            x: original.x * this.scale,
            y: original.y * this.scale
        };
    }
    setCanvas(c) {
        this.canvas = c;
        this.updateCanvasPosition();
    }
    rest() {
        let points = this.shakeWhenRest ? this.generatePoints(this.currentPoints) : this.currentPoints;
        this.draw(points);
    }

    grow(idx = 0) {
        idx = idx * this.grow_acc;
        idx = idx || 1;
        let points = this.currentPoints.slice(0, idx);
        this.draw(points);
        if (idx >= this.pointCount) {
            this.init();
            return;
        }
    }

    animate(count) {
        if (!this.initialized) {
            this.grow(count);
        } else {
            frameRate(10);
            this.rest();
        }
    }
    on(){
        this.status = 1;
    }
    off(){
        this.status = 0;
    }
    init() {
        openHelperMessage();
        this.on();
        this.initialized = true;
        this.parent.classList.remove('initializing');
    }
}
