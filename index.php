<?php
/**
 * Donation Platform
 * Home page (with donation form)
 * @author Jeffrey Wang
 */

require_once(__DIR__ . '/includes/header.php');
?>
<div class="row">
    <div class="col">
        <form method="post" action="review.php">
            <div class="form-group">
                <label>First name</label>
                <input type="text" name="first_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Last name</label>
                <input type="text" name="last_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Street address</label>
                <input type="text" name="street_address" class="form-control" required>
            </div>
            <div class="form-group">
                <label>City</label>
                <input type="text" name="city" class="form-control" required>
            </div>
            <div class="form-group">
                <label>State/Region</label>
                <input type="text" name="region" class="form-control">
            </div>
            <div class="form-group">
                <label>Country</label>
                <select class="form-control" name="country">
                    <?php
                    // Load countries from file in includes
                    $countries_str = file_get_contents(__DIR__ . '/includes/countries.txt');
                    // Split by new line (https://stackoverflow.com/a/11165332)
                    $countries = preg_split("/\r\n|\n|\r/", $countries_str);
                    foreach ($countries as $country_name) {
                        echo "<option value=\"$country_name\">$country_name</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label>Postal code</label>
                <input type="text" name="postal_code" class="form-control">
            </div>
            <div class="form-group">
                <label>Phone number</label>
                <input type="tel" name="phone_number" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Email address</label>
                <input type="email" name="email_address" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Preferred form of contact</label>
                <select class="form-control" name="contact_method">
                    <option value="phone">Phone</option>
                    <option value="email">Email</option>
                </select>
            </div>
            <div class="form-group">
                <label>Preferred form of payment</label>
                <select class="form-control" id="currency" name="currency">
                    <option value="USD">USD - $ - United States dollar</option>
                    <option value="EUR">EUR - € - Euro</option>
                    <option id="btc" value="BTC">BTC - Bitcoin</option>
                </select>
            </div>
            <div class="form-group">
                <label>Frequency of donation</label>
                <select class="form-control" name="frequency">
                    <option value="monthly">Monthly</option>
                    <option value="yearly">Yearly</option>
                    <option value="once">One-time</option>
                </select>
            </div>
            <div class="form-group">
                <label>Amount of donation</label>
                <input type="number" id="donation_amount" name="donation_amount" class="form-control" min="0.00000001" step="0.00000001" required>
            </div>
            <div class="form-group">
                <label>Comments</label>
                <textarea name="comments" maxlen="2048"></textarea>
            </div>
            <button id="submitbtn" type="submit" class="btn btn-lg btn-success">Review</button>
            <div class="d-flex justify-content-center p-3">
                <div id="spinner" class="spinner-border displaynone" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </form>
    </div>
</div>
<?php
require_once(__DIR__ . '/includes/footer.php');