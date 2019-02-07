<?php
    require 'mailer.php';
    $link = mysqli_connect("ip", "database", "password", "table");
	if ($_SERVER['REQUEST_METHOD'] != 'POST') {
		header('Location: index.php');
		exit();
	}

	$ch = curl_init("https://ipnpb.sandbox.paypal.com/cgi-bin/webscr");



	curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSLVERSION, 6);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

	curl_setopt($ch, CURLOPT_POSTFIELDS, "cmd=_notify-validate&" . http_build_query($_POST));
	$response = curl_exec($ch);
	curl_close($ch);


	if ($response == "VERIFIED") {
        header("HTTP/1.1 200 OK");

        $handle = fopen("output.txt", "w");
        foreach ($_POST as $key=>$value)
            fwrite($handle, "$key=>$value \r\n");


        sendMail( $_POST["receiver_email"], $_POST["first_name"]." ".$_POST["last_name"]);

        $stmt = $link->prepare("INSERT INTO pending_paypal (transaction_id, package, email) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $_POST["txn_id"],$_POST["item_name"], $_POST["payer_email"]);
        $stmt->execute();
    }
