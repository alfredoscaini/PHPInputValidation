<?php
/**
 * Validation Class file.
 *  
 * @author Alfredo Scaini
 * @package alfredoscaini\PHPInputValidation
 * @version 1.0 
*/

namespace WC;

/**
 * PHP Validation class to check inputs
 * 
 */
class Validation {
  const NUMBER    = 1;
  const ALPHANUM  = 2;
  const ALPHA     = 3;
  const DIGIT     = 4;
  const DATE      = 5;
  const TEXT      = 6;
  const PHONE     = 7;
  const EMAIL     = 8;
  const URL       = 9;
    
  /**
   * check method
   * This method will check that the data coming in conforms to the data type being expected
   * 
   * @param mixed $data The data we want to validate
   * @param int $validation_type  the data type we are to check against
   * @param array $params Any additional information to help check that the data is valid
   * 
   * @return bool True or false depending on the outcome
   */
	public static function check($data, int $validation_type = 0, array $params = []) : bool {
    
    $min    = ($params['min'])    ?? -2147483647;
    $max    = ($params['max'])    ?? PHP_INT_MAX;
    $format = ($params['format']) ?? '';
    
    switch ($validation_type) {
      case self::NUMBER:
        if ($data > $max || $data < $min) { return false; }
        return ( filter_var($data, FILTER_VALIDATE_INT) == false ) ? false : true;
      break;

      case self::EMAIL:
        if (!preg_match("/([a-zA-Z0-9]{2,}\.[a-zA-Z0-9]*)$/", $data)) { return false; }
        return (filter_var($data, FILTER_VALIDATE_EMAIL) == false) ? false : true;
      break;

      case self::URL:
        if (!preg_match("/^(ftp|http|https):\/\//i", $data)) { return false; }
        if (!preg_match("/[a-zA-Z0-9]{2,}$/", $data)) { return false; }
        return (filter_var($data, FILTER_VALIDATE_URL) == false) ? false : true;
      break;

      case self::ALPHANUM:
        return ctype_alnum($data);
      break;

      case self::TEXT:
        return (strlen($data) >= 1 && is_string($data)) ? true : false ;
      break;

      case self::ALPHA:
        return ctype_alpha($data);
      break;

      case self::DIGIT:
        return ctype_digit($data);
      break;

      case self::DATE:
        return self::date($data, $format);
      break;

      case self::PHONE:
        $pattern = '/^[0-9]{3}[ |\-|\.]?[0-9]{3}[ |\-|\.]?[0-9]{4}$/';
        return (preg_match($pattern, $data) ? 1 : 0);
      break;

      default:
        return false;
      break;
    }
  }

  /**
   * date method
   * This method will validate that the date is a valid date, according to the format
   * being passed in.
   * 
   * @param string $data The date to check
   * @param string $format The format in which we need to check
   * 
   * @return bool True or false depending on the outcome.
   */
  private function date(string $data = '', string $format = '') : bool {
  $valid = false;

    switch($format) {
      case 'YYYYMMDD':
        if (strlen($data) == 8) { 
          $year  = substr($data, 0, 4);
          $month = substr($data, 4, 2);
          $day   = substr($data, 6, 2);

          $valid = (checkdate($month, $day, $year)) ? true : false ;
        }
      break;
    
      case 'TIMESTAMP':
        $valid = ($data <= PHP_INT_MAX) ? true : false;
      break;

      case 'YYYY-MM-DD':
        $valid_format = (preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/", $data)) ? true : false ;

        if (strlen($data) == 10 && $valid_format) {
          $year = intval(substr($data, 0, 4));
          $month = intval(substr($data, 5, 2));
          $day   = intval(substr($data, 8, 2));
          $valid = (checkdate($month, $day, $year)) ? true : false ;
        }
      break;
    
      case 'MM/DD/YYYY HH:MM:SS':
        $valid_format = (preg_match("/[0-9]{2}\/[0-9]{2}\/[0-9]{4} [0-9]{2}:[0-9]{2}:[0-9]{2}/", $data)) ? true : false ;

        if (strlen($data) == 19 && $valid_format) {
          $year  = intval(substr($data, 6, 4));
          $month = intval(substr($data, 0, 2));
          $day   = intval(substr($data, 3, 2));
          $valid = (checkdate($month, $day, $year)) ? true : false ;
        }
      break;

      default:
        $valid = false; // Unnknown date format
    }

    return $valid;
  }
}