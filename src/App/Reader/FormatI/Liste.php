<?php

declare(strict_types=1);

namespace App\Reader\FormatI;

use App\Reader\FormatI\Liste\G;
use App\Reader\FormatI\Liste\L;
use Exception;
use League\Csv\Reader;
use League\Csv\Statement;

class Liste
{
    private $year;
    private $type;

    private $test;

    private $file;
    private $metadata;
    private $lists;

    public function __construct(int $year, string $type, bool $test = false)
    {
        $this->year = $year;
        $this->type = $type;

        $this->test = $test;

        if ($this->test === true) {
            $this->file = sprintf('data/%d/test/format-i/IL.%s', $this->year, $this->type);
        } else {
            $this->file = sprintf('data/%d/format-i/IL.%s', $this->year, $this->type);
        }

        $this->metadata = $this->readG();
        $this->lists = $this->readL();

        if ($this->metadata->count !== count($this->lists)) {
            throw new Exception(sprintf('Data mismatch: count (%d) does not match lists count (%d).', $this->metadata->count, count($this->lists)));
        }
    }

    private function readG(): G
    {
        $csv = Reader::createFromPath($this->file, 'r');

        $stmt = (new Statement())->offset(0)->limit(1);

        $records = $stmt->process($csv);

        return G::fromArray($records->fetchOne(0));
    }

    private function readL(): array
    {
        $csv = Reader::createFromPath($this->file, 'r');
        $stmt = (new Statement())->offset(1);
        $records = $stmt->process($csv);

        $list = [];

        foreach ($records as $record) {
            $list[] = L::fromArray($record);
        }

        return $list;
    }

    public function getArray(): array
    {
        return [
            'file'         => basename($this->file),
            'test'         => $this->test,
            'metadata'     => $this->metadata,
            'lists'        => $this->lists,
        ];
    }

    /*
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
    */
}
