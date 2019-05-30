<?php

declare(strict_types=1);

namespace App\Reader\FormatI\Entity;

use ErrorException;

class T
{
    /** @var int ID unique de l’entité. */
    public $idEntity;
    /** @var string Langue. */
    public $language;
    /** @var string Nom de l’entité traduit. */
    public $name;

    public static function fromArray(array $record): self
    {
        if ($record[0] !== 'T') {
            throw new ErrorException('Invalid T record.');
        }

        $t = new self();

        $t->idEntity = intval($record[1]);
        $t->language = $record[2];
        $t->name = $record[3];

        return $t;
    }
}
