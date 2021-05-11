<?php
declare(strict_types=1);

require_once(__DIR__ . '/../includes/formatters.php');

use PHPUnit\Framework\TestCase;

final class FormattersTest extends TestCase {
    public function testValidateLastName() {
        $this->assertTrue(Validators::last_name('Doe'));
    }

    public function testCurrencyConverter() {
        $this->assertStringStartsWith(
            'In USD: $',
            Formatters::currency_converter('3.22', 'EUR')
        );
    }

    public function testDonationAmount() {
        $this->assertEquals(
            '€4.20',
            Formatters::donation_amount('4.20', 'EUR')
        );
    }
}