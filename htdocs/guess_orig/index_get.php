<?php
/**
* Guess number GET verson.
*/

require __DIR__ . "/autoload.php";
require __DIR__ . "/config.php";

// Deal with incoming variables
$count = $_GET["count"] ?? null;
$number = $_GET["number"] ?? null;
$tries = $_GET["tries"] ?? null;
$guess = $_GET["guess"] ?? null;
$doInit = $_GET["doInit"] ?? null;
$doGuess = $_GET["doGuess"] ?? null;
$doCheat = $_GET["doCheat"] ?? null;

//init the game
if ($doInit || $number === null) {
    $number = rand(1, 100);
    $count = 0;
    $tries = 6;
    header("Location: index_get.php?tries=$tries&number=$number");
} elseif ($doGuess) {
    if ($tries > 0) {
        $tries -= 1;
    }
    if ($count == $tries) {
        $res = "";
    } else {
        if ($guess === $number) {
            $res = "CORRECT YOU WON";
        } elseif ($guess > $number) {
            $res = "TOO HIGH";
        } else {
            $res = "TOO LOW";
        }
    }
}

// Render the page
require __DIR__ . "/view/guess_my_number.php";
