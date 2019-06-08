<?php

declare(strict_types=1);

namespace App\Reader\FormatI\Group;

use DateTime;
use ErrorException;

class G
{
    /** @var int N° version des fichiers de bases. */
    public $version;
    /** @var int Taille du fichier en octets. */
    public $size;
    /** @var string Date de génération du fichier. */
    public $date;
    /** @var string Heure de génération du fichier. */
    public $time;
    /** @var int Nombre total d’entités dans le fichier. */
    public $count;

    public static function fromArray(array $record): self
    {
        if ($record[0] !== 'G') {
            throw new ErrorException('Invalid G record.');
        }

        $g = new self();

        $g->version = intval($record[1]);
        $g->size = intval($record[2]);
        $g->date = $record[3];
        $g->time = $record[4];
        $g->count = intval($record[5]);

        return $g;
    }

    public function getDateTime() : DateTime
    {
        return DateTime::createFromFormat('d/m/Y H:i:s', $this->date . ' ' . $this->time);
    }
}
