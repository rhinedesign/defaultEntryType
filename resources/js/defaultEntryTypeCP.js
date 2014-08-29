var entryTypeField = $('#entryType');
var pageId = $('#entry-form').find('[name="entryId"]').val();
if(entryTypeField.length)
{
	//edit entry
	if(pageId)
	{
		Craft.postActionRequest('defaultEntryType/order/getTypeByEntryId', 'id='+pageId, function(response) {
			if(response != "false")
			{
			    entryTypeField.find("option:selected").removeAttr("selected");
			    entryTypeField.find('[value="'+response+'"]').attr('selected', 'selected');
			    entryTypeField.attr('disabled', 'disabled').css('background-color', 'rgba(200,200,200,0.4)');
			}
		});
	} // new entry
	else
	{
		switchParent();
	}
	
	//handle switching parents from dropdown
	$('#parentId').on('change', function(){
		switchParent();
	})
}

function switchParent(){
	var parentId = $('#parentId').find('option:selected').val();

	if(parentId)
	{
		Craft.postActionRequest('defaultEntryType/order/getTypeByParentId', 'id='+parentId, function(response) {
			if(response != "false")
			{
			    entryTypeField.find("option:selected").removeAttr("selected");
			    entryTypeField.find('[value="'+response+'"]').attr('selected', 'selected');
			    entryTypeField.attr('disabled', 'disabled').css('background-color', 'rgba(200,200,200,0.4)');
			}
		});
	}
}