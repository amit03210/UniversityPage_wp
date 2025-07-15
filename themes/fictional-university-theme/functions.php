<?php 
    function page_banner($args = NULL){
        if(!isset($args['title'])){
            $args['title'] = get_the_title();
        }

        if(!isset($args['subtitle'])){
            if(get_field('banner_image_subtitle')){
                $args['subtitle'] = get_field(selector: 'banner_image_subtitle');
            }else{
                $args['subtitle'] = "";
            }
        }

        if(!isset($args['photo'])){
            if(get_field('banner_image_background') AND !is_archive() AND !is_home()){
                $args['photo'] = get_field('banner_image_background')['sizes']['professorBanner'];
            }else{
                $args['photo'] = get_theme_file_uri('./images/ocean.jpg');
            }
        }

?>
<div class="page-banner">
      <div class="page-banner__bg-image" style="background-image: url(<?php 
        $professorbannerImage = get_field('banner_image_background');
        echo $args['photo'];
        ?>)"></div>
      <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title"><?php echo $args['title'] ?></h1>
        <div class="page-banner__intro">
          <p><?php echo $args['subtitle']; ?></p>
        </div>
      </div>
    </div>

<?php
    }
function my_files() {
    wp_enqueue_style('university_main_styles', get_theme_file_uri('./build/style-index.css'));
    wp_enqueue_style('university_extra_styles', get_theme_file_uri('./build/index.css'));
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('google-font', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_script('main-univiersity', get_theme_file_uri('./build/index.js'), array('jquery'), '1.0', true);
}

function university_features() {
    // register_nav_menu('headerMenuLocation', "Header Menu Location");
    // register_nav_menu('footerMenuLocation_1', "Footer Menu Location 1");
    // register_nav_menu('footerMenuLocation_2', "Footer Menu Location 2");
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_image_size('professorLandscape', 400, 250, true);
    add_image_size('professorPortrait', 400, 650, true);
    add_image_size('professorBanner', 1500, 150, true);
    
}

function modifying_default_queries($query){
    $today = date(format: 'Ymd');
    if(!is_admin() AND is_post_type_archive('event') AND $query->is_main_query()){
        $query->set('posts_per_page', '2');
        $query->set('order', 'ASC');
        $query->set('meta_key', 'event_date');
        $query->set('orderby', 'meta_value_num');
        $query->set('meta_query', array(
                array(
                  'key' => 'event_date',
                  'compare' => '>=',
                  'value' => $today,
                  'type' => 'NUMERIC',
                )
        ));
    }

    if(!is_admin() AND is_post_type_archive('program') AND $query->is_main_query()){
        $query->set('posts_per_page', '-1');
        $query->set('orderby', 'title');
        $query->set('order', 'ASC');
    }

}

add_action('wp_enqueue_scripts', 'my_files');
add_action('after_setup_theme', 'university_features');
add_action('pre_get_posts', 'modifying_default_queries');
?>