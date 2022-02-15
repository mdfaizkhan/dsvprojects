+function ($) {

  $(function(){

      $(document).on('click', '[ui-toggle-class]', function (e) {
        e.preventDefault();
        var $this = $(e.target);
        $this.attr('ui-toggle-class') || ($this = $this.closest('[ui-toggle-class]'));
        
		var classes = $this.attr('ui-toggle-class').split(','),
			targets = ($this.attr('target') && $this.attr('target').split(',')) || Array($this),
			key = 0;
		$.each(classes, function( index, value ) {
			var target = targets[(targets.length && key)];
			$( target ).toggleClass(classes[index]);
			if(classes[index]=="app-aside-folded")
			{
				var user_type = getUserType();
    			if (user_type == 'admin') {
        			themeSetting.asideDock =$('.settings input[name="asideFolded"]').is(':checked');
	        		if(themeSetting.asideDock)
	        		{
	        			$('.settings input[name="asideFolded"]').prop( 'checked', false );
	        			updateThemeSetting(themeSetting.asideFolded);
	        		}
	        		else
	        		{
	        			$('.settings input[name="asideFolded"]').prop( 'checked', true );
	        			updateThemeSetting(themeSetting.asideFolded);
	        		}
    			}
    			else if(user_type == 'user')
    			{
    				themeSetting.asideDock =$('#user_theme_aside_folded_value').val();
	        		if(themeSetting.asideDock=="1")
	        		{
	        			$('#user_theme_aside_folded_value').val("0");
	        			updateUserThemeSetting(0);
	        		}
	        		else if(themeSetting.asideDock=="0")
	        		{
	        			$('#user_theme_aside_folded_value').val("1");
	        			updateUserThemeSetting(1);
	        		}
    			}
			}
			key ++;
		});
		$this.toggleClass('active');

      });
  });

function updateUserThemeSetting(themeSetting) {

    var base_url = $('#base_url').val();
    var user_type = getUserType();
    var themeID = getthemeid();
    $.ajax({
        type: "post",
        url: base_url + user_type + '/home/update_user_theme_setting',
        data: {
            asideFolded: themeSetting,
        },
        dataType: "text",
        success: function (response) {
                     
        }
    });
}


}(jQuery);
