<?php
class ValidateData
{
    /**
    * @bool
    * Note: This has some flaws
    * For example using numbers in the name of the email MAY give back some false negatives
    * For more details see this question: https://stackoverflow.com/questions/3722831/does-phps-filter-var-filter-validate-email-actually-work
    */
    public function validateEmail($email){
        if (filter_var(trim($email), FILTER_VALIDATE_EMAIL)){
            return true;
        }
        return false;
    }
    /**
    * @bool
    * example rules: /^[a-z\d_]{5,20}$/i
    */
    public function pregMatch($rules, $data){
        return (preg_match($rules, trim($data)));

    }
    

}

