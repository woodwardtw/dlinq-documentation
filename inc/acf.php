<?php
/**
 * UnderStrap ACF specific
 *
 * @package UnderStrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

function dlinq_app_overview(){
    if(get_field('overview')){
        $overview = get_field('overview');
        return "<h2>Overview</h2><div class='documentation'>{$overview}</div>";
    }
}

function dlinq_section_repeater(){
    $html = '';
    if( have_rows('sections') ):

        // Loop through rows.
        while( have_rows('sections') ) : the_row();

            // Load sub field value.
            if(get_sub_field('section_title')){
                $title = get_sub_field('section_title');
                $id = sanitize_title($title);
                $title_block = "<h2 id='{$id}'>{$title}</h2>";
            } else {
                $title_block = '';
            }
            $content = get_sub_field('section_content');
            $type = get_sub_field('callout_type');

            $html .= "<div class='section {$type}'>
                    {$title_block}
                    {$content}
            </div>";
            // Do something...
        // End loop.
        endwhile;
        return $html;
        // No value.
        else :
            // Do something...
        endif;
    }

function dlinq_documentation_nav(){
    $html = '';
    if( have_rows('sections') ):

        // Loop through rows.
        while( have_rows('sections') ) : the_row();
            // Load sub field value.
            if(get_sub_field('section_title')){
                $title = get_sub_field('section_title');
                $id = sanitize_title($title);
                $title_nav = "<a href='#{$id}'>{$title}</a>";
                $html .= "<li>{$title_nav}</li>";
            }     
        endwhile;
        if(get_field('related_internal_pages') || get_field('related_external_documents')){
                $html .= "<li><a href='#learn-more'>Learn More</a></li>";
            }
        return "<div class='doc-nav'><h2>On this page</h2><ul>{$html}</ul></div>";
        // No value.
        else :
            // Do something...
        endif;

}

function dlinq_internal_pages(){
    $html = '';
    if(get_field('related_internal_pages')){
        $pages = get_field('related_internal_pages');
        foreach ($pages as $key => $page) {
            // code...
            $url = get_post_permalink($page->ID);
            $title = $page->post_title;
            $html .= "<li><a href='{$url}'>{$title}</a></li>";
        }
        $external = dlinq_external_pages();
        return "<div class='doc-nav'><h2 id='learn-more'>Learn More</h2><h3>Middlebury Resources</h3><ul>{$html}</ul>{$external}</div>";
    }
}


function dlinq_external_pages(){
    $html = '';
    if( have_rows('related_external_documents') ):

        // Loop through rows.
        while( have_rows('related_external_documents') ) : the_row();

            // Load sub field value.
            $title = get_sub_field('title');
            $link = get_sub_field('link');
            $html .= "<li><a href='{$link}'>{$title}</a></li>";
        endwhile;
        return "<h3>External Resources</h3><ul>{$html}</ul>";
        // No value.
        else :
            // Do something...
        endif;
}




/** add additional classes / id to the facetwp-template div generated by a facetwp 
 ** layout template
 **/
add_filter( 'facetwp_shortcode_html', function( $output, $atts) {
    if ( $atts['template'] = 'example' ) { // replace 'example' with name of your template
    /** modify replacement as needed, make sure you keep the facetwp-template class **/
        $output = str_replace( 'class="facetwp-template"', 'class="facetwp-template row"', $output );
    }
    return $output; 
}, 10, 2 );


    //save acf json
        add_filter('acf/settings/save_json', 'acf_special_json_save_point');
         
        function acf_special_json_save_point( $path ) {
            
            // update path
            $path = get_stylesheet_directory() . '/acf-json'; //replace w get_stylesheet_directory() for theme
            
            
            // return
            return $path;
            
        }


        // load acf json
        add_filter('acf/settings/load_json', 'acf_special_json_load_point');

        function acf_special_json_load_point( $paths ) {
            
            // remove original path (optional)
            unset($paths[0]);
            
            
            // append path
            $paths[] = get_stylesheet_directory()  . '/acf-json';//replace w get_stylesheet_directory() for theme
            
            
            // return
            return $paths;
            
        }