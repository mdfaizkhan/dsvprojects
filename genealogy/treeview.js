
$(document).ready(function() {
   //$('#treeview-pan').panner({control: $('#pan-5-control')});
    var $section = $('.pan-container').first();
    $section.find('#treeview-pan').panzoom();
  /*  $('li.subx').on('click',function(){
		
                    var id = $(this).attr('data-id');
					alert(id);
                   $(this).removeClass('subx');
					
					 $(this).attr('onclick', 'return get_child1('+id+')');
					
                    $("<p class='loadingtext'>Loading Data.. Please wait...</p>").insertAfter("[data-id="+id+"] a");
                    var msg = "";
                     $.ajax({
                     type: "POST",
                     url: "getchildtree",
                     data: "id="+id,
                     cache: false,
                     beforeSend: function(){ $("#loading").show();},
                     success: function(msg)
                        {
                            $('p.loadingtext').remove();
							
						//	$('#genealogy_id').empty().append(msg);
							
							$(msg).insertAfter("[data-id="+id+"] a");
                        }
                
                    });
                   
                });  */
    $("#tree-loading").hide();
    $(".pan-container").show();
});


function get_child(id)
{
//	alert(111);
//	alert(id);
	//$("<p class='loadingtext'>Loading Data.. Please wait...</p>").insertAfter("[data-id="+id+"] a");
	var msg = "";
	$.ajax({
		type: "POST",
		url: "getchildtree",
		data: "id="+id,
		cache: false,
		beforeSend: function(){ $("#loading").show();},
		success: function(msg)
		{
			//$('p.loadingtext').remove();
			$('#genealogy_id').empty().append(msg);
			return false;
			
		}
	});
	return false;
}

function get_child1(id)
{
//	alert(111);
//	alert(id);
	
	var msg = "";
	 $.ajax({
	 type: "POST",
	 url: "getchildtree",
	 data: "id="+id,
	 cache: false,
	 success: function(msg)
		{
		   $('#genealogy_id').empty().append(msg);
			return false;
		}

	});
	return false;
}

$('#SearchID').on('click', function(e)
{
	var sid = $('#sponserid').val();
	if(sid != '')
	{
        $elm=$(".btn-submit");
        $elm.hide();
        $elm.after('<i class="fa fa-spinner fa-pulse fa-1x fa-fw submit-loading"></i>');
        $.ajax({
            type: "POST",
            url: "../includes/adminfunction",
            data: "id="+sid+"&CheckSponser=1",
            cache: false,
            success: function(resp)
            {
                resp=JSON.parse(resp);
                if(resp.valid)
                {
                    $.ajax({
                        type: "POST",
                        url: "getchildtree",
                        data: "id="+resp.id,
                        cache: false,
                        success: function(msg)
                        {
                            $('#genealogy_id').empty().append(msg);
                            return false;
                        }

                    });
                }
                else{
                    _toastr(resp.message,"bottom-right","info",false);
                }
                $(".submit-loading").remove();
                $elm.show();

            },
            error: function(data) {
            }

        });
	}
	else
	{
        _toastr("Enter Sponser ID","bottom-right","info",false);
	}


});