<?php

declare(strict_types=1);

namespace App\Reader\FormatI\Liste;

use ErrorException;

class L
{
    /** @var string INS Entité. */
    public $entityNis;
    /** @var string Type d’élection. */
    public $type;
    /** @var string Niveau. */
    public $level;
    /** @var int Numéro de la liste. */
    public $nr;
    /** @var string Sigle de la liste. */
    public $name;
    /** @var string Régime Linguistique. */
    public $language;
    /** @var int Id de la Liste. */
    public $id;
    /** @var int Id du Groupe de la liste. */
    public $idGroup;
    /** @var int Nombre d’effectifs. */
    public $countEffectives;
    /** @var int Nombre de suppléants. */
    public $countSubstitutes;
    /** @var int Id de la Liste élection - 1. */
    public $previousId;
    /** @var string Nom de la liste élection - 1. */
    public $previousName;
    /** @var int ID unique de l’entité. */
    public $entityId;

    public static function fromArray(array $record): self
    {
        if ($record[0] !== 'L') {
            throw new ErrorException('Invalid L record.');
        }

        $x = new self();

        $x->entityNis = $record[1];
        $x->type = $record[2];
        $x->level = $record[3];
        $x->nr =  $record[4] !== 'null' ? intval($record[4]) : null;
        $x->name = strlen($record[5]) > 0 ? $record[5] : null;
        $x->language = strlen($record[6]) > 0 ? $record[6] : null;
        $x->id = $record[7] !== 'null' ? intval($record[7]) : null;
        $x->idGroup = $record[8] !== 'null' ? intval($record[8]) : null;
        $x->countEffectives = $record[9] !== 'null' ? intval($record[9]) : null;
        $x->countSubstitutes = $record[10] !== 'null' ? intval($record[10]) : null;
        $x->previousId = $record[11] !== 'null' ? intval($record[11]) : null;
        $x->previousName = strlen($record[12]) > 0 ? $record[12] : null;
        $x->entityId = intval($record[13]);

        return $x;
    }
}
