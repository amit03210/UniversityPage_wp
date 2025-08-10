<?php 

require get_theme_file_path('./inc/customREST.php');

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
    wp_enqueue_script('googleMaps', '//maps.googleapis.com/maps/api/js?key=AIzaSyA-UMBNQswwBjDPHfYF9Zo8IH4eeHC6nHI', NULL, 1.0, true);
    wp_enqueue_script('main-university', get_theme_file_uri('./build/index.js'), NULL , '1.0', true);
    wp_enqueue_style('university_main_styles', get_theme_file_uri('./build/style-index.css'));
    wp_enqueue_style('university_extra_styles', get_theme_file_uri('./build/index.css'));
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('google-font', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');

    wp_localize_script('main-university', 'universityData', array(
            'root_url' => site_url(),
            'nonce' => wp_create_nonce('wp_rest'), //for authentication proof of logged user to modify data
    ));
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

    if(!is_admin() AND is_post_type_archive('campus') AND $query->is_main_query()){
        $query->set('posts_per_page', '-1');
    }

}

function universityMapKey($api){
    $api['key'] = "AIzaSyA-UMBNQswwBjDPHfYF9Zo8IH4eeHC6nHI";
    return $api;
}

function modifyingREST_API(){
    register_rest_field('post', 'authorName', array(
        'get_callback' => function () {
            return get_the_author();
        },
    ));
}


add_action('wp_enqueue_scripts', 'my_files');
add_action('after_setup_theme', 'university_features');
add_action('pre_get_posts', 'modifying_default_queries');
add_filter('acf/fields/google_map/api', 'universityMapKey');
add_action('rest_api_init', 'modifyingREST_API');


//-----------------------------------Login Screen---------------------------------------
//redirecting user to homepage and restrict them redirect to dashboard.
add_action('admin_init', 'restrictUserFromDashboard');

function restrictUserFromDashboard(){
    $currentUser    = wp_get_current_user();
    // echo '<pre>';
    // print_r($currentUser);
    // echo '</pre>';
    if(count($currentUser->roles) == 1 AND $currentUser->roles[0] == 'subscriber'){
        wp_redirect(esc_url(site_url("/")));
        exit;
    }
}

add_action('wp_loaded', 'hideAdminBarForSubscriber');

function hideAdminBarForSubscriber(){
    $currentUser    = wp_get_current_user();
    // echo '<pre>';
    // print_r($currentUser);
    // echo '</pre>';
    if(count($currentUser->roles) == 1 AND $currentUser->roles[0] == 'subscriber'){
        show_admin_bar(false);
    }
}

//styling Login screen
add_action('login_enqueue_scripts', 'styleLoginScreen');

function styleLoginScreen(){
    wp_enqueue_style('university_main_styles', get_theme_file_uri('./build/style-index.css'));
    wp_enqueue_style('university_extra_styles', get_theme_file_uri('./build/index.css'));
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('google-font', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');

}

//changing login screen text
add_action('login_headertext', 'changeLoginScreenTitle');

function changeLoginScreenTitle(){
    return get_bloginfo('name');
}

//changing login brand url
add_action('login_headerurl', 'changeLoginBrandURL');

function changeLoginBrandURL(){
    return site_url('/');
}

?>