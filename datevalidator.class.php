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
	private $dateFormatError;

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
	 * @return object Instance of DateValidator
	 */
	public static function validateHistoricalDate($dateString) {
		$instance = new DateValidator($dateString);
		$instance->historicDate = true;
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
	 * @return mixed false if dateString is invalid, datetime Object when format is correct
	 */
	public function isValid($historic = false) {		
		$dateItems = explode('/', $this->dateString);
		// Check there are 3 elements
		if (count($dateItems) === 3) {
			// And each is the correct length
			if (strlen($dateItems[0]) === 2 && strlen($dateItems[1]) === 2 && strlen($dateItems[2]) === 4) {
				$day = intval($dateItems[0]);
				$month = intval($dateItems[1]);
				$year = intval($dateItems[2]);
				// And it is a gregorian date
				$isGregorianDate = checkdate($month, $day, $year);
				if ($isGregorianDate) {
					// Create DateTime object
					try {
						$date = new DateTime($year . '-' . $month . '-' . $day);
					} catch (Exception $e) {
						$this->dateFormatError = $e->getMessage();
						$date = false;
					}
				} else {
					$date = false;
				}
			} else {
				$date = false;
			}
		} else {
			$date = false;
		}

		// Check it is a historic date
		if ($date && $historic) {
			if ($this->isHistoric($date)) {
				return $date;
			} else {
				$date = false;
			}
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
			$dateIsValid = $this->isValid($this->historicDate);
			if ($dateIsValid) {
				$type = 'success';
				$td = '<br>' . $dateIsValid->format('l j F Y');
				if ($this->historicDate) {
					$message = 'Valid historic date!';
					$message .= $td;
				} else {
					$message = 'Valid date!';
					$message .= $td;
				}
			} else {
				$type = 'alert';
				if ($this->historicDate) {
					$message = 'The provided date is not a valid <em>historic</em> date.' . $format;
					$message .= $this->dateFormatError;
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