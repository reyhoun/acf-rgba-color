<?php

class acf_field_rgba_color extends acf_field {
	
	
	/*
	*  __construct
	*
	*  This function will setup the field type data
	*
	*  @type	function
	*  @date	5/03/2014
	*  @since	5.0.0
	*
	*  @param	n/a
	*  @return	n/a
	*/
	
	function __construct() {
		
		/*
		*  name (string) Single word, no spaces. Underscores allowed
		*/
		
		$this->name = 'rgba_color';
		
		
		/*
		*  label (string) Multiple words, can include spaces, visible when selecting a field type
		*/
		
		$this->label = __('RGBA Color', 'advanced-custom-fields-rgba-color');
		
		
		/*
		*  category (string) basic | content | choice | relational | jquery | layout | CUSTOM GROUP NAME
		*/
		
		$this->category = 'choice';
		
		
		/*
		*  defaults (array) Array of default settings which are merged into the field object. These are used later in settings
		*/
		
		$this->defaults = array(
			'rgba'			=>'',
			'return_value'	=> 0,
			'ext_value'		=> array(),
		);
		
		
		/*
		*  l10n (array) Array of strings that are used in JavaScript. This allows JS strings to be translated in PHP and loaded via:
		*  var message = acf._e('rgba_color', 'error');
		*/
		
		$this->l10n = array(
			'error'	=> __('Error! Please enter a higher value', 'advanced-custom-fields-rgba-color'),
		);
		
				
		// do not delete!
    	parent::__construct();
    	
	}
	
	
	/*
	*  render_field_settings()
	*
	*  Create extra settings for your field. These are visible when editing a field
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field (array) the $field being edited
	*  @return	n/a
	*/
	
	function render_field_settings( $field ) {
		
		/*
		*  acf_render_field_setting
		*
		*  This function will create a setting for your field. Simply pass the $field parameter and an array of field settings.
		*  The array of settings does not require a `value` or `prefix`; These settings are found from the $field array.
		*
		*  More than one setting can be added by copy/paste the above code.
		*  Please note that you must also have a matching $defaults value for the field name (font_size)
		*/
		
		acf_render_field_setting( $field, array(
			'label'			=> __('RGBA Color','advanced-custom-fields-rgba-color'),
			'instructions'	=> __('Following this methods for default value: rgba(red, green, blue, alpha)','advanced-custom-fields-rgba-color'),
			'type'			=> 'text',
			'name'			=> 'rgba',
			
		));

		acf_render_field_setting( $field, array(
            'label'         => __('Return Value ','advanced-custom-fields-rgba-color'),
            'type'          => 'radio',
            'name'          => 'return_value',
            'layout'  =>  'horizontal',
            'choices' =>  array(
                1 => __('hex and opacity', 'return_value'),
                0 => __('css rgba', 'return_value'),
            )
        ));

	}
	
	
	
	/*
	*  render_field()
	*
	*  Create the HTML interface for your field
	*
	*  @param	$field (array) the $field being rendered
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field (array) the $field being edited
	*  @return	n/a
	*/
	
