<?php

declare(strict_types = 1);

namespace App\Reader\FormatR\Extension\Evolution;

use DateTime;
use ErrorException;

class X
{
    /** @var string Type d’élection. */
    public $type;
    /** @var string N° ins. du canton. */
    public $nisCanton;
    /** @var string N° ins. de la commune. */
    public $nis;
    /** @var string|null Date de maj de l’eXtension au niveau communal. */
    public $date;
    /** @var string|null Heure de maj  de l’eXtension au niveau communal. */
    public $time;

    public static function fromArray(array $record): self
    {
        if ($record[0] !== 'X') {
            throw new ErrorException('Invalid X record');
        }

        $x = new self();

        $x->type = $record[1];
        $x->nisCanton = $record[2];
        $x->nis = $record[3];
        $x->date = strlen($record[4]) > 0 ? $record[4] : null;
        $x->time = strlen($record[5]) > 0 ? $record[5] : null;

        return $x;
    }

    public function getDateTime(): DateTime
    {
        return DateTime::createFromFormat('d/m/Y H:i:s', $this->date . ' ' . $this->time);
    }
}
