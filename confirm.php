<?php
/**
 * Donation Platform
 * Confirm donation
 * @author Jeffrey Wang
 */

require_once(__DIR__ . '/includes/validators.php');
require_once(__DIR__ . '/includes/DonationSubmission.php');
require_once(__DIR__ . '/includes/header.php');

$validation_response = Validators::validate_all($_POST);
?>
<div class="row">
    <div class="col">
        <?php
        if ($validation_response === 'no problems') {
            $donation_submission = new DonationSubmission($_POST);
            $response = $donation_submission->commit();
            if ($response && $donation_submission->getState() === 'valid-committed') {
                ?>
                <h3>Donation confirmed!</h3>
                <p>Thank you so much for your donation to the Wikimedia Foundation!</p>
                <p>Someone will be in touch with you soon regarding your pending donation.</p>
                <p><a href="index.php">Return to home</a></p>
                <?php
            } else {
                ?>
                <h3>There was a problem with the database</h3>
                <p>Ruh roh!<?php echo " State: " . $donation_submission->getState(); ?></p>
                <p><a href="index.php">Return to home</a></p>
                <?php
            }
        } else {
            ?>
            <h3>There was a problem...</h3>
            <p>
            <?php
            echo Validators::issue_tostring($validation_response);
            ?>
            </p>
            <p><a href="javascript:window.history.go(-1)">Go back and try again</a></p>
            <?php
        }
        ?>
    </div>
</div>
<?php
require_once(__DIR__ . '/includes/footer.php');