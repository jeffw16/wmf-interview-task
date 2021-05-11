<?php
/**
 * Donation Platform
 * Page footer
 * @author Jeffrey Wang
 */
?>
    </div><!-- .container -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    <script>
        $('#submitbtn').click(function() {
            // $('#submitbtn').addClass('displaynone'); // let's disable this for now
            $('#spinner').removeClass('displaynone');
        });

        $('#currency').change(function() {
            let selected_option = $('#currency option:selected').val();
            if (selected_option === 'BTC') {
                // Change donation amount limits
                let btc_limit = '0.00000001';
                $('#donation_amount').attr('min', btc_limit);
                $('#donation_amount').attr('step', btc_limit);
            } else {
                // Change back to default
                let usdeur_limit = '0.01';
                $('#donation_amount').attr('min', usdeur_limit);
                $('#donation_amount').attr('step', usdeur_limit);
            }
        });
    </script>
  </body>
</html>