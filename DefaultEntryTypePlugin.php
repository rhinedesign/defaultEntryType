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


        // intercept controller actions for deleting entry types, (there's not an event so this was the only way i could think to do this.)
        if( craft()->request->isActionRequest() &&  end(craft()->request->getActionSegments() ) == "deleteEntryType" ){
            $entryTypeId = craft()->request->getPost( 'id' );
            craft()->defaultEntryType_entry->removeOrderById( $entryTypeId );
        }

         // intercept controller actions for deleting section in order to remove entry types
        if( craft()->request->isActionRequest() &&  end(craft()->request->getActionSegments() ) == "deleteSection" ){
            $sectionId = craft()->request->getPost( 'id' );
            $entryTypes = craft()->sections->getEntryTypesBySectionId($sectionId);
            foreach($entryTypes as $entryType)
            {
                $entryTypeId = $entryType->getAttribute('id');
                craft()->defaultEntryType_entry->removeOrderById( $entryTypeId );
            }
            
        }
        
        //load entrytype overriding javascript for appropriate control panel pages (entry edit or new entry pages)
        $segs = craft()->request->getSegments();
        if($segs && $segs[0] == "entries" && count($segs) == 3 )
        {
            craft()->templates->includeJsResource('/defaultEntryType/js/defaultEntryTypeCP.js');
        }
    }
}