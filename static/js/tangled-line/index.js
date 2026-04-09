// import TangledLine from './TangledLine.js'
// import Txtara from './Txtara.js'
const parent_id = 'tangled-wrapper';
const parent = document.getElementById(parent_id);
console.log(parent);
const size = {w: parent ? parent.offsetWidth : 70, h: 70};
const line_params = {
    start: {x: size.w / 2, y: size.h * 5 / 6},
    end: {x: size.w / 2, y: size.h / 6},
    center: {x: size.w / 2, y: size.h / 2},
    points: []
}
let v=0;

if(v == 1) {
  line_params['start'] = {
    x: size.w / 6, 
    y: size.h / 6
  };
  line_params['end'] = {
    x: size.w * 5 / 6, 
    y: size.h / 6
  };
  line_params['points'] = [
    line_params['start'],
    line_params['center'],
    line_params['end']
  ]
  line_params['hideLastPoint'] = false;
}
line_params['dev'] = size.w / 12;
let shapes = [];
function setup() {
  frameRate(30);
  randomSeed(2);
  const canvas = createCanvas(size.w, size.h);
  canvas.parent(parent_id);
  const line = new TangledLine(size, line_params)
  shapes.push(line);
  
  const control_container = document.getElementById('input-wrapper');
  new Txtara(control_container, line)
  draw();
}

function draw() {
  background(255);
  for (const shape of shapes)
    shape.display();
}