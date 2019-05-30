<?php

declare(strict_types=1);

namespace App\Model;

use App\Reader\FormatI\Entity\E;

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
    /** @var array */
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
                $this->municipalities[$m->nisMunicipality] = [
                    'name_de' => $m->name_de,
                    'name_en' => $m->name_en,
                    'name_fr' => $m->name_fr,
                    'name_nl' => $m->name_nl,
                ];
            }
        }

        return $this;
    }
}
