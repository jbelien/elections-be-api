<?php

declare(strict_types=1);

namespace App\Reader\FormatI\Extension;

use ErrorException;

class X
{
    /** @var string INS du canton. */
    public $nisCanton;
    /** @var string INS de la commune. */
    public $nisMunicipality;
    /** @var string Nom de l’extension communale en français. */
    public $name_fr;
    /** @var string Nom de l’extension communale en néerlandais. */
    public $name_nl;
    /** @var string Nom de l’extension communale en allemand. */
    public $name_de;
    /** @var string Nom de l’extension communale en anglais. */
    public $name_en;

    public static function fromArray(array $record): self
    {
        if ($record[0] !== 'X') {
            throw new ErrorException('Invalid X record.');
        }

        $x = new self();

        $x->nisCanton = $record[1];
        $x->nisMunicipality = $record[2];
        $x->name_fr = $record[3];
        $x->name_nl = $record[4];
        $x->name_de = $record[5];
        $x->name_en = $record[6];

        return $x;
    }
}
