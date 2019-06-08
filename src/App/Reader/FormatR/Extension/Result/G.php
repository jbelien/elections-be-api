<?php

declare (strict_types = 1);

namespace App\Reader\FormatR\Extension\Result;

use DateTime;
use ErrorException;

class G
{
    /** @var string Date de génération du fichier. */
    public $date;
    /** @var string Heure de génération du fichier. */
    public $time;

    public static function fromArray(array $record): self
    {
        if ($record[0] !== 'G') {
            throw new ErrorException('Invalid G record.');
        }

        $g = new self();

        $g->date = $record[1];
        $g->time = $record[2];

        return $g;
    }

    public function getDateTime(): DateTime
    {
        return DateTime::createFromFormat('d/m/Y H:i:s', $this->date . ' ' . $this->time);
    }
}
