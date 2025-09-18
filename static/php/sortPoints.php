<?php
/**
 * Sort points to form a smooth, ellipse-like polygon.
 *
 * @param array $points [[x, y], ...] (can be strings)
 * @param bool  $clockwise Sort clockwise (true) or CCW (false)
 * @param bool  $outerOnly Keep only outer boundary (farthest per angle bin)
 * @param int   $bins Number of angle bins when outerOnly is true
 * @return array Sorted points as [[x, y], ...] (floats)
 */
function sortPoints(array $points, bool $clockwise = true, bool $outerOnly = false, int $bins = 360): array
{
    if (count($points) <= 2) return $points;

    // Cast to floats and compute centroid
    $pts = [];
    $cx = 0.0; $cy = 0.0;
    foreach ($points as $p) {
        $x = (float)$p[0];
        $y = (float)$p[1];
        $pts[] = ['x' => $x, 'y' => $y];
        $cx += $x; $cy += $y;
    }
    $n = count($pts);
    $cx /= $n; $cy /= $n;

    // Attach angle (radians) and squared radius
    foreach ($pts as &$p) {
        $dx = $p['x'] - $cx;
        $dy = $p['y'] - $cy;
        $p['angle'] = atan2($dy, $dx);     // -pi..pi
        $p['r']     = $dx*$dx + $dy*$dy;   // squared distance
    }
    unset($p);

    // Optionally keep only the outer boundary by angular bins
    if ($outerOnly) {
        $binsArr = array_fill(0, $bins, null);
        foreach ($pts as $p) {
            $a = $p['angle'];
            if ($a < 0) $a += 2 * M_PI; // 0..2pi
            $idx = min($bins - 1, (int) floor($a / (2 * M_PI) * $bins));
            $cur = $binsArr[$idx];
            if ($cur === null || $p['r'] > $cur['r']) {
                $binsArr[$idx] = $p;
            }
        }
        $pts = array_values(array_filter($binsArr));
    }

    // Sort by angle; for SVG (y down), descending angle gives clockwise visually
    usort($pts, function($a, $b) use ($clockwise) {
        if ($a['angle'] == $b['angle']) {
            // Tie-breaker: farther first to avoid tiny backtracks
            if ($a['r'] == $b['r']) return 0;
            return ($a['r'] < $b['r']) ? 1 : -1;
        }
        if ($clockwise) {
            return ($a['angle'] < $b['angle']) ? 1 : -1; // descending
        }
        return ($a['angle'] < $b['angle']) ? -1 : 1;      // ascending
    });

    // Return as numeric pairs
    $out = [];
    foreach ($pts as $p) {
        $out[] = [$p['x'], $p['y']];
    }
    return $out;
}

/**
 * Convert points to SVG polygon points attribute string.
 * @param array $points [[x, y], ...]
 * @return string "x1,y1 x2,y2 ..."
 */
function svg_points_attr(array $points): string
{
    return implode(' ', array_map(function($p) {
        // Trim trailing zeros for cleaner output
        $x = rtrim(rtrim(sprintf('%.6f', $p[0]), '0'), '.');
        $y = rtrim(rtrim(sprintf('%.6f', $p[1]), '0'), '.');
        return $x . ',' . $y;
    }, $points));
}
