<?php
/**
* Guess number POST verson.
*/

require __DIR__ . "/autoload.php";
require __DIR__ . "/config.php";
require __DIR__ . "/src/GuessException.php";

session_name("hepe");
session_start();


//Deal with incoming variables
$guess = $_POST["guess"] ?? null;
$doInit = $_POST["doInit"] ?? null;
$doGuess = $_POST["doGuess"] ?? null;
$doCheat = $_POST["doCheat"] ?? null;

// Settings for session.
$number = $_SESSION["number"] ?? null;
$tries = $_SESSION["tries"] ?? null;
$game = null;

if ($doInit or $number === null) {
    $game = new Guess();
    $_SESSION["number"] = $game->number();
    $_SESSION["tries"] = $game->tries();
} elseif ($doGuess) {
    $game = new Guess($number, $tries);
    $res = $game->makeGuess($guess);
    $_SESSION["tries"] = $game->tries();
}
// Render the page
require __DIR__ . "/view/guess_my_number.php";
require __DIR__ . "/view/debug_session_post_get.php";
