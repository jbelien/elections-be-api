<?php

declare(strict_types=1);

namespace App\Reader\FormatR\Result;

use ErrorException;

class C
{
    /** @var int Numéro de la liste. */
    public $nrList;
    /** @var string Type de candidat. */
    public $type;
    /** @var int Numéro d’ordre du candidat titulaire ou suppléant. */
    public $nr;
    /** @var int Nombre de voix nominatives. */
    public $votes;
    /** @var string|null Date de décès du candidat. */
    public $deathdate;
    /** @var int|null Total de voix obtenues par le candidat après dévolution. */
    public $votesAfterDevolution;
    /** @var int|null Reste dévolution. */
    public $remainderAfterDevolution;
    /** @var int|null Numéro d’ordre du titulaire élu. */
    public $nrElectedOfficial;
    /** @var int|null Numéro d’ordre du suppléant élu. */
    public $nrElectedSubstitute;
    /** @var int|null Id du candidat. */
    public $id;
    /** @var int|null Numéro d’ordre de l’échevin. */
    public $nrAlderman;

    public static function fromArray(array $record): self
    {
        if ($record[0] !== 'C') {
            throw new ErrorException('Invalid C record.');
        }

        $c = new self();

        $c->nrList = intval($record[1]);
        $c->type = $record[2];
        $c->nr = intval($record[3]);
        $c->votes = intval($record[4]);
        $c->deathdate = strlen($record[5]) > 0 ? $record[5] : null;
        $c->votesAfterDevolution = strlen($record[6]) > 0 ? intval($record[6]) : null;
        $c->remainderAfterDevolution = strlen($record[7]) > 0 ? intval($record[7]) : null;
        $c->nrElectedOfficial = strlen($record[8]) > 0 ? intval($record[8]) : null;
        $c->nrElectedSubstitute = strlen($record[9]) > 0 ? intval($record[9]) : null;
        $c->id = intval($record[10]);

        if (isset($record[11])) {
            $c->nrAlderman = intval($record[11]);
        }

        return $c;
    }
}
