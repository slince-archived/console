<?php
// use Slince\Console\Stdio;
// use Slince\Console\Input;
// use Slince\Console\Output;
// include __DIR__ . '/../vendor/autoload.php';

// $stdio = new Stdio(new Input(), new Output(), new Output('php://stderr'));

// $i = 0;
// while (true) {
//     $in  = $stdio->in();
//     if ($in == 0) {
//         break;
//     }
//     $stdio->outln($in);
// }

$options = getopt("a:");
var_dump($options);
// print_r($_SERVER['argv']);
?>