	function render_field( $field ) {
 		
		
		 // add empty value (allows '' to be selected)
        if( empty($field['value']) ){

            
            if ($field['rgba']) {

            	if ($field['return_value']) {
            		$rgba = sscanf($field['rgba'], "rgba(%d, %d, %d, %f)");

            		$hex = "#";
					$hex.= str_pad(dechex($rgba[0]), 2, "0", STR_PAD_LEFT);
					$hex.= str_pad(dechex($rgba[1]), 2, "0", STR_PAD_LEFT);
					$hex.= str_pad(dechex($rgba[2]), 2, "0", STR_PAD_LEFT);

					$field['value']['hex'] 	= $hex;
            		$field['value']['opacity'] = $rgba[3];
            	} else{

               		$field['value']	= $field['rgba'];
            	}

            } else {
            	if ($field['return_value']) {
            		$field['value']['hex'] 	= '#2b42d6';
            		$field['value']['opacity'] = 0;
            	} else{
            		$field['value']	= '';
            	}
            }
            
        }



    		if( empty($field['value']) ){

    			$field['ext_value']['he-op']['hex'] 	= '#000000';
            	$field['ext_value']['he-op']['opacity'] = '0';
            	
            	$field['ext_value']['rgba']		= '';

    		} else {
            	if( empty($field['value']['hex']) ){

            		$rgba = sscanf($field['value'], "rgba(%d, %d, %d, %f)");

            		$hex = "#";
					$hex.= str_pad(dechex($rgba[0]), 2, "0", STR_PAD_LEFT);
					$hex.= str_pad(dechex($rgba[1]), 2, "0", STR_PAD_LEFT);
					$hex.= str_pad(dechex($rgba[2]), 2, "0", STR_PAD_LEFT);

            		$field['ext_value']['he-op']['hex'] 	= $hex;
            		$field['ext_value']['he-op']['opacity'] = $rgba[3];
            	
            		$field['ext_value']['rgba']		= $field['value'];
            	} else {

            		$field['ext_value']['he-op']['hex'] 	= $field['value']['hex'];
            		$field['ext_value']['he-op']['opacity'] = $field['value']['opacity'];


            		$hex = preg_replace("/#/", "", $field['value']['hex']);
					$color = array();
 
					if(strlen($hex) == 3) {
						$color['r'] = hexdec(substr($hex, 0, 1) . $r);
						$color['g'] = hexdec(substr($hex, 1, 1) . $g);
						$color['b'] = hexdec(substr($hex, 2, 1) . $b);
					}
					else if(strlen($hex) == 6) {
						$color['r'] = hexdec(substr($hex, 0, 2));
						$color['g'] = hexdec(substr($hex, 2, 2));
						$color['b'] = hexdec(substr($hex, 4, 2));
					}
            	
            		$field['ext_value']['rgba']		= 'rgba(' . $color['r'] . ',' . $color['g'] . ',' . $color['b'] . ',' . $field['value']['opacity'] . ')';

            	}
            }
		
		// echo '<pre>';
		// 	print_r( $field);
		// echo '</pre>';
		
		
		if ($field['return_value']) {
			$hexname 	 =  $field['name'] . '[hex]';
			$opacityname =  $field['name'] . '[opacity]';
			$rgbatext	 = '';
			$readonly	 = 'readonly';
		} else {
			$hexname 	 =  '';
			$opacityname =  '';
			$rgbatext	 = $field['name'];
			$readonly	 = '';

		}
		

		
		
		echo '<div class="">';
			echo '	<div class="toping">
						<input name="' . $hexname . '" type="hidden" id="rgba" class="form-control rgba" data-inline="true" value="' . $field['ext_value']['he-op']['hex'] . '" data-opacity="' . $field['ext_value']['he-op']['opacity'] . '">
						<input name="' . $opacityname . '" type="hidden" class="opacity" value="' . $field['ext_value']['he-op']['opacity'] . '">
                		<input name="' . $rgbatext . '" ' . $readonly . ' value="' . $field['ext_value']['rgba'] . '" class="rgbatext">
                 		<input type="submit" value="Clear" class="clear">
                 	</div>';
		echo '</div>';



		
        echo "<script>
        	(function($){

        		var colpick = $('.rgba').each( function() {
    			$(this).minicolors({
    			  defaultValue: '#ff6167',
    			  inline: false,
    			  opacity: true,
    			  change: function(hex, opacity) {
    			    if(!hex) return;
    			    text = hex ? hex : 'transparent';
    			    if( opacity ) text += ', ' + opacity;
    				    text = jQuery(this).minicolors('rgbaString');
    				    $(this).closest('.toping').find('.rgbatext').val(text);
    				    $(this).closest('.toping').find('.opacity').val(opacity);
    				  },
    				});
				   });



// @jgraup:         Adding multiple methods for changing color and opacity with the keyboard.

                    // ~ Trigger with 'Enter' or 'Paste' from Clipboard into rgba textfield.
                    //
                    // + NUMBER will set opacity. ex: (0-1 or 1-100)
                    // + HEX will set color
                    // + RGBA(r,g,b,a) will set color and opacity
                    // + RGB(r,g,b) will set color, opacity is set to 1
                    //
                    // User value must be formatted;
                    //
                    // num:    .4
                    // num:    99
                    // hex:    #BADA55
                    // rgba:   rgba(0,111,222,.5) or (0,111,222,.5)
                    // rgb:    rgb(0,111,222) or (0,111,222)

                    parseUserInput = function(evt,el){
                        var val = el.val();
                        if(val === '' || val == undefined)
                            return; // no joy



                        if(val.indexOf('#')>-1){
                            // hex
                            el.closest('.toping').find('#rgba.rgba').minicolors('value', val);
                        } else if(val.indexOf('(')>-1){
                            // rgba / rgb
                            var _1 = val.indexOf('(')+1,
                                _2 = val.indexOf(')'),
                                str = val.slice (_1, _2),
                                vals = str.split(' ').join('').split(',');

                            if(vals.length < 3)
                                return; // no joy

                            // rgb acts like hex except alpha turns to 1
                            var a = vals.length == 4 ? vals[3] : 1,
                                // r = vals[0],
                                // g = vals[1],
                                // b = vals[2],
                                hex = '#' +
                                ('0' + parseInt(vals[0],10).toString(16)).slice(-2) +
                                ('0' + parseInt(vals[1],10).toString(16)).slice(-2) +
                                ('0' + parseInt(vals[2],10).toString(16)).slice(-2);

                            el.closest('.toping').find('#rgba.rgba').minicolors('value', hex);
                            el.closest('.toping').find('#rgba.rgba').minicolors('opacity', a);
                        }
                        else {
                            // opacity?
                            var float = parseFloat(val);
                            if(!isNaN(float)){
                                if(float<0){
                                    // less than 1? sorry.
                                    float = 0;
                                }
                                else if(float>1){
                                    // greater than 1, then assume 1-100
                                    float/=100;
                                }
                                if(float>1){
                                    // greater than 1... still? denied.
                                    float = 1;
                                }

                                el.closest('.toping').find('#rgba.rgba').minicolors('opacity', float);
                            }
                        }
                    }

                    // Clear (Clear Button)
                    $('.clear').each( function() {
    					$(this).bind('click', function(evt){
                    	    // don't submit the form just yet...
                    	    evt.preventDefault();

                    	    // swatch retains the color value temporarily,
                    	    // but let's make it look clear either way.
                    	    $(this).closest('.toping').find('#rgba.rgba').minicolors('opacity', '0');

                    	    // this is the data that is saved
                    	    $(this).closest('.toping').find('.rgbatext').val('');
                    	    $(this).closest('.toping').find('.opacity').val('');
                    	})
					});

                    // Enter (Keyboard Input)
					
                    $('.rgbatext').each( function() {
    					$(this).keypress(function(evt) {
                    	    // on 'Enter'
                    	    if(evt.which == 13) {
                    	    	var el = $(this);
                    	        evt.preventDefault();
                    	        parseUserInput(evt,el); // magic!
                    	    }
                    	})
                   	});

                    // Paste  (Keyboard Input)
                    $('.rgbatext').each( function() {
    					$(this).on('paste', function (evt) {
                        	// wait for the text after the event
                        	var el = $(this);
                        	setTimeout(function () {
                        	    parseUserInput(evt,el); // magic!
                        	}, 60);
						})
                    });


				})(jQuery);
        	  </script>";

	}
	
		
	/*
	*  input_admin_enqueue_scripts()
	*
	*  This action is called in the admin_enqueue_scripts action on the edit screen where your field is created.
	*  Use this action to add CSS + JavaScript to assist your render_field() action.
	*
	*  @type	action (admin_enqueue_scripts)
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	n/a
	*  @return	n/a
	*/

	
	
