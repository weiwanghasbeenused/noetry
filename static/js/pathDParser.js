function parseSVGPath(d) {
                const points = [];
                const commands = d.match(/[MmLlHhVvCcSsQqTtAaZz][^MmLlHhVvCcSsQqTtAaZz]*/g) || [];
                let currentPos = { x: 0, y: 0 };

                // Define how many coordinate pairs each command expects
                const coordCounts = {
                    'M': 1, 'm': 1,
                    'L': 1, 'l': 1,
                    'H': 0, 'h': 0, // Only x value
                    'V': 0, 'v': 0, // Only y value
                    'C': 3, 'c': 3,
                    'S': 2, 's': 2,
                    'Q': 2, 'q': 2,
                    'T': 1, 't': 1,
                    'A': 0, 'a': 0, // Special handling
                    'Z': 0, 'z': 0
                };

                commands.forEach(cmd => {
                    const type = cmd[0];
                    const values = cmd.slice(1).trim().match(/-?\d*\.?\d+/g) || [];
                    const coords = [];

                    // Parse coordinates based on command type
                    const expectedPairs = coordCounts[type] || 0;

                    if (expectedPairs > 0) {
                        for (let i = 0; i < values.length; i += expectedPairs * 2) {
                            for (let j = 0; j < expectedPairs; j++) {
                                if (i + j*2 + 1 < values.length) {
                                    let x = parseFloat(values[i + j*2]);
                                    let y = parseFloat(values[i + j*2 + 1]);

                                    // Convert relative to absolute
                                    if (type === type.toLowerCase() && type !== 'z' && type !== 'Z') {
                                        x += currentPos.x;
                                        y += currentPos.y;
                                    }

                                    coords.push({ x, y, index: coords.length });
                                }
                            }
                            // Update currentPos after each set of coordinate pairs (for chained commands)
                            if (coords.length > 0) {
                                currentPos = { x: coords[coords.length - 1].x, y: coords[coords.length - 1].y };
                            }
                        }
                    }

                    // Update current position
                    if (coords.length > 0) {
                        currentPos = coords[coords.length - 1];
                    }

                    points.push({ command: type, coords });
                });

                return points;
            }

            // Add shake/vibration to points
            function shakePathPoints(pathPoints, intensity = 2) {
                return pathPoints.map(({ command, coords }) => ({
                    command,
                    coords: coords.map(coord => ({
                        x: coord.x + (Math.random() - 0.5) * intensity,
                        y: coord.y + (Math.random() - 0.5) * intensity,
                        index: coord.index
                    }))
                }));
            }

            // Convert points back to SVG path d string
            function serializeSVGPath(pathPoints) {
                let d = '';
                let currentPos = { x: 0, y: 0 };

                // Define how many coordinate pairs each command expects (for grouping chained commands)
                const coordCounts = {
                    'M': 1, 'm': 1,
                    'L': 1, 'l': 1,
                    'C': 3, 'c': 3,
                    'S': 2, 's': 2,
                    'Q': 2, 'q': 2,
                    'T': 1, 't': 1
                };

                pathPoints.forEach(({ command, coords }) => {
                    d += command;

                    const expectedPairs = coordCounts[command] || 0;
                    let subCommandStartPos = { ...currentPos };

                    coords.forEach((coord, idx) => {
                        // Every expectedPairs coordinates represent a new sub-command with a new starting point
                        if (expectedPairs > 0 && idx > 0 && idx % expectedPairs === 0) {
                            // Update the starting point for the next sub-command
                            subCommandStartPos = { x: coords[idx - 1].x, y: coords[idx - 1].y };
                        }

                        let x = coord.x;
                        let y = coord.y;

                        // For relative commands, convert back to relative coordinates
                        if (command === command.toLowerCase() && command !== 'z' && command !== 'Z') {
                            x = x - subCommandStartPos.x;
                            y = y - subCommandStartPos.y;
                        }

                        d += x.toFixed(3) + ',' + y.toFixed(3) + ' ';
                    });

                    // Update currentPos to the last coordinate of this command
                    if (coords.length > 0) {
                        currentPos = { x: coords[coords.length - 1].x, y: coords[coords.length - 1].y };
                    }
                });

                return d.trim();
            }
            
            const pathPoints = parseSVGPath(pathData);
            const originalPoints = JSON.parse(JSON.stringify(pathPoints)); // Deep copy
            console.log('Parsed path points:', pathPoints);

            // Animate with shake effect
            function animate(intensity = 1.5, interval = 80) {
                animationFrameId = setTimeout(() => {
                    const shakenPoints = shakePathPoints(originalPoints, intensity);
                    const newD = serializeSVGPath(shakenPoints);
                    helper_line.setAttribute('d', newD);
                    animate(intensity)
                }, interval);
            }

            // Test round-trip: parse and serialize without shaking
            function testRoundTrip() {
                
                console.log('=== ROUND TRIP TEST ===');
                console.log('Original d:', pathData);
                console.log('Reconstructed d:', reconstructedD);
                console.log('Match:', pathData === reconstructedD);
                helper_line.setAttribute('d', reconstructedD);

                // Print parsed points line by line
                console.log('\n=== PARSED POINTS ===');
                // originalPoints.forEach((point, idx) => {
                //     console.log(`Command ${idx}: ${point.command}`);
                //     console.log(`  Coords (${point.coords.length} pairs):`);
                //     point.coords.forEach((coord, cidx) => {
                //         console.log(`    [${cidx}] x: ${coord.x.toFixed(3)}, y: ${coord.y.toFixed(3)}`);
                //     });
                // });

                return reconstructedD;
            }
            const reconstructedD = serializeSVGPath(originalPoints);
            let status = 0;
            const paths = [
                pathData,
                reconstructedD
            ]
            helper_line.addEventListener('click', ()=>{
                console.log('click');
                status = (status + 1) % 2
                console.log(paths[status]);
                helper_line.setAttribute('d', paths[status]);
            });