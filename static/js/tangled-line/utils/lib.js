function approachN(pointCount, i, n) {
  // n: the value to approach as pointCount increases
  // k: controls how fast the function approaches n (higher k = slower approach)
  const k = 0.01;
  return n - (n - i) * Math.exp(-k * (pointCount - 2));
}