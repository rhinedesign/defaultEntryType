var entryTypeField = $('#entryType');
var pageId = $('#entry-form').find('[name="entryId"]').val();
var sectionId = $('#entry-form').find('[name="sectionId"]').val();

if(entryTypeField.length)
{
	//edit entry
	if(pageId)
	{
		Craft.postActionRequest('defaultEntryType/order/getTypeByEntryId', 'id='+pageId, function(response) {
			if(response != "false")
			{
			    selectType(response);
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
	if(parentId > 0)
	{
		Craft.postActionRequest('defaultEntryType/order/getTypeByParentId', 'id='+parentId, function(response) {
			if(response != "false")
			{
			    selectType(response);
			}
		});
	}
	else
	{
		Craft.postActionRequest('defaultEntryType/order/getTypeBySectionId', 'id='+sectionId, function(response) {
			if(response != "false")
			{
			    selectType(response);
			}
		});
	}
}

function selectType(response){
	entryTypeField.css('background-color', 'rgba(200,200,200,0.4)');
	var currentEntryTypeID = entryTypeField.find("option:selected").val();
	console.log(currentEntryTypeID + ', ' + parseInt(response))
	if(parseInt(currentEntryTypeID) != parseInt(response)){
		entryTypeField.find("option:selected").removeAttr("selected");
		entryTypeField.find('[value="'+response+'"]').attr('selected', 'selected');
		entryTypeField.find("option:not(:selected)").remove();
		if(!pageId){pageId=""}
		Craft.postActionRequest('entries/switchEntryType', $('#entry-form').serialize(), function(response){
			$('#fields').html(response.paneHtml);
			$(document.body).append(response.footHtml);
		});
	}
}