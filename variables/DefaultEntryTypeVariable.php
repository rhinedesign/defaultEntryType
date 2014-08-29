<?php
namespace Craft;

class DefaultEntryTypeVariable
{
    public function getOrderById($id)
    {
        return craft()->defaultEntryType_entry->getOrderById($id);
    }
}