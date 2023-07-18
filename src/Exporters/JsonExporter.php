<?php

namespace JackSleight\StatamicMemberbox\Exporters;

class JsonExporter extends AbstractExporter
{
    public function contentType()
    {
        return 'application/json';
    }

    public function export()
    {
        return json_encode($this->getData());
    }
}
