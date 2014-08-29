<?php
namespace Craft;

class DefaultEntryType_EntryService extends BaseApplicationComponent
{

	protected $ETRecord;

    /**
     * Create a new instance of the Cocktail Recpies Service.
     * Constructor allows IngredientRecord dependency to be injected to assist with unit testing.
     *
     * @param @ETRecord ETRecord The entry type record to access the database
     */
    public function __construct($ETRecord = null)
    {
        $this->ETRecord = $ETRecord;
        if (is_null($this->ETRecord)) {
            $this->ETRecord = DefaultEntryType_EntryRecord::model();
        }
    }



    public function saveDEType(DefaultEntryType_EntryModel $eType)
    {

    	$isNewEType = !$eType->id;

		$eTypeRecord = DefaultEntryType_EntryRecord::model()->findById($eType->id);

		if (!$eTypeRecord)
		{
			$record = new DefaultEntryType_EntryRecord();
		}
		else
		{
			$record = $eTypeRecord;
		}

        $record->setAttributes($eType->getAttributes());
        if ($record->save()) {
            $eType->setAttribute('id', $record->getAttribute('id'));
            return true;
        } else {
            $eType->addErrors($record->getErrors());

            return false;
        }
    }



    public function getOrderById($id)
    {
    	 if ($record = $this->ETRecord->findByPk($id)) {
            $model = DefaultEntryType_EntryModel::populateModel($record);
            return $model->getAttribute('order');
        }
    }


    public function removeOrderById($id)
    {
        return $this->ETRecord->deleteByPk($id);
    }

    public function getAllOrders()
    {
    	$records = $this->ETRecord->findAll();
    	return DefaultEntryType_EntryModel::populateModels($records, 'id');
    }
}