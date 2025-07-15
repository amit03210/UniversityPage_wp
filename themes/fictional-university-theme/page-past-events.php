<?php
get_header(); ?>

<div class="page-banner">
  <div class="page-banner__bg-image"
    style="background-image: url(<?php echo get_theme_file_uri('images/ocean.jpg') ?>)"></div>
  <div class="page-banner__content container container--narrow">
    <h1 class="page-banner__title">Past Events</h1>
    <div class="page-banner__intro">
      <p>Bootkaal...</p>
    </div>
  </div>
</div>

<div class="container container--narrow page-section">
  <?php
            $today = date('Ymd');
            $pastEvent = new WP_Query(array(
                 'paged' => get_query_var('paged', 1), //which page query should be on and make it dynamic
                'post_type' => 'event',
                'meta_key' => 'event_date',
                'orderby' => 'meta_value_num',
                'order' => 'ASC',
                'meta_query' => array(
                  'key' => 'event_date',
                  'compare' => '<',
                  'value' => $today,
                ),
    
            ));

            while($pastEvent->have_posts()){
              $pastEvent->the_post();
              get_template_part('template_parts/customEvents');
            }
  echo paginate_links(array(
    'total' => $pastEvent->max_num_pages,       //Calculate total number of pages based on posts_per page. (total no. post/posts_per_page)
  ));
 get_footer();
  ?>
