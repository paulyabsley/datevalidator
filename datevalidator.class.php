<?php

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