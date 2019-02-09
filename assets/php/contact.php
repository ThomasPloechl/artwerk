<?php

// configure
$from = 'art.werk Kontaktformular <kontakt@art-werk.at>';
$sendTo = 'art.werk Kontaktformular <kontakt@art-werk.at>';
$subject = 'Neue Nachtricht vom Kontaktformular';
$fields = array('name' => 'Name', 'lastname' => 'Nachname','email' => 'Email', 'phone' => 'Telefon', 'message' => 'Nachricht'); // array variable name => Text to appear in the email
$okMessage = 'Nachricht erfolgreich versendet! Wir werden dir schnellstmöglich antworten!';
$errorMessage = 'Leider ist ein Fehler aufgetreten. Bitte versuche es noch einmal.';

// let's do the sending

try
{
    $emailText = "Neue Nachtricht vom Kontaktformular\n=============================\n";

    foreach ($_POST as $key => $value) {

        if (isset($fields[$key])) {
            $emailText .= "$fields[$key]: $value\n";
        }
    }

    $headers = array('Content-Type: text/plain; charset="UTF-8";',
        'From: ' . $from,
        'Reply-To: ' . $from,
        'Return-Path: ' . $from,
    );
    
    mail($sendTo, $subject, $emailText, implode("\n", $headers));

    $responseArray = array('type' => 'success', 'message' => $okMessage);
}
catch (\Exception $e)
{
    $responseArray = array('type' => 'danger', 'message' => $errorMessage);
}

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $encoded = json_encode($responseArray);

    header('Content-Type: application/json');

    echo $encoded;
}
else {
    echo $responseArray['message'];
}
