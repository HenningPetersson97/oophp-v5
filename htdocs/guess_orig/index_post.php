<?php
/**
* Guess number POST verson.
*/

require __DIR__ . "/autoload.php";
require __DIR__ . "/config.php";
require __DIR__ . "/src/Guess.php";
require __DIR__ . "/src/GuessException.php";

// Deal with incoming variables
$count = $_POST["count"] ?? null;
$number = $_POST["number"] ?? null;
$tries = $_POST["tries"] ?? null;
$guess = $_POST["guess"] ?? null;
$doInit = $_POST["doInit"] ?? null;
$doGuess = $_POST["doGuess"] ?? null;
$doCheat = $_POST["doCheat"] ?? null;

//init the game
if ($doInit || $number === null) {
    $number = rand(1, 100);
    $count = 0;
    $tries = 6;
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
require __DIR__ . "/view/debug_session_post_get.php";
