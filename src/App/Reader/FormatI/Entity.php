<?php

declare(strict_types=1);

namespace App\Reader\FormatI;

use App\Model\Entity as ModelEntity;
use App\Reader\FormatI\Entity\E;
use App\Reader\FormatI\Entity\G;
use App\Reader\FormatI\Entity\T;
use Exception;
use League\Csv\Reader;
use League\Csv\Statement;

class Entity
{
    private $year;
    private $type;

    private $test;

    private $file;
    private $metadata;
    private $entities;
    private $translations;

    public function __construct(int $year, string $type, bool $test = false)
    {
        $this->year = $year;
        $this->type = $type;

        $this->test = $test;

        if ($this->test === true) {
            $this->file = sprintf('data/%d/test/format-i/IE.%s', $this->year, $this->type);
        } else {
            $this->file = sprintf('data/%d/format-i/IE.%s', $this->year, $this->type);
        }

        $this->metadata = $this->readG();
        $this->entities = $this->readE();
        $this->translations = $this->readT();

        if ($this->metadata->count !== count($this->entities)) {
            throw new Exception(sprintf('Data mismatch: count (%d) does not match entities count (%d).', $this->metadata->count, count($this->entities)));
        }
    }

    private function readG(): G
    {
        $csv = Reader::createFromPath($this->file, 'r');

        $stmt = (new Statement())->offset(0)->limit(1);

        $records = $stmt->process($csv);

        return G::fromArray($records->fetchOne(0));
    }

    private function readE(): array
    {
        $csv = Reader::createFromPath($this->file, 'r');
        $stmt = (new Statement())->offset(1);
        $records = $stmt->process($csv);

        $list = [];

        foreach ($records as $record) {
            if ($record[0] === 'E') {
                $list[] = E::fromArray($record);
            }
        }

        return $list;
    }

    private function readT(): array
    {
        $csv = Reader::createFromPath($this->file, 'r');
        $stmt = (new Statement())->offset(1);
        $records = $stmt->process($csv);

        $list = [];

        foreach ($records as $record) {
            if ($record[0] === 'T') {
                $list[] = T::fromArray($record);
            }
        }

        return $list;
    }

    public function getEntities() : array
    {
        return $this->entities;
    }

    public function getArray(): array
    {
        return [
            'file'         => basename($this->file),
            'test'         => $this->test,
            'metadata'     => $this->metadata,
            'entities'     => $this->entities,
            'translations' => $this->translations,
        ];
    }

    public function get(int $id) : ModelEntity
    {
        $entities = array_filter($this->entities, function ($e) use ($id) {
            return $e->id === $id;
        });

        if (count($entities) === 0) {
            throw new Exception(sprintf('Invalid entity ID (%d) for type "%s" in %d.', $id, $this->type, $this->year));
        }
        if (count($entities) > 1) {
            throw new Exception(sprintf('Ambiguous entity ID (%d).', $id));
        }

        $translations = array_filter($this->translations, function ($t) use ($id) {
            return $t->idEntity === $id;
        });

        return ModelEntity::fromE(current($entities), $translations);
    }
}
