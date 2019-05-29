<?php

declare (strict_types = 1);

namespace App\Reader\FormatR;

use App\Reader\FormatR\Evolution\C;
use App\Reader\FormatR\Evolution\G;
use League\Csv\Reader;
use League\Csv\Statement;
use App\Reader\FormatI\Entity;

class Evolution
{
    private $year;
    private $type;

    private $test;
    private $testFinal;

    private $file;
    private $metadata;
    private $cantons;

    public function __construct(int $year, string $type, bool $test = false, bool $testFinal = false)
    {
        $this->year = $year;
        $this->type = $type;

        $this->test = $test;
        $this->testFinal = $this->test && $testFinal;

        if ($this->test === true) {
            $this->file = sprintf('data/%d/test/format-r/%s/RER00000.%s', $this->year, $this->testFinal ? 'final' : 'intermediate', $this->type);
        } else {
            $this->file = sprintf('data/%d/format-r/RER00000.%s', $this->year, $this->type);
        }

        $this->metadata = $this->readG();
        $this->cantons = $this->readC();
    }

    private function readG(): G
    {
        $csv = Reader::createFromPath($this->file, 'r');

        $stmt = (new Statement())->offset(0)->limit(1);

        $records = $stmt->process($csv);

        return G::fromArray($records->fetchOne(0));
    }

    private function readC(): array
    {
        $csv = Reader::createFromPath($this->file, 'r');
        $stmt = (new Statement())->offset(1);
        $records = $stmt->process($csv);

        $list = [];

        foreach ($records as $record) {
            $list[] = C::fromArray($record);
        }

        return $list;
    }


    public function getArray(): array
    {
        $array = [
            'file' => basename($this->file),
            'metadata' => $this->metadata,
            'cantons' => $this->cantons
        ];

        return $array;
    }
}
