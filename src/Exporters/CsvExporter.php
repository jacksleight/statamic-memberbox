<?php

namespace JackSleight\StatamicMemberbox\Exporters;

use League\Csv\Writer;
use SplTempFileObject;
use Statamic\Facades\User;

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
        $this->writer->insertOne($this->getHeaders());
        $this->writer->insertAll($this->getData());

        return (string) $this->writer;
    }

    protected function getHeaders()
    {
        return User::blueprint()
            ->fields()
            ->except(['id', 'groups', 'roles', 'password'])
            ->all()
            ->keys()
            ->merge(['id', 'last_login'])
            ->all();
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
