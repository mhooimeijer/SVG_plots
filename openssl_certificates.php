<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Open SSL Test</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Abel&family=Caveat&family=Montserrat:wght@400;600&display=swap"
          rel="stylesheet">
    <style>
        *,
        *::after,
        *::before {
            box-sizing: border-box;
        }

        body {
            font-family: "Abel", sans-serif;
            background-color: lightgrey;
        }

        div.content {
            background-color: white;
        }

        .animated-logo {
            position: fixed;
            right: 20px;
            width: 150px;
        }

        svg.value-score-logo .letter-v {
            animation: svg_logo_v 5s forwards;
        }

        .swipe {
            animation: my_swipe 3s forwards;
            /*filter: url(#sofGlow);*/
        }

        @keyframes svg_logo_v {
            50% {
                fill: lightgreen;
                /*transform: scale(1.1);*/
            }
            100% {
                fill: rgb(135, 210, 231);
                transform: scale(1);
            }
        }

        @keyframes my_swipe {
            0% {
                x1: 0;
                x2: 0;
            }
            50% {
                x1: 20;
                x2: 20;
            }
            100% {
                x1: 100%;
                x2: 100%;
            }
        }
    </style>
</head>
<body>
<img class="animated-logo" src="images/value_score_logo_animated_cropped_one_loop.gif" width="100px">


<svg class="value-score-logo" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 36 36" width="180px"
     height="180px">
    <defs>
        <filter id="sofGlow" height="300%" width="300%" x="-75%" y="-75%">
            <!-- Thicken out the original shape -->
            <feMorphology operator="dilate" radius="4" in="SourceAlpha" result="thicken"/>

            <!-- Use a gaussian blur to create the soft blurriness of the glow -->
            <feGaussianBlur in="thicken" stdDeviation="10" result="blurred"/>

            <!-- Change the colour -->
            <feFlood flood-color="rgb(0,186,255)" result="glowColor"/>

            <!-- Color in the glows -->
            <feComposite in="glowColor" in2="blurred" operator="in" result="softGlow_colored"/>

            <!--	Layer the effects together -->
            <feMerge>
                <feMergeNode in="softGlow_colored"/>
                <feMergeNode in="SourceGraphic"/>
            </feMerge>

        </filter>

        <filter id="red-glow" filterUnits="userSpaceOnUse"
                x="-50%" y="-50%" width="200%" height="200%">
            <!-- blur the text at different levels-->
            <feGaussianBlur in="SourceGraphic" stdDeviation="5" result="blur5"/>
            <feGaussianBlur in="SourceGraphic" stdDeviation="10" result="blur10"/>
            <feGaussianBlur in="SourceGraphic" stdDeviation="20" result="blur20"/>
            <feGaussianBlur in="SourceGraphic" stdDeviation="30" result="blur30"/>
            <feGaussianBlur in="SourceGraphic" stdDeviation="50" result="blur50"/>
            <!-- merge all the blurs except for the first one -->
            <feMerge result="blur-merged">
                <feMergeNode in="blur10"/>
                <feMergeNode in="blur20"/>
                <feMergeNode in="blur30"/>
                <feMergeNode in="blur50"/>
            </feMerge>
            <!-- recolour the merged blurs red-->
            <feColorMatrix result="red-blur" in="blur-merged" type="matrix"
                           values="1 0 0 0 0
                             0 0.06 0 0 0
                             0 0 0.44 0 0
                             0 0 0 1 0"/>
            <feMerge>
                <feMergeNode in="red-blur"/>       <!-- largest blurs coloured red -->
                <feMergeNode in="blur5"/>          <!-- smallest blur left white -->
                <feMergeNode in="SourceGraphic"/>  <!-- original white text -->
            </feMerge>
        </filter>
    </defs>
    <mask id="myMask">
        <!-- Everything under a white pixel will be visible -->
