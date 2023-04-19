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
    .svg-chart-title {
        font-family: Abel;
        font-weight: bold;
        font-size: large
    }

    .svg-legend-title {
        font-family: Abel;
        font-weight: bold;
        font-size: smaller;
        text-transform: capitalize
    }

    .svg-legend-entry {
        font-family: Abel;
        font-weight: bold;
        font-size: x-small;
        text-transform: capitalize
    }
    .score-good {
        font-weight: bolder;
        color: green;
        fill: green;
    }

    .score-medium {
        font-weight: bolder;
        color: orange;
        fill: orange;

    }

    .score-bad {
        font-weight: bolder;
        color: red;
        fill: red;
    }


</style>
<body>

<?php

function getSunBurstBands($level, $bandwidth, $num_elements): string
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

$bands1 = getSunBurstBands(1, $band_width, 1);
$bands2 = getSunBurstBands(2, $band_width, 8);
$bands3 = getSunBurstBands(3, $band_width, 1);
$bands4 = getSunBurstBands(4, $band_width, 18);
$bands5 = getSunBurstBands(5, $band_width, 30);
$bands6 = getSunBurstBands(6, $band_width, 50);
$bands7 = getSunBurstBands(7, $band_width, 50);
$bands8 = getSunBurstBands(8, $band_width, 50);
$bands9 = getSunBurstBands(9, $band_width, 100);
$bands10 = getSunBurstBands(10, $band_width, 150);

?>


<svg viewBox="0 0 750 375" xmlns="http://www.w3.org/2000/svg" width="1200px" height="600px">
     Simple rectangle
    <rect x="2" y="2" width="90%" height="90%" rx="15" stroke="black" fill="none"/>
    <!-- move the origin to the center of the plot -->
    <!-- band with: 50 -->
    <text class="svg-chart-title" text-anchor="left" x="20" y="35">Sector Overview</text>
    <g id="legend" transform="translate(300, 90)">
        <text class="svg-legend-title" text-anchor="left" x="0" y="0">Legend</text>
    </g>
    <g id="sector" transform="translate(300, 230)" visibility="hidden">
        <text class="svg-legend-title" text-anchor="left" x="0" y="0">Sector Details</text>
        <text id="sector_name" class="svg-legend-entry" text-anchor="left" x="0" y="20">Name:</text>
        <text id="sector_score" class="svg-legend-entry" text-anchor="left" x="0" y="40">Score:</text>
    </g>
    <g transform="translate(150, 200)" id="sunburst">
    </g>
</svg>

