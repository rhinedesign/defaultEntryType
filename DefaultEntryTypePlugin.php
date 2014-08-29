<?php
namespace Craft;

class DefaultEntryTypePlugin extends BasePlugin
{
    function getName()
    {
         return Craft::t('Default Entry Type');
    }

    function getVersion()
    {
        return '0.1';
    }

    function getDeveloper()
    {
        return 'Rhine Design';
    }

    function getDeveloperUrl()
    {
        return 'http://rhinedesign.biz';
    }
    public function hasCpSection()
    {
        return true;
    }

    function onAfterInstall()
    {
        foreach(craft()->sections->getAllSectionIds() as $sectionId)
        {
            foreach(craft()->sections->getEntryTypesBySectionId($sectionId) as $entryType)
            {
                $entryTypeModel = new DefaultEntryType_EntryModel();
                $entryTypeModel->setAttribute('id', $entryType->getAttribute('id') );
                craft()->defaultEntryType_entry->saveDEType($entryTypeModel);
            }
        }
    }

    function init() {
        // intercept controller actions for deleting entry types
        if( craft()->request->isActionRequest() &&  end(craft()->request->getActionSegments() ) == "deleteEntryType" ){
            $entryTypeId = craft()->request->getPost( 'id' );
            craft()->defaultEntryType_entry->removeOrderById( $entryTypeId );
        }
        
        $segs = craft()->request->getSegments();
        
        if($segs && $segs[0] == "entries" && count($segs) == 3 )
        {
            craft()->templates->includeJsResource('defaultEntryType/js/defaultEntryTypeCP.js');
        }
    }
}