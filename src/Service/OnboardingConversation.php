<?php


namespace App\Service;


use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;

class OnboardingConversation extends Conversation
{
    protected $firstname;
    public function askFirstname()
    {
        $this->ask('Hello! What is your firstname?', function(Answer $answer) {
            // Save result
            $this->firstname = $answer->getText();

            $this->say('Nice to meet you '.$this->firstname);

        });
    }
    public function run()
    {
        // This will be called immediately
        $this->askFirstname();
    }
}
