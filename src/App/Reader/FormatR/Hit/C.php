<?php

declare (strict_types = 1);

namespace App\Reader\FormatR\Hit;

use ErrorException;

class C
{
    /** @var int Identifiant du candidat. */
    public $idCandidate;
    /** @var int Nombre de votes de préférence. */
    public $votes;
    /** @var int Taux de pénétration. */
    public $rate;
    /** @var string Situation du dépouillement. */
    public $status;

    public static function fromArray(array $record): self
    {
        if ($record[0] !== 'C') {
            throw new ErrorException('Invalid C record');
        }

        $c = new self();

        $c->idCandidate = intval($record[1]);
        $c->votes = intval($record[2]);
        $c->rate = intval($record[3]);
        $c->status = $record[4];

        return $c;
    }
}
