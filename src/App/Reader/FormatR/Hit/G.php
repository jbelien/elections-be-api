<?php

declare (strict_types = 1);

namespace App\Reader\FormatR\Hit;

use DateTime;
use ErrorException;

class G
{
    /** @var int N° version des fichiers de bases. */
    public $version;
    /** @var string Situation du dépouillement. */
    public $status;
    /** @var int Nombre de bureaux dépouillés. */
    public $countStations;
    /** @var int Nombre de cantons définitifs. */
    public $countCantons;
    /** @var int Taille du fichier en octets. */
    public $size;
    /** @var string Date de génération du fichier. */
    public $date;
    /** @var string Heure de génération du fichier. */
    public $time;
    /** @var int Nombre total de bureaux . */
    public $totalStations;

    public static function fromArray(array $record): self
    {
        if ($record[0] !== 'G') {
            throw new ErrorException('Invalid G record.');
        }

        $g = new self();

        $g->version = intval($record[1]);
        $g->status = $record[2];
        $g->countStations = intval($record[3]);
        $g->countCantons = intval($record[4]);
        $g->size = intval($record[5]);
        $g->date = $record[6];
        $g->time = $record[7];
        $g->totalStations = intval($record[8]);

        return $g;
    }

    public function getDateTime(): DateTime
    {
        return DateTime::createFromFormat('d/m/Y H:i:s', $this->date . ' ' . $this->time);
    }
}
