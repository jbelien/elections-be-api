<?php

declare(strict_types=1);

namespace App\Reader\FormatI\Group;

use DateTime;
use ErrorException;

class X
{
    /** @var string  */
    public $name;
    /** @var int  */
    public $id;
    /** @var string  */
    public $previousName;
    /** @var int  */
    public $previousId;
    /** @var string  */
    public $color;
    /** @var int  */
    public $nr;
    /** @var int  */
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
