<?php

declare (strict_types = 1);

namespace App\Reader\FormatR\Extension\Result;

use ErrorException;

class C
{
    /** @var string N° ins de l’entité de dépôt des listes. */
    public $nisEntity;
    /** @var int Numéro de la liste. */
    public $nrList;
    /** @var string Type de candidat. */
    public $type;
    /** @var int Numéro d’ordre du candidat titulaire ou suppléant. */
    public $nr;
    /** @var int Nom du candidat (Connu comme). */
    public $name;
    /** @var int Nombre de voix nominatives. */
    public $votes;
    /** @var int Id du candidat. */
    public $id;

    public static function fromArray(array $record): self
    {
        if ($record[0] !== 'C') {
            throw new ErrorException('Invalid C record.');
        }

        $c = new self();

        $c->nisEntity = $record[1];
        $c->nrList = intval($record[2]);
        $c->type = $record[3];
        $c->nr = intval($record[4]);
        $c->name = $record[5];
        $c->votes = intval($record[6]);
        $c->id = intval($record[7]);

        return $c;
    }
}
