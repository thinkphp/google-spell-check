<?php
header('content-type: application/json; charset=utf-8');

if($_POST['lang'] && isset($_POST['lang'])) {
  $lang = $_POST['lang'];
} else {
  $lang = 'en';
}

if($_POST['text'] && isset($_POST['text'])) {
  $text = $_POST['text'];
} else {
  $text = "";
}

$digits = isset($_POST['ignoredigits']) ? (int) $_POST['ignoredigits'] : false;

$caps = isset($_POST['ignoreallcaps']) ? (int) $_POST['ignoreallcaps'] : false;

$body = '<?xml version="1.0" encoding="utf-8" ?>';
$body .= '<spellrequest textalreadyclipped="0" ignoredubs="1" ignoredigits="'.$digits.'" ignoreallcaps="'.$caps.'">';
$body .= "<text>".urldecode($text)."</text>";
$body .= '</spellrequest>';


$url = "https://www.google.com/tbproxy/spell?lang=".$lang;

$output = post($url,$body);

$data = array();

$resp = new SimpleXMLElement($output);

foreach($resp->c as $r) {

       $data[] = array(
                  'o' => (int) $r['o'],
                  'l' => (int) $r['l'],
                  's' => (int) $r['s'],
                  'a' => explode("\t",$r)
                 );
}


function post($url,$xml) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    $content = curl_exec($ch);
    curl_close($ch);
    if(empty($content)) {
       return 'Server timeout. Please try again!'; 
    } else {
       return $content;
    }   
}

echo json_encode($data);
?>