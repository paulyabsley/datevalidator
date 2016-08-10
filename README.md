# Date Validator
Technical task to create a date validator in PHP
## Example usage
```
$dateString = "03/12/1999";
$result = DateValidator::validateHistoricalDate($dateString);
if (!$result->isValid()) {
    $message = $result->getMessage();
}
```
