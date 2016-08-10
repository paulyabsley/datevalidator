<?php

/*
Create a date validator in PHP that will check that a given date is a valid historical date. It will accept the date as a string, which is assumed to have come from user input. The user will have been told to use the format DD/MM/YYYY. Any non-valid dates or strings which do not match this format should be rejected. An example of it in use would be:
 
$dateString = "03/12/1999";
$result = DateValidator::validateHistoricalDate($dateString);
if (!$result->isValid()) {
    $message = $result->getMessage();
}
*/

class DateValidator
{

	/**
	 * Create new instance of DateValidator
	 * @param string $dateString (DD/MM/YYYY)
	 * @return object Instance of DateValidator
	 */
	public static function validateHistoricalDate($dateString) {
		return new DateValidator();
	}

	/**
	 * Validate the date is historic
	 * @return bool
	 */
	public function isValid() {
		return false;
	}

	/**
	 * Provide feedback of historic date validity
	 * @return string
	 */
	public function getMessage() {
		return $this->isValid() ? 'This is a valid historic date.' : 'This is not a valid historic date.';
	}

}