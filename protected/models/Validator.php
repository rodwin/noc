<?php
class Validator {

  static function InArrayKey($key, $array) {
		
      if (is_array($array) AND in_array($key, array_keys( $array ) ) ) {
          return TRUE;
      }

      return FALSE;
  }

  static function IsPhoneNumber($value) {

      //Strip out all non-numeric characters.
      $phone = MiscValidator::stripNonNumeric($value);


      if ( strlen($phone) >= 6 AND strlen($phone) <= 20
           AND preg_match('/^[0-9\(\)\-\.\+\ ]{6,20}$/i',$value) ) {
          return TRUE;
      }

      return FALSE;
  }

  static function stripSpaces($value) {
      return str_replace(" ", "", trim($value));
  }

  static function stripNonNumeric($value) {
      $retval = preg_replace('/[^0-9]/','',$value);

      return $retval;
  }

  static function stripNonAlphaNumeric($value) {
      $retval = preg_replace('/[^A-Za-z0-9]/','',$value);

      return $retval;
  }

  static function stripNonFloat($value) {
      $retval = preg_replace('/[^-0-9\.]/','',$value);

      return $retval;

  }

  static function isDate($value) {
      if ( $value != '' AND is_numeric($value) ) {
          $date = gmdate("U", $value);

          if (  $date == $value ) {
              return TRUE;
          }
      }

      return FALSE;
  }

  //Checks a result set for one or more rows.
  static function isResultSetWithRows($rs) {

      if ( is_object($rs) ) {
          foreach($rs as $result) {
              return TRUE;
          }
      }

      return FALSE;
  }

  //Function to simple set an error.
  static function isTrue($value) {
      if ($value == TRUE) {
          return TRUE;
      }

      return FALSE;
  }

  static function isNumeric($value) {

      if ( is_numeric( $value ) == TRUE ) {
          return TRUE;
      }


      return FALSE;
  }

}