	function input_admin_enqueue_scripts() {
		
		$dir = plugin_dir_url( __FILE__ );
		
		
		// register & include JS
		wp_register_script( 'acf-input-rgba_minicolors', "{$dir}js/jquery.minicolors.min.js" );
		wp_enqueue_script('acf-input-rgba_minicolors');

		wp_register_script( 'acf-input-rgba_color', "{$dir}js/input.js" );
		wp_enqueue_script('acf-input-rgba_color');
		

		// register & include CSS
		wp_register_style( 'acf-input-rgba_color', "{$dir}css/input.css" ); 
		wp_enqueue_style('acf-input-rgba_color');
		
		wp_enqueue_media();
		
	}
	
	
	
	
	/*
	*  input_admin_head()
	*
	*  This action is called in the admin_head action on the edit screen where your field is created.
	*  Use this action to add CSS and JavaScript to assist your render_field() action.
	*
	*  @type	action (admin_head)
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	n/a
	*  @return	n/a
	*/

	/*
		
	function input_admin_head() {
	
		
		
	}
	
	*/
	
	
	/*
   	*  input_form_data()
   	*
   	*  This function is called once on the 'input' page between the head and footer
   	*  There are 2 situations where ACF did not load during the 'acf/input_admin_enqueue_scripts' and 
   	*  'acf/input_admin_head' actions because ACF did not know it was going to be used. These situations are
   	*  seen on comments / user edit forms on the front end. This function will always be called, and includes
   	*  $args that related to the current screen such as $args['post_id']
   	*
   	*  @type	function
   	*  @date	6/03/2014
   	*  @since	5.0.0
   	*
   	*  @param	$args (array)
   	*  @return	n/a
   	*/
   	
