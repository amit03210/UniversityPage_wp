<?php 

add_action('rest_api_init', 'customRestCallback');

function customRestCallback(){
    register_rest_route('university/v2', 'talaash', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'doAction',
    ));
}

function doAction($data){
    $mainQuery = new WP_Query(array(
        'post_type' => array('event', 'post', 'pages', 'campus', 'program', 'professor'),
        's' => sanitize_text_field($data['keyword']),
    ));

    $results = array(
        'generalInfo' => array(),
        'events' => array(),
        'programs' => array(),
        'professors' => array(),
        'campuses' => array(),

    );

    while($mainQuery->have_posts()){
        $mainQuery->the_post();
    
        if(get_post_type() == "post" OR get_post_type() == "pages"){
            array_push($results['generalInfo'], array(
                'title' => get_the_title(),
                'url' => get_the_permalink(),
                'type' => get_post_type(),
                'author'=> get_the_author(),

            ));
        }

        if(get_post_type() == "event"){
            $eventDate = new DateTime( get_field('event_date'));
            $description = null;
            if(has_excerpt()){
                  $description =  get_the_excerpt();
              } else {
                  $description =  wp_trim_words(get_the_content(), 18);
              }
            array_push($results['events'], array(
                'title' => get_the_title(),
                'url' => get_the_permalink(),
                'month' => $eventDate->format('M'),
                'date' => $eventDate->format('d'),
                'description' => $description,
            ));
        }

        if(get_post_type() == "program"){
            $relatedCampus = get_field('related_campus');
            if($relatedCampus){
                foreach($relatedCampus as $campus){
                    array_push($results['campuses'], array(
                    'title' => get_the_title($campus),
                    'url' => get_the_permalink($campus),
                    ));
                }
            }


            array_push($results['programs'], array(
                'title' => get_the_title(),
                'url' => get_the_permalink(),
                'page_id' => get_the_ID(), // to pass it in relationship query
            ));
        }

        if(get_post_type() == "professor"){
            array_push($results['professors'], array(
                'title' => get_the_title(),
                'url' => get_the_permalink(),
                'image' => get_the_post_thumbnail_url(0, 'professorLandscape'),
            ));
        }

        if(get_post_type() == "campus"){
            array_push($results['campuses'], array(
                'title' => get_the_title(),
                'url' => get_the_permalink(),
            ));
        }
    }

    if($results['programs']){
$relationProfessorMetaQuery = array('relation' => 'OR');

    foreach($results['programs'] as $items){
        array_push($relationProfessorMetaQuery, array(
                'key' => 'related_programs',
                'compare' => 'LIKE',
                'value' => '"' . $items['page_id'] . '"',
        ));
    }

    //Pulling Query Instance again for adding relationship data
    $relatedProfessorswithProgram = new WP_Query(array(
        'post_type' => 'professor',
        'meta_query' => $relationProfessorMetaQuery,
    ));

    while($relatedProfessorswithProgram -> have_posts()){
        $relatedProfessorswithProgram-> the_post();

     if(get_post_type() == "professor"){
            array_push($results['professors'], array(
                'title' => get_the_title(),
                'url' => get_the_permalink(),
                'image' => get_the_post_thumbnail_url(0, 'professorLandscape'),
            ));
        }
        
    if(get_post_type() == "event"){
            $eventDate = new DateTime( get_field('event_date'));
            $description = null;
            if(has_excerpt()){
                  $description =  get_the_excerpt();
              } else {
                  $description =  wp_trim_words(get_the_content(), 18);
                }
            array_push($results['events'], array(
                'title' => get_the_title(),
                'url' => get_the_permalink(),
                'month' => $eventDate->format('M'),
                'date' => $eventDate->format('d'),
                'description' => $description,
            ));
        }
        
    }
    
    $results['events'] = array_unique($results['events'], SORT_REGULAR);
    $results['campuses'] = array_unique($results['campuses'], SORT_REGULAR);
    $results['professors'] = array_values(array_unique($results['professors'], SORT_REGULAR));
}
     
    return $results;
}

?>