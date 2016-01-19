<?php
include __DIR__ . '/vendor/autoload.php';

// use Colors\Color;

// // $color = new Color();
// // echo $color('Hello World!')->white()->bold()->highlight('green') . PHP_EOL;
// // function colorize($text, $status) {
// //     $out = "";
// //     switch($status) {
// //         case "SUCCESS":
// //             $out = "[42m"; //Green background
// //             break;
// //         case "FAILURE":
// //             $out = "[41m"; //Red background
// //             break;
// //         case "WARNING":
// //             $out = "[43m"; //Yellow background
// //             break;
// //         case "NOTE":
// //             $out = "[44m"; //Blue background
// //             break;
// //         default:
// //             throw new Exception("Invalid status: " . $status);
// //     }
// //     return chr(27) . "$out" . "$text" . chr(27) . "[0m";
// // }

// // echo colorize("Your command was successfully executed...", "SUCCESS");

// echo "\e[1;34mThis text is bold blue.\e[0m\n";

$res = fopen('php://stdin', 'r+');


$i = 0;
while (true) {
    $in  = fgets($res);
    if ($in == 0) {
        break;
    }
    echo $in;
}