<?php
require_once('datevalidator.class.php');

$message = '';
$strictFormat = true;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$dateString = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING);
	$format = filter_input(INPUT_POST, 'strict', FILTER_SANITIZE_NUMBER_INT);
	if (!isset($format)) {
		$strictFormat = false;
	}
	$result = DateValidator::validateHistoricalDate($dateString, $strictFormat);
	$message = $result->getMessage();
}

?>

<html dir="ltr" lang="en-GB">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Date Validator</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/foundation/6.2.3/foundation.min.css">
</head>
<body>
	<div class="column row">
		<h1>Date Validator</h1>
		<div class="row">
			<div class="medium-6 column">
				<form method="post">
					<label for="date">Historic Date <span>(DD/MM/YYYY)</span></label>
					<div class="input-group">
						<input type="text" id="date" name="date" placeholder="03/12/1999" maxlength="10" value="<?php echo isset($dateString) ? $dateString : '' ?>" class="input-group-field">
						<div class="input-group-button">
							<input type="submit" value="Validate Date" class="button">
						</div>
					</div>
					<label for="strict">Strict Format</label>
					<div class="switch">
						<input class="switch-input" id="strict" type="checkbox" name="strict" value="1"<?php echo $strictFormat ? ' checked' : ''; ?>>
						<label class="switch-paddle" for="strict">
							<span class="show-for-sr">Strict Format</span>
						</label>
					</div>
				</form>
				<?php echo $message; ?>
			</div>
		</div>
	</div>
</body>
</html>