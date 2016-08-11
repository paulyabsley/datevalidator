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

	private $dateString;
	private $historicDate = false;
	private $strictFormat = false;

	function __construct($dateString) {
		$this->dateString = $dateString;
	}

	/**
	 * Create new instance of DateValidator
	 * @param string $dateString
	 * @return object Instance of DateValidator
	 */
	public static function validateDate($dateString) {
		$instance = new DateValidator($dateString);
		return $instance;
	}

	/**
	 * Create new instance of DateValidator for historic dates
	 * @param string $dateString
	 * @param bool $strictFormat Can be set to false for more forgiving date input formats
	 * @return object Instance of DateValidator
	 */
	public static function validateHistoricalDate($dateString, $strictFormat = true) {
		$instance = new DateValidator($dateString);
		$instance->historicDate = true;
		$instance->strictFormat = $strictFormat;
		return $instance;
	}

	/**
	 * Check if date is empty
	 * @return bool
	 */
	public function isEmpty() {
		return empty($this->dateString) ? true : false;
	}

	/**
	 * Check date is valid
	 * @param bool $historic option
	 * @return mixed Bool when not empty and historic option is set, datetime Object when historic is false and date is valid
	 */
	public function isValid($historic = false) {
		// Allow more forgiving date format entry
		$date = DateTime::createFromFormat('d/m/Y', $this->dateString); // False when not a valid date
		
		// Require specific DD/MM/YYYY format
		if ($this->strictFormat) {
			$dateItems = explode('/', $this->dateString);
			// Check there are 3 elements
			if (count($dateItems) === 3) {
				// And each is the correct length
				if (strlen($dateItems[0]) === 2 && strlen($dateItems[1]) === 2 && strlen($dateItems[2]) === 4) {
					$ymd = $dateItems[2] . '-' . $dateItems[1] . '-' . $dateItems[0];
					try {
						$date = new DateTime($ymd);
					} catch (Exception $e) {
				    	$error = $e->getMessage();
				    	$date = false;
					}
				} else {
					$date = false;
				}
			} else {
				$date = false;
			}
		}

		// Check it is a historic date
		if ($date && $historic) {
			return $this->isHistoric($date);
		}

		return $date;
	}

	/**
	 * Check date is historic
	 * @param object $date
	 * @return bool
	 */
	private function isHistoric($date) {
		$now = new DateTime();
		return $now > $date;
	}

	/**
	 * Provide feedback of date validity
	 * @return string
	 */
	public function getMessage() {
		$format =  '<br>Please use DD/MM/YYYY format e.g. 03/12/1999';
		// Check a value has been provided
		if ($this->isEmpty()) {
			$type = 'primary';
			$message = 'Please enter a historic date value.' . $format;
		} else {
			// Check value is valid
			if ($this->isValid($this->historicDate)) {
				$type = 'success';
				$message = 'Valid historic date!';
			} else {
				$type = 'alert';
				if ($this->historicDate) {
					$message = 'The provided date is not a valid <em>historic</em> date.' . $format;
				} else {
					$message = 'The provided date is not valid.' . $format;
				}
			}
		}
		return $this->outputMessage($type, $message);
	}

	/**
	 * HTML output for message
	 * @param string $type type class
	 * @param string $message
	 */
	private function outputMessage($type, $message) {
		$o = '<div class="callout ' . $type . '">';
		$o .= '<p>' . $message . '</p>';
		$o .= '</div>';
		return $o;
	}

}