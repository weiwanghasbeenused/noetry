// import { approachN } from './utils/lib.js'

class TangledLine {
  constructor(parent_size, params) {
    this.start = params.start; 
    this.end = params.end; 
    this.center = params.center;
    this.points = params.points;
    this.curve_dev = Math.min(parent_size.w, parent_size.h) / 60;
    this.shift_dev = Math.min(parent_size.w, parent_size.h) / 60;
    this.vibrating_points = [];
    this.vibrating_step_count = 10;
    this.vibrating_step_idx = 0;
    this.vibrating_direction = 1;
    this.pointCount = this.points.length;
    this.weight = 2;
    this.isVibrating = false;
    this.initialized = false;
    this.timer = null;
    this.hideLastPoint = params.hideLastPoint ?? true;
    this.padding = Math.min(parent_size.w, parent_size.h) / 10;
    this.point_size = Math.min(parent_size.w, parent_size.h) / 10;
    this.init();
  }
  init(){
    if(this.initialized) return;
    this.points.push(this.start);
    this.points = this.generatePoints(this.points);
    this.initialized = true;
  }

  generatePoints(){
    const output = [this.start];
    let direction_x = (Math.random() - 0.5);
    let direction_y = -1;
    const r = (this.start.y - this.end.y) / 2
    for (let i = 1; i < this.pointCount - 1; i++) {
      if(i < this.points.length) {
        let y_bias = this.points[i].y - this.center.y > r ? approachN(this.points[i].y - r, 0.4, 0.8) : 0.5;
        let point = this.shiftPoint(this.points[i], y_bias);
        output.push(point);
      } else {
        const bias = approachN(this.pointCount, 0.1, 0.8);
        const new_point = this.pickRandomPointOnCurve(this.center, bias);
        output.push(new_point);
      }
      direction_x *= -1;
      direction_y *= -1;
    }

    if(!this.hideLastPoint) output.push(this.end);
    // points = points_temp;
    return output;
  }
  shiftPoint(prev, y_bias=0.5){
    let x = prev.x + (Math.random() - 0.5) * 10;
    let y = prev.y + (Math.random() - y_bias) * 10;
    if(y > height - this.padding) y = height - this.padding;
    else if(y < this.padding) y = this.padding;
    return {x, y};
  }
  drawInitialCurve(pointCount=2) {
    this.points = [];
    this.points.push(createVector(this.start.x, this.start.y));
    for (let i = 0; i < pointCount; i++) {
      const t = i / (pointCount - 1);
      const x = lerp(this.start.x, this.end.x, t) + random(-this.dev, this.dev);
      const y = lerp(this.start.y, this.end.y, t) + random(-this.dev, this.dev);
      this.points.push(createVector(x, y));
    }
    noFill();
    stroke(0);
    strokeWeight(2);

    beginShape();
    // Duplicate the first point for curveVertex padding
    curveVertex(this.start.x, this.start.y);
    curveVertex(this.start.x, this.start.y);

    for (let pt of this.points) {
      curveVertex(pt.x, pt.y);
    }

    // Duplicate the end point for smooth curve ending
    curveVertex(this.end.x, this.end.y);
    curveVertex(this.end.x, this.end.y);
    endShape();
  }
  pickRandomPointOnCurve(center, bias=0.5) {
    // Pick a random segment (not the last one)
    if(this.points.length < 3) return { x: (this.start.x + this.end.x) / 2, y: (this.start.y + this.end.y) / 2 };
    const i = floor(random(1, this.points.length - 1));
    const A = this.points[i - 1];
    const B = this.points[i];
    const C = {
      x: (this.points[i].x + this.points[i + 1].x) / 2,
      y: (this.points[i].y + this.points[i + 1].y) / 2,
    };
    // Pick a random t in (0,1)
    const t = random();

    // Quadratic Bézier formula
    const x = (1 - t) * (1 - t) * A.x + 2 * (1 - t) * t * B.x + t * t * C.x;
    let y = (1 - t) * (1 - t) * A.y + 2 * (1 - t) * t * B.y + t * t * C.y;
    y = lerp(y, this.center.y, bias);
    return {x, y};
  }
  updatePoints(count){
    // console.log('onThinking', count);
    this.pointCount = count;
    this.points = this.generatePoints();
  }
  resetVibratingPoints(){
    this.vibrating_points = [];
    this.vibrating_idx = 0;
  }
  vibrate(){
    this.isVibrating = true;
  }
  unvibrate(){
    this.isVibrating = false;
    this.resetVibratingPoints();
  }
  onThinking(count){
    this.unvibrate();
    this.updatePoints(count)
    
  }
  onPause(){
    this.vibrate();
    
  }
  display() {
    // this.drawInitialCurve();
    if(this.isVibrating) {
      frameRate(10);
      if(!this.vibrating_points.length) {
        for(let i = 0; i < this.vibrating_step_count; i++) {
          const prev_points = this.vibrating_points.length ? this.vibrating_points[this.vibrating_points.length - 1] : this.points;
          this.vibrating_points.push(this.generatePoints(prev_points));
        }
      }
      this.points = this.vibrating_points[this.vibrating_step_idx];
      if(this.vibrating_step_idx == this.vibrating_points.length - 1 || (this.vibrating_step_idx == 0 && this.vibrating_direction === -1)) {
        this.vibrating_direction *= -1
      }
      this.vibrating_step_idx = (this.vibrating_step_idx + 1 * this.vibrating_direction);
      // console.log(this.vibrating_step_idx);
      
    } else {
      frameRate(30)
    }
    // line

    stroke('#000');
    strokeWeight(this.weight);
    noFill();
    beginShape();
    vertex(this.points[0].x, this.points[0].y);
    for (let i = 1; i < this.points.length - 1; i++) {
      const p1 = this.points[i];
      const p2 = this.points[i + 1];
      const mid = {
        x: (p1.x + p2.x) / 2,
        y: (p1.y + p2.y) / 2,
      };
      quadraticVertex(p1.x, p1.y, mid.x, mid.y);
    }
    const last = this.points[this.points.length - 1];
    vertex(last.x, last.y);
    endShape();

    fill('#000');
    noStroke();
    if(!this.hideLastPoint) ellipse(last.x, last.y, this.point_size, this.point_size); // end point
    ellipse(this.points[0].x, this.points[0].y, this.point_size, this.point_size); // start point
  }
}