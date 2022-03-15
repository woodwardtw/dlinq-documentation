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
        return "<div class='section'><h2 id='overview'>Overview</h2><div class='documentation'>{$overview}</div></div>";
    }
}

function dlinq_get_started(){
    if(get_field('get_started')){
        $overview = get_field('get_started');
        return "<div class='section'><h2 id='get_started'>Get Started</h2><div class='documentation'>{$overview}</div></div>";
    }
}

//INTERNAL PAGE NAV
function dlinq_documentation_nav(){
    $html = '';
    if(get_field('overview')){
        $html .= "<li><a href='#overview'>Overview</a></li>";
    }
    if(get_field('get_started')){
        $html .= "<li><a href='#get_started'>Get Started</a></li>";
    }
    if( have_rows('sections') ):

        // Loop through rows.
        while( have_rows('sections') ) : the_row();
            // Load sub field value.
            $html .= "<ul>";
            if(get_sub_field('section_title')){
                $title = get_sub_field('section_title');
                $id = sanitize_title($title);
                $page_url = get_permalink();
                $row = '-'.get_row_index();
                $title_nav = "<a href='{$page_url}#{$id}{$row}'>{$title}</a>";
                $html .= "<li>{$title_nav}</li>";
            }     
            $html .= "</ul>";
        endwhile;
        if(get_field('teaching_resources')){
            $html .= "<li><a href='#teaching-resources'>Teaching Resources</a></li>";
        }
        $html .= "<li><a href='{$page_url}#help'>Need help?</a></li>";
        if(get_field('related_internal_pages') || get_field('related_external_documents')){
                $html .= "<li><a href='#learn-more'>Learn More</a></li>";
            }
        return "<nav class='doc-nav' id='navbar-documentation'><button id='doc-btn-expand-collapse'  aria-controls='navbar-documentation' aria-expanded='true' aria-label='Hide or show the internal navigation.'>x</button><h2>On this page</h2><ul>{$html}</ul></nav>";
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
     if( have_rows('related_internal_pages') ):
        // Loop through rows.
        $html = '';
        while( have_rows('related_internal_pages') ) : the_row();       
           // Load sub field value.
            $title = get_sub_field('title');
            $link = get_sub_field('link');
            $html .= "<li><a href='{$link}'>{$title}</a></li>";
        endwhile;
        $internal = "<h3>Middlebury Resources</h3><ul>{$html}</ul>";
        $external = dlinq_external_pages();
        return "<div class='doc-nav'><h2 id='learn-more'>Learn More</h2>{$internal}{$external}</div>";
         else :
            // Do something...
        endif;
}

function dlinq_teaching(){
    $app_title = get_the_title();
    $html = '';
    if( have_rows('teaching_resources') ):

        // Loop through rows.
        while( have_rows('teaching_resources') ) : the_row();

            // Load sub field value.
            $title = get_sub_field('title');
            $link = get_sub_field('link');
            $html .= "<li><a href='{$link}'>{$title}</a></li>";
        endwhile;
        return "<h2 id='teaching-resources'>Teaching with {$app_title}</h2><ul>{$html}</ul>";
        // No value.
        else :
            // Do something...
        endif;
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

function dlinq_help_section(){
    $title = get_the_title();
    $page_url = get_permalink();
    $its_link = get_field('technical_support_link');
    $dlinq_link = get_field('pedagogical_support_link');
    $html = 
            "<div id='help' class='section important'>
                    <h2 id='header-help'>Need help?</h2><button class='direct-link' data-url='{$page_url}#help'>copy link</button>
                <p>For technical support for {$title}, <a href='https://support.gmhec.org/TDClient/47/middlebury/Shared/Search/?c=all&s={$title}'>search the ITS Knowledge Base</a> or <a href='{$its_link}'>submit a help ticket here</a>.</p>

                <p>For pedagogical support for {$title}, <a href='{$dlinq_link}'>schedule a consultation with a DLINQ team member</a>.</p>                

            </div>";
    return $html;
}

function dlinq_canvas_integration(){
    $canvas = get_field('canvas_integration');
    if($canvas == 'true'){
        $img = get_stylesheet_directory_uri(). '/imgs/checkbox.svg';
        return "<div class='canvas-integration'>
                <img src='{$img}' alt='This tool has Canvas integration.'>
                This tool is available in Canvas.
            </div>";
    }
}

function dlinq_extra_links(){
    $html = '';
    $privacy_img = get_stylesheet_directory_uri(). '/imgs/privacy.svg';
    $accessibility_img = get_stylesheet_directory_uri(). '/imgs/accessibility.svg';
    if(get_field('privacy_statement_link')){
        $privacy = get_field('privacy_statement_link');
        $html .= "<div class='privacy'><img src='{$privacy_img}' alt='Privacy icon.'><a href='{$privacy}' class='privacy-link'>Privacy Statement</a></div>";
    }
     if(get_field('accessibility_statement_link')){
        $accessibility = get_field('accessibility_statement_link');
        $html .= "<div class='accessibility'><img src='{$accessibility_img}' alt='Accessibility icon.'><a href='{$accessibility}' class='accessibility-link'>Accessibility Statement</a></div>";
        }
    return $html;
}


function dlinq_video_embed(){
    if(get_field('panopto_video_url')){
        $url = get_field('panopto_video_url');
        $url_components = parse_url($url);
        parse_str($url_components['query'], $params);
        $video_id = $params['id'];
        return "<div class='col-md-6'><div id='player' data-videoid='{$video_id}'></div></div>";
    }
   
}

function dlinq_video_buttons(){
    $html = '';
    if( have_rows('chapters') ):

        // Loop through rows.
        while( have_rows('chapters') ) : the_row();
            // Load sub field value.
            $title = get_sub_field('title');
            $time = get_sub_field('start_time');
            $row = get_row_index();
            $html .= "<button class='jump-button' data-jump='{$time}' data-row='{$row}'>{$title}</button>";
       // End loop.
        endwhile;
        return "<div class='col-md-2'>{$html}</div>";
        // No value.
        else :
            // Do something...
        endif;
}

function dlinq_video_playlists(){
    $html = '';
    if(get_field('playlists')){
        $html .= '<div class="video-links"><h2>Video Playlists</h2><ol>';
         $playlists = get_field('playlists');
        foreach($playlists as $list){
            $title = $list->post_title;
            $link = get_permalink($list->ID);
            $html .= "<li><a href='{$link}'>{$title}</a></li>";
        }
        return $html . '</ol></div>';
    }
   
}

function dlinq_video_resources(){
    $html = '';
    if( have_rows('chapters') ):

        // Loop through rows.
        while( have_rows('chapters') ) : the_row();
            // Load sub field value.
            $title = get_sub_field('title');
            $content = get_sub_field('details');
            $row = get_row_index();
            $html .= "<div class='video-content hide' id='video-content-{$row}'><h2>{$title}</h2>{$content}</div>";
       // End loop.
        endwhile;
        return "<div class='col-md-4'>{$html}</div>";
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