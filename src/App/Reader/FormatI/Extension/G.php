<?php

declare(strict_types=1);

namespace App\Reader\FormatI\Extension;

use DateTime;
use ErrorException;

class G
{
    /** @var int N° version des fichiers de bases. */
    public $version;
    /** @var string Type d’élection. */
    public $type;
    /** @var int Taille du fichier en octets. */
    public $size;
    /** @var string Date de génération du fichier. */
    public $date;
    /** @var string Heure de génération du fichier. */
    public $time;

    public static function fromArray(array $record): self
    {
        if ($record[0] !== 'G') {
            throw new ErrorException('Invalid G record.');
        }

        $g = new self();

        $g->version = intval($record[1]);
        $g->type = $record[2];
        $g->size = intval($record[3]);
        $g->date = $record[4];
        $g->time = $record[5];

        return $g;
    }

    public function getDateTime(): DateTime
    {
        return DateTime::createFromFormat('d/m/Y H:i:s', $this->date . ' ' . $this->time);
    }
}
