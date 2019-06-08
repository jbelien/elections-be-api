<?php

declare(strict_types = 1);

namespace App\Reader\FormatR\Extension\Result;

use ErrorException;

class L
{
    /** @var string N° ins de l’entité de dépôt des listes. */
    public $nisEntity;
    /** @var int Numéro de la liste. */
    public $nr;
    /** @var string Nom de la liste. */
    public $name;
    /** @var int Nombre maximum de titulaires. */
    public $maxOfficials;
    /** @var int Nombre maximum de suppléants. */
    public $maxSubstitutes;
    /** @var int Nombre de bulletins sous-catégorie 1. */
    public $countSubCategory1;
    /** @var int Nombre de bulletins sous-catégorie 2. */
    public $countSubCategory2;
    /** @var int Nombre de bulletins sous-catégorie 3. */
    public $countSubCategory3;
    /** @var int Nombre de bulletins sous-catégorie 4. */
    public $countSubCategory4;
    /** @var int Chiffre d’éligibilité. */
    public $eligibility;
    /** @var int Id du groupe. */
    public $idGroup;

    public static function fromArray(array $record): self
    {
        if ($record[0] !== 'L') {
            throw new ErrorException('Invalid L record.');
        }

        $l = new self();

        $l->nisEntity = $record[1];
        $l->nr = intval($record[2]);
        $l->name = $record[3];
        $l->maxOfficials = intval($record[4]);
        $l->maxSubstitutes = intval($record[5]);
        $l->countSubCategory1 = intval($record[6]);
        $l->countSubCategory2 = intval($record[7]);
        $l->countSubCategory3 = intval($record[8]);
        $l->countSubCategory4 = intval($record[9]);
        $l->eligibility = intval($record[10]);
        $l->idGroup = intval($record[11]);

        return $l;
    }
}
