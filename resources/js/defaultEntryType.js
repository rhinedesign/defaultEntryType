var modified = false;

jQuery.fn.EntryOrderControl =
function(buttonSelector)
{
    var oldInt = '';
    var button = $(buttonSelector);
    return this.each(function()
    {
        $(this).keydown(function(e)
        {
            oldInt = this.value;
            var key = e.charCode || e.keyCode || 0;
            // allow backspace, tab, delete, enter, arrows, numbers and keypad numbers ONLY
            return
            (
                key == 8 || 
                key == 9 ||
                key == 13 ||
                key == 46 ||
                (key >= 35 && key <= 40) ||
                (key >= 48 && key <= 57) ||
                (key >= 96 && key <= 105)
            );
        });
        $(this).keyup(function(e)
        {
            var currentEType = e.target;
            var parentContainer = $(e.target).closest('.item');
            var entryTypes = parentContainer.find('.numeric');

            //ensure only different values per group
            entryTypes.not(currentEType).each(function(){
                if( parseInt(currentEType.value) === parseInt(this.value) )
                {
                    if(currentEType.value > 0)
                    {
                        this.value = oldInt;
                    }
                    else
                    {
                        this.value = '';
                    }
                }
            });

            if(!modified){
                button.val('Save');
            }
            modified = true;
        });
    });
};

//populate input


//attach handler for unique section numbers
$('#entrytypeorder .numeric').EntryOrderControl('#entryOrderSubmit');

//attach handler for submitting to controller
$('#entryOrderSubmit').on('click', function(){
    var button = $(this);
    button.val('Saving...');
    var sections = $('#entrytypeorder').find('.item');
    var postData = [];
    for ( var i=0; i<sections.length; i++ )
    {
        postData[i] = {id: sections[i].getAttribute('data-id'), etypes: []}
        var entryTypes = $(sections[i]).find('.numeric');
        for ( var j=0; j<entryTypes.length; j++ )
        {
            if( entryTypes[j].getAttribute('data-id') )
            {
                postData[i].etypes[j] = {id: entryTypes[j].getAttribute('data-id'), order: entryTypes[j].value}
            }
        }
    }
    Craft.postActionRequest('defaultEntryType/order/updateOrder', 'entryTypeOrders='+JSON.stringify(postData), function(response){
        modified = false;
        setTimeout(function(){
            button.val('Saved');
        }, 400);
    });
})
