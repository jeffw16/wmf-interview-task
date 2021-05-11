<?php
/**
 * Donation Platform
 * Review donation
 * @author Jeffrey Wang
 */

require_once(__DIR__ . '/includes/validators.php');
require_once(__DIR__ . '/includes/formatters.php');
require_once(__DIR__ . '/includes/header.php');

$validation_response = Validators::validate_all($_POST);
?>
<div class="row">
    <div class="col">
        <?php
        if ($validation_response !== 'no problems') {
            ?>
            <h3>Review your donation</h3>
            <?php
            foreach ($_POST as $field => $value) {
                if ($field === 'donation_amount') {
                    echo "<p>$field_titles[$field]: " . Formatters::donation_amount($value, $_POST['currency']) . "</p>";
                } else {
                    echo "<p>$field_titles[$field]: " . Formatters::$field($value) . "</p>";
                }
                if ($field === 'donation_amount' && ($_POST['currency'] === 'EUR' || $_POST['currency'] === 'BTC')) {
                    echo "<p>" . Formatters::currency_converter($value, $_POST['currency']) . "</p>";
                }
            }
            ?>
            <form method="post" action="submit.php">
                <?php
                foreach ($_POST as $field => $value) {
                    echo "<input type=\"hidden\" name=\"$field\" value=\"$value\">";
                }
                ?>
                <button type="submit" class="btn btn-success">Confirm my donation</button>
                
            </form>
            <p><a class="btn btn-danger" href="cancel.php">Cancel my donation</a></p>
            <?php
        } else {
            ?>
            <h3>There was a problem...</h3>
            <p>
            <?php
            echo Validators::issue_tostring($validation_response);
            ?>
            </p>
            <p><a href="javascript:window.history.go(-1)">Go back and try again</a></p>
            </php
        }
        ?>
    </div>
</div>
<?php
require_once(__DIR__ . '/includes/footer.php');