<?php

declare (strict_types = 1);

namespace App\Model;

use App\Reader\FormatI\Candidate\C;
use DateTime;

class Candidate
{
    /** @var int */
    public $id;
    /** @var string */
    public $type;
    /** @var string */
    public $level;
    /** @var int */
    public $nr;
    /** @var string */
    public $name;
    /** @var string */
    public $gender;
    /** @var string */
    public $birthdate;
    /** @var int */
    public $idList;
    /** @var int */
    public $idGroup;
    /** @var int */
    public $idEntity;

    public static function fromC(C $c): self
    {
        $candidate = new self();

        $candidate->id = $c->id;
        $candidate->type = $c->typeCandidate;
        $candidate->level = $c->level;
        $candidate->nr = $c->nr;
        $candidate->name = $c->name;
        $candidate->gender = $c->gender === 'U' ? null : $c->gender;
        $candidate->birthdate = $c->birthdate === '00/00/0000' ? null : DateTime::createFromFormat('d/m/Y', $c->birthdate)->format('Y-m-d');
        $candidate->idList = $c->idList;
        $candidate->idGroup = $c->idGroup;
        $candidate->idEntity = $c->idEntity;

        return $candidate;
    }
}
