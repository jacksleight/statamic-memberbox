<?php

namespace JackSleight\StatamicMemberbox\Exporters;

use JackSleight\StatamicMemberbox\Facades\Member;
use League\Csv\Writer;
use SplTempFileObject;

class CsvExporter
{
    private $writer;

    public function __construct()
    {
        $this->writer = Writer::createFromFileObject(new SplTempFileObject);
    }

    public function export()
    {
        $users = Member::query()->get()->toArray();

        if (! count($users)) {
            return (string) $this->writer;
        }

        $this->writer->insertOne(array_keys($users[0]));

        $data = collect($users)->map(function ($user) {
            return collect($user)->map(function ($value) {
                return (is_array($value)) ? implode(', ', $value) : $value;
            })->all();
        })->all();

        $this->writer->insertAll($data);

        return (string) $this->writer;
    }

    public function contentType()
    {
        return 'text/csv';
    }
}
