<?php

declare(strict_types = 1);

namespace App\Reader\FormatR\Extension;

use App\Reader\FormatR\Extension\Evolution\G;
use App\Reader\FormatR\Extension\Evolution\X;
use League\Csv\Reader;
use League\Csv\Statement;

class Evolution
{
    private $year;
    private $type;

    private $test;
    private $testFinal;

    private $file;
    private $metadata;
    private $municipalities;

    public function __construct(int $year, string $type, bool $test = false, bool $testFinal = false)
    {
        $this->year = $year;
        $this->type = $type;

        $this->test = $test;
        $this->testFinal = $this->test && $testFinal;

        if ($this->test === true) {
            $this->file = sprintf('data/%d/test/format-r/%s/REX00000.%s', $this->year, $this->testFinal ? 'final' : 'intermediate', $this->type);
        } else {
            $this->file = sprintf('data/%d/format-r/REX00000.%s', $this->year, $this->type);
        }

        $this->metadata = $this->readG();
        $this->municipalities = $this->readX();
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
            'file'           => basename($this->file),
            'year'           => $this->year,
            'type'           => $this->type,
            'test'           => $this->test,
            'metadata'       => $this->metadata,
            'municipalities' => $this->municipalities,
        ];

        return $array;
    }
}
