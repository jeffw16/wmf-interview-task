<?php
declare(strict_types=1);

require_once(__DIR__ . '/../includes/validators.php');

use PHPUnit\Framework\TestCase;

final class ValidatorsTest extends TestCase {
    public function testValidateLastName() {
        $this->assertTrue(Validators::last_name('Doe'));
    }

    public function testValidateAllSuccess() {
        $values = [
            'last_name' => 'Doe',
            'first_name' => 'John',
            'street_address' => '123 Main St',
            'city' => 'Kirkland',
            'region' => 'Washington',
            'country' => 'United States',
            'postal_code' => '98033',
            'phone_number' => '+1 (206) 321-2345',
            'email_address' => 'jdoe@wikimedia.org',
            'contact_method' => 'email',
            'currency' => 'BTC',
            'frequency' => 'yearly',
            'donation_amount' => '0.00000001',
            'comments' => 'I love Wikipedia!',
        ];
        $this->assertEquals(
            'no problems',
            Validators::validate_all($values)
        );
    }

    public function testValidateAllFailOnLastName() {
        $values = [
            'first_name' => 'John',
            'street_address' => '123 Main St',
            'city' => 'Kirkland',
            'region' => 'Washington',
            'country' => 'United States',
            'postal_code' => '98033',
            'phone_number' => '+1 (206) 321-2345',
            'email_address' => 'jdoe@wikimedia.org',
            'contact_method' => 'email',
            'currency' => 'BTC',
            'frequency' => 'yearly',
            'donation_amount' => '0.00000001',
            'comments' => 'I love Wikipedia!',
        ];
        $this->assertEquals(
            'last_name',
            Validators::validate_all($values)
        );
    }
}