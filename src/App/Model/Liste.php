<?php

declare(strict_types=1);

namespace App\Model;

use App\Reader\FormatI\Liste\L;

class Liste
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
    /** @var array|null */
    public $previous;
    /** @var string */
    public $language;
    /** @var int */
    public $idGroup;
    /** @var int */
    public $idEntity;
    /** @var int */
    public $effectives;
    /** @var int */
    public $substitutes;

    public static function fromL(L $l): self
    {
        $list = new self();

        $list->id = $l->id;
        $list->type = $l->type;
        $list->level = $l->level;
        $list->nr = $l->nr;
        $list->name = $l->name;
        $list->previous = is_null($l->previousId) || is_null($l->previousName) ? null : [
            'id' => $l->previousId,
            'name' => $l->previousName,
        ];
        $list->language = $l->language;
        $list->idGroup = $l->idGroup;
        $list->idEntity = $l->idEntity;
        $list->effectives = $l->countEffectives;
        $list->substitutes = $l->countSubstitutes;

        return $list;
    }
}
