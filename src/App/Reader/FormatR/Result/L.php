<?php

declare (strict_types = 1);

namespace App\Reader\FormatR\Result;

use ErrorException;

class L
{
    /** @var int Numéro de la liste. */
    public $nr;
    /** @var string Situation de la liste. */
    public $status;
    /** @var int Nombre de bulletins sous-catégorie 1. */
    public $countSubCategory1;
    /** @var int Nombre de bulletins sous-catégorie 2. */
    public $countSubCategory2;
    /** @var int Nombre de bulletins sous-catégorie 3. */
    public $countSubCategory3;
    /** @var int Nombre de bulletins sous-catégorie 4. */
    public $countSubCategory4;
    /** @var int|null Chiffre d’éligibilité. */
    public $eligibility;
    /** @var int|null Nombre de sièges acquis. */
    public $seats;
    /** @var int Id du groupe. */
    public $idGroup;
    /** @var int|null Sub Id du Groupe. */
    public $subIdgroup;
    /** @var int|null Nombre d’échevins acquis. */
    public $alderman;
    /** @var int|null INS du collège des listes. */
    public $nis;

    public static function fromArray(array $record): self
    {
        if ($record[0] !== 'L') {
            throw new ErrorException('Invalid L record.');
        }

        $l = new self();

        $l->nr = intval($record[1]);
        $l->status = $record[2];
        $l->countSubCategory1 = intval($record[3]);
        $l->countSubCategory2 = intval($record[4]);
        $l->countSubCategory3 = intval($record[5]);
        $l->countSubCategory4 = intval($record[6]);
        $l->eligibility = strlen($record[7]) > 0 ? intval($record[7]) : null;
        $l->seats = strlen($record[8]) > 0 ? intval($record[8]) : null;
        $l->idGroup = intval($record[9]);

        return $l;
    }
}
