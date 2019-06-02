<?php

declare(strict_types=1);

namespace App\Reader\FormatR\Seats;

use ErrorException;

class L
{
    /** @var int Identifiant du groupe des listes. */
    public $idGroup;
    /** @var string Nombre de sièges. */
    public $seats;
    /** @var string Nombre d’hommes. */
    public $men;
    /** @var int Nombre de femmes. */
    public $women;

    public static function fromArray(array $record): self
    {
        if ($record[0] !== 'L') {
            throw new ErrorException('Invalid L record');
        }

        $l = new self();

        $l->idGroup = intval($record[1]);
        $l->seats = intval($record[2]);
        $l->men = intval($record[3]);
        $l->women = intval($record[4]);

        return $l;
    }
}
