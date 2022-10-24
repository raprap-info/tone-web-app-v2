<?php
/**
* Customizer Custom Classes.
*
* @package Bloglog
*/


/** Customizer Custom Control **/
if ( class_exists( 'WP_Customize_Control' ) ) {
    
    // Radio Image Custom Control Class.
    class Bloglog_Custom_Radio_Image_Control extends WP_Customize_Control {

        public $type = 'radio-image';
    
        public function render_content() {
           
            if ( empty( $this->choices ) ) {
                return;
            }           
            
            $name = '_customize-radio-' . $this->id; ?>
            
            <span class="customize-control-title">
                <?php echo esc_attr( $this->label ); ?>
                <?php if ( ! empty( $this->description ) ) : ?>
                    <span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
                <?php endif; ?>
            </span>
            
            <div id="input_<?php echo esc_attr($this->id); ?>" class="image radio-image-buttenset">
                <?php foreach ( $this->choices as $value => $label ) : ?>
                    <input class="image-select" type="radio" value="<?php echo esc_attr( $value ); ?>" id="<?php echo esc_attr($this->id) . esc_attr($value); ?>" name="<?php echo esc_attr( $name ); ?>" <?php $this->link(); checked( $this->value(), $value ); ?>>
                        <label for="<?php echo esc_attr($this->id) . esc_attr($value); ?>">
                            <img src="<?php echo esc_html( $label ); ?>" alt="<?php echo esc_attr( $value ); ?>" title="<?php echo esc_attr( $value ); ?>">
                        </label>
                    </input>
                <?php endforeach; ?>
            </div>
            
        <?php }
    }
    
}

// Radio COlor Schema
class Bloglog_Custom_Radio_Color_Schema extends WP_Customize_Control {

    public $type = 'color-scheme';

    public function render_content() {
       
        if ( empty( $this->choices ) ) {
            return;
        }           
        
        $name = '_customize-radio-' . $this->id; ?>
        
        <span class="customize-control-title">
            <?php echo esc_attr( $this->label ); ?>
            <?php if ( ! empty( $this->description ) ) : ?>
                <span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
            <?php endif; ?>
        </span>
        
        <div id="input_<?php echo esc_attr($this->id); ?>" class="color-scheme-picker image radio-image-buttenset">
            <?php foreach ( $this->choices as $value => $fields ) : ?>

                <input class="image-select" type="radio" value="<?php echo esc_attr( $value ); ?>" id="<?php echo esc_attr($this->id) . esc_attr($value); ?>" name="<?php echo esc_attr( $name ); ?>" <?php $this->link(); checked( $this->value(), $value ); ?>>

                    <label for="<?php echo esc_attr($this->id) . esc_attr($value); ?>" class="color-scheme-label">
                        
                        <?php
                        echo '<div class="color-scheme-panel">';
                        foreach( $fields['color'] as $color){
                            echo '<div class="color-scheme-stripe" style="background:'.esc_attr($color).'"></div>';
                        }
                        echo '</div>';
                        echo '<div class="color-scheme-title" >'.esc_html( $fields['title'] ).'</div>'; ?>
                        
                    </label>
                </input>

            <?php endforeach; ?>
        </div>
        
    <?php }
}

/**
 * Upsell customizer section.
 *
 * @since  1.0.0
 * @access public
 */
class Bloglog_Customize_Section_Upsell extends WP_Customize_Section {

    /**
     * The type of customize section being rendered.
     *
     * @since  1.0.0
     * @access public
     * @var    string
     */
    public $type = 'upsell';

    /**
     * Custom button text to output.
     *
     * @since  1.0.0
     * @access public
     * @var    string
     */
    public $pro_text = '';

    /**
     * Custom pro button URL.
     *
     * @since  1.0.0
     * @access public
     * @var    string
     */
    public $pro_url = '';

    public $notice = '';
    public $nonotice = '';

    /**
     * Add custom parameters to pass to the JS via JSON.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function json() {
        $json = parent::json();

        $json['pro_text'] = $this->pro_text;
        $json['pro_url']  = esc_url( $this->pro_url );
        $json['notice']  = esc_attr( $this->notice );
        $json['nonotice']  = esc_attr( $this->nonotice );

        return $json;
    }

    /**
     * Outputs the Underscore.js template.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    protected function render_template() { ?>

        <li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }} cannot-expand">

                <# if ( data.notice ) { #>
                    <h3 class="accordion-section-notice">
                        {{ data.title }}
                    </h3>
                <# } #>

                <# if ( !data.notice ) { #>
                    <h3 class="accordion-section-title">
                        {{ data.title }}

                        <# if ( data.pro_text && data.pro_url ) { #>
                            <a href="{{ data.pro_url }}" class="button button-secondary alignright" target="_blank">{{ data.pro_text }}</a>
                        <# } #>
                    </h3>
                <# } #>
            
        </li>
    <?php }
}

if ( class_exists( 'WP_Customize_Control' ) ) {
    
    // Repeator Info
    class Bloglog_Premium_Notiece_Control extends WP_Customize_Control {

        public $type = 'bloglog-premiuminfonotice';
    
        public function render_content() {
           
            $name = '_customize-notice-' . $this->id; ?>
            
            <span class="customize-control-title">
                <div class="theme-info-icon">
                    <div class="icon-notice-wrap">
                        <span class="dashicons dashicons-lightbulb twp-filter-icon"></span>
                        <span><?php echo esc_html__('More ','bloglog'). esc_html( $this->label ). esc_html__(' Available on Premium Version.', 'bloglog' ); ?></span>
                    </div>
                </div>
            </span>
            
        <?php }
    }
    
}

/**
 * Repeater Custom Control
*/
class Bloglog_Repeater_Controler extends WP_Customize_Control {
    /**
     * The control type.
     *
     * @access public
     * @var string
    */
    public $type = 'repeater';

