<?php

namespace JackSleight\StatamicMemberbox\Exporters;

use League\Csv\Writer;
use SplTempFileObject;

class CsvExporter extends AbstractExporter
{
    private $writer;

    public function __construct()
    {
        $this->writer = Writer::createFromFileObject(new SplTempFileObject);
    }

    public function contentType()
    {
        return 'text/csv';
    }

    public function export()
    {
        $this->writer->insertOne($this->getKeys());
        $this->writer->insertAll($this->getData());

        return (string) $this->writer;
    }

    protected function getData()
    {
        return collect(parent::getData())
            ->map(function ($user) {
                return collect($user)->map(function ($value) {
                    return (is_array($value)) ? implode(', ', $value) : $value;
                })->all();
            })
            ->all();
    }
}
