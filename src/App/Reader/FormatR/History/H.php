<?php

declare (strict_types = 1);

namespace App\Reader\FormatR\History;

use DateTime;
use ErrorException;

class H
{
    /** @var string Date et heure . */
    public $datetime;
    /** @var int Nombre de bureaux total. */
    public $totalStations;
    /** @var int Nombre de bureaux dépouillés. */
    public $countedStations;
    /** @var int Nombre de cantons total. */
    public $totalCantons;
    /** @var int Nombre de cantons traités. */
    public $processedCantons;
    /** @var int Nombre de cantons complets. */
    public $completedCantons;
    /** @var int Nombre de cantons définitifs. */
    public $finalCantons;

    public static function fromArray(array $record): self
    {
        if ($record[0] !== 'H') {
            throw new ErrorException('Invalid H record');
        }

        $h = new self();

        $h->datetime = $record[1];
        $h->totalStations = intval($record[2]);
        $h->countedStations = intval($record[3]);
        $h->totalCantons = intval($record[4]);
        $h->processedCantons = intval($record[5]);
        $h->completedCantons = intval($record[6]);
        $h->finalCantons = intval($record[7]);

        return $h;
    }

    public function getDateTime(): DateTime
    {
        return DateTime::createFromFormat('Y-m-d-H.i.s', $this->datetime);
    }
}
