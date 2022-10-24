/* Customizer JS Upsale*/
( function( api ) {

	api.sectionConstructor['upsell'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );


jQuery(document).ready(function($){

    // Color Scheme
    $( '#customize-control-bloglog_color_schema .color-scheme-picker input' ).on( 'change', function() {

        if ( $( this ).is( ':checked' ) ) {

            var currentColor = this.value;

            var data = {
                'action': 'bloglog_color_schema_color',
                'currentColor': currentColor,
            };
     
            $.post( ajaxurl, data, function(response) {

                if( response ){

                    //Get the list of settings to update, and their colors
                    var colors = JSON.parse( response );

                    // Loop over them
                    for ( var color in colors ) {
                        if ( ! colors.hasOwnProperty( color ) ) {
                            continue;
                        }

                        var colorName = color,
                            colorValue = colors[color];

                        // Update the color settings
                        wp.customize( colorName, function( colorSetting ) {
                            colorSetting.set( colorValue );
                        } );

                    }

                }

            });

        }

    } );


    // Tygoraphy
	$('#_customize-input-bloglog_heading_font').change(function(){

		var currentfont = this.value;

		var data = {
            'action': 'bloglog_customizer_font_weight',
            'currentfont': currentfont,
            '_wpnonce': bloglog_customizer.ajax_nonce,
        };
 
        $.post( ajaxurl, data, function(response) {

            if( response ){

                $('#_customize-input-bloglog_heading_weight').empty();
                $('#_customize-input-bloglog_heading_weight').html(response);

            }

        });

	});	

    $('.radio-image-buttenset').each(function(){
        
        id = $(this).attr('id');
        $( '[id='+id+']' ).buttonset();
    });
    
});