(function($){
	
	
	function initialize_field( $el ) {
		
		//$el.doStuff();
		
	}
	
	
	if( typeof acf.add_action !== 'undefined' ) {
	
		/*
		*  ready append (ACF5)
		*
		*  These are 2 events which are fired during the page load
		*  ready = on page load similar to $(document).ready()
		*  append = on new DOM elements appended via repeater field
		*
		*  @type	event
		*  @date	20/07/13
		*
		*  @param	$el (jQuery selection) the jQuery element which contains the ACF fields
		*  @return	n/a
		*/
		
		acf.add_action('ready append', function( $el ){
			
			// search $el for fields of type 'rgba_color'
			acf.get_fields({ type : 'rgba_color'}, $el).each(function(){
				
				initialize_field( $(this) );

				// var colpick = $('.rgba').each( function() {
    // 			$(this).minicolors({
    // 			  	defaultValue: '#ff6167',
    // 			  	inline: false,
    // 			  	opacity: true,
    // 			  	change: function(hex, opacity) {
    // 			  		console.log($(this));
    // 			    	if(!hex) return;
    // 			    	text = hex ? hex : 'transparent';
    // 			    	if( opacity ) text += ', ' + opacity;
    // 					    text = jQuery(this).minicolors('rgbaString');
    // 					    console.log($(this).closest('.toping').find('#rgbatext'));
    // 					    $(this).closest('.toping').find('#rgbatext').val(text);
    // 					    $(this).closest('.toping').find('#opacity').val(opacity);
    // 				 	},
    // 				});
				// });
			});

		});
		
		
	} else {
		
		
		/*
		*  acf/setup_fields (ACF4)
		*
		*  This event is triggered when ACF adds any new elements to the DOM. 
		*
		*  @type	function
		*  @since	1.0.0
		*  @date	01/01/12
		*
		*  @param	event		e: an event object. This can be ignored
		*  @param	Element		postbox: An element which contains the new HTML
		*
		*  @return	n/a
		*/
		
		$(document).live('acf/setup_fields', function(e, postbox){
			
			$(postbox).find('.field[data-field_type="rgba_color"]').each(function(){
				
				initialize_field( $(this) );
				
			});
		
		});
	
	
	}


})(jQuery);
