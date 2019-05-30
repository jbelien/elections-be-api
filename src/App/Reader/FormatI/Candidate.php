<?php

declare(strict_types=1);

namespace App\Reader\FormatI;

use App\Reader\FormatI\Candidate\C;
use App\Reader\FormatI\Candidate\G;
use Exception;
use League\Csv\Reader;
use League\Csv\Statement;

class Candidate
{
    private $year;
    private $type;

    private $test;

    private $file;
    private $metadata;
    private $candidates;

    public function __construct(int $year, string $type, bool $test = false)
    {
        $this->year = $year;
        $this->type = $type;

        $this->test = $test;

        if ($this->test === true) {
            $this->file = sprintf('data/%d/test/format-i/IC.%s', $this->year, $this->type);
        } else {
            $this->file = sprintf('data/%d/format-i/IC.%s', $this->year, $this->type);
        }

        $this->metadata = $this->readG();
        $this->candidates = $this->readC();

        if ($this->metadata->count !== count($this->candidates)) {
            throw new Exception(sprintf('Data mismatch: count (%d) does not match candidates count (%d).', $this->metadata->count, count($this->candidates)));
        }
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
        return [
            'file'       => basename($this->file),
            'test'       => $this->test,
            'metadata'   => $this->metadata,
            'candidates' => $this->candidates,
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