<!--        <rect x="0" y="0" width="100" height="100" fill="rgb(135,210,231)" />-->

        <line class="swipe" x1="0" y1="0" x2="0" y2="100%" stroke="white" stroke-width="0">
            <animate
                    attributeName="stroke"
                    values="rgb(135,210,231);green;rgb(135,210,231)"
                    dur="2s"
                    repeatCount="1"/>
            <animate
                    attributeName="stroke-width"
                    values="0;72"
                    begin="0s"
                    dur="2s"
                    repeatCount="1"
                    fill="freeze"
            />
<!--            <animateTransform-->
<!--                    attributeName="transform" attributeType="XML"-->
<!--                    type="translate" from="0 0" to="36 0"-->
<!--                    begin="0s" dur="2s" fill="freeze" />-->
        </line>

        <!-- Everything under a black pixel will be invisible -->
    </mask>
    <rect height="36" width="36" fill="black"></rect>
    <g transform="translate(6, 6)" fill="rgb(135,210,231)" >
        <path class="icon-background-fill" d="M0 0 L24 0 L24 3.2 L24 17.8 L12 24.4 L0 17.8 Z" stroke-width="0"
              stroke="black" fill="black"/>
        <!--        <path class="icon" d="M0 0 L24 0 L24 3.2 L14.4 3.2 L0 11.4 L0 8 L8.2 3.2 L0 3.2 Z" stroke-width="0" />-->
        <path class="icon letter-v" d="M0 0 L0 11.4 L14.4 3.2 L24 3.2 L24 0 L13.66 0 L0 8 L3.2 6.12 L3.2 0 Z"
              stroke-width="0" mask="url(#myMask)">
            <!--            <animate-->
            <!--                    attributeName="fill"-->
            <!--                    values="rgb(135,210,231);green;rgb(135,210,231)"-->
            <!--                    dur="2s"-->
            <!--                    repeatCount="2" />-->
        </path>
        <path class="icon letter-s"
              d="M0 16.7 L0 16 L15.4 7 L24 7 L24 10.2 L16.2 10.2 L9.6 13.8 L24 13.8 L24 17.8 L12 24.4 L5.4 20.8 L12.4 20.8 L20 16.7 Z"
              stroke-width="0"/>
    </g>
</svg>
<section>
    <h1>Basic Encryption and Decryption with Open SSL</h1>
    <div class="content">

		<?php

		date_default_timezone_set('America/New_York');
		$key = 'qkwjdiw239&&jdafweihbrhnan&^%$ggdnawhd4njshjwuuO';

		define("encryption_method", "AES-128-CBC");
		define("key", 'qkwjdiw239&&jdafweihbrhnan&^%$ggdnawhd4njshjwuuO');
		define("SIGN_ALGORITHM", OPENSSL_ALGO_SHA512);


		$res = openssl_pkey_new();

		//echo extension_loaded("openssl") . PHP_EOL;

		//var_dump($res);
		// Get private key
		openssl_pkey_export($res, $privatekey);

		// Get public key
		$keyset = openssl_pkey_get_details($res);
		//var_dump($keyset);
		$public_key = $keyset["key"];

		echo "Private Key:<BR>
<pre>
$privatekey
</pre>
Public Key:
<pre>
$public_key
</pre>";

		$data = "this is my data set";

		echo $data;

		openssl_sign($data, $signature, $privatekey, SIGN_ALGORITHM);
		echo "<br><br>
Signature:
<pre>
$privatekey
</pre>";


		$changed_data = "this is changed data!";

		$verification_result1 = openssl_verify($data, $signature, $public_key, SIGN_ALGORITHM) ? "Valid signature" : "Invalid signature";
		$verification_result2 = openssl_verify($changed_data, $signature, $public_key, SIGN_ALGORITHM) ? "Valid signature" : "Invalid signature";


		echo "<br><br>
Verification result of the signature of original:
<pre>
$verification_result1
</pre>";

		echo "<br><br>
Verification result of the signature with changed data:
<pre>
$verification_result2
</pre>";

		?>
    </div>
</section>
</body>
</html>
