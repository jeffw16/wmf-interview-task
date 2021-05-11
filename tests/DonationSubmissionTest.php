<?php
declare(strict_types=1);

require(__DIR__ . '/../vendor/autoload.php');

require_once(__DIR__ . '/../includes/DonationSubmission.php');

use PHPUnit\Framework\TestCase;

final class DonationSubmissionTest extends TestCase {
    public function testDSState() {
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
        $ds = new DonationSubmission($values);
        $this->assertEquals(
            'valid-uncommitted',
            $ds->getState()
        );
    }
}