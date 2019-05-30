<?php

declare(strict_types=1);

namespace App\Model;

use App\Reader\FormatI\Entity\E;
use ErrorException;

class Entity extends E
{
    /** @var string */
    public $name_de;
    /** @var string */
    public $name_en;
    /** @var string */
    public $name_fr;
    /** @var string */
    public $name_nl;
    /** @var Municipality[] */
    public $municipalities;

    public static function fromE(E $e, array $translations): self
    {
        $entity = new self();

        $entity->id = $e->id;
        $entity->level = $e->level;
        $entity->type = $e->type;
        $entity->nis = $e->nis;
        $entity->nisParent = $e->nisParent;
        $entity->maxOfficials = $e->maxOfficials;
        $entity->maxSubstitutes = $e->maxSubstitutes;
        $entity->countBB = $e->countBB;
        $entity->countE1E2 = $e->countE1E2;
        $entity->countE3E4 = $e->countE3E4;
        $entity->countE5 = $e->countE5;
        $entity->stations = $e->stations;
        $entity->nisDepositStation = $e->nisDepositStation;
        $entity->electronic = $e->electronic;
        $entity->alderman = $e->alderman;

        foreach ($translations as $t) {
            switch ($t->language) {
                case 'EN':
                    $entity->name_en = $t->name;
                    break;
                case 'DE':
                    $entity->name_de = $t->name;
                    break;
                case 'FR':
                    $entity->name_fr = $t->name;
                    break;
                case 'NL':
                    $entity->name_nl = $t->name;
                    break;
            }
        }

        return $entity;
    }

    public function setMunicipalities(array $extensions) : self
    {
        if ($this->level === 'K') {
            $nis = $this->nis;
            $municipalities = array_filter($extensions, function ($x) use ($nis) {
                return $x->nisCanton === $nis;
            });

            foreach ($municipalities as $m) {
                $municipality = Municipality::fromX($m);

                $this->municipalities[$municipality->nis] = $municipality;
            }
        }

        return $this;
    }

    public function toGeoJSON(int $year) : array
    {
        if (is_array($this->municipalities) && count($this->municipalities) === 1) {
            $geometry = current($this->municipalities)->getGeometry($year);
        } elseif (is_array($this->municipalities) && count($this->municipalities) > 1) {
            $geometry = [
                'type'        => 'MultiPolygon',
                'coordinates' => [],
            ];

            foreach ($this->municipalities as $m) {
                $g = $m->getGeometry($year);

                if ($g->type === 'Polygon') {
                    array_push($geometry['coordinates'], $g->coordinates);
                } elseif ($g->type === 'MultiPolygon') {
                    $geometry['coordinates'] = array_merge($geometry['coordinates'], $g->coordinates);
                } else {
                    throw new ErrorException(sprintf('Invalid geometry type %s.', $g->type));
                }
            }
        }

        return [
            'type'       => 'Feature',
            'id'         => $this->id,
            'properties' => $this,
            'geometry'   => $geometry ?? null,
        ];
    }
}