    public $bloglog_box_label = '';

    public $bloglog_box_add_control = '';

    public $bloglog_box_add_button = '';

    private $cats = '';

    /**
     * The fields that each container row will contain.
     *
     * @access public
     * @var array
     */
    public $fields = array();

    /**
     * Repeater drag and drop controler
     *
     * @since  1.0.0
     */
    public function __construct( $manager, $id, $args = array(), $fields = array() ) {
        $this->fields = $fields;
        $this->bloglog_box_label = $args['bloglog_box_label'] ;
        $this->bloglog_box_add_control = $args['bloglog_box_add_control'];
        $this->bloglog_box_add_button = $args['bloglog_box_add_button'];
        $this->cats = get_categories(array( 'hide_empty' => false ));
        parent::__construct( $manager, $id, $args );
    }

    public function render_content() {

        $values = json_decode($this->value());
        ?>
        <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>

        <?php if($this->description){ ?>
            <span class="description customize-control-description">
            <?php echo wp_kses_post($this->description); ?>
            </span>
        <?php } ?>

        <ul class="bloglog-repeater-field-control-wrap">
            <?php
            $this->bloglog_get_fields();
            ?>
        </ul>
        <input type="hidden" <?php esc_attr( $this->link() ); ?> class="bloglog-repeater-collector" value="<?php echo esc_attr( $this->value() ); ?>" />
        <?php

        if( isset( $this->bloglog_box_add_button ) && $this->bloglog_box_add_button ){ ?>
            
            <button type="button" class="button bloglog-add-control-field"><?php echo esc_html( $this->bloglog_box_add_control ); ?></button>
        <?php
        }

    }

    private function ToObject($Array) { 
      
        // Create new stdClass object 
        $object = new stdClass(); 
          
        // Use loop to convert array into 
        // stdClass object 
        foreach ($Array as $key => $value) { 
            if (is_array($value)) { 
                $value = $this->ToObject($value); 
            } 
            $object->$key = $value; 
        } 
        return $object; 
    } 

