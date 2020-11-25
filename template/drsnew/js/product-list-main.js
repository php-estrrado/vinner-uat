(function($) 
 {
    
    function rating() {
        $('select.ps-rating').each(function() {
            var readOnly;
            if ($(this).attr('data-read-only') == 'true') {
                readOnly = true
            } else {
                readOnly = false;
            }
            $(this).barrating({
                theme: 'fontawesome-stars',
                readonly: readOnly,
                emptyValue: '0'
            });
        });
    }

    $(function() 
	{
    	//siteToggleAction();
        //subMenuToggle();
        rating();
    });

})(jQuery);

