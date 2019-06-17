<?php

declare (strict_types = 1);

namespace App\Model;

use App\Reader\FormatI\Extension\X;

class Municipality
{
    /** @var string */
    public $nis;
    /** @var string */
    public $name_de;
    /** @var string */
    public $name_en;
    /** @var string */
    public $name_fr;
    /** @var string */
    public $name_nl;

    public static function fromX(X $x): self
    {
        $municipality = new self();

        $municipality->nis = $x->nisMunicipality;
        $municipality->name_de = $x->name_de;
        $municipality->name_en = $x->name_en;
        $municipality->name_fr = $x->name_fr;
        $municipality->name_nl = $x->name_nl;

        return $municipality;
    }

    public function getGeometry(int $year)
    {
        $geoJSON = json_decode(file_get_contents(sprintf('data/%d/municipality.geojson', $year)));

        $nis = $this->nis;
        $mun = current(array_filter($geoJSON->features, function ($m) use ($nis) {
            return $m->id === $nis;
        }));

        return $mun !== false ? $mun->geometry : null;
    }
}
