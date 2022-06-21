<?php

namespace JackSleight\StatamicMemberbox\Exporters;

class JsonExporter extends AbstractExporter
{
    public function export()
    {
        return json_encode($this->getData());
    }

    public function contentType()
    {
        return 'application/json';
    }
}
