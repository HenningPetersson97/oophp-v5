<?php

namespace Hepe\Guess;

/**
 * Guess my number, a class supporting the game through GET, POST and SESSION.
 */
class Guess
{
    /**
     * @var int $number   The current secret number.
     * @var int $tries    Number of tries a guess has been made.

     */

    private $number;
    private $tries;

    /**
     * Constructor to initiate the object with current game settings,
     * if available. Randomize the current number if no value is sent in.
     *
     * @param int $number The current secret number, default -1 to initiate
     *                    the number from start.
     * @param int $tries  Number of tries a guess has been made,
     *                    default 6.
     */

    public function __construct(int $number = -1, int $tries = 6)
    {
        if ($number === -1) {
            $number = rand(1, 100);
        }
        $this->number = $number;
        $this->tries = $tries;
    }


    public function number()
    {
         return $this->number;
    }

    public function tries()
    {
         return $this->tries;
    }

    /**
     * Randomize the secret number between 1 and 100 to initiate a new game.
     *
     * @return void
     */

    public function random()
    {
        if ($this->number === -1) {
            $this->number = rand(1, 100);
        }
        return $this->number;
    }


    /**
     * Make a guess, decrease remaining guesses and return a string stating
     * if the guess was correct, too low or to high or if no guesses remains.
     *
     * @throws GuessException when guessed number is out of bounds.
     *
     * @return string to show the status of the guess made.
     */

    public function makeGuess($guess)
    {
        try {
            if ($this->tries > 0) {
                $this->tries -= 1;
            }
            if ($guess < 1 or $guess > 100) {
                 throw new GuessException;
            } else {
                if ($guess === strval($this->number)) {
                    return "CORRECT YOU WON";
                } elseif ($guess > strval($this->number)) {
                    return "TOO HIGH";
                } else {
                    return "TOO LOW";
                }
            }
        } catch (GuessException $e) {
            echo "Got exception: " . get_class($e) . "<hr>";
            echo "Guess is out of bounds";
        }
    }
}
