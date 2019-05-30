<?php

declare(strict_types=1);

namespace App\Reader\FormatI;

use App\Reader\FormatI\Group\G;
use App\Reader\FormatI\Group\X;
use Exception;
use League\Csv\Reader;
use League\Csv\Statement;

class Group
{
    private $year;
    private $type;

    private $test;

    private $file;
    private $metadata;
    private $groups;

    public function __construct(int $year, string $type, bool $test = false)
    {
        $this->year = $year;
        $this->type = $type;

        $this->test = $test;

        if ($this->test === true) {
            $this->file = sprintf('data/%d/test/format-i/%s/IG.%s', $this->year, $this->testFinal ? 'final' : 'intermediate', $this->type);
        } else {
            $this->file = sprintf('data/%d/format-i/IG.%s', $this->year, $this->type);
        }

        $this->metadata = $this->readG();
        $this->groups = $this->readX();

        if ($this->metadata->count !== count($this->groups)) {
            throw new Exception(sprintf('Data mismatch: count (%d) does not match groups count (%d).', $this->metadata->count, count($this->groups)));
        }
    }

    private function readG(): G
    {
        $csv = Reader::createFromPath($this->file, 'r');

        $stmt = (new Statement())->offset(0)->limit(1);

        $records = $stmt->process($csv);

        return G::fromArray($records->fetchOne(0));
    }

    private function readX(): array
    {
        $csv = Reader::createFromPath($this->file, 'r');
        $stmt = (new Statement())->offset(1);
        $records = $stmt->process($csv);

        $list = [];

        foreach ($records as $record) {
            $list[] = X::fromArray($record);
        }

        return $list;
    }

    public function getArray(): array
    {
        $array = [
            'file'     => basename($this->file),
            'metadata' => $this->metadata,
            'groups'   => $this->groups,
        ];

        return $array;
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
            return $t->entity === $id;
        });

        return ModelEntity::fromE(current($entities), $translations);
    }
}
