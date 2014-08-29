<?php
namespace Craft;

class DefaultEntryType_EntryModel extends BaseModel
{

	public function __toString()
    {
        return $this->order;
    }

    protected function defineAttributes()
    {
        return array(
            'id' => AttributeType::Number,
            'order' => AttributeType::Number
        );
    }
}