<?php namespace Listener;

require('PaypalIPN.php');

use PaypalIPN;

$ipn = new PaypalIPN();
// Use the sandbox endpoint during testing.
$ipn->useSandbox();
$verified = $ipn->verifyIPN();
error_log("printed: ".$verified);
if ($verified) {
    $servername = "api.tangorythm.com";
	$username = "sdiuser";
	$password = "Sdi2019user";
	$dbname = "sdi";
	$idFacture = $_POST['custom'];

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
 
 $sql = "UPDATE factures
SET paie = 1
WHERE id = ".$idFacture."; ";

if (mysqli_query($conn, $sql)) {
    echo "facture archivé avec succès";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
mysqli_close($conn);
}

// Reply with an empty 200 response to indicate to paypal the IPN was received correctly.
header("HTTP/1.1 200 OK");
