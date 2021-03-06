<?php
/**
 * Donation Platform
 * Donation submission object definition
 * @author Jeffrey Wang
 */

require(__DIR__ . '/dicts.php');
require_once(__DIR__ . '/validators.php');
require(__DIR__ . '/../settings.php');

class DonationSubmission {
    // private $id; // int
    private $state_name; // string: {invalid-uncommitted, valid-uncommitted, valid-committed}
    private $last_name; // string
    private $first_name; // string
    private $street_address; // string
    private $city; // string
    private $region; // string
    private $country; // string
    private $postal_code; // string
    private $phone_number; // string
    private $email_address; // string
    private $contact_method; // string: {phone, email}
    private $currency; // string: {USD, EUR, BTC}
    private $frequency; // string: {monthly, yearly, once}
    private $donation_amount; // int
    private $comments; // string

    public function __construct($data) {
        global $field_titles;
        $this->state_name = 'invalid-uncommitted';
        // Validate values
        $validation_status = Validators::validate_all($data);
        if ($validation_status !== 'no problems') {
            $this->state_name = 'invalid-uncommitted';
        } else {
            // Initialize these values
            foreach ($field_titles as $field_id => $dontuse) {
                if ($field_id === 'donation_amount') {
                    $currency = $data['currency'];
                    if ($currency === 'EUR' || $currency === 'USD') {
                        $data[$field_id] *= 100;
                    } elseif ($currency === 'BTC') {
                        $data[$field_id] *= 100000000;
                    }
                }
                $this->$field_id = $data[$field_id];
            }
            $this->state_name = 'valid-uncommitted';
        }
    }

    public function commit() {
        global $field_titles, $mysql_host, $mysql_user, $mysql_pass, $mysql_dbname;
        // Commit to DB
        // idempotency built-in by state check
        if ($this->state_name === 'valid-committed') {
            return true; // don't repeat, but it did already previously work
        }
        if ($this->state_name === 'valid-uncommitted') {
            // Attempt connection to database using PDO
            try {
                $options = [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ];
                $pdo = new PDO('mysql:host=' . $mysql_host . ';'
                . 'dbname=' . $mysql_dbname . ';'
                . 'charset=utf8mb4',
                $mysql_user,
                $mysql_pass,
                $options);
            } catch (\PDOException $ex) {
                throw new \PDOException($ex->getMessage(), (int) $ex->getCode());
            }

            $sql_query = "INSERT INTO `submissions` ("
            . "last_name, first_name, street_address, city, region, country, postal_code,"
            . "phone_number, email_address, contact_method, currency, frequency, donation_amount,"
            . "comments"
            . ") VALUES ("
            . ":last_name, "
            . ":first_name, "
            . ":street_address, "
            . ":city, "
            . ":region, "
            . ":country, "
            . ":postal_code, "
            . ":phone_number, "
            . ":email_address, "
            . ":contact_method, "
            . ":currency, "
            . ":frequency, "
            . ":donation_amount, "
            . ":comments "
            . ")";
        
            $statement = $pdo->prepare($sql_query);

            $mapping = [];
            foreach ($field_titles as $field_id => $dontuse) {
                $mapping[$field_id] = $this->$field_id;
            }

            $sql_successful = $statement->execute($mapping);

            if ($sql_successful) {
                $this->state_name = 'valid-committed';
                return true;
            }
        }
        return false; // any other state, return false
    }

    public function getState() {
        return $this->state_name;
    }
}