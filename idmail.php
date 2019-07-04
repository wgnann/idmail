<?php
require 'vendor/autoload.php';
require 'IDMail.php';
use Dotenv\Dotenv;

if (!isset($argv[2])) {
    die("uso: ".$argv[0]." [nusp]\n");
}

$dotenv = Dotenv::create(__DIR__);
$dotenv->load();
$mode = $argv[1];
$nusp = $argv[2];

if ($mode == "list") {
    $idmail = new IDMail();
    $json = json_decode($idmail->id_get_emails($nusp));
    $emails = $idmail->list_emails($json, "ime.usp.br", ["Institucional", "Grupo"]);
    foreach ($emails as $email) {
        echo $email['email'].":".$email['name']."\n";
    }
}
else {
    $email = IDMail::find_email($nusp, ["P", "O"]);
    if ($email == "") {
        $idmail = new IDMail();
        $json = json_decode($idmail->id_get_emails($nusp));
        $email = $idmail->extract_email($json, "ime.usp.br", ["Pessoal", "Secundaria"]);
    }
    echo $email."\n";
}


?>
