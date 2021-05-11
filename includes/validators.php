<?php
/**
 * Donation Platform
 * Validating functions
 * @author Jeffrey Wang
 */

require(__DIR__ . '/dicts.php');

class Validators {
    public static function last_name($candidate) {
        return strlen($candidate) > 0 && strlen($candidate) <= 256;
    }

    public static function first_name($candidate) {
        return strlen($candidate) > 0 && strlen($candidate) <= 256;
    }

    public static function street_address($candidate) {
        return strlen($candidate) > 0 && strlen($candidate) <= 512;
    }

    public static function city($candidate) {
        return strlen($candidate) > 0 && strlen($candidate) <= 128;
    }
    
    public static function region($candidate) {
        return strlen($candidate) <= 128;
    }

    public static function country($candidate) {
        // Load countries from file in includes
        $countries_str = file_get_contents(__DIR__ . '/countries.txt');
        // Split by new line (https://stackoverflow.com/a/11165332)
        $countries = preg_split("/\r\n|\n|\r/", $countries_str);
        return strlen($candidate) > 0 && strlen($candidate) <= 64 && in_array($candidate, $countries); // must be in countries list
    }

    public static function postal_code($candidate) {
        if ($candidate !== '') {
            return strlen($candidate) <= 16;
        }
        return true;
    }

    public static function phone_number($candidate) {
        // there are many different formats of phone numbers.
        // it is not fair to use regex to filter some out in case
        // it rejects a country's phone number format.
        // it is fine to store it as a string as long as it meets string length requirements
        return strlen($candidate) > 0 && strlen($candidate) <= 32;
    }
    
    public static function email_address($email_candidate) {
        return strlen($candidate) > 0 && strlen($candidate) <= 254 && filter_var($email_candidate, FILTER_VALIDATE_EMAIL); // 254 is the limit per RFC 5321
    }

    public static function contact_method($candidate) {
        return $candidate === 'email' || $candidate === 'phone';
    }

    public static function currency($candidate) {
        return $candidate === 'USD' || $candidate === 'EUR' || $candidate === 'BTC';
    }

    public static function frequency($candidate) {
        return $candidate === 'monthly' || $candidate === 'yearly' || $candidate === 'once';
    }

    public static function donation_amount($candidate, $currency) {
        $result = true;
        if ($currency === 'BTC') {
            $amount = (int) ($candidate * 100000000); // 100 million
            $result = $result && is_int($amount);
        } elseif ($currency === 'USD' || $currency === 'EUR') {
            $amount = (int) ($candidate * 100); // convert to cents
            $result = $result && is_int($amount);
        } else {
            $result = false; // invalid currency
        }
        return $result && $candidate > 0;
    }

    public static function comments($candidate) {
        return strlen($candidate) <= 2048;
    }

    /**
     * validate_all
     * returns 'no problems' when successful, else returns the problematic field
     */
    public static function validate_all($assoc_arr) {
        global $field_titles;

        // Check whether all fields are there
        foreach ($field_titles as $field_id => $dontuse) {
            $value = $assoc_arr[$field_id];
            if ($value === null) {
                return $field_id;
            }
            if (method_exists('Validators', $field_id)) {
                if ($field_id === 'donation_amount') {
                    $individual_result = Validators::donation_amount($value, $assoc_arr['currency']);
                } else {
                    $individual_result = Validators::$field_id($value);
                }
                
                if (!$individual_result) {
                    return $field_id;
                }
            } else {
                // why wouldn't the function exist? garbage extraneous POST data
                // shouldn't be allowed for security reasons
                return $field_id;
            }
        }
        return 'no problems'; // no function name could have a space in it :)
    }

    public static function issue_tostring($result) {
        switch ($result) {
            case 'last_name':
                return "Last name needs to be between 0 and 256 characters.";
            case 'first_name':
                return "First name needs to be between 0 and 256 characters.";
            case 'street_address':
                return "Street address needs to be between 0 and 512 characters.";
            case 'city':
                return "City needs to be between 0 and 128 characters.";
            case 'region':
                return "Region cannot exceed 128 characters.";
            case 'country':
                return "Country needs to be a valid country in our list.";
            case 'postal_code':
                return "Postal code cannot exceed 16 characters.";
            case 'phone_number':
                return "Phone number needs to be between 0 and 32 characters.";
            case 'email_address':
                return "Email address needs to be between 0 and 254 characters and must include @ and the domain.";
            case 'contact_method':
                return "Contact method must be either phone or email.";
            case 'currency':
                return "Currency must be either USD, EUR, or BTC.";
            case 'frequency':
                return "Frequency must be either monthly, yearly, or one-time.";
            case 'donation_amount':
                return "Donation amount must be at least 0.01 USD/EUR or 0.00000001 BTC (1 satoshi).";
            case 'comments':
                return "Comments cannot be longer than 2048 characters.";
        }
        return "Unknown error";
    }
}