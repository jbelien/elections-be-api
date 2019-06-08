<?php

declare (strict_types = 1);

namespace App\Reader\FormatR\Extension\Result;

use ErrorException;

class S
{
    /** @var string N° ins de l’entité. */
    public $nisEntity;
    /** @var int Nombre de bulletins enregistrés. */
    public $count;
    /** @var int Nombre de bulletins valables. */
    public $countValid;
    /** @var int Nombre de bulletins nuls et blancs. */
    public $countBlank;

    public static function fromArray(array $record): self
    {
        if ($record[0] !== 'S') {
            throw new ErrorException('Invalid S record.');
        }

        $s = new self();

        $s->nisEntity = $record[1];
        $s->count = intval($record[2]);
        $s->countValid = intval($record[3]);
        $s->countBlank = intval($record[4]);

        return $s;
    }
}
