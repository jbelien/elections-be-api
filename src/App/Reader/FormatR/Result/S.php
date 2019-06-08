<?php

declare(strict_types=1);

namespace App\Reader\FormatR\Result;

use ErrorException;

class S
{
    /** @var int Nombre de bulletins enregistrés BB+E1+E2. */
    public $countBBE1E2;
    /** @var int Nombre de bulletins nuls et blancs BB+E1+E2+E5. */
    public $countBlankBBE1E2E5;
    /** @var int Nombre de bulletins enregistrés E3+E4. */
    public $countE3E4;
    /** @var int Nombre de bulletins nuls et blancs E3+E4. */
    public $countBlankE3E4;
    /** @var int Nombre de bulletins enregistrés E5. */
    public $countE5;

    public static function fromArray(array $record): self
    {
        if ($record[0] !== 'S') {
            throw new ErrorException('Invalid S record.');
        }

        $s = new self();

        $s->countBBE1E2 = intval($record[1]);
        $s->countBlankBBE1E2E5 = intval($record[2]);
        $s->countE3E4 = intval($record[3]);
        $s->countBlankE3E4 = intval($record[4]);
        $s->countE5 = intval($record[5]);

        return $s;
    }
}
