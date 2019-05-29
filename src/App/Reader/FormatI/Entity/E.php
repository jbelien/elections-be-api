<?php

declare(strict_types=1);

namespace App\Reader\FormatI\Entity;

use ErrorException;

class E
{
    /** @var int ID unique de l’entité. */
    public $id;
    /** @var string Niveau. */
    public $level;
    /** @var string Type d’élection. */
    public $type;
    /** @var string INS de l’entité. */
    public $nis;
    /** @var string INS Supérieur à cette entité. */
    public $nisParent;
    /** @var int Nombre maximum de titulaires. */
    public $maxOfficials;
    /** @var int Nombre maximum de suppléants. */
    public $maxSubstitutes;
    /** @var int Nombre d’inscrits BB. */
    public $countBB;
    /** @var int Nombre d’inscrits E1+E2. */
    public $countE1E2;
    /** @var int Nombre d’inscrits E3+E4. */
    public $countE3E4;
    /** @var int Nombre d’inscrits E5. */
    public $countE5;
    /** @var int Nombre total de bureaux. */
    public $stations;
    /** @var string INS du bureau de dépôt des listes. */
    public $nisDepositStation;
    /** @var string Vote électronique. */
    public $electronic;
    /** @var int Election des échevins. */
    public $alderman;

    public static function fromArray(array $record): self
    {
        if ($record[0] !== 'E') {
            throw new ErrorException('Invalid E record.');
        }

        $e = new self();

        $e->id = intval($record[1]);
        $e->level = $record[2];
        $e->type = $record[3];
        $e->nis = $record[4];
        $e->nisParent = strlen($record[5]) > 0 ? $record[5] : null;
        $e->maxOfficials = intval($record[6]);
        $e->maxSubstitutes = intval($record[7]);
        $e->countBB = intval($record[8]);
        $e->countE1E2 = intval($record[9]);
        $e->countE3E4 = intval($record[10]);
        $e->countE5 = intval($record[11]);
        $e->stations = intval($record[12]);
        $e->nisDepositStation = $record[13];
        $e->electronic = $record[14];
        $e->alderman = $record[15];

        return $e;
    }
}
