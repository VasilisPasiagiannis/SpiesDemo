<?php

namespace App\Domains\Spies\Commands;

class CreateSpyCommand
{
    public string $name;
    public string $surname;
    public string $agency;
    public string $countryOfOperation;
    public string $birthday;
    public ?string $deathday;

    public function __construct(string $name, string $surname, string $agency, string $countryOfOperation, string $birthday, ?string $deathday = null)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->agency = $agency;
        $this->countryOfOperation = $countryOfOperation;
        $this->birthday = $birthday;
        $this->deathday = $deathday;
    }
}
