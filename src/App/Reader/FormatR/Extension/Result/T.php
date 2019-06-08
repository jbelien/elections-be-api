<?php

declare(strict_types = 1);

namespace App\Reader\FormatR\Extension\Result;

use ErrorException;

class T
{
    /** @var int Nombre de bureaux. */
    public $countStations;

    public static function fromArray(array $record): self
    {
        if ($record[0] !== 'T') {
            throw new ErrorException('Invalid T record.');
        }

        $t = new self();

        $t->countStations = intval($record[1]);

        return $t;
    }
}
