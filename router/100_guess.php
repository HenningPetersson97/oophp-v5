<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));



/**
 * Init the game and redirect to play the game.
 */
$app->router->get("guess/init", function () use ($app) {
    // init the game.
    $game = new Hepe\Guess\Guess();
    $_SESSION["number"] = $game->number();
    $_SESSION["tries"] = $game->tries();
    return $app->response->redirect("guess/play");
});



/**
 * Play the game - show game status
 */
$app->router->get("guess/play", function () use ($app) {
    $title = "Play the game";


    $tries = $_SESSION["tries"] ?? null;
    $res = $_SESSION["res"] ?? null;
    $guess = $_SESSION["guess"] ?? null;
    $number = $_SESSION["number"] ?? null;
    $doCheat = $_SESSION["doCheat"] ?? null;

    $_SESSION["res"] = null;
    $_SESSION["guess"] = null;
    $_SESSION["doCheat"] = null;


    $data = [
        "guess" => $guess ?? null,
        "tries" => $tries,
        "number" => $number ?? null,
        "res" => $res,
        "doGuess" => $doGuess ?? null,
        "doCheat" => $doCheat,
    ];

    $app->page->add("/guess/play", $data);
    $app->page->add("/guess/debug");

    return $app->page->render([
        "title" => $title,
    ]);
});



/**
 * Play the game - make a guess
 */
$app->router->post("guess/play", function () use ($app) {
    $title = "Play the game";

    //Deal with incoming variables
    $guess = $_POST["guess"] ?? null;
    $doInit = $_POST["doInit"] ?? null;
    $doGuess = $_POST["doGuess"] ?? null;
    $doCheat = $_POST["doCheat"] ?? null;

    // Settings for session.
    $number = $_SESSION["number"] ?? null;
    $tries = $_SESSION["tries"] ?? null;
    // $game = null;

    if ($doInit or $number === null) {
        $game = new Hepe\Guess\Guess();
        $_SESSION["number"] = $game->number();
        $_SESSION["tries"] = $game->tries();
    } elseif ($doGuess) {
        $game = new Hepe\Guess\Guess($number, $tries);
        $res = $game->makeGuess($guess);
        $_SESSION["tries"] = $game->tries();
        $_SESSION["res"] = $res;
        $_SESSION["guess"] = $guess;
        $_SESSION["number"] = $number;
    } elseif ($doCheat) {
        $_SESSION["doCheat"] = $doCheat;
    }

    return $app->response->redirect("guess/play");
});
