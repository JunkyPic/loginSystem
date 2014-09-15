<?php
class ValidateData{
    /**
    * @bool
    * Note: This has some flaws
    * For example using numbers in the name of the email MAY give back some false negatives
    * For more details see this question: https://stackoverflow.com/questions/3722831/does-phps-filter-var-filter-validate-email-actually-work
    */
    public static function validateEmail($email){
        if (filter_var($email, FILTER_VALIDATE_EMAIL)){
            return true;
        }
        return false;
    }
    
    /**
    * @bool
    * example rules: /^[a-z\d_]{5,20}$/i
    */
    public static function pregMatch($rules, $data){
        return (preg_match($rules, $data));
    }
    
    /**
    * @bool
    * requires associative array
    */
    public static function isEmpty($data){
        foreach($data as $value){
            if(empty($value)){
                return true;
            }
        return false; 
        }
    }
    
    /**
    * @param associative array
    * stripAllWhiteSpaces will remove ALL white spaces.
    * example: $stringBefore = ' this is an example';
    *          $stringAfter  = 'thisisanexample';
    */
    public static function stripAllWhiteSpaces($data){
        foreach($data as $key => $value){
            $data[$key] = str_replace(' ', '', $value);
        }
        return $data;
    }
}