   	/*
   	
   	function input_form_data( $args ) {
	   	
		
	
   	}
   	
   	*/
	
	
	/*
	*  input_admin_footer()
	*
	*  This action is called in the admin_footer action on the edit screen where your field is created.
	*  Use this action to add CSS and JavaScript to assist your render_field() action.
	*
	*  @type	action (admin_footer)
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	n/a
	*  @return	n/a
	*/

	/*
		
	function input_admin_footer() {
	
		
		
	}
	
	*/
	
	
	/*
	*  field_group_admin_enqueue_scripts()
	*
	*  This action is called in the admin_enqueue_scripts action on the edit screen where your field is edited.
	*  Use this action to add CSS + JavaScript to assist your render_field_options() action.
	*
	*  @type	action (admin_enqueue_scripts)
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	n/a
	*  @return	n/a
	*/

	/*
	
	function field_group_admin_enqueue_scripts() {
		
	}
	
	*/

	
	/*
	*  field_group_admin_head()
	*
	*  This action is called in the admin_head action on the edit screen where your field is edited.
	*  Use this action to add CSS and JavaScript to assist your render_field_options() action.
	*
	*  @type	action (admin_head)
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	n/a
	*  @return	n/a
	*/

	/*
	
	function field_group_admin_head() {
	
	}
	
	*/


	/*
	*  load_value()
	*
	*  This filter is applied to the $value after it is loaded from the db
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value (mixed) the value found in the database
	*  @param	$post_id (mixed) the $post_id from which the value was loaded
	*  @param	$field (array) the field array holding all the field options
	*  @return	$value
	*/
	
	/*
	
	function load_value( $value, $post_id, $field ) {
		
		return $value;
		
	}
	
	*/
	
	
	/*
	*  update_value()
	*
	*  This filter is applied to the $value before it is saved in the db
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value (mixed) the value found in the database
	*  @param	$post_id (mixed) the $post_id from which the value was loaded
	*  @param	$field (array) the field array holding all the field options
	*  @return	$value
	*/
	
