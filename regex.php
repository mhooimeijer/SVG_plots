<?php

$text = '12- Brooklyn_St Akron (NY), 14001';
$text = "My Company";
$result = preg_replace('/[^a-zA-Z0-9_]/', '', $text);
echo $result;

/*
    Output: 12 Brooklyn_St Akron NY 14001
*/

