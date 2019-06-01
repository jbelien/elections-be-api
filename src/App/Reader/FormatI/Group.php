<?php

declare(strict_types=1);

namespace App\Reader\FormatI;

use App\Model\Group as ModelGroup;
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
            $this->file = sprintf('data/%d/test/format-i/IG.%s', $this->year, $this->type);
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

    public function getGroups(): array
    {
        return $this->groups;
    }

    public function getArray(): array
    {
        return [
            'file'         => basename($this->file),
            'year'         => $this->year,
            'type'         => $this->type,
            'test'         => $this->test,
            'metadata'     => $this->metadata,
            'groups'       => $this->groups,
        ];
    }

    public function get(int $id): ModelGroup
    {
        $groups = array_filter($this->groups, function ($g) use ($id) {
            return $g->id === $id;
        });

        if (count($groups) === 0) {
            throw new Exception(sprintf('Invalid group ID (%d) for type "%s" in %d.', $id, $this->type, $this->year));
        }
        // Issue with 2019 election groups:
        // "PTB*PVDA" (323) is defined twice because of previous name ("PTB-GO !" & "PVDA+")
        // if (count($groups) > 1) {
        //     throw new Exception(sprintf('Ambiguous group ID (%d).', $id));
        // }

        return ModelGroup::fromX(current($groups));
    }
}
