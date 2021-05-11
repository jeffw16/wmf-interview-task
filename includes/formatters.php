<?php
/**
 * Donation Platform
 * Validating functions
 * @author Jeffrey Wang
 */

require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../settings.php');

use Swap\Builder;

class Formatters {
    public static function last_name($candidate) {
        return $candidate;
    }

    public static function first_name($candidate) {
        return $candidate;
    }

    public static function street_address($candidate) {
        return $candidate;
    }

    public static function city($candidate) {
        return $candidate;
    }
    
    public static function region($candidate) {
        return $candidate;
    }

    public static function country($candidate) {
        return $candidate;
    }

    public static function postal_code($candidate) {
        return $candidate;
    }

    public static function phone_number($candidate) {
        // there are many different formats of phone numbers.
        return $candidate;
    }
    
    public static function email_address($candidate) {
        return $candidate;
    }

    public static function contact_method($candidate) {
        if ($candidate === 'email') {
            return "Email";
        } elseif ($candidate === 'phone') {
            return "Phone";
        }
        return "Unknown";
    }

    public static function currency($candidate) {
        if ($candidate === 'USD') {
            return "U.S. dollar";
        } elseif ($candidate === 'EUR') {
            return "Euro";
        } elseif ($candidate === 'BTC') {
            return "Bitcoin";
        }
        return "Unknown";
    }

    public static function frequency($candidate) {
        if ($candidate === 'once') {
            return "one-time";
        }
        return $candidate;
    }

    public static function donation_amount($candidate, $currency) {
        $currency_symbol = [
            'USD' => '$',
            'EUR' => '€',
            'BTC' => 'BTC',
        ];
        return $currency_symbol[$currency] . $candidate;
    }

    public static function comments($candidate) {
        return $candidate;
    }

    public static function currency_converter($amount, $currency) {
        global $erapi_access_key;
        // currency conversion
        // Build Swap
        $swap = (new Builder())
        ->add('exchange_rates_api', ['access_key' => $erapi_access_key])
        ->build();

        // Get the latest EUR/USD rate
        $rate = $swap->latest("$currency/USD");
        $converted_val = $amount * $rate->getValue();
        $formatted = "In USD: $$converted_val";
        return $formatted;
    }
}