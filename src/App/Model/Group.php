<?php

declare(strict_types=1);

namespace App\Model;

use App\Reader\FormatI\Group\X;

class Group
{
    /** @var int */
    public $id;
    /** @var string */
    public $name;
    /** @var array|null */
    public $previous;
    /** @var string */
    public $color;
    /** @var int */
    public $nr;

    public static function fromX(X $x): self
    {
        $group = new self();

        $group->id = $x->id;
        $group->name = $x->name;
        $group->previous = is_null($x->previousId) || is_null($x->previousName) ? null : [
            'id'   => $x->previousId,
            'name' => $x->previousName,
        ];
        $group->color = $x->color;
        $group->nr = $x->nr;

        return $group;
    }
}
