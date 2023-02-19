<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SVG Plots</title>
    <link href="https://fonts.googleapis.com/css?family=Abel" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Abel:400,400i,700,700i"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto+Condensed:400,400i,700,700i"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,700i"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Anonymous+Pro:400,400i,700,700i"/>

</head>
<style>
    .svg-chart-title {font-family: Abel; font-weight: bold; font-size: large}
    .svg-legend-title {font-family: Abel; font-weight: bold; font-size: smaller; text-transform: capitalize}
    .svg-legend-entry {font-family: Abel; font-weight: bold; font-size: x-small; text-transform: capitalize}
</style>
<body>

<?php

function getSubBurstBands($level, $bandwidth, $num_elements): string
{

	$band_width = $level * $bandwidth;
	$bandangle = 180 / $num_elements;
	$outer_bandwidth = $band_width + $bandwidth;
	$bands = "";
	$fill_colors = array("red", "green", "orange");
	if ($num_elements === 1) {
		$fill_color = $fill_colors[array_rand($fill_colors)];
		$circle_fill = '<circle  cx="0" cy="0" r="' . ($band_width + 0.5 * $bandwidth) . '" fill="transparent" stroke="' . $fill_color . '" stroke-width="' . $bandwidth . '" ></circle>' . PHP_EOL;
		$inner_circle = '<circle  cx="0" cy="0" r="' . $band_width . '" fill="transparent" stroke="black" stroke-width="1" ></circle>' . PHP_EOL;
		$outer_circle = '<circle  cx="0" cy="0" r="' . ($band_width + $bandwidth) . '" fill="transparent" stroke="black" stroke-width="1" ></circle>' . PHP_EOL;
		$bands .= $circle_fill . $inner_circle . $outer_circle;

	} else {
		for ($i = 0; $i < $num_elements; $i++) {
			$start_angle = $bandangle * $i;
			$band_angle = $start_angle + $bandangle;
			$start_point_arc1_x = round(cos((360 - $start_angle) / 360 * 2 * M_PI) * $band_width);
			$start_point_arc1_y = round(sin((360 - $start_angle) / 360 * 2 * M_PI) * $band_width);

			$end_point_arc1_x = round(cos((360 - $band_angle) / 360 * 2 * M_PI) * $band_width);
			$end_point_arc1_y = round(sin((360 - $band_angle) / 360 * 2 * M_PI) * $band_width);

			$start_point_arc2_x = round(cos((360 - $band_angle) / 360 * 2 * M_PI) * ($outer_bandwidth));
			$start_point_arc2_y = round(sin((360 - $band_angle) / 360 * 2 * M_PI) * ($outer_bandwidth));

			$end_point_arc2_x = round(cos((360 - $start_angle) / 360 * 2 * M_PI) * ($outer_bandwidth));
			$end_point_arc2_y = round(sin((360 - $start_angle) / 360 * 2 * M_PI) * ($outer_bandwidth));

			$flip = $bandangle > 180 ? 1 : 0;
			$path = "M $start_point_arc1_x $start_point_arc1_y 
         A $band_width $band_width 0 $flip 0 $end_point_arc1_x $end_point_arc1_y
         L $start_point_arc2_x $start_point_arc2_y
         A $outer_bandwidth $outer_bandwidth 0 $flip 1 $end_point_arc2_x $end_point_arc2_y Z";
			$fill_color = $fill_colors[array_rand($fill_colors)];
			$bands .= "<path d=\"$path\" stroke=\"black\" fill=\"$fill_color\" />\n";
		}
	}
	$circle_r = $bandwidth / 3;
	$circle_cx = $band_width + $bandwidth / 2;
	$text_y = $circle_r / 2;
	$font_size = 1.5 * $circle_r . "px";
	$bands .= "<circle cx=\"$circle_cx\" cy=\"0\" r=\"$circle_r\" fill='white' stroke='black' />\n";
	$bands .= "<text x='$circle_cx' y='$text_y' text-anchor='middle' style='font-size: $font_size; font-family: \"Abel\"'>$level</text>\n";
	return $bands;
}

