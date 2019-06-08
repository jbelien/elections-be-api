<?php

declare(strict_types=1);

namespace App\Reader\FormatR\Result;

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
    /** @var int Taille du fichier en octets. */
    public $size;
    /** @var string Date de génération du fichier. */
    public $date;
    /** @var string Heure de génération du fichier. */
    public $time;
    /** @var int Nombre total de bureaux . */
    public $totalStations;
    /** @var int Nombre de cantons traités. */
    public $countCantons;
    /** @var int Nombre total de cantons. */
    public $totalCantons;
    /** @var int ID unique de l’entité. */
    public $idEntity;

    public static function fromArray(array $record): self
    {
        if ($record[0] !== 'G') {
            throw new ErrorException('Invalid G record.');
        }

        $g = new self();

        $g->version = intval($record[1]);
        $g->status = $record[2];
        $g->countStations = intval($record[3]);
        $g->size = intval($record[4]);
        $g->date = $record[5];
        $g->time = $record[6];
        $g->totalStations = intval($record[7]);
        $g->countCantons = intval($record[8]);
        $g->totalCantons = intval($record[9]);
        $g->idEntity = intval($record[10]);

        return $g;
    }

    public function getDateTime(): DateTime
    {
        return DateTime::createFromFormat('d/m/Y H:i:s', $this->date . ' ' . $this->time);
    }
}
