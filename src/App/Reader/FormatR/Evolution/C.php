<?php

declare(strict_types=1);

namespace App\Reader\FormatR\Evolution;

use DateTime;
use ErrorException;

class C
{
    /** @var int N° ins. du canton. */
    public $nis;
    /** @var string Type d’élection. */
    public $type;
    /** @var string Situation du dépouillement du canton. */
    public $status;
    /** @var int Nombre de bureaux de dépouillement traités. */
    public $countProcessedStations;
    /** @var int Nombre de bureaux de dépouillement total. */
    public $countTotalStations;
    /** @var string Date de maj du canton. */
    public $date;
    /** @var string Heure de maj  du canton. */
    public $time;
    /** @var int ID unique de l’entité. */
    public $entity;

    public static function fromArray(array $record): self
    {
        if ($record[0] !== 'C') {
            throw new ErrorException('Invalid C record');
        }

        $c = new self();

        $c->nis = intval($record[1]);
        $c->type = $record[2];
        $c->status = $record[3];
        $c->countProcessedStations = intval($record[4]);
        $c->countTotalStations = intval($record[5]);
        $c->date = $record[6];
        $c->time = $record[7];
        $c->entity = intval($record[8]);

        return $c;
    }

    public function getDateTime() : DateTime
    {
        return DateTime::createFromFormat('d/m/Y H:i:s', $this->date.' '.$this->time);
    }

    public function getEntity()
    {
        return new Entity($this->entity);
    }
}