    private function bloglog_get_fields(){

        $fields = $this->fields;

        $values = json_decode( $this->value() );

        if( is_array( $values ) ){
        foreach($values as $value){
        ?>
        <li class="bloglog-repeater-field-control">

        <div class="title-rep-wrap">
            <span class="dashicons dashicons-move twp-filter-icon"></span>
            <h3 class="bloglog-repeater-field-title"><?php echo esc_html( $this->bloglog_box_label ); ?></h3>
            <span class="dashicons dashicons-arrow-down twp-filter-icon"></span>
        </div>

        <div class="bloglog-repeater-fields">
        <?php
            foreach ($fields as $key => $field) {
            $class = isset($field['class']) ? $field['class'] : '';
            ?>
            <div class="bloglog-fields bloglog-type-<?php echo esc_attr($field['type']).' '.esc_attr( $class ); ?>">
                <?php 
                    $label = isset($field['label']) ? $field['label'] : '';
                    $description = isset($field['description']) ? $field['description'] : '';
                    if($field['type'] != 'checkbox'){ ?>
                        <span class="customize-control-title"><?php echo esc_html( $label ); ?></span>
                        <span class="description customize-control-description"><?php echo esc_html( $description ); ?></span>
                    <?php 
                    }

                    $new_value = isset($value->$key) ? $value->$key : '';
                    $default = isset($field['default']) ? $field['default'] : '';

                    switch ($field['type']) {
                        case 'text':
                            echo '<input data-default="'.esc_attr($default).'" data-name="'.esc_attr($key).'" type="text" value="'.esc_attr($new_value).'"/>';
                            break;

                        case 'link':
                            echo '<input data-default="'.esc_attr($default).'" data-name="'.esc_attr($key).'" type="text" value="'.esc_url($new_value).'"/>';
                            break;

                        case 'textarea':
                            echo '<textarea data-default="'.esc_attr($default).'"  data-name="'.esc_attr($key).'">'.esc_html( $new_value ).'</textarea>';
                            break;

                        case 'select':
                            $options = $field['options'];
                            echo '<select  data-default="'.esc_attr($default).'"  data-name="'.esc_attr($key).'">';
                                foreach ( $options as $option => $val )
                                {
                                    printf('<option value="%s" %s>%s</option>', esc_attr($option), selected($new_value, $option, false), esc_html($val));
                                }
                            echo '</select>';
                            break;

                        case 'checkbox':
                            echo '<label>';
                            echo '<input data-default="'.esc_attr($default).'" value="'.esc_attr( $new_value ).'" data-name="'.esc_attr($key).'" type="checkbox" '.checked($new_value, 'yes', false).'/>';
                            echo esc_html( $label );
                            echo '<span class="description customize-control-description">'.esc_html( $description ).'</span>';
                            echo '</label>';
                            break;

                        case 'selector_color':
                        $options = $field['options'];
                            echo '<div class="bloglog-type-radio">';
                            echo '<div class="radio-labels">';
                            foreach ( $options as $option => $val ){

                                $class_active = '';
                                $checked = '';
                                if( $new_value == '' ){
                                    $new_value = $default;
                                }
                                if( $new_value == $option  ){
                                    $class_active = 'radio-active';
                                    $checked = 'checked';
                                }

                                echo '<label class="bg-color-label '.esc_attr( $class_active ).'">';
                                echo '<input name="'.esc_attr($key).'" value="'.esc_attr($option).'" type="radio" '.esc_attr( $checked ).'/>';
                                ?>
                                <div class="color-scheme-panel"><div class="color-scheme-stripe" style="background:  <?php echo esc_attr(  $val['color'] ) ?>"></div></div>
                                <?php
                                 echo '<div class="color-ribbon-title" >'.esc_html( $val['title'] ).'</div>';
                                echo '</label>'; 
                            }
                            echo '</div>';
                            echo '<input data-default="'.esc_attr($default).'" type="hidden" value="'.esc_attr($new_value).'" data-name="'.esc_attr($key).'"/>';
                            echo '</div>';
                        break;

                        case 'seperator':
                            echo '<span class="seperator-control-title">'.esc_html( $field['seperator_text'] ).'</span>';
                            break;

                        case 'colorpicker':
                            echo '<input data-default="'.esc_attr($default).'" class="customizer-color-picker" data-alpha="true" data-name="'.esc_attr($key).'" type="text" value="'.esc_attr($new_value).'"/>';
                            break;

                        case 'upload':
                                $image = $image_class= "";
                                if($new_value){ 
                                    $image = '<img src="'.esc_url($new_value).'" style="max-width:100%;"/>';    
                                    $image_class = ' hidden';
                                }
                                echo '<div class="theme-attachment-panel">';
                                echo '<div class="theme-attachment-media">';
                                echo '<div class="placeholder'.esc_attr( $image_class ).'">';
                                esc_html_e('No image selected', 'bloglog');
                                echo '</div>';
                                echo '<div class="thumbnail thumbnail-image">';
                                echo $image;
                                echo '</div>';
                                echo '<div class="actions clearfix">';
                                echo '<button type="button" class="button theme-image-delete align-left">'.esc_html__('Remove', 'bloglog').'</button>';
                                echo '<button type="button" class="button theme-custom-upload-button alignright">'.esc_html__('Select Image', 'bloglog').'</button>';
                                echo '<input data-default="'.esc_attr($default).'" class="upload-id" data-name="'.esc_attr($key).'" type="hidden" value="'.esc_attr($new_value).'"/>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                break;

                        default:
                            break;
                    }
                ?>
            </div>
            <?php
            } ?>

            <div class="clearfix bloglog-repeater-footer">
                <div class="alignright">
                <?php if( isset( $this->bloglog_box_add_button ) && $this->bloglog_box_add_button ){ ?>
                    <a class="bloglog-repeater-field-remove" href="#remove"><?php esc_html_e('Delete', 'bloglog') ?>|</a> 
                <?php } ?>
                <a class="bloglog-repeater-field-close" href="#close"><?php esc_html_e('Close', 'bloglog') ?></a>
                </div>
            </div>
        </div>
        </li>
        <?php   
        }
        }
    }

}


if ( ! function_exists( 'bloglog_sanitize_number_range' ) ) :

    /**
     * Sanitize number range.
     *
     * @since 1.0.0
     *
     * @see absint() https://developer.wordpress.org/reference/functions/absint/
     *
     * @param int                  $input Number to check within the numeric range defined by the setting.
     * @param WP_Customize_Setting $setting WP_Customize_Setting instance.
     * @return int|string The number, if it is zero or greater and falls within the defined range; otherwise, the setting default.
     */
    function bloglog_sanitize_number_range( $input, $setting ) {

        // Ensure input is an absolute integer.
        $input = absint( $input );

        // Get the input attributes associated with the setting.
        $atts = $setting->manager->get_control( $setting->id )->input_attrs;

        // Get min.
        $min = ( isset( $atts['min'] ) ? $atts['min'] : $input );

        // Get max.
        $max = ( isset( $atts['max'] ) ? $atts['max'] : $input );

        // Get Step.
        $step = ( isset( $atts['step'] ) ? $atts['step'] : 1 );

        // If the input is within the valid range, return it; otherwise, return the default.
        return ( $min <= $input && $input <= $max && is_int( $input / $step ) ? $input : $setting->default );

    }

endif;

