<?php
/**
 * UnderStrap ACF specific
 *
 * @package UnderStrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


//OVERVIEW
function dlinq_app_overview(){
    if(get_field('overview')){
        $overview = get_field('overview');
        return "<h2>Overview</h2><div class='documentation'>{$overview}</div>";
    }
}

//INTERNAL PAGE NAV
function dlinq_documentation_nav(){
    $html = '';
    if( have_rows('sections') ):

        // Loop through rows.
        while( have_rows('sections') ) : the_row();
            // Load sub field value.
            if(get_sub_field('section_title')){
                $title = get_sub_field('section_title');
                $id = sanitize_title($title);
                $page_url = get_permalink();
                $row = '-'.get_row_index();
                $title_nav = "<a href='{$page_url}#{$id}{$row}'>{$title}</a>";
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


function dlinq_section_repeater(){
    $html = '';
    if( have_rows('sections') ):

        // Loop through rows.
        while( have_rows('sections') ) : the_row();

            // Load sub field value.
            $row = '-'.get_row_index();
            if(get_sub_field('section_title')){
                $title = get_sub_field('section_title');
                $id = sanitize_title($title);
                $page_url = get_permalink();
                $title_block = "<h2 id='header-{$id}'>{$title}</h2><button class='direct-link' data-url='{$page_url}#{$id}{$row}'>copy link</button>";
            } else {
                $title_block = '';
            }
            $content = get_sub_field('section_content');
            $type = get_sub_field('callout_type');
            $html .= "<div id='{$id}{$row}' class='section {$type}'>
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
    }
    if (have_rows('related_internal_pages') || have_rows('related_external_documents')){
        $internal = "<h3>Middlebury Resources</h3><ul>{$html}</ul>";
        $external = dlinq_external_pages();
        return "<div class='doc-nav'><h2 id='learn-more'>Learn More</h2>{$internal}{$external}</div>";
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

function dlinq_highlight_repeater(){
    $html = '';
    if( have_rows('highlight') ):

        // Loop through rows.
        while( have_rows('highlight') ) : the_row();

            // Load sub field value.
            $title = get_sub_field('title');
            $link = get_sub_field('link');
            $description = get_sub_field('description');
            $html .= "<div class='col-md-4'>
                            <div class='card h-100'>
                             <h2>{$title}</h2>
                                 <div class='highlight-desc card-body'>{$description}</div>
                                 <div class='card-footer'>
                                    <a class='btn btn-primary' href='{$link}' aria-label='Learn more about {$title}.'>Learn More</a>
                                </div>
                            </div>
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

function dlinq_article_subpages(){
    global $post;
    if(get_post_type() == 'article'){
        $html = '';
        $args = array(
        'posts_per_page' => -1,
        'order'          => 'DESC',
        'post_parent'    => $post->ID,
        'post_type'      => 'article'
        );
     
        $doc_children = get_children( $args); 
        //var_dump($doc_children);
        if($doc_children){
            $html = '<div class="article-links"><h2>Dig Deeper</h2><ol>';
            foreach ($doc_children as $key => $child) {
                // code...
                $title = $child->post_title;
                $link = get_permalink($child->ID);
                $html .= "<li><a href='{$link}'>{$title}</a></li>";
            }
            return $html.'</ol></div>';
        }
    }
    
}

function dlinq_acf_search(){
    global $post;
    if($post->post_type == 'article'){
        return 'article';
    } else {
        return 'not';
    }
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