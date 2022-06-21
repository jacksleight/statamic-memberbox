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

    public function export()
    {
        $this->writer->insertOne($this->getHeaders());
        $this->writer->insertAll($this->getData());

        return (string) $this->writer;
    }

    public function contentType()
    {
        return 'text/csv';
    }
}
