<?php

$ports[] = array('host'=>'smtp.gmail.com','number'=>465);
$ports[] = array('host'=>'smtp.live.com','number'=>25);
$ports[] = array('host'=>'smtpout.secureserver.net','number'=>3535);
$ports[] = array('host'=>'server107.greatnet.de','number'=>587);
$ports[] = array('host'=>'smtp.zoho.com','number'=>587);
$ports[] = array('host'=>'email-smtp.us-east-1.amazonaws.com','number'=>465);

foreach ($ports as $port)
{
    //$connection = @fsockopen($port['host'], $port['number']);
	$connection = @fsockopen($port['host'], $port['number'], $errno, $errstr, 5); // 5 second timeout for each port.

    if (is_resource($connection))
    {
        echo '<h2>' . $port['host'] . ':' . $port['number'] . ' ' . '(' . getservbyport($port, 'tcp') . ') is open.</h2>' . "\n";

        fclose($connection);
    }

    else
    {
        echo '<h2>' . $port['host'] . ':' . $port['number'] . ' is not responding.</h2>' . "\n";
    }
}


?>
