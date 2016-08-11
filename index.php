<?php
require_once('datevalidator.class.php');

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$dateString = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING);
	$result = DateValidator::validateHistoricalDate($dateString);
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
				</form>
				<?php echo $message; ?>
			</div>
		</div>
	</div>
</body>
</html>