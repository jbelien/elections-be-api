<?php

declare(strict_types=1);

namespace App\Reader\FormatI\Group;

use ErrorException;

class X
{
    /** @var string Nom du groupe. */
    public $name;
    /** @var int Id du groupe de Listes. */
    public $id;
    /** @var string Nom du groupe élection - 1. */
    public $previousName;
    /** @var int Id du groupe de Listes élection - 1. */
    public $previousId;
    /** @var string Couleur du GRP. */
    public $color;
    /** @var int N° officiel de liste pour listes nationales. */
    public $nr;
    /** @var int Tri technique. */
    public $order;

    public static function fromArray(array $record): self
    {
        if ($record[0] !== 'X') {
            throw new ErrorException('Invalid X record.');
        }

        $x = new self();

        $x->name = strlen($record[1]) > 0 ? $record[1] : null;
        $x->id = $record[2] !== 'null' ? intval($record[2]) : null;
        $x->previousName = strlen($record[3]) > 0 ? $record[3] : null;
        $x->previousId = $record[4] !== 'null' ? intval($record[4]) : null;
        $x->color = $record[2] !== 'null' ? $record[5] : null;
        $x->nr = strlen($record[6]) > 0 ? intval($record[6]) : null;
        $x->order = intval($record[7]);

        return $x;
    }
}
