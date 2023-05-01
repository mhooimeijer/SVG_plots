<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inbox Test</title>
    <link href="https://fonts.googleapis.com/css?family=Abel" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <style>
        body {
            width: 90%;
            margin: auto;
        }
    </style>
</head>
<body>

<?php

$language_file_dir = __DIR__ . '/json/languages/';

$language_codes = getExistingLanguageFileCodeList($language_file_dir);
//var_dump($language_codes);
function getExistingLanguageFileCodeList(string $dir)
{
	$files = scandir($dir);
	$language_codes = [];
	foreach ($files as $file) {
		$has_match = preg_match('/language.(\w{2}).json/', $file, $matches);
		if ($has_match) {
			$language_code = $matches[count($matches) - 1];
			$language_codes[] = $language_code;
		}
	}
	return $language_codes;
//	var_dump(preg_grep('/language.(\w{2}).json/', $files));
//	var_dump(array_filter($files, function ($v) {
//		return preg_match('/language.(\w{2}).json/', $v);
//
//	}, 0));
	// var_dump($files);
}

if (isset($_POST["value"])) {
	echo "<code><pre>";
	echo(json_encode($_POST["value"]));
	echo "</pre></code>";


	$code = $_POST["value"]["language"]["code"];
	$filename = "$language_file_dir" . "language.$code.json";
	file_put_contents($filename, json_encode($_POST["value"]));
	echo "<h2 class='text-warning'>$filename</h2>";
}
//reference language
$target_language_code = $_GET["target_language"] ?? "nl";

$language_file_en = __DIR__ . '/json/languages/language.en.json';
$language_file_target = __DIR__ . "/json/languages/language.$target_language_code.json";

$json_reference_text = file_get_contents($language_file_en);
$json_target_text = file_get_contents($language_file_target);

$ref_language_object = json_decode($json_reference_text, true);
$target_language_object = json_decode($json_target_text, true);
//var_dump($target_language_object["language"]["name"]);

?>

<div class="container text-start">
    <div class="row p-3">
        <div class="col-3 p-3">
        </div>
        <div class="col-4 p-3">

        </div>
        <div class="col-5 p-3">
            <form target="#" method="get" class="form border border-1 p-2">
                <div class="row mb-3">
                    <label for="target_language" class="col-4 col-form-label-sm">Select Language</label>
                    <div class="col-4">
                        <select class="form-select form-control-sm" name="target_language" aria-label="Default select example">
							<?php
							foreach ($language_codes as $code) {
								echo "<option value=\"$code\">$code</option>\n";
							}
							?>
                        </select>
                    </div>
                    <div class="col-2 col-form-label">
                        <input class="btn btn-sm btn-primary" type="submit" value="Change">
                    </div>


                </div>


            </form>
        </div>
    </div>
</div>

<form method="post">
    <div class="container text-start">
        <div class="row p-3">
            <div class="col-3 p-3">
            </div>
            <div class="col-4 p-3">
                Reference Language <strong><?= $ref_language_object["language"]["name"] ?></strong>
            </div>
            <div class="col-5 p-3">
                Target Language <strong><?= $target_language_object["language"]["name"] ?></strong>
            </div>
        </div>
    </div>

	<?php
	foreach ($ref_language_object as $key => $value) {
		echo "
    <div class=\"row accordion\">
        <div class=\"col-12\">
            <div class='accordion-item'>
                <button class='accordion-button collapsed' type='button' data-bs-toggle='collapse' data-bs-target='#$key' aria-expanded='false' aria-controls='collapseOne'>
                    <h5>Page: $key</h5>
                </button>
                <div id='$key' class='accordion-collapse collapse' aria-labelledby='headingOne' data-bs-parent='#accordionExample'>

";

		foreach ($value as $value_key => $item) {
			$num_rows = ceil(strlen($item) / 60) + 1;
			// look up the value (if it exists) in the target file
			$item_value = $target_language_object[$key][$value_key] ?? "";

			$border_config = isset($target_language_object[$key][$value_key]) && strlen(trim($target_language_object[$key][$value_key])) > 0 ? "" : "border border-2 border-danger";

			echo "
                    <div class='row border border-1 my-3 p-2'>
                        <div class='col-3'>$value_key</div>
                        <div class='col-4'>$item</div>
                        <div class='col-5'> 
                            <textarea class='form-control $border_config' id='$value_key' name='value[$key][$value_key]' rows='$num_rows'>$item_value</textarea>
                       </div>
                    </div>
";

//            echo "<p><strong>$value_key</strong>: $item </p>\n";
		}
		echo "
                </div>
            </div>
        </div>
     </div>
";
	} ?>


    <input type="submit" value="Save"/>
</form>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
</body>
</html>