	/*
	
	function update_value( $value, $post_id, $field ) {
		
		return $value;
		
	}
	
	*/
	
	
	/*
	*  format_value()
	*
	*  This filter is appied to the $value after it is loaded from the db and before it is returned to the template
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value (mixed) the value which was loaded from the database
	*  @param	$post_id (mixed) the $post_id from which the value was loaded
	*  @param	$field (array) the field array holding all the field options
	*
	*  @return	$value (mixed) the modified value
	*/
		
	/*
	
	function format_value( $value, $post_id, $field ) {
		
		// bail early if no value
		if( empty($value) ) {
		
			return $value;
			
		}
		
		
		// apply setting
		if( $field['font_size'] > 12 ) { 
			
			// format the value
			// $value = 'something';
		
		}
		
		
		// return
		return $value;
	}
	
	*/
	
	
	/*
	*  validate_value()
	*
	*  This filter is used to perform validation on the value prior to saving.
	*  All values are validated regardless of the field's required setting. This allows you to validate and return
	*  messages to the user if the value is not correct
	*
	*  @type	filter
	*  @date	11/02/2014
	*  @since	5.0.0
	*
	*  @param	$valid (boolean) validation status based on the value and the field's required setting
	*  @param	$value (mixed) the $_POST value
	*  @param	$field (array) the field array holding all the field options
	*  @param	$input (string) the corresponding input name for $_POST value
	*  @return	$valid
	*/
	
	
	
	function validate_value( $valid, $value, $field, $input ){
		
			    if ($field['required']) {
	    
		    	$set = 0;
		    	$txt = __('The value is empty! : ','advanced-custom-fields-rgba-color');

		    	if ($field['return_value']) {
		    		if( empty($value['hex'])){
		    			$txt .= __('hex, ','advanced-custom-fields-rgba-color');
		    			$set = 1;
		    		}

		    		if( empty($value['opacity'])){
		    			$txt .= __('opacity, ','advanced-custom-fields-rgba-color');
		    			$set = 1;
		    		}

		    	} else {
		    		if( empty($value)){
		    			$txt .= __('rgba, ','advanced-custom-fields-rgba-color');
		    			$set = 1;
		    		}
		    	}
		    
		    	if ($set) {
		    		$valid = $txt;
		    	}
		    	
		}

	    return $valid;
		
	}
	
	
	
	
	/*
	*  delete_value()
	*
	*  This action is fired after a value has been deleted from the db.
	*  Please note that saving a blank value is treated as an update, not a delete
	*
	*  @type	action
	*  @date	6/03/2014
	*  @since	5.0.0
	*
	*  @param	$post_id (mixed) the $post_id from which the value was deleted
	*  @param	$key (string) the $meta_key which the value was deleted
	*  @return	n/a
	*/
	
	/*
	
	function delete_value( $post_id, $key ) {
		
		
		
	}
	
	*/
	
	
	/*
	*  load_field()
	*
	*  This filter is applied to the $field after it is loaded from the database
	*
	*  @type	filter
	*  @date	23/01/2013
	*  @since	3.6.0	
	*
	*  @param	$field (array) the field array holding all the field options
	*  @return	$field
	*/
	
	/*
	
	function load_field( $field ) {
		
		return $field;
		
	}	
	
	*/
	
	
	/*
	*  update_field()
	*
	*  This filter is applied to the $field before it is saved to the database
	*
	*  @type	filter
	*  @date	23/01/2013
	*  @since	3.6.0
	*
	*  @param	$field (array) the field array holding all the field options
	*  @return	$field
	*/
	
	/*
	
	function update_field( $field ) {
		
		return $field;
		
	}	
	
	*/
	
	
	/*
	*  delete_field()
	*
	*  This action is fired after a field is deleted from the database
	*
	*  @type	action
	*  @date	11/02/2014
	*  @since	5.0.0
	*
	*  @param	$field (array) the field array holding all the field options
	*  @return	n/a
	*/
	
	/*
	
	function delete_field( $field ) {
		
		
		
	}	
	
	*/
	
	
}

// create field
new acf_field_rgba_color();

?>
