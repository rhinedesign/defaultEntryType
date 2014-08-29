<?php
namespace Craft;

class DefaultEntryType_EntryRecord extends BaseRecord
{
    public function getTableName()
    {
        return 'defaultentrytype_entries';
    }

    protected function defineAttributes()
    {
        return array(
            'id' => AttributeType::Number,
            'order' => AttributeType::Number
        );
    }
    public function defineIndexes()
    {
        return array(
            array('columns' => array('id'), 'unique' => true),
        );
    }
}