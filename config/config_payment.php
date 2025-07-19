<?php
require_once "vendor/autoload.php"; 
use Omnipay\Omnipay;
 
define('CLIENT_ID', 'AUepW_R8YYWL7R9nASWIkYSvoLg_3KzYFeb-tt0KMWuWOBwX_JmYlMGKMWbsg_bhPIB2CoNNy5AGk1dm');
define('CLIENT_SECRET', 'EFuwGqxMAPpSMCoxkmo6-WWnt02EjZFNtdN39Z9Ay-rmruF2gR2MmCPdQn1Rk1fH5z93yd96fB5hqP6s');
 
define('PAYPAL_RETURN_URL', BASE_URL.'paypal_success.php');
define('PAYPAL_CANCEL_URL', BASE_URL.'payment_cancel.php');
define('PAYPAL_CURRENCY', 'USD'); // set your currency here
 
$gateway = Omnipay::create('PayPal_Rest');
$gateway->setClientId(CLIENT_ID);
$gateway->setSecret(CLIENT_SECRET);
$gateway->setTestMode(true); //set it to 'false' when go live

define('STRIPE_TEST_PK', 'pk_test_51RRTxHCxK6iNqqRi903P4Dx1Y8IGNGf9XhfHFbUD1oeNvxqb8NKULxBNgrFitteLZID6FP2o6qDP0Drgws7VqLfV00Df45fi0E');
define('STRIPE_TEST_SK', 'sk_test_51RRTxHCxK6iNqqRilDlUGk7t8GNPvKRrhuVjfNKwg0PlTCDV4YsaVz3qzlwTE4ixMghiXNhWpijUWZwELJbhlT3r00nnaDnMTs');

define('STRIPE_SUCCESS_URL', BASE_URL.'stripe_success.php');
define('STRIPE_CANCEL_URL', BASE_URL.'payment_cancel.php');