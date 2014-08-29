<?php
namespace Craft;

class DefaultEntryType_OrderController extends BaseController
{
    public function actionUpdateOrder()
    {
    	$this->requireAdmin();
    	$this->requireAjaxRequest();

        if ( $entryTypeOrders = craft()->request->getPost('entryTypeOrders') )
        {
        	$entryTypeOrders = json_decode($entryTypeOrders);
        	foreach($entryTypeOrders as $section)
        	{
        		foreach($section->etypes as $entryType)
        		{
        			$entryTypeModel = new DefaultEntryType_EntryModel();
        			$entryTypeModel->setAttribute( 'id',    $entryType->id    );
        			$entryTypeModel->setAttribute( 'order', $entryType->order );
        			craft()->defaultEntryType_entry->saveDEType($entryTypeModel);
        		}
        	}


        	$this->returnJson('{success: true}');
        }
        else
        {
        	$this->returnErrorJson('{failure: "no data"}');
        }

        /* $attributes = craft()->request->getPost('ingredient');
        $model->setAttributes($attributes); */
        // echo craft()->request->getPost('entryTypeOrders');
        
    }

    public function actionGetTypeByEntryId()
    {

        $this->requireAjaxRequest();
        $id = craft()->request->getPost('id');
    	$criteria = craft()->elements->getCriteria(ElementType::Entry);
        $criteria->id = $id;
        $entries = $criteria->find();

        if($entries)
        {
            $entry = $entries[0];
            $level = $entry->getAttribute('level');
            $section = $entry->getAttribute('sectionId');

            $entryTypes = craft()->sections->getEntryTypesBySectionId($section);
            $orderExists = false;
            foreach($entryTypes as $entryType)
            {
                $entryTypeId = $entryType->getAttribute('id');
                $order = craft()->defaultEntryType_entry->getOrderById($entryTypeId);
                if( $order == $level )
                {
                    $orderExists = true;
                    break;
                }
            }
            if($entryTypeId && $orderExists)
            {
                $this->returnJson($entryTypeId);
            }
            else
            {
                $this->returnJson('false');
            }
        }
        else{
             $this->returnJson('false');
        }
    }


    public function actionGetTypeByParentId()
    {
       $this->requireAjaxRequest();
        $id = craft()->request->getPost('id');
        $criteria = craft()->elements->getCriteria(ElementType::Entry);
        $criteria->id = $id;
        $entries = $criteria->find();

        if($entries)
        {
            $entry = $entries[0];
            $level = $entry->getAttribute('level');
            $section = $entry->getAttribute('sectionId');

            $entryTypes = craft()->sections->getEntryTypesBySectionId($section);
            $orderExists = false;
            foreach($entryTypes as $entryType)
            {
                $entryTypeId = $entryType->getAttribute('id');
                $order = craft()->defaultEntryType_entry->getOrderById($entryTypeId);
                if( $order == $level + 1 )
                {
                    $orderExists = true;
                    break;
                }
            }
            if($entryTypeId && $orderExists)
            {
                $this->returnJson($entryTypeId);
            }
            else
            {
                $this->returnJson('false');
            }
        }
        else{
             $this->returnJson('false');
        }
    }
}