$num_levels = 10;
$band_width = 400 / 2 / ($num_levels + 2);

$bands1 = getSubBurstBands(1, $band_width, 1);
$bands2 = getSubBurstBands(2, $band_width, 8);
$bands3 = getSubBurstBands(3, $band_width, 1);
$bands4 = getSubBurstBands(4, $band_width, 18);
$bands5 = getSubBurstBands(5, $band_width, 30);
$bands6 = getSubBurstBands(6, $band_width, 50);
$bands7 = getSubBurstBands(7, $band_width, 50);
$bands8 = getSubBurstBands(8, $band_width, 50);
$bands9 = getSubBurstBands(9, $band_width, 100);
$bands10 = getSubBurstBands(10, $band_width, 150);

?>


<svg viewBox="0 0 500 375" xmlns="http://www.w3.org/2000/svg" width="800px" height="600px">
    <!-- Simple rectangle -->
    <rect x="2" y="2" width="90%" height="90%" rx="15" stroke="black" fill="none"/>
    <!-- move the origin to the center of the plot -->
    <!-- band with: 50 -->
    <text class="svg-chart-title" text-anchor="left" x="20" y="35">Sector Overview</text>
    <g id="legend" transform="translate(300, 90)">
        <text class="svg-legend-title"  text-anchor="left" x="0" y="0">Legend</text>
    </g>
    <g id="sector" transform="translate(300, 230)" visibility="hidden">
        <text class="svg-legend-title"  text-anchor="left" x="0" y="0">Sector Details</text>
        <text id="sector_name" class="svg-legend-entry"  text-anchor="left" x="0" y="20">Name: </text>
        <text id="sector_score" class="svg-legend-entry"  text-anchor="left" x="0" y="40">Score: </text>
    </g>
    <g transform="translate(150, 200)" id="sunburst">
    </g>
</svg>