<script>
    let sectors;
    fetch('./test_sectors.json')
        .then((response) => response.json())
        .then((json) => {
            sectors = json;

            sectors = {
                "sectors": [
                {
                    "company_name": "Company 83",
                    "name": "Company 83",
                    "sector_name": "Default - for testing - all certificates enabled",
                    "parent_sector_id": "0",
                    "parent_sector_name": null,
                    "jurisdiction_name": "Netherlands (the)",
                    "sector_score": "[{\"category_id\": \"0\", \"category\": \"Overall\", \"average_score\": 0.09262194877156604, \"min_score\": \"0\", \"max_score\": \"0.8117647058823529\", \"stdev_score\": \"0.1270189688396383\", \"sector_id\": \"94\", \"jurisdiction_id\": \"85\", \"num_entries\": \"89\", \"num_companies\": \"89\"}, {\"category_id\": \"1\", \"category\": \"Identity\", \"average_score\": 0.09968290199817906, \"sector_id\": \"94\", \"jurisdiction_id\": \"85\"}, {\"category_id\": \"2\", \"category\": \"IT\", \"average_score\": 0.09551721437131579, \"sector_id\": \"94\", \"jurisdiction_id\": \"85\"}, {\"category_id\": \"3\", \"category\": \"ESG\", \"average_score\": 0.07981849172359448, \"sector_id\": \"94\", \"jurisdiction_id\": \"85\"}, {\"category_id\": \"4\", \"category\": \"Financial\", \"average_score\": 0.09731437024810732, \"sector_id\": \"94\", \"jurisdiction_id\": \"85\"}, {\"category_id\": \"5\", \"category\": \"Delivery\", \"average_score\": 0.1081037479569113, \"sector_id\": \"94\", \"jurisdiction_id\": \"85\"}, {\"category_id\": \"6\", \"category\": \"Competence\", \"average_score\": 0.08235494129824489, \"sector_id\": \"94\", \"jurisdiction_id\": \"85\"}]",
                    "country_code": "NL",
                    "registration_code": "83",
                    "adres": "",
                    "street": "",
                    "street_number": "",
                    "postalcode": "",
                    "key_id": null,
                    "city": null,
                    "country": "",
                    "state": null,
                    "public_key": null,
                    "private_key": null,
                    "is_certifier": "0",
                    "is_accreditor": "0",
                    "is_authorizor": "0",
                    "trust_score": "[{\"category_id\": \"0\", \"category\": \"Overall\", \"average_score\": 0.5624651250120601, \"company_id\": \"83\"}, {\"category_id\": \"1\", \"category\": \"Identity\", \"average_score\": 0.6356253383865729, \"company_id\": \"83\"}, {\"category_id\": \"2\", \"category\": \"IT\", \"average_score\": 0.6116946399566865, \"company_id\": \"83\"}, {\"category_id\": \"3\", \"category\": \"ESG\", \"average_score\": 0.6605441256090314, \"company_id\": \"83\"}, {\"category_id\": \"4\", \"category\": \"Financial\", \"average_score\": 0.5847319977453338, \"company_id\": \"83\"}, {\"category_id\": \"5\", \"category\": \"Delivery\", \"average_score\": 0.6586355637770203, \"company_id\": \"83\"}, {\"category_id\": \"6\", \"category\": \"Competence\", \"average_score\": 0.23034518823147032, \"company_id\": \"83\"}]",
                    "company_score": "[{\"category_id\": 0, \"category\": \"Overall\", \"average_score_unweighted\": 0.8823529411764706, \"num_certificates\": 15, \"sum_weights\": 17.00, \"weighted_total\": 15, \"average_score\": 0.8823529411764706, \"company_id\": \"83\", \"next_expiry_date\": \"2023-02-23\", \"sector_id\": \"%\", \"jurisdiction_id\": \"%\", \"comment\": \"\"},{\"category_id\": 1, \"category\": \"Identity\", \"average_score_unweighted\": \"1\", \"num_certificates\": \"3\", \"sum_weights\": \"3.00\", \"weighted_total\": \"3\", \"average_score\": 1, \"company_id\": \"83\", \"next_expiry_date\": \"2023-02-23\", \"sector_id\": \"%\", \"jurisdiction_id\": \"%\", \"comment\": \"\"},{\"category_id\": 2, \"category\": \"IT\", \"average_score_unweighted\": \"1\", \"num_certificates\": \"3\", \"sum_weights\": \"3.00\", \"weighted_total\": \"3\", \"average_score\": 1, \"company_id\": \"83\", \"next_expiry_date\": \"2023-02-23\", \"sector_id\": \"%\", \"jurisdiction_id\": \"%\", \"comment\": \"\"},{\"category_id\": 3, \"category\": \"ESG\", \"average_score_unweighted\": \"1\", \"num_certificates\": \"4\", \"sum_weights\": \"4.00\", \"weighted_total\": \"4\", \"average_score\": 1, \"company_id\": \"83\", \"next_expiry_date\": \"2023-02-23\", \"sector_id\": \"%\", \"jurisdiction_id\": \"%\", \"comment\": \"\"},{\"category_id\": 4, \"category\": \"Financial\", \"average_score_unweighted\": \"1\", \"num_certificates\": \"2\", \"sum_weights\": \"2.00\", \"weighted_total\": \"2\", \"average_score\": 1, \"company_id\": \"83\", \"next_expiry_date\": \"2023-02-23\", \"sector_id\": \"%\", \"jurisdiction_id\": \"%\", \"comment\": \"\"},{\"category_id\": 5, \"category\": \"Delivery\", \"average_score_unweighted\": \"1\", \"num_certificates\": \"2\", \"sum_weights\": \"2.00\", \"weighted_total\": \"2\", \"average_score\": 1, \"company_id\": \"83\", \"next_expiry_date\": \"2023-02-23\", \"sector_id\": \"%\", \"jurisdiction_id\": \"%\", \"comment\": \"\"},{\"category_id\": 6, \"category\": \"Competence\", \"average_score_unweighted\": \"0.3333333333333333\", \"num_certificates\": \"1\", \"sum_weights\": \"3.00\", \"weighted_total\": \"1\", \"average_score\": 0.3333333333333333, \"company_id\": \"83\", \"next_expiry_date\": \"2023-02-23\", \"sector_id\": \"%\", \"jurisdiction_id\": \"%\", \"comment\": \"\"}]",
                    "supply_chain_score": "[{\"category_id\": \"0\", \"category\": \"Overall\", \"average_score\": \"0.24257730884764972\", \"company_id\": \"78\"}, {\"category_id\": \"1\", \"category\": \"Identity\", \"average_score\": \"0.2712506767731456\", \"company_id\": \"78\"}, {\"category_id\": \"2\", \"category\": \"IT\", \"average_score\": \"0.22338927991337304\", \"company_id\": \"78\"}, {\"category_id\": \"3\", \"category\": \"ESG\", \"average_score\": \"0.32108825121806284\", \"company_id\": \"78\"}, {\"category_id\": \"4\", \"category\": \"Financial\", \"average_score\": \"0.16946399549066762\", \"company_id\": \"78\"}, {\"category_id\": \"5\", \"category\": \"Delivery\", \"average_score\": \"0.3172711275540405\", \"company_id\": \"78\"}, {\"category_id\": \"6\", \"category\": \"Competence\", \"average_score\": \"0.12735704312960733\", \"company_id\": \"78\"}]",
                    "next_expiry_date": "2023-02-23",
                    "more_details": null,
                    "sector_type": "standard",
                    "id": "2",
                    "company_id": "83",
                    "sector_id": "94",
                    "jurisdiction_id": "85",
                    "company_size": "medium",
                    "date_created": "2023-02-20 14:46:53",
                    "date_last_modified": "2023-02-20 14:46:53",
                    "created_by": "mhooimei_mhooimeijer",
                    "last_modified_by": "mhooimei_mhooimeijer"
                },
                {
                    "company_name": "Company 83",
                    "name": "Company 83",
                    "sector_name": "Crop and animal production, hunting and related service activities",
                    "parent_sector_id": "3104",
                    "parent_sector_name": "AGRICULTURE, FORESTRY AND FISHING",
                    "jurisdiction_name": "Netherlands (the)",
                    "sector_score": "[{\"category_id\": \"0\", \"category\": \"Overall\", \"average_score\": 0, \"min_score\": \"0\", \"max_score\": \"0\", \"stdev_score\": \"0\", \"sector_id\": \"3105\", \"jurisdiction_id\": \"85\", \"num_entries\": \"1\", \"num_companies\": \"1\"}, {\"category_id\": \"1\", \"category\": \"Identity\", \"average_score\": 0, \"sector_id\": \"3105\", \"jurisdiction_id\": \"85\"}, {\"category_id\": \"null\", \"category\": \"null\", \"average_score\": 0, \"sector_id\": \"3105\", \"jurisdiction_id\": \"85\"}, {\"category_id\": \"null\", \"category\": \"null\", \"average_score\": 0, \"sector_id\": \"3105\", \"jurisdiction_id\": \"85\"}, {\"category_id\": \"null\", \"category\": \"null\", \"average_score\": 0, \"sector_id\": \"3105\", \"jurisdiction_id\": \"85\"}, {\"category_id\": \"null\", \"category\": \"null\", \"average_score\": 0, \"sector_id\": \"3105\", \"jurisdiction_id\": \"85\"}, {\"category_id\": \"null\", \"category\": \"null\", \"average_score\": 0, \"sector_id\": \"3105\", \"jurisdiction_id\": \"85\"}]",
                    "country_code": "NL",
                    "registration_code": "83",
                    "adres": "",
                    "street": "",
                    "street_number": "",
                    "postalcode": "",
                    "key_id": null,
                    "city": null,
                    "country": "",
                    "state": null,
                    "public_key": null,
                    "private_key": null,
                    "is_certifier": "0",
                    "is_accreditor": "0",
                    "is_authorizor": "0",
                    "trust_score": "[{\"category_id\": \"0\", \"category\": \"Overall\", \"average_score\": 0.5624651250120601, \"company_id\": \"83\"}, {\"category_id\": \"1\", \"category\": \"Identity\", \"average_score\": 0.6356253383865729, \"company_id\": \"83\"}, {\"category_id\": \"2\", \"category\": \"IT\", \"average_score\": 0.6116946399566865, \"company_id\": \"83\"}, {\"category_id\": \"3\", \"category\": \"ESG\", \"average_score\": 0.6605441256090314, \"company_id\": \"83\"}, {\"category_id\": \"4\", \"category\": \"Financial\", \"average_score\": 0.5847319977453338, \"company_id\": \"83\"}, {\"category_id\": \"5\", \"category\": \"Delivery\", \"average_score\": 0.6586355637770203, \"company_id\": \"83\"}, {\"category_id\": \"6\", \"category\": \"Competence\", \"average_score\": 0.23034518823147032, \"company_id\": \"83\"}]",
                    "company_score": "[{\"category_id\": 0, \"category\": \"Overall\", \"average_score_unweighted\": 0.8823529411764706, \"num_certificates\": 15, \"sum_weights\": 17.00, \"weighted_total\": 15, \"average_score\": 0.8823529411764706, \"company_id\": \"83\", \"next_expiry_date\": \"2023-02-23\", \"sector_id\": \"%\", \"jurisdiction_id\": \"%\", \"comment\": \"\"},{\"category_id\": 1, \"category\": \"Identity\", \"average_score_unweighted\": \"1\", \"num_certificates\": \"3\", \"sum_weights\": \"3.00\", \"weighted_total\": \"3\", \"average_score\": 1, \"company_id\": \"83\", \"next_expiry_date\": \"2023-02-23\", \"sector_id\": \"%\", \"jurisdiction_id\": \"%\", \"comment\": \"\"},{\"category_id\": 2, \"category\": \"IT\", \"average_score_unweighted\": \"1\", \"num_certificates\": \"3\", \"sum_weights\": \"3.00\", \"weighted_total\": \"3\", \"average_score\": 1, \"company_id\": \"83\", \"next_expiry_date\": \"2023-02-23\", \"sector_id\": \"%\", \"jurisdiction_id\": \"%\", \"comment\": \"\"},{\"category_id\": 3, \"category\": \"ESG\", \"average_score_unweighted\": \"1\", \"num_certificates\": \"4\", \"sum_weights\": \"4.00\", \"weighted_total\": \"4\", \"average_score\": 1, \"company_id\": \"83\", \"next_expiry_date\": \"2023-02-23\", \"sector_id\": \"%\", \"jurisdiction_id\": \"%\", \"comment\": \"\"},{\"category_id\": 4, \"category\": \"Financial\", \"average_score_unweighted\": \"1\", \"num_certificates\": \"2\", \"sum_weights\": \"2.00\", \"weighted_total\": \"2\", \"average_score\": 1, \"company_id\": \"83\", \"next_expiry_date\": \"2023-02-23\", \"sector_id\": \"%\", \"jurisdiction_id\": \"%\", \"comment\": \"\"},{\"category_id\": 5, \"category\": \"Delivery\", \"average_score_unweighted\": \"1\", \"num_certificates\": \"2\", \"sum_weights\": \"2.00\", \"weighted_total\": \"2\", \"average_score\": 1, \"company_id\": \"83\", \"next_expiry_date\": \"2023-02-23\", \"sector_id\": \"%\", \"jurisdiction_id\": \"%\", \"comment\": \"\"},{\"category_id\": 6, \"category\": \"Competence\", \"average_score_unweighted\": \"0.3333333333333333\", \"num_certificates\": \"1\", \"sum_weights\": \"3.00\", \"weighted_total\": \"1\", \"average_score\": 0.3333333333333333, \"company_id\": \"83\", \"next_expiry_date\": \"2023-02-23\", \"sector_id\": \"%\", \"jurisdiction_id\": \"%\", \"comment\": \"\"}]",
                    "supply_chain_score": "[{\"category_id\": \"0\", \"category\": \"Overall\", \"average_score\": \"0.24257730884764972\", \"company_id\": \"78\"}, {\"category_id\": \"1\", \"category\": \"Identity\", \"average_score\": \"0.2712506767731456\", \"company_id\": \"78\"}, {\"category_id\": \"2\", \"category\": \"IT\", \"average_score\": \"0.22338927991337304\", \"company_id\": \"78\"}, {\"category_id\": \"3\", \"category\": \"ESG\", \"average_score\": \"0.32108825121806284\", \"company_id\": \"78\"}, {\"category_id\": \"4\", \"category\": \"Financial\", \"average_score\": \"0.16946399549066762\", \"company_id\": \"78\"}, {\"category_id\": \"5\", \"category\": \"Delivery\", \"average_score\": \"0.3172711275540405\", \"company_id\": \"78\"}, {\"category_id\": \"6\", \"category\": \"Competence\", \"average_score\": \"0.12735704312960733\", \"company_id\": \"78\"}]",
                    "next_expiry_date": "2023-02-23",
                    "more_details": null,
                    "sector_type": "standard",
                    "id": "3",
                    "company_id": "83",
                    "sector_id": "3105",
                    "jurisdiction_id": "85",
                    "company_size": "medium",
                    "date_created": "2023-02-20 15:22:27",
                    "date_last_modified": "2023-02-20 15:22:27",
                    "created_by": "mhooimei_mhooimeijer",
                    "last_modified_by": "mhooimei_mhooimeijer"
                },
                {
                    "company_name": "Company 83",
                    "name": "Company 83",
                    "sector_name": "Forestry and logging",
                    "parent_sector_id": "3104",
                    "parent_sector_name": "AGRICULTURE, FORESTRY AND FISHING",
                    "jurisdiction_name": "Netherlands (the)",
                    "sector_score": "[{\"category_id\": \"0\", \"category\": \"Overall\", \"average_score\": 0, \"min_score\": \"0\", \"max_score\": \"0\", \"stdev_score\": \"0\", \"sector_id\": \"3144\", \"jurisdiction_id\": \"85\", \"num_entries\": \"1\", \"num_companies\": \"1\"}, {\"category_id\": \"1\", \"category\": \"Identity\", \"average_score\": 0, \"sector_id\": \"3144\", \"jurisdiction_id\": \"85\"}, {\"category_id\": \"null\", \"category\": \"null\", \"average_score\": 0, \"sector_id\": \"3144\", \"jurisdiction_id\": \"85\"}, {\"category_id\": \"null\", \"category\": \"null\", \"average_score\": 0, \"sector_id\": \"3144\", \"jurisdiction_id\": \"85\"}, {\"category_id\": \"null\", \"category\": \"null\", \"average_score\": 0, \"sector_id\": \"3144\", \"jurisdiction_id\": \"85\"}, {\"category_id\": \"null\", \"category\": \"null\", \"average_score\": 0, \"sector_id\": \"3144\", \"jurisdiction_id\": \"85\"}, {\"category_id\": \"null\", \"category\": \"null\", \"average_score\": 0, \"sector_id\": \"3144\", \"jurisdiction_id\": \"85\"}]",
                    "country_code": "NL",
                    "registration_code": "83",
                    "adres": "",
                    "street": "",
                    "street_number": "",
                    "postalcode": "",
                    "key_id": null,
                    "city": null,
                    "country": "",
                    "state": null,
                    "public_key": null,
                    "private_key": null,
                    "is_certifier": "0",
                    "is_accreditor": "0",
                    "is_authorizor": "0",
                    "trust_score": "[{\"category_id\": \"0\", \"category\": \"Overall\", \"average_score\": 0.5624651250120601, \"company_id\": \"83\"}, {\"category_id\": \"1\", \"category\": \"Identity\", \"average_score\": 0.6356253383865729, \"company_id\": \"83\"}, {\"category_id\": \"2\", \"category\": \"IT\", \"average_score\": 0.6116946399566865, \"company_id\": \"83\"}, {\"category_id\": \"3\", \"category\": \"ESG\", \"average_score\": 0.6605441256090314, \"company_id\": \"83\"}, {\"category_id\": \"4\", \"category\": \"Financial\", \"average_score\": 0.5847319977453338, \"company_id\": \"83\"}, {\"category_id\": \"5\", \"category\": \"Delivery\", \"average_score\": 0.6586355637770203, \"company_id\": \"83\"}, {\"category_id\": \"6\", \"category\": \"Competence\", \"average_score\": 0.23034518823147032, \"company_id\": \"83\"}]",
                    "company_score": "[{\"category_id\": 0, \"category\": \"Overall\", \"average_score_unweighted\": 0.8823529411764706, \"num_certificates\": 15, \"sum_weights\": 17.00, \"weighted_total\": 15, \"average_score\": 0.8823529411764706, \"company_id\": \"83\", \"next_expiry_date\": \"2023-02-23\", \"sector_id\": \"%\", \"jurisdiction_id\": \"%\", \"comment\": \"\"},{\"category_id\": 1, \"category\": \"Identity\", \"average_score_unweighted\": \"1\", \"num_certificates\": \"3\", \"sum_weights\": \"3.00\", \"weighted_total\": \"3\", \"average_score\": 1, \"company_id\": \"83\", \"next_expiry_date\": \"2023-02-23\", \"sector_id\": \"%\", \"jurisdiction_id\": \"%\", \"comment\": \"\"},{\"category_id\": 2, \"category\": \"IT\", \"average_score_unweighted\": \"1\", \"num_certificates\": \"3\", \"sum_weights\": \"3.00\", \"weighted_total\": \"3\", \"average_score\": 1, \"company_id\": \"83\", \"next_expiry_date\": \"2023-02-23\", \"sector_id\": \"%\", \"jurisdiction_id\": \"%\", \"comment\": \"\"},{\"category_id\": 3, \"category\": \"ESG\", \"average_score_unweighted\": \"1\", \"num_certificates\": \"4\", \"sum_weights\": \"4.00\", \"weighted_total\": \"4\", \"average_score\": 1, \"company_id\": \"83\", \"next_expiry_date\": \"2023-02-23\", \"sector_id\": \"%\", \"jurisdiction_id\": \"%\", \"comment\": \"\"},{\"category_id\": 4, \"category\": \"Financial\", \"average_score_unweighted\": \"1\", \"num_certificates\": \"2\", \"sum_weights\": \"2.00\", \"weighted_total\": \"2\", \"average_score\": 1, \"company_id\": \"83\", \"next_expiry_date\": \"2023-02-23\", \"sector_id\": \"%\", \"jurisdiction_id\": \"%\", \"comment\": \"\"},{\"category_id\": 5, \"category\": \"Delivery\", \"average_score_unweighted\": \"1\", \"num_certificates\": \"2\", \"sum_weights\": \"2.00\", \"weighted_total\": \"2\", \"average_score\": 1, \"company_id\": \"83\", \"next_expiry_date\": \"2023-02-23\", \"sector_id\": \"%\", \"jurisdiction_id\": \"%\", \"comment\": \"\"},{\"category_id\": 6, \"category\": \"Competence\", \"average_score_unweighted\": \"0.3333333333333333\", \"num_certificates\": \"1\", \"sum_weights\": \"3.00\", \"weighted_total\": \"1\", \"average_score\": 0.3333333333333333, \"company_id\": \"83\", \"next_expiry_date\": \"2023-02-23\", \"sector_id\": \"%\", \"jurisdiction_id\": \"%\", \"comment\": \"\"}]",
                    "supply_chain_score": "[{\"category_id\": \"0\", \"category\": \"Overall\", \"average_score\": \"0.24257730884764972\", \"company_id\": \"78\"}, {\"category_id\": \"1\", \"category\": \"Identity\", \"average_score\": \"0.2712506767731456\", \"company_id\": \"78\"}, {\"category_id\": \"2\", \"category\": \"IT\", \"average_score\": \"0.22338927991337304\", \"company_id\": \"78\"}, {\"category_id\": \"3\", \"category\": \"ESG\", \"average_score\": \"0.32108825121806284\", \"company_id\": \"78\"}, {\"category_id\": \"4\", \"category\": \"Financial\", \"average_score\": \"0.16946399549066762\", \"company_id\": \"78\"}, {\"category_id\": \"5\", \"category\": \"Delivery\", \"average_score\": \"0.3172711275540405\", \"company_id\": \"78\"}, {\"category_id\": \"6\", \"category\": \"Competence\", \"average_score\": \"0.12735704312960733\", \"company_id\": \"78\"}]",
                    "next_expiry_date": "2023-02-23",
                    "more_details": null,
                    "sector_type": "standard",
                    "id": "4",
                    "company_id": "83",
                    "sector_id": "3144",
                    "jurisdiction_id": "85",
                    "company_size": "medium",
                    "date_created": "2023-02-20 15:22:32",
                    "date_last_modified": "2023-02-20 15:22:32",
                    "created_by": "mhooimei_mhooimeijer",
                    "last_modified_by": "mhooimei_mhooimeijer"
                },
                {
                    "company_name": "Company 83",
                    "name": "Company 83",
                    "sector_name": "Fishing and aquaculture",
                    "parent_sector_id": "3104",
                    "parent_sector_name": "AGRICULTURE, FORESTRY AND FISHING",
                    "jurisdiction_name": "Netherlands (the)",
                    "sector_score": "[{\"category_id\": \"0\", \"category\": \"Overall\", \"average_score\": 0, \"min_score\": \"0\", \"max_score\": \"0\", \"stdev_score\": \"0\", \"sector_id\": \"3153\", \"jurisdiction_id\": \"85\", \"num_entries\": \"1\", \"num_companies\": \"1\"}, {\"category_id\": \"1\", \"category\": \"Identity\", \"average_score\": 0, \"sector_id\": \"3153\", \"jurisdiction_id\": \"85\"}, {\"category_id\": \"null\", \"category\": \"null\", \"average_score\": 0, \"sector_id\": \"3153\", \"jurisdiction_id\": \"85\"}, {\"category_id\": \"null\", \"category\": \"null\", \"average_score\": 0, \"sector_id\": \"3153\", \"jurisdiction_id\": \"85\"}, {\"category_id\": \"null\", \"category\": \"null\", \"average_score\": 0, \"sector_id\": \"3153\", \"jurisdiction_id\": \"85\"}, {\"category_id\": \"null\", \"category\": \"null\", \"average_score\": 0, \"sector_id\": \"3153\", \"jurisdiction_id\": \"85\"}, {\"category_id\": \"null\", \"category\": \"null\", \"average_score\": 0, \"sector_id\": \"3153\", \"jurisdiction_id\": \"85\"}]",
                    "country_code": "NL",
                    "registration_code": "83",
                    "adres": "",
                    "street": "",
                    "street_number": "",
                    "postalcode": "",
                    "key_id": null,
                    "city": null,
                    "country": "",
                    "state": null,
                    "public_key": null,
                    "private_key": null,
                    "is_certifier": "0",
                    "is_accreditor": "0",
                    "is_authorizor": "0",
                    "trust_score": "[{\"category_id\": \"0\", \"category\": \"Overall\", \"average_score\": 0.5624651250120601, \"company_id\": \"83\"}, {\"category_id\": \"1\", \"category\": \"Identity\", \"average_score\": 0.6356253383865729, \"company_id\": \"83\"}, {\"category_id\": \"2\", \"category\": \"IT\", \"average_score\": 0.6116946399566865, \"company_id\": \"83\"}, {\"category_id\": \"3\", \"category\": \"ESG\", \"average_score\": 0.6605441256090314, \"company_id\": \"83\"}, {\"category_id\": \"4\", \"category\": \"Financial\", \"average_score\": 0.5847319977453338, \"company_id\": \"83\"}, {\"category_id\": \"5\", \"category\": \"Delivery\", \"average_score\": 0.6586355637770203, \"company_id\": \"83\"}, {\"category_id\": \"6\", \"category\": \"Competence\", \"average_score\": 0.23034518823147032, \"company_id\": \"83\"}]",
                    "company_score": "[{\"category_id\": 0, \"category\": \"Overall\", \"average_score_unweighted\": 0.8823529411764706, \"num_certificates\": 15, \"sum_weights\": 17.00, \"weighted_total\": 15, \"average_score\": 0.8823529411764706, \"company_id\": \"83\", \"next_expiry_date\": \"2023-02-23\", \"sector_id\": \"%\", \"jurisdiction_id\": \"%\", \"comment\": \"\"},{\"category_id\": 1, \"category\": \"Identity\", \"average_score_unweighted\": \"1\", \"num_certificates\": \"3\", \"sum_weights\": \"3.00\", \"weighted_total\": \"3\", \"average_score\": 1, \"company_id\": \"83\", \"next_expiry_date\": \"2023-02-23\", \"sector_id\": \"%\", \"jurisdiction_id\": \"%\", \"comment\": \"\"},{\"category_id\": 2, \"category\": \"IT\", \"average_score_unweighted\": \"1\", \"num_certificates\": \"3\", \"sum_weights\": \"3.00\", \"weighted_total\": \"3\", \"average_score\": 1, \"company_id\": \"83\", \"next_expiry_date\": \"2023-02-23\", \"sector_id\": \"%\", \"jurisdiction_id\": \"%\", \"comment\": \"\"},{\"category_id\": 3, \"category\": \"ESG\", \"average_score_unweighted\": \"1\", \"num_certificates\": \"4\", \"sum_weights\": \"4.00\", \"weighted_total\": \"4\", \"average_score\": 1, \"company_id\": \"83\", \"next_expiry_date\": \"2023-02-23\", \"sector_id\": \"%\", \"jurisdiction_id\": \"%\", \"comment\": \"\"},{\"category_id\": 4, \"category\": \"Financial\", \"average_score_unweighted\": \"1\", \"num_certificates\": \"2\", \"sum_weights\": \"2.00\", \"weighted_total\": \"2\", \"average_score\": 1, \"company_id\": \"83\", \"next_expiry_date\": \"2023-02-23\", \"sector_id\": \"%\", \"jurisdiction_id\": \"%\", \"comment\": \"\"},{\"category_id\": 5, \"category\": \"Delivery\", \"average_score_unweighted\": \"1\", \"num_certificates\": \"2\", \"sum_weights\": \"2.00\", \"weighted_total\": \"2\", \"average_score\": 1, \"company_id\": \"83\", \"next_expiry_date\": \"2023-02-23\", \"sector_id\": \"%\", \"jurisdiction_id\": \"%\", \"comment\": \"\"},{\"category_id\": 6, \"category\": \"Competence\", \"average_score_unweighted\": \"0.3333333333333333\", \"num_certificates\": \"1\", \"sum_weights\": \"3.00\", \"weighted_total\": \"1\", \"average_score\": 0.3333333333333333, \"company_id\": \"83\", \"next_expiry_date\": \"2023-02-23\", \"sector_id\": \"%\", \"jurisdiction_id\": \"%\", \"comment\": \"\"}]",
                    "supply_chain_score": "[{\"category_id\": \"0\", \"category\": \"Overall\", \"average_score\": \"0.24257730884764972\", \"company_id\": \"78\"}, {\"category_id\": \"1\", \"category\": \"Identity\", \"average_score\": \"0.2712506767731456\", \"company_id\": \"78\"}, {\"category_id\": \"2\", \"category\": \"IT\", \"average_score\": \"0.22338927991337304\", \"company_id\": \"78\"}, {\"category_id\": \"3\", \"category\": \"ESG\", \"average_score\": \"0.32108825121806284\", \"company_id\": \"78\"}, {\"category_id\": \"4\", \"category\": \"Financial\", \"average_score\": \"0.16946399549066762\", \"company_id\": \"78\"}, {\"category_id\": \"5\", \"category\": \"Delivery\", \"average_score\": \"0.3172711275540405\", \"company_id\": \"78\"}, {\"category_id\": \"6\", \"category\": \"Competence\", \"average_score\": \"0.12735704312960733\", \"company_id\": \"78\"}]",
                    "next_expiry_date": "2023-02-23",
                    "more_details": null,
                    "sector_type": "standard",
                    "id": "5",
                    "company_id": "83",
                    "sector_id": "3153",
                    "jurisdiction_id": "85",
                    "company_size": "medium",
                    "date_created": "2023-02-20 15:22:36",
                    "date_last_modified": "2023-02-20 15:22:36",
                    "created_by": "mhooimei_mhooimeijer",
                    "last_modified_by": "mhooimei_mhooimeijer"
                },
                {
                    "company_name": "Company 83",
                    "name": "Company 83",
                    "sector_name": "Mining of coal and lignite",
                    "parent_sector_id": "3160",
                    "parent_sector_name": "MINING AND QUARRYING",
                    "jurisdiction_name": "Netherlands (the)",
                    "sector_score": "[{\"category_id\": \"0\", \"category\": \"Overall\", \"average_score\": 0, \"min_score\": null, \"max_score\": null, \"stdev_score\": null, \"sector_id\": \"3161\", \"jurisdiction_id\": \"85\", \"num_entries\": \"0\", \"num_companies\": \"0\"}, {\"category_id\": \"1\", \"category\": \"Identity\", \"average_score\": 0, \"sector_id\": \"3161\", \"jurisdiction_id\": \"85\"}, {\"category_id\": \"2\", \"category\": \"IT\", \"average_score\": 0, \"sector_id\": \"3161\", \"jurisdiction_id\": \"85\"}, {\"category_id\": \"3\", \"category\": \"ESG\", \"average_score\": 0, \"sector_id\": \"3161\", \"jurisdiction_id\": \"85\"}, {\"category_id\": \"4\", \"category\": \"Financial\", \"average_score\": 0, \"sector_id\": \"3161\", \"jurisdiction_id\": \"85\"}, {\"category_id\": \"5\", \"category\": \"Delivery\", \"average_score\": 0, \"sector_id\": \"3161\", \"jurisdiction_id\": \"85\"}, {\"category_id\": \"6\", \"category\": \"Competence\", \"average_score\": 0, \"sector_id\": \"3161\", \"jurisdiction_id\": \"85\"}]",
                    "country_code": "NL",
                    "registration_code": "83",
                    "adres": "",
                    "street": "",
                    "street_number": "",
                    "postalcode": "",
                    "key_id": null,
                    "city": null,
                    "country": "",
                    "state": null,
                    "public_key": null,
                    "private_key": null,
                    "is_certifier": "0",
                    "is_accreditor": "0",
                    "is_authorizor": "0",
                    "trust_score": "[{\"category_id\": \"0\", \"category\": \"Overall\", \"average_score\": 0.5624651250120601, \"company_id\": \"83\"}, {\"category_id\": \"1\", \"category\": \"Identity\", \"average_score\": 0.6356253383865729, \"company_id\": \"83\"}, {\"category_id\": \"2\", \"category\": \"IT\", \"average_score\": 0.6116946399566865, \"company_id\": \"83\"}, {\"category_id\": \"3\", \"category\": \"ESG\", \"average_score\": 0.6605441256090314, \"company_id\": \"83\"}, {\"category_id\": \"4\", \"category\": \"Financial\", \"average_score\": 0.5847319977453338, \"company_id\": \"83\"}, {\"category_id\": \"5\", \"category\": \"Delivery\", \"average_score\": 0.6586355637770203, \"company_id\": \"83\"}, {\"category_id\": \"6\", \"category\": \"Competence\", \"average_score\": 0.23034518823147032, \"company_id\": \"83\"}]",
                    "company_score": "[{\"category_id\": 0, \"category\": \"Overall\", \"average_score_unweighted\": 0.8823529411764706, \"num_certificates\": 15, \"sum_weights\": 17.00, \"weighted_total\": 15, \"average_score\": 0.8823529411764706, \"company_id\": \"83\", \"next_expiry_date\": \"2023-02-23\", \"sector_id\": \"%\", \"jurisdiction_id\": \"%\", \"comment\": \"\"},{\"category_id\": 1, \"category\": \"Identity\", \"average_score_unweighted\": \"1\", \"num_certificates\": \"3\", \"sum_weights\": \"3.00\", \"weighted_total\": \"3\", \"average_score\": 1, \"company_id\": \"83\", \"next_expiry_date\": \"2023-02-23\", \"sector_id\": \"%\", \"jurisdiction_id\": \"%\", \"comment\": \"\"},{\"category_id\": 2, \"category\": \"IT\", \"average_score_unweighted\": \"1\", \"num_certificates\": \"3\", \"sum_weights\": \"3.00\", \"weighted_total\": \"3\", \"average_score\": 1, \"company_id\": \"83\", \"next_expiry_date\": \"2023-02-23\", \"sector_id\": \"%\", \"jurisdiction_id\": \"%\", \"comment\": \"\"},{\"category_id\": 3, \"category\": \"ESG\", \"average_score_unweighted\": \"1\", \"num_certificates\": \"4\", \"sum_weights\": \"4.00\", \"weighted_total\": \"4\", \"average_score\": 1, \"company_id\": \"83\", \"next_expiry_date\": \"2023-02-23\", \"sector_id\": \"%\", \"jurisdiction_id\": \"%\", \"comment\": \"\"},{\"category_id\": 4, \"category\": \"Financial\", \"average_score_unweighted\": \"1\", \"num_certificates\": \"2\", \"sum_weights\": \"2.00\", \"weighted_total\": \"2\", \"average_score\": 1, \"company_id\": \"83\", \"next_expiry_date\": \"2023-02-23\", \"sector_id\": \"%\", \"jurisdiction_id\": \"%\", \"comment\": \"\"},{\"category_id\": 5, \"category\": \"Delivery\", \"average_score_unweighted\": \"1\", \"num_certificates\": \"2\", \"sum_weights\": \"2.00\", \"weighted_total\": \"2\", \"average_score\": 1, \"company_id\": \"83\", \"next_expiry_date\": \"2023-02-23\", \"sector_id\": \"%\", \"jurisdiction_id\": \"%\", \"comment\": \"\"},{\"category_id\": 6, \"category\": \"Competence\", \"average_score_unweighted\": \"0.3333333333333333\", \"num_certificates\": \"1\", \"sum_weights\": \"3.00\", \"weighted_total\": \"1\", \"average_score\": 0.3333333333333333, \"company_id\": \"83\", \"next_expiry_date\": \"2023-02-23\", \"sector_id\": \"%\", \"jurisdiction_id\": \"%\", \"comment\": \"\"}]",
                    "supply_chain_score": "[{\"category_id\": \"0\", \"category\": \"Overall\", \"average_score\": \"0.24257730884764972\", \"company_id\": \"78\"}, {\"category_id\": \"1\", \"category\": \"Identity\", \"average_score\": \"0.2712506767731456\", \"company_id\": \"78\"}, {\"category_id\": \"2\", \"category\": \"IT\", \"average_score\": \"0.22338927991337304\", \"company_id\": \"78\"}, {\"category_id\": \"3\", \"category\": \"ESG\", \"average_score\": \"0.32108825121806284\", \"company_id\": \"78\"}, {\"category_id\": \"4\", \"category\": \"Financial\", \"average_score\": \"0.16946399549066762\", \"company_id\": \"78\"}, {\"category_id\": \"5\", \"category\": \"Delivery\", \"average_score\": \"0.3172711275540405\", \"company_id\": \"78\"}, {\"category_id\": \"6\", \"category\": \"Competence\", \"average_score\": \"0.12735704312960733\", \"company_id\": \"78\"}]",
                    "next_expiry_date": "2023-02-23",
                    "more_details": null,
                    "sector_type": "standard",
                    "id": "7",
                    "company_id": "83",
                    "sector_id": "3161",
                    "jurisdiction_id": "85",
                    "company_size": "medium",
                    "date_created": "2023-02-20 15:41:25",
                    "date_last_modified": "2023-02-20 15:41:25",
                    "created_by": "mhooimei_mhooimeijer",
                    "last_modified_by": "mhooimei_mhooimeijer"
                },
                {
                    "company_name": "Company 83",
                    "name": "Company 83",
                    "sector_name": "Extraction of crude petroleum and natural gas",
                    "parent_sector_id": "3160",
                    "parent_sector_name": "MINING AND QUARRYING",
                    "jurisdiction_name": "Netherlands (the)",
                    "sector_score": "[{\"category_id\": \"0\", \"category\": \"Overall\", \"average_score\": 0, \"min_score\": null, \"max_score\": null, \"stdev_score\": null, \"sector_id\": \"3166\", \"jurisdiction_id\": \"85\", \"num_entries\": \"0\", \"num_companies\": \"0\"}, {\"category_id\": \"1\", \"category\": \"Identity\", \"average_score\": 0, \"sector_id\": \"3166\", \"jurisdiction_id\": \"85\"}, {\"category_id\": \"2\", \"category\": \"IT\", \"average_score\": 0, \"sector_id\": \"3166\", \"jurisdiction_id\": \"85\"}, {\"category_id\": \"3\", \"category\": \"ESG\", \"average_score\": 0, \"sector_id\": \"3166\", \"jurisdiction_id\": \"85\"}, {\"category_id\": \"4\", \"category\": \"Financial\", \"average_score\": 0, \"sector_id\": \"3166\", \"jurisdiction_id\": \"85\"}, {\"category_id\": \"5\", \"category\": \"Delivery\", \"average_score\": 0, \"sector_id\": \"3166\", \"jurisdiction_id\": \"85\"}, {\"category_id\": \"6\", \"category\": \"Competence\", \"average_score\": 0, \"sector_id\": \"3166\", \"jurisdiction_id\": \"85\"}]",
                    "country_code": "NL",
                    "registration_code": "83",
                    "adres": "",
                    "street": "",
                    "street_number": "",
                    "postalcode": "",
                    "key_id": null,
                    "city": null,
                    "country": "",
                    "state": null,
                    "public_key": null,
                    "private_key": null,
                    "is_certifier": "0",
                    "is_accreditor": "0",
                    "is_authorizor": "0",
                    "trust_score": "[{\"category_id\": \"0\", \"category\": \"Overall\", \"average_score\": 0.5624651250120601, \"company_id\": \"83\"}, {\"category_id\": \"1\", \"category\": \"Identity\", \"average_score\": 0.6356253383865729, \"company_id\": \"83\"}, {\"category_id\": \"2\", \"category\": \"IT\", \"average_score\": 0.6116946399566865, \"company_id\": \"83\"}, {\"category_id\": \"3\", \"category\": \"ESG\", \"average_score\": 0.6605441256090314, \"company_id\": \"83\"}, {\"category_id\": \"4\", \"category\": \"Financial\", \"average_score\": 0.5847319977453338, \"company_id\": \"83\"}, {\"category_id\": \"5\", \"category\": \"Delivery\", \"average_score\": 0.6586355637770203, \"company_id\": \"83\"}, {\"category_id\": \"6\", \"category\": \"Competence\", \"average_score\": 0.23034518823147032, \"company_id\": \"83\"}]",
                    "company_score": "[{\"category_id\": 0, \"category\": \"Overall\", \"average_score_unweighted\": 0.8823529411764706, \"num_certificates\": 15, \"sum_weights\": 17.00, \"weighted_total\": 15, \"average_score\": 0.8823529411764706, \"company_id\": \"83\", \"next_expiry_date\": \"2023-02-23\", \"sector_id\": \"%\", \"jurisdiction_id\": \"%\", \"comment\": \"\"},{\"category_id\": 1, \"category\": \"Identity\", \"average_score_unweighted\": \"1\", \"num_certificates\": \"3\", \"sum_weights\": \"3.00\", \"weighted_total\": \"3\", \"average_score\": 1, \"company_id\": \"83\", \"next_expiry_date\": \"2023-02-23\", \"sector_id\": \"%\", \"jurisdiction_id\": \"%\", \"comment\": \"\"},{\"category_id\": 2, \"category\": \"IT\", \"average_score_unweighted\": \"1\", \"num_certificates\": \"3\", \"sum_weights\": \"3.00\", \"weighted_total\": \"3\", \"average_score\": 1, \"company_id\": \"83\", \"next_expiry_date\": \"2023-02-23\", \"sector_id\": \"%\", \"jurisdiction_id\": \"%\", \"comment\": \"\"},{\"category_id\": 3, \"category\": \"ESG\", \"average_score_unweighted\": \"1\", \"num_certificates\": \"4\", \"sum_weights\": \"4.00\", \"weighted_total\": \"4\", \"average_score\": 1, \"company_id\": \"83\", \"next_expiry_date\": \"2023-02-23\", \"sector_id\": \"%\", \"jurisdiction_id\": \"%\", \"comment\": \"\"},{\"category_id\": 4, \"category\": \"Financial\", \"average_score_unweighted\": \"1\", \"num_certificates\": \"2\", \"sum_weights\": \"2.00\", \"weighted_total\": \"2\", \"average_score\": 1, \"company_id\": \"83\", \"next_expiry_date\": \"2023-02-23\", \"sector_id\": \"%\", \"jurisdiction_id\": \"%\", \"comment\": \"\"},{\"category_id\": 5, \"category\": \"Delivery\", \"average_score_unweighted\": \"1\", \"num_certificates\": \"2\", \"sum_weights\": \"2.00\", \"weighted_total\": \"2\", \"average_score\": 1, \"company_id\": \"83\", \"next_expiry_date\": \"2023-02-23\", \"sector_id\": \"%\", \"jurisdiction_id\": \"%\", \"comment\": \"\"},{\"category_id\": 6, \"category\": \"Competence\", \"average_score_unweighted\": \"0.3333333333333333\", \"num_certificates\": \"1\", \"sum_weights\": \"3.00\", \"weighted_total\": \"1\", \"average_score\": 0.3333333333333333, \"company_id\": \"83\", \"next_expiry_date\": \"2023-02-23\", \"sector_id\": \"%\", \"jurisdiction_id\": \"%\", \"comment\": \"\"}]",
                    "supply_chain_score": "[{\"category_id\": \"0\", \"category\": \"Overall\", \"average_score\": \"0.24257730884764972\", \"company_id\": \"78\"}, {\"category_id\": \"1\", \"category\": \"Identity\", \"average_score\": \"0.2712506767731456\", \"company_id\": \"78\"}, {\"category_id\": \"2\", \"category\": \"IT\", \"average_score\": \"0.22338927991337304\", \"company_id\": \"78\"}, {\"category_id\": \"3\", \"category\": \"ESG\", \"average_score\": \"0.32108825121806284\", \"company_id\": \"78\"}, {\"category_id\": \"4\", \"category\": \"Financial\", \"average_score\": \"0.16946399549066762\", \"company_id\": \"78\"}, {\"category_id\": \"5\", \"category\": \"Delivery\", \"average_score\": \"0.3172711275540405\", \"company_id\": \"78\"}, {\"category_id\": \"6\", \"category\": \"Competence\", \"average_score\": \"0.12735704312960733\", \"company_id\": \"78\"}]",
                    "next_expiry_date": "2023-02-23",
                    "more_details": null,
                    "sector_type": "standard",
                    "id": "8",
                    "company_id": "83",
                    "sector_id": "3166",
                    "jurisdiction_id": "85",
                    "company_size": "medium",
                    "date_created": "2023-02-20 15:41:29",
                    "date_last_modified": "2023-02-20 15:41:29",
                    "created_by": "mhooimei_mhooimeijer",
                    "last_modified_by": "mhooimei_mhooimeijer"
                },
                {
                    "company_name": "Company 83",
                    "name": "Company 83",
                    "sector_name": "Mining of metal ores",
                    "parent_sector_id": "3160",
                    "parent_sector_name": "MINING AND QUARRYING",
                    "jurisdiction_name": "Netherlands (the)",
                    "sector_score": "[{\"category_id\": \"0\", \"category\": \"Overall\", \"average_score\": 0, \"min_score\": null, \"max_score\": null, \"stdev_score\": null, \"sector_id\": \"3171\", \"jurisdiction_id\": \"85\", \"num_entries\": \"0\", \"num_companies\": \"0\"}, {\"category_id\": \"1\", \"category\": \"Identity\", \"average_score\": 0, \"sector_id\": \"3171\", \"jurisdiction_id\": \"85\"}, {\"category_id\": \"2\", \"category\": \"IT\", \"average_score\": 0, \"sector_id\": \"3171\", \"jurisdiction_id\": \"85\"}, {\"category_id\": \"3\", \"category\": \"ESG\", \"average_score\": 0, \"sector_id\": \"3171\", \"jurisdiction_id\": \"85\"}, {\"category_id\": \"4\", \"category\": \"Financial\", \"average_score\": 0, \"sector_id\": \"3171\", \"jurisdiction_id\": \"85\"}, {\"category_id\": \"5\", \"category\": \"Delivery\", \"average_score\": 0, \"sector_id\": \"3171\", \"jurisdiction_id\": \"85\"}, {\"category_id\": \"6\", \"category\": \"Competence\", \"average_score\": 0, \"sector_id\": \"3171\", \"jurisdiction_id\": \"85\"}]",
                    "country_code": "NL",
                    "registration_code": "83",
                    "adres": "",
                    "street": "",
                    "street_number": "",
                    "postalcode": "",
                    "key_id": null,
                    "city": null,
                    "country": "",
                    "state": null,
                    "public_key": null,
                    "private_key": null,
                    "is_certifier": "0",
                    "is_accreditor": "0",
                    "is_authorizor": "0",
                    "trust_score": "[{\"category_id\": \"0\", \"category\": \"Overall\", \"average_score\": 0.5624651250120601, \"company_id\": \"83\"}, {\"category_id\": \"1\", \"category\": \"Identity\", \"average_score\": 0.6356253383865729, \"company_id\": \"83\"}, {\"category_id\": \"2\", \"category\": \"IT\", \"average_score\": 0.6116946399566865, \"company_id\": \"83\"}, {\"category_id\": \"3\", \"category\": \"ESG\", \"average_score\": 0.6605441256090314, \"company_id\": \"83\"}, {\"category_id\": \"4\", \"category\": \"Financial\", \"average_score\": 0.5847319977453338, \"company_id\": \"83\"}, {\"category_id\": \"5\", \"category\": \"Delivery\", \"average_score\": 0.6586355637770203, \"company_id\": \"83\"}, {\"category_id\": \"6\", \"category\": \"Competence\", \"average_score\": 0.23034518823147032, \"company_id\": \"83\"}]",
                    "company_score": "[{\"category_id\": 0, \"category\": \"Overall\", \"average_score_unweighted\": 0.8823529411764706, \"num_certificates\": 15, \"sum_weights\": 17.00, \"weighted_total\": 15, \"average_score\": 0.8823529411764706, \"company_id\": \"83\", \"next_expiry_date\": \"2023-02-23\", \"sector_id\": \"%\", \"jurisdiction_id\": \"%\", \"comment\": \"\"},{\"category_id\": 1, \"category\": \"Identity\", \"average_score_unweighted\": \"1\", \"num_certificates\": \"3\", \"sum_weights\": \"3.00\", \"weighted_total\": \"3\", \"average_score\": 1, \"company_id\": \"83\", \"next_expiry_date\": \"2023-02-23\", \"sector_id\": \"%\", \"jurisdiction_id\": \"%\", \"comment\": \"\"},{\"category_id\": 2, \"category\": \"IT\", \"average_score_unweighted\": \"1\", \"num_certificates\": \"3\", \"sum_weights\": \"3.00\", \"weighted_total\": \"3\", \"average_score\": 1, \"company_id\": \"83\", \"next_expiry_date\": \"2023-02-23\", \"sector_id\": \"%\", \"jurisdiction_id\": \"%\", \"comment\": \"\"},{\"category_id\": 3, \"category\": \"ESG\", \"average_score_unweighted\": \"1\", \"num_certificates\": \"4\", \"sum_weights\": \"4.00\", \"weighted_total\": \"4\", \"average_score\": 1, \"company_id\": \"83\", \"next_expiry_date\": \"2023-02-23\", \"sector_id\": \"%\", \"jurisdiction_id\": \"%\", \"comment\": \"\"},{\"category_id\": 4, \"category\": \"Financial\", \"average_score_unweighted\": \"1\", \"num_certificates\": \"2\", \"sum_weights\": \"2.00\", \"weighted_total\": \"2\", \"average_score\": 1, \"company_id\": \"83\", \"next_expiry_date\": \"2023-02-23\", \"sector_id\": \"%\", \"jurisdiction_id\": \"%\", \"comment\": \"\"},{\"category_id\": 5, \"category\": \"Delivery\", \"average_score_unweighted\": \"1\", \"num_certificates\": \"2\", \"sum_weights\": \"2.00\", \"weighted_total\": \"2\", \"average_score\": 1, \"company_id\": \"83\", \"next_expiry_date\": \"2023-02-23\", \"sector_id\": \"%\", \"jurisdiction_id\": \"%\", \"comment\": \"\"},{\"category_id\": 6, \"category\": \"Competence\", \"average_score_unweighted\": \"0.3333333333333333\", \"num_certificates\": \"1\", \"sum_weights\": \"3.00\", \"weighted_total\": \"1\", \"average_score\": 0.3333333333333333, \"company_id\": \"83\", \"next_expiry_date\": \"2023-02-23\", \"sector_id\": \"%\", \"jurisdiction_id\": \"%\", \"comment\": \"\"}]",
                    "supply_chain_score": "[{\"category_id\": \"0\", \"category\": \"Overall\", \"average_score\": \"0.24257730884764972\", \"company_id\": \"78\"}, {\"category_id\": \"1\", \"category\": \"Identity\", \"average_score\": \"0.2712506767731456\", \"company_id\": \"78\"}, {\"category_id\": \"2\", \"category\": \"IT\", \"average_score\": \"0.22338927991337304\", \"company_id\": \"78\"}, {\"category_id\": \"3\", \"category\": \"ESG\", \"average_score\": \"0.32108825121806284\", \"company_id\": \"78\"}, {\"category_id\": \"4\", \"category\": \"Financial\", \"average_score\": \"0.16946399549066762\", \"company_id\": \"78\"}, {\"category_id\": \"5\", \"category\": \"Delivery\", \"average_score\": \"0.3172711275540405\", \"company_id\": \"78\"}, {\"category_id\": \"6\", \"category\": \"Competence\", \"average_score\": \"0.12735704312960733\", \"company_id\": \"78\"}]",
                    "next_expiry_date": "2023-02-23",
                    "more_details": null,
                    "sector_type": "standard",
                    "id": "9",
                    "company_id": "83",
                    "sector_id": "3171",
                    "jurisdiction_id": "85",
                    "company_size": "medium",
                    "date_created": "2023-02-20 15:41:34",
                    "date_last_modified": "2023-02-20 15:41:34",
                    "created_by": "mhooimei_mhooimeijer",
                    "last_modified_by": "mhooimei_mhooimeijer"
                },
                {
                    "company_name": "Company 83",
                    "name": "Company 83",
                    "sector_name": "Other mining and quarrying",
                    "parent_sector_id": "3160",
                    "parent_sector_name": "MINING AND QUARRYING",
                    "jurisdiction_name": "Netherlands (the)",
                    "sector_score": "[{\"category_id\": \"0\", \"category\": \"Overall\", \"average_score\": 0, \"min_score\": null, \"max_score\": null, \"stdev_score\": null, \"sector_id\": \"3177\", \"jurisdiction_id\": \"85\", \"num_entries\": \"0\", \"num_companies\": \"0\"}, {\"category_id\": \"1\", \"category\": \"Identity\", \"average_score\": 0, \"sector_id\": \"3177\", \"jurisdiction_id\": \"85\"}, {\"category_id\": \"2\", \"category\": \"IT\", \"average_score\": 0, \"sector_id\": \"3177\", \"jurisdiction_id\": \"85\"}, {\"category_id\": \"3\", \"category\": \"ESG\", \"average_score\": 0, \"sector_id\": \"3177\", \"jurisdiction_id\": \"85\"}, {\"category_id\": \"4\", \"category\": \"Financial\", \"average_score\": 0, \"sector_id\": \"3177\", \"jurisdiction_id\": \"85\"}, {\"category_id\": \"5\", \"category\": \"Delivery\", \"average_score\": 0, \"sector_id\": \"3177\", \"jurisdiction_id\": \"85\"}, {\"category_id\": \"6\", \"category\": \"Competence\", \"average_score\": 0, \"sector_id\": \"3177\", \"jurisdiction_id\": \"85\"}]",
                    "country_code": "NL",
                    "registration_code": "83",
                    "adres": "",
                    "street": "",
                    "street_number": "",
                    "postalcode": "",
                    "key_id": null,
                    "city": null,
                    "country": "",
                    "state": null,
                    "public_key": null,
                    "private_key": null,
                    "is_certifier": "0",
                    "is_accreditor": "0",
                    "is_authorizor": "0",
                    "trust_score": "[{\"category_id\": \"0\", \"category\": \"Overall\", \"average_score\": 0.5624651250120601, \"company_id\": \"83\"}, {\"category_id\": \"1\", \"category\": \"Identity\", \"average_score\": 0.6356253383865729, \"company_id\": \"83\"}, {\"category_id\": \"2\", \"category\": \"IT\", \"average_score\": 0.6116946399566865, \"company_id\": \"83\"}, {\"category_id\": \"3\", \"category\": \"ESG\", \"average_score\": 0.6605441256090314, \"company_id\": \"83\"}, {\"category_id\": \"4\", \"category\": \"Financial\", \"average_score\": 0.5847319977453338, \"company_id\": \"83\"}, {\"category_id\": \"5\", \"category\": \"Delivery\", \"average_score\": 0.6586355637770203, \"company_id\": \"83\"}, {\"category_id\": \"6\", \"category\": \"Competence\", \"average_score\": 0.23034518823147032, \"company_id\": \"83\"}]",
                    "company_score": "[{\"category_id\": 0, \"category\": \"Overall\", \"average_score_unweighted\": 0.8823529411764706, \"num_certificates\": 15, \"sum_weights\": 17.00, \"weighted_total\": 15, \"average_score\": 0.8823529411764706, \"company_id\": \"83\", \"next_expiry_date\": \"2023-02-23\", \"sector_id\": \"%\", \"jurisdiction_id\": \"%\", \"comment\": \"\"},{\"category_id\": 1, \"category\": \"Identity\", \"average_score_unweighted\": \"1\", \"num_certificates\": \"3\", \"sum_weights\": \"3.00\", \"weighted_total\": \"3\", \"average_score\": 1, \"company_id\": \"83\", \"next_expiry_date\": \"2023-02-23\", \"sector_id\": \"%\", \"jurisdiction_id\": \"%\", \"comment\": \"\"},{\"category_id\": 2, \"category\": \"IT\", \"average_score_unweighted\": \"1\", \"num_certificates\": \"3\", \"sum_weights\": \"3.00\", \"weighted_total\": \"3\", \"average_score\": 1, \"company_id\": \"83\", \"next_expiry_date\": \"2023-02-23\", \"sector_id\": \"%\", \"jurisdiction_id\": \"%\", \"comment\": \"\"},{\"category_id\": 3, \"category\": \"ESG\", \"average_score_unweighted\": \"1\", \"num_certificates\": \"4\", \"sum_weights\": \"4.00\", \"weighted_total\": \"4\", \"average_score\": 1, \"company_id\": \"83\", \"next_expiry_date\": \"2023-02-23\", \"sector_id\": \"%\", \"jurisdiction_id\": \"%\", \"comment\": \"\"},{\"category_id\": 4, \"category\": \"Financial\", \"average_score_unweighted\": \"1\", \"num_certificates\": \"2\", \"sum_weights\": \"2.00\", \"weighted_total\": \"2\", \"average_score\": 1, \"company_id\": \"83\", \"next_expiry_date\": \"2023-02-23\", \"sector_id\": \"%\", \"jurisdiction_id\": \"%\", \"comment\": \"\"},{\"category_id\": 5, \"category\": \"Delivery\", \"average_score_unweighted\": \"1\", \"num_certificates\": \"2\", \"sum_weights\": \"2.00\", \"weighted_total\": \"2\", \"average_score\": 1, \"company_id\": \"83\", \"next_expiry_date\": \"2023-02-23\", \"sector_id\": \"%\", \"jurisdiction_id\": \"%\", \"comment\": \"\"},{\"category_id\": 6, \"category\": \"Competence\", \"average_score_unweighted\": \"0.3333333333333333\", \"num_certificates\": \"1\", \"sum_weights\": \"3.00\", \"weighted_total\": \"1\", \"average_score\": 0.3333333333333333, \"company_id\": \"83\", \"next_expiry_date\": \"2023-02-23\", \"sector_id\": \"%\", \"jurisdiction_id\": \"%\", \"comment\": \"\"}]",
                    "supply_chain_score": "[{\"category_id\": \"0\", \"category\": \"Overall\", \"average_score\": \"0.24257730884764972\", \"company_id\": \"78\"}, {\"category_id\": \"1\", \"category\": \"Identity\", \"average_score\": \"0.2712506767731456\", \"company_id\": \"78\"}, {\"category_id\": \"2\", \"category\": \"IT\", \"average_score\": \"0.22338927991337304\", \"company_id\": \"78\"}, {\"category_id\": \"3\", \"category\": \"ESG\", \"average_score\": \"0.32108825121806284\", \"company_id\": \"78\"}, {\"category_id\": \"4\", \"category\": \"Financial\", \"average_score\": \"0.16946399549066762\", \"company_id\": \"78\"}, {\"category_id\": \"5\", \"category\": \"Delivery\", \"average_score\": \"0.3172711275540405\", \"company_id\": \"78\"}, {\"category_id\": \"6\", \"category\": \"Competence\", \"average_score\": \"0.12735704312960733\", \"company_id\": \"78\"}]",
                    "next_expiry_date": "2023-02-23",
                    "more_details": null,
                    "sector_type": "standard",
                    "id": "10",
                    "company_id": "83",
                    "sector_id": "3177",
                    "jurisdiction_id": "85",
                    "company_size": "medium",
                    "date_created": "2023-02-20 15:41:43",
                    "date_last_modified": "2023-02-20 15:41:43",
                    "created_by": "mhooimei_mhooimeijer",
                    "last_modified_by": "mhooimei_mhooimeijer"
                },
                {
                    "company_name": "Company 83",
                    "name": "Company 83",
                    "sector_name": "Mining support service activities",
                    "parent_sector_id": "3160",
                    "parent_sector_name": "MINING AND QUARRYING",
                    "jurisdiction_name": "Netherlands (the)",
                    "sector_score": "[{\"category_id\": \"0\", \"category\": \"Overall\", \"average_score\": 0, \"min_score\": null, \"max_score\": null, \"stdev_score\": null, \"sector_id\": \"3186\", \"jurisdiction_id\": \"85\", \"num_entries\": \"0\", \"num_companies\": \"0\"}, {\"category_id\": \"1\", \"category\": \"Identity\", \"average_score\": 0, \"sector_id\": \"3186\", \"jurisdiction_id\": \"85\"}, {\"category_id\": \"2\", \"category\": \"IT\", \"average_score\": 0, \"sector_id\": \"3186\", \"jurisdiction_id\": \"85\"}, {\"category_id\": \"3\", \"category\": \"ESG\", \"average_score\": 0, \"sector_id\": \"3186\", \"jurisdiction_id\": \"85\"}, {\"category_id\": \"4\", \"category\": \"Financial\", \"average_score\": 0, \"sector_id\": \"3186\", \"jurisdiction_id\": \"85\"}, {\"category_id\": \"5\", \"category\": \"Delivery\", \"average_score\": 0, \"sector_id\": \"3186\", \"jurisdiction_id\": \"85\"}, {\"category_id\": \"6\", \"category\": \"Competence\", \"average_score\": 0, \"sector_id\": \"3186\", \"jurisdiction_id\": \"85\"}]",
                    "country_code": "NL",
                    "registration_code": "83",
                    "adres": "",
                    "street": "",
                    "street_number": "",
                    "postalcode": "",
                    "key_id": null,
                    "city": null,
                    "country": "",
                    "state": null,
                    "public_key": null,
                    "private_key": null,
                    "is_certifier": "0",
                    "is_accreditor": "0",
                    "is_authorizor": "0",
                    "trust_score": "[{\"category_id\": \"0\", \"category\": \"Overall\", \"average_score\": 0.5624651250120601, \"company_id\": \"83\"}, {\"category_id\": \"1\", \"category\": \"Identity\", \"average_score\": 0.6356253383865729, \"company_id\": \"83\"}, {\"category_id\": \"2\", \"category\": \"IT\", \"average_score\": 0.6116946399566865, \"company_id\": \"83\"}, {\"category_id\": \"3\", \"category\": \"ESG\", \"average_score\": 0.6605441256090314, \"company_id\": \"83\"}, {\"category_id\": \"4\", \"category\": \"Financial\", \"average_score\": 0.5847319977453338, \"company_id\": \"83\"}, {\"category_id\": \"5\", \"category\": \"Delivery\", \"average_score\": 0.6586355637770203, \"company_id\": \"83\"}, {\"category_id\": \"6\", \"category\": \"Competence\", \"average_score\": 0.23034518823147032, \"company_id\": \"83\"}]",
                    "company_score": "[{\"category_id\": 0, \"category\": \"Overall\", \"average_score_unweighted\": 0.8823529411764706, \"num_certificates\": 15, \"sum_weights\": 17.00, \"weighted_total\": 15, \"average_score\": 0.8823529411764706, \"company_id\": \"83\", \"next_expiry_date\": \"2023-02-23\", \"sector_id\": \"%\", \"jurisdiction_id\": \"%\", \"comment\": \"\"},{\"category_id\": 1, \"category\": \"Identity\", \"average_score_unweighted\": \"1\", \"num_certificates\": \"3\", \"sum_weights\": \"3.00\", \"weighted_total\": \"3\", \"average_score\": 1, \"company_id\": \"83\", \"next_expiry_date\": \"2023-02-23\", \"sector_id\": \"%\", \"jurisdiction_id\": \"%\", \"comment\": \"\"},{\"category_id\": 2, \"category\": \"IT\", \"average_score_unweighted\": \"1\", \"num_certificates\": \"3\", \"sum_weights\": \"3.00\", \"weighted_total\": \"3\", \"average_score\": 1, \"company_id\": \"83\", \"next_expiry_date\": \"2023-02-23\", \"sector_id\": \"%\", \"jurisdiction_id\": \"%\", \"comment\": \"\"},{\"category_id\": 3, \"category\": \"ESG\", \"average_score_unweighted\": \"1\", \"num_certificates\": \"4\", \"sum_weights\": \"4.00\", \"weighted_total\": \"4\", \"average_score\": 1, \"company_id\": \"83\", \"next_expiry_date\": \"2023-02-23\", \"sector_id\": \"%\", \"jurisdiction_id\": \"%\", \"comment\": \"\"},{\"category_id\": 4, \"category\": \"Financial\", \"average_score_unweighted\": \"1\", \"num_certificates\": \"2\", \"sum_weights\": \"2.00\", \"weighted_total\": \"2\", \"average_score\": 1, \"company_id\": \"83\", \"next_expiry_date\": \"2023-02-23\", \"sector_id\": \"%\", \"jurisdiction_id\": \"%\", \"comment\": \"\"},{\"category_id\": 5, \"category\": \"Delivery\", \"average_score_unweighted\": \"1\", \"num_certificates\": \"2\", \"sum_weights\": \"2.00\", \"weighted_total\": \"2\", \"average_score\": 1, \"company_id\": \"83\", \"next_expiry_date\": \"2023-02-23\", \"sector_id\": \"%\", \"jurisdiction_id\": \"%\", \"comment\": \"\"},{\"category_id\": 6, \"category\": \"Competence\", \"average_score_unweighted\": \"0.3333333333333333\", \"num_certificates\": \"1\", \"sum_weights\": \"3.00\", \"weighted_total\": \"1\", \"average_score\": 0.3333333333333333, \"company_id\": \"83\", \"next_expiry_date\": \"2023-02-23\", \"sector_id\": \"%\", \"jurisdiction_id\": \"%\", \"comment\": \"\"}]",
                    "supply_chain_score": "[{\"category_id\": \"0\", \"category\": \"Overall\", \"average_score\": \"0.24257730884764972\", \"company_id\": \"78\"}, {\"category_id\": \"1\", \"category\": \"Identity\", \"average_score\": \"0.2712506767731456\", \"company_id\": \"78\"}, {\"category_id\": \"2\", \"category\": \"IT\", \"average_score\": \"0.22338927991337304\", \"company_id\": \"78\"}, {\"category_id\": \"3\", \"category\": \"ESG\", \"average_score\": \"0.32108825121806284\", \"company_id\": \"78\"}, {\"category_id\": \"4\", \"category\": \"Financial\", \"average_score\": \"0.16946399549066762\", \"company_id\": \"78\"}, {\"category_id\": \"5\", \"category\": \"Delivery\", \"average_score\": \"0.3172711275540405\", \"company_id\": \"78\"}, {\"category_id\": \"6\", \"category\": \"Competence\", \"average_score\": \"0.12735704312960733\", \"company_id\": \"78\"}]",
                    "next_expiry_date": "2023-02-23",
                    "more_details": null,
                    "sector_type": "standard",
                    "id": "11",
                    "company_id": "83",
                    "sector_id": "3186",
                    "jurisdiction_id": "85",
                    "company_size": "medium",
                    "date_created": "2023-02-20 15:41:53",
                    "date_last_modified": "2023-02-20 15:41:53",
                    "created_by": "mhooimei_mhooimeijer",
                    "last_modified_by": "mhooimei_mhooimeijer"
                }
            ]
            };

           // plotSectors(sectors);
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
                parent_sectors[parent_sector_id] = {
                    count: 1,
                    name: sector.parent_sector_name,
                    id: parent_sector_id,
                    sectors: [sector]
                };
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
            let segment_params = {
                start_angle: start_angle,
                segment_angle: seq_angle,
                inner_circle_radius: inner_circle_radius,
                segment_width: inner_segment_width,
                fill_color: fill_color,
                segment_stroke_color: inner_segment_stroke_color,
                segment_stroke_width: inner_segment_stroke_width
            };
            let segmentPath = getSegmentPathElement(segment_params);
            groupElem.appendChild(segmentPath)
            parent_sector.sectors.forEach((sector, index2) => {
                let sector_start_angle = start_angle + index2 * sector_segment_angle;
                let color_index = index2 % 2 == 0 ? 2 : 1
                let segment_params = {
                    start_angle: sector_start_angle,
                    segment_angle: sector_segment_angle,
                    inner_circle_radius: outer_circle_radius,
                    segment_width: outer_segment_width,
                    fill_color: color_palettes[color_palette_index][color_index],
                    segment_stroke_color: outer_segment_stroke_color,
                    segment_stroke_width: outer_segment_stroke_width,
                    animate: true,
                    onShowAdditionalFunction: 'showSector(' + JSON.stringify(sector) + ')',
                    onHideAdditionalFunction: 'hideSector()',
                    onclickFunction: 'alert("hello")'
                };

                let segmentPath = getSegmentPathElement(segment_params);
                groupElem.appendChild(segmentPath)
            })

            segment_params.segment_width = inner_segment_width + outer_segment_width / 2;
            segment_params.fill_color = "none";
            segment_params.segment_stroke_width = 2;

            segmentPath = getSegmentPathElement(segment_params);
            groupElem.appendChild(segmentPath)
            start_angle = start_angle + seq_angle;

            // draw the legend
            const legendGroup = document.getElementById("legend");
            const textElem = document.createElementNS('http://www.w3.org/2000/svg', 'text');
            textElem.setAttribute('x', (0).toString());
            textElem.setAttribute('y', (vertical_space_between_entries * (index + 1)).toString());
            textElem.setAttribute('text-anchor', 'left');
            textElem.classList.add('svg-legend-entry');
            textElem.setAttribute('fill', fill_color);
            textElem.innerHTML = parent_sector.name ? parent_sector.name : 'No parent sector';
            legendGroup.appendChild(textElem);
            testParamStructure({id: 12, name: "something"});
        });

    }

    function testParamStructure(param = null) {
        if (param && param.name) {
             console.log(param.name)
        } else {
            console.log('not set');
        }
    }

    function getScoreClase(score){
        if (score < 0.5) return 'score-bad';
        if (score < 0.75) return 'score-medium';
        return 'score-good';
    }


    function showSector(sector) {
        const my_score = JSON.parse(sector.sector_score)[0].average_score;
        const formatted_score = (Math.round(100 * my_score)).toString() + '%';
        const my_class = getScoreClase(my_score);

        const sectorDetailElem = document.getElementById('sector');
        sectorDetailElem.setAttribute('visibility', 'visible');

        const sectorNameElem = document.getElementById('sector_name');
        sectorNameElem.innerHTML = "Name: " + sector.sector_name;

        const sectorScoreElem = document.getElementById('sector_score');
        sectorScoreElem.classList.add(my_class);
        sectorScoreElem.innerHTML = "Score: " + formatted_score;
    }

    function hideSector() {

        const sectorDetailElem = document.getElementById('sector');
        sectorDetailElem.setAttribute('visibility', 'hidden');
        const sectorScoreElem = document.getElementById('sector_score');
        sectorScoreElem.classList.remove('score-good');
        sectorScoreElem.classList.remove('score-medium');
        sectorScoreElem.classList.remove('score-bad');
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

    function getSegmentPathElement(p) {
        const flip = p.segment_angle > 180 ? 1 : 0;
        const outer_circle_radius = p.inner_circle_radius + p.segment_width;
        const start_point_arc1_x = Math.round(Math.cos((360 - p.start_angle) / 360 * 2 * Math.PI) * p.inner_circle_radius);
        const start_point_arc1_y = Math.round(Math.sin((360 - p.start_angle) / 360 * 2 * Math.PI) * p.inner_circle_radius);

        const end_point_arc1_x = Math.round(Math.cos((360 - p.start_angle - p.segment_angle) / 360 * 2 * Math.PI) * p.inner_circle_radius);
        const end_point_arc1_y = Math.round(Math.sin((360 - p.start_angle - p.segment_angle) / 360 * 2 * Math.PI) * p.inner_circle_radius);

        const start_point_arc2_x = Math.round(Math.cos((360 - p.start_angle - p.segment_angle) / 360 * 2 * Math.PI) * (outer_circle_radius));
        const start_point_arc2_y = Math.round(Math.sin((360 - p.start_angle - p.segment_angle) / 360 * 2 * Math.PI) * (outer_circle_radius));

        const end_point_arc2_x = Math.round(Math.cos((360 - p.start_angle) / 360 * 2 * Math.PI) * (outer_circle_radius));
        const end_point_arc2_y = Math.round(Math.sin((360 - p.start_angle) / 360 * 2 * Math.PI) * (outer_circle_radius));

        const path =
            "M " + start_point_arc1_x + " " + start_point_arc1_y +
            " A " + (p.inner_circle_radius) + " " + (p.inner_circle_radius) + " 0 " + flip + " 0 " + end_point_arc1_x + " " + end_point_arc1_y + " " +
            " L " + start_point_arc2_x + " " + start_point_arc2_y + " " +
            " A " + (outer_circle_radius) + " " + (outer_circle_radius) + " 0 " + flip + " 1 " + end_point_arc2_x + " " + end_point_arc2_y + " Z";
        // add a path element to the svg
        const pathElem = document.createElementNS('http://www.w3.org/2000/svg', 'path');
        pathElem.setAttribute('d', path);
        pathElem.setAttribute('stroke', p.segment_stroke_color);
        pathElem.setAttribute('stroke-width', p.segment_stroke_width);
        pathElem.setAttribute('fill', p.fill_color);
        if (p.animate) {
            
            pathElem.setAttribute('onmouseover', 'this.setAttribute("transform", "scale(1.05, 1.05)");' + p.onShowAdditionalFunction + ';');
            pathElem.setAttribute('onmouseout', 'this.setAttribute("transform", "scale(1, 1)"); ' + p.onHideAdditionalFunction + ';');
        }
        if (typeof p.onclickFunction !== "undefined") {
            pathElem.setAttribute('onclick', p.onclickFunction + ';');
        }

        return pathElem;
    }

    function getSunBurstBands(level, bandwidth, num_elements, full = true, upper = true, segment_span = []) {
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
                const outer_segment_stroke_color = "white"
                const outer_segment_stroke_width = 0
                const outer_segment_width = 40
                let segment_params = {
                    start_angle: start_angle,
                    segment_angle: bandangle,
                    inner_circle_radius: inner_circle_radius,
                    segment_width: bandwidth,
                    fill_color: fill_color,
                    segment_stroke_color: outer_segment_stroke_color,
                    segment_stroke_width: outer_segment_stroke_width,
                    animate: false
                };
                const newPathElem = getSegmentPathElement(segment_params);
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
    getSunBurstBands(1, band_width_inner + 2, 2, true, true);
    //
    //  const num_levels = 5;
    //  const band_width = 400 / 2 / (num_levels + 2);
    //  getSunBurstBands(1, band_width, 1, false, true);
    //  getSunBurstBands(2, band_width, 6, false, true);
    //  getSunBurstBands(3, band_width, 20, true, true);
    //  getSunBurstBands(4, band_width, 1, false, true);
    //  getSunBurstBands(5, band_width, 20, false, true);
    // getSunBurstBands(6, band_width, 19, false, true);
    // getSunBurstBands(7, band_width, 40, false, true);
    // getSunBurstBands(8, band_width, 20, false, true);
    // getSunBurstBands(9, band_width, 15, false, true);


    // getSunBurstBands(1, band_width, 1, false, false);
    // getSunBurstBands(2, band_width, 6, false, false);
    // getSunBurstBands(3, band_width, 20, false, false);
    // getSunBurstBands(4, band_width, 1, false, false);
    // getSunBurstBands(5, band_width, 20, false, false);
    // getSunBurstBands(6, band_width, 19, false, false);

</script>


</body>
</html>