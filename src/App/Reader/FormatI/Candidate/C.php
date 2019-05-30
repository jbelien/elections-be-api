<?php

declare(strict_types=1);

namespace App\Reader\FormatI\Candidate;

use ErrorException;

class C
{
    /** @var string INS Entité. */
    public $nisEntity;
    /** @var string Type d’élection. */
    public $type;
    /** @var string Niveau. */
    public $level;
    /** @var int Numéro de la liste. */
    public $nrList;
    /** @var int Id de la Liste. */
    public $idList;
    /** @var int Id du Groupe de la liste. */
    public $idGroup;
    /** @var string Type de candidat. */
    public $typeCandidate;
    /** @var int Numéro du candidat titulaire ou suppléant. */
    public $nr;
    /** @var string Nom du candidat (Connu comme). */
    public $name;
    /** @var string Sexe du candidat. */
    public $gender;
    /** @var int Id du candidat. */
    public $id;
    /** @var string Date de naissance. */
    public $birthdate;
    /** @var int ID unique de l’entité. */
    public $idEntity;

    public static function fromArray(array $record): self
    {
        if ($record[0] !== 'C') {
            throw new ErrorException('Invalid C record.');
        }

        $c = new self();

        $c->nisEntity = $record[1];
        $c->type = $record[2];
        $c->level = $record[3];
        $c->nrList = intval($record[4]);
        $c->idList = intval($record[5]);
        $c->idGroup = intval($record[6]);
        $c->typeCandidate = $record[7];
        $c->nr = intval($record[8]);
        $c->name = $record[9];
        $c->gender = $record[10];
        $c->id = intval($record[11]);
        $c->birthdate = $record[12];
        $c->idEntity = intval($record[13]);

        return $c;
    }
}