<script>
    let sectors;
    fetch('./sectors.json')
        .then((response) => response.json())
        .then((json) => {
            sectors = json;
            plotSectors(sectors);
        });


    function plotSectors(sectors) {
        // svg parameters
        const svg_width = 400;
        const margin = 120;

        // get the number of sectors

        // preparing the data for plotting
        // get the number of parent sector and how many sub sectors are in each
        let parent_sectors = Array();
        for (let i = 0; i < sectors.sectors.length; i++) {
            let sector = sectors.sectors[i];
            let parent_sector_id = sector.parent_sector_id;
            if (parent_sectors[parent_sector_id]) {
                parent_sectors[parent_sector_id].count++;
                parent_sectors[parent_sector_id].sectors.push(sector);
            } else {
                parent_sectors[parent_sector_id] = {count: 1, name: sector.parent_sector_name, id: parent_sector_id, sectors:[sector]};
            }
        }
        // remove empty entries
        parent_sectors = parent_sectors.filter(n => n);

        // configure the inner segments for the parent sector
        const inner_segment_stroke_color = "white"
        const inner_segment_stroke_width = 0
        const inner_segment_width = 40
        let inner_circle_radius = (svg_width / 2) - 10 - margin;
        let outer_circle_radius = (svg_width / 2) - margin;

        // configure the outer segments for the  sector
        const outer_segment_stroke_color = "white"
        const outer_segment_stroke_width = 0
        const outer_segment_width = 40
        const num_sectors = sectors.sectors.length;
        const sector_segment_angle = 360 / num_sectors;

        // configure the legend
        const vertical_space_between_entries = 20;

        // define the color pallets to be used in drawing the graph
        const red_color_palette = ["darkred", "darksalmon", "red"];
        const green_color_palette = ["darkgreen", "darkseagreen", "green"];
        const blue_color_palette = ["darkblue", "deepskyblue", "dodgerblue"];
        const orange_color_palette = ["darkorange", "peachpuff", "orange"];
        const color_palettes = [red_color_palette, green_color_palette, blue_color_palette, orange_color_palette];

        const groupElem = initializePlotGroupElement();
        // draw the parent sector background elements

        let start_angle = 0;
        parent_sectors.forEach((parent_sector, index) => {
            // calculate the parent segment size and color
            let seq_angle = 360 / num_sectors * parent_sector.count;
            let color_palette_index = index % color_palettes.length;
            let fill_color = color_palettes[color_palette_index][0];
            // create the segment
            let segmentPath = getSegmentPathElement(start_angle, seq_angle, inner_circle_radius, inner_segment_width, fill_color, inner_segment_stroke_color, inner_segment_stroke_width);
            groupElem.appendChild(segmentPath)
            parent_sector.sectors.forEach((sector, index2)=>{
                let sector_start_angle = start_angle +  index2 * sector_segment_angle;
                let color_index = index2 % 2 == 0 ? 2 : 1
                let segmentPath = getSegmentPathElement(sector_start_angle, sector_segment_angle, outer_circle_radius,
                    outer_segment_width, color_palettes[color_palette_index][color_index], outer_segment_stroke_color, outer_segment_stroke_width,
                    true, 'showSector("' + sector.name + '", "' + (Math.round (100 * sector.score[0].average_score)).toString() + '%")');
                groupElem.appendChild(segmentPath)
                console.log(sector.score[0].average_score);
            })
            segmentPath = getSegmentPathElement(start_angle, seq_angle, inner_circle_radius, inner_segment_width+outer_segment_width/2, "none", inner_segment_stroke_color, 2);
            groupElem.appendChild(segmentPath)
            start_angle = start_angle + seq_angle;

            // draw the legend
            const legendGroup = document.getElementById("legend");
            const textElem = document.createElementNS('http://www.w3.org/2000/svg', 'text');
            textElem.setAttribute('x', (0).toString());
            textElem.setAttribute('y', (vertical_space_between_entries * (index+1)).toString());
            textElem.setAttribute('text-anchor', 'left');
            textElem.classList.add('svg-legend-entry');
            textElem.setAttribute('fill', fill_color );
            textElem.innerHTML = parent_sector.name;
            console.log(legendGroup)
            legendGroup.appendChild(textElem);
        });

    }

    function showSector(name, score){
        console.log(name);
        const sectorDetailElem = document.getElementById('sector');
        sectorDetailElem.setAttribute('visibility', 'visible');
        const sectorNameElem = document.getElementById('sector_name');
        sectorNameElem.innerHTML = "Name: " + name;
        const sectorScoreElem = document.getElementById('sector_score');
        sectorScoreElem.innerHTML = "Score: " + score;
    }
    function hideSector(){

        const sectorDetailElem = document.getElementById('sector');
        sectorDetailElem.setAttribute('visibility', 'hidden');
    }

    function initializePlotGroupElement() {
        const mainElem = document.getElementById('sunburst');
        const groupElem = document.createElementNS('http://www.w3.org/2000/svg', 'g');
        groupElem.setAttribute("id", "sunburst_group");
        groupElem.setAttribute("width", "100%");
        groupElem.setAttribute("height", "100%");
        // append the full band to the main group
        mainElem.appendChild(groupElem)
        return groupElem;
    }

    function getSegmentPathElement(start_angle, segment_angle, inner_circle_radius, segment_width, fill_color, segment_stroke_color, segment_stroke_width, animate = false, onShowAdditionalFunction = '', onHideAdditionalFunction = '') {
        const flip = segment_angle > 180 ? 1 : 0;
        const outer_circle_radius = inner_circle_radius + segment_width;
        const start_point_arc1_x = Math.round(Math.cos((360 - start_angle) / 360 * 2 * Math.PI) * inner_circle_radius);
        const start_point_arc1_y = Math.round(Math.sin((360 - start_angle) / 360 * 2 * Math.PI) * inner_circle_radius);

        const end_point_arc1_x = Math.round(Math.cos((360 - start_angle - segment_angle) / 360 * 2 * Math.PI) * inner_circle_radius);
        const end_point_arc1_y = Math.round(Math.sin((360 - start_angle - segment_angle) / 360 * 2 * Math.PI) * inner_circle_radius);

        const start_point_arc2_x = Math.round(Math.cos((360 - start_angle - segment_angle) / 360 * 2 * Math.PI) * (outer_circle_radius));
        const start_point_arc2_y = Math.round(Math.sin((360 - start_angle - segment_angle) / 360 * 2 * Math.PI) * (outer_circle_radius));

        const end_point_arc2_x = Math.round(Math.cos((360 - start_angle) / 360 * 2 * Math.PI) * (outer_circle_radius));
        const end_point_arc2_y = Math.round(Math.sin((360 - start_angle) / 360 * 2 * Math.PI) * (outer_circle_radius));

        const path =
            "M " + start_point_arc1_x + " " + start_point_arc1_y +
            " A " + (inner_circle_radius) + " " + (inner_circle_radius) + " 0 " + flip + " 0 " + end_point_arc1_x + " " + end_point_arc1_y + " " +
            " L " + start_point_arc2_x + " " + start_point_arc2_y + " " +
            " A " + (outer_circle_radius) + " " + (outer_circle_radius) + " 0 " + flip + " 1 " + end_point_arc2_x + " " + end_point_arc2_y + " Z";
        // add a path element to the svg
        const pathElem = document.createElementNS('http://www.w3.org/2000/svg', 'path');
        pathElem.setAttribute('d', path);
        pathElem.setAttribute('stroke', segment_stroke_color);
        pathElem.setAttribute('stroke-width', segment_stroke_width);
        pathElem.setAttribute('fill', fill_color);
        if (animate) {
            pathElem.setAttribute('onclick', 'this.setAttribute("transform", "scale(1.05, 1.05)");');
            pathElem.setAttribute('onmouseover', 'this.setAttribute("transform", "scale(1.05, 1.05)");showSector("name", 0.6);' + onShowAdditionalFunction + ';');
            pathElem.setAttribute('onmouseout', 'this.setAttribute("transform", "scale(1, 1)"); hideSector();' + onHideAdditionalFunction + ';');
        }

        return pathElem;
    }

    function getSubBurstBands(level, bandwidth, num_elements, full = true, upper = true, segment_span = []) {
        const gap_between_band = 0;
        const inner_circle_radius = level * bandwidth;
        const bandangle = (full ? 360 : 180) / num_elements;
        const outer_bandwidth = inner_circle_radius + bandwidth - gap_between_band;
        const fill_colors = ["red", "green", "orange"];
        const segment_stroke_color = 'white';
        const segment_stroke_width = 4;


        const mainElem = document.getElementById('sunburst');
        const groupElem = document.createElementNS('http://www.w3.org/2000/svg', 'g');
        groupElem.setAttribute("id", "sunburst_group");
        // append the full band to the main group
        mainElem.appendChild(groupElem)


        if ((full && num_elements == 1)) {
            // if there is only one element in this level. Create a circle element with a width of bandwidth
            let fill_color = fill_colors[Math.floor(Math.random() * fill_colors.length)];
            // convert to creating
            const circleFillElem = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
            circleFillElem.setAttribute('cx', '0');
            circleFillElem.setAttribute('cy', '0');
            circleFillElem.setAttribute('r', (inner_circle_radius + 0.5 * bandwidth - 0.5 * gap_between_band).toString());
            circleFillElem.setAttribute('stroke', fill_color);
            circleFillElem.setAttribute('stroke-width', bandwidth - gap_between_band);
            circleFillElem.setAttribute('fill', 'transparent');
            groupElem.appendChild(circleFillElem);

            const circleOuterElem = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
            circleOuterElem.setAttribute('cx', '0');
            circleOuterElem.setAttribute('cy', '0');
            circleOuterElem.setAttribute('r', (inner_circle_radius + bandwidth - gap_between_band).toString());
            circleOuterElem.setAttribute('stroke', segment_stroke_color);
            circleOuterElem.setAttribute('stroke-width', segment_stroke_width);
            circleOuterElem.setAttribute('fill', 'transparent');
            groupElem.appendChild(circleOuterElem);

            const circleInnerElem = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
            circleInnerElem.setAttribute('cx', '0');
            circleInnerElem.setAttribute('cy', '0');
            circleInnerElem.setAttribute('r', (inner_circle_radius).toString());
            circleInnerElem.setAttribute('stroke', segment_stroke_color);
            circleInnerElem.setAttribute('stroke-width', segment_stroke_width);
            circleInnerElem.setAttribute('fill', 'transparent');
            groupElem.appendChild(circleInnerElem);

        } else {
            let span = 0;
            for (let i = 0; i < num_elements; i++) {
                let scale = 1
                if (segment_span.length > 0 && segment_span.length >= i) {
                    span = segment_span[i];
                }
                const start_angle = bandangle * i * scale + ((full || upper) ? 0 : 180);
                let fill_color = fill_colors[Math.floor(Math.random() * fill_colors.length)];

                const newPathElem = getSegmentPathElement(start_angle, bandangle, inner_circle_radius, bandwidth, fill_color, segment_stroke_color, segment_stroke_width);
                groupElem.appendChild(newPathElem);
            }
        }

        let levelGroupingElem = document.getElementById('level_labels');
        if (!levelGroupingElem) {
            levelGroupingElem = document.createElementNS('http://www.w3.org/2000/svg', 'g');
            levelGroupingElem.setAttribute("id", "level_labels");
            mainElem.appendChild(levelGroupingElem);
        }


        const circle_r = bandwidth / 3;
        const circle_cx = inner_circle_radius + bandwidth / 2;
        const text_y = circle_r / 2;
        const font_size = 1.5 * circle_r + "px";
        const style = "font-size: " + font_size + "; font-family: 'Abel'";
        // add circle element element
        const circleElem = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
        circleElem.setAttribute('cx', circle_cx.toString());
        circleElem.setAttribute('cy', '0');
        circleElem.setAttribute('r', circle_r.toString());
        circleElem.setAttribute('stroke', 'black');
        circleElem.setAttribute('fill', 'white');
        levelGroupingElem.appendChild(circleElem);

        const textElem = document.createElementNS('http://www.w3.org/2000/svg', 'text');
        textElem.setAttribute('x', circle_cx.toString());
        textElem.setAttribute('y', text_y.toString());
        textElem.setAttribute('text-anchor', 'middle');
        textElem.setAttribute('style', style);
        textElem.innerHTML = level;
        levelGroupingElem.appendChild(textElem);

        // $bands .= "<text x='$circle_cx' y='$text_y' text-anchor='middle' style='font-size: $font_size; font-family: \"Abel\"'>$level</text>\n";

        console.log('ending');
    }

    const num_levels_inner = 3;
    const band_width_inner = 400 / 2 / (num_levels_inner + 2);
    // getSubBurstBands(2, band_width_inner + 2, 4, true, true);
    //
    // const num_levels = 5;
    // const band_width = 400 / 2 / (num_levels + 2);
    // getSubBurstBands(1, band_width, 1, false, true);
    // getSubBurstBands(2, band_width, 6, false, true);
    // getSubBurstBands(3, band_width, 20, true, true);
    // getSubBurstBands(4, band_width, 1, false, true);
    // getSubBurstBands(5, band_width, 20, false, true);
    // getSubBurstBands(6, band_width, 19, false, true);
    // getSubBurstBands(7, band_width, 40, false, true);
    // getSubBurstBands(8, band_width, 20, false, true);
    // getSubBurstBands(9, band_width, 15, false, true);


    // getSubBurstBands(1, band_width, 1, false, false);
    // getSubBurstBands(2, band_width, 6, false, false);
    // getSubBurstBands(3, band_width, 20, false, false);
    // getSubBurstBands(4, band_width, 1, false, false);
    // getSubBurstBands(5, band_width, 20, false, false);
    // getSubBurstBands(6, band_width, 19, false, false);

</script>


</body>
</html>