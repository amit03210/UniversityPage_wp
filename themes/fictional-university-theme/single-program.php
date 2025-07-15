<?php
get_header();

while(have_posts()) {
    the_post(); 
    page_banner();
    ?>

    <div class="container container--narrow page-section">
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p>
                <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('program') ?>"><i class="fa fa-home" aria-hidden="true"></i> All Programs</a>
            </p>
        </div>

        <div class="generic-content"><?php the_content() ?></div>
        &nbsp;
        <hr> 
        <?php 
            $today = date('Ymd');
            $relatedEvents = new WP_Query(query: array(
                'post_type' => 'event',
                'meta_key' => 'event_date',
                'orderby' => 'meta_value_num',
                'order' => 'ASC',
                'meta_query' => array(
                    array(
                  'key' => 'event_date',
                  'compare' => '<',
                  'value' => $today,
                ),
                 array(
                  'key' => 'related_programs',
                  'compare' => 'LIKE',
                  'value' => '"' . get_the_ID() . '"',
                ),
            ),
        ));
        $relatedProfessor = new WP_Query( array(
          'post_type' => 'professor',
          'orderby' => 'title',
          'order' => 'ASC',
          'meta_query' => array(
            array(
              'key' => 'related_programs',
              'compare' => 'LIKE',
              'value' => '"' . get_the_ID() . '"',
            ),
          ),
        ));

         if($relatedProfessor->have_posts()){
                echo "&nbsp;<h3>" . get_the_title() . ' Professor </h3>';
                echo "<ul class='professor-cards' style='list-style:none'>";
                while($relatedProfessor->have_posts()){
                  $relatedProfessor->the_post(); ?>
                  <li><a class="professor-card" href="<?php the_permalink()?>">
                    <img src="<?php echo get_the_post_thumbnail_url(null, 'professorLandscape'); ?>" alt="" class="professor-card__image">
                    <span class="professor-card__name"><?php the_title(); ?></span>
                  </a></li>
                <?php
                }
                echo "</ul>";
            } 
            echo "<hr> &nbsp;";
            wp_reset_postdata();
            if($relatedEvents->have_posts()){
                echo "<h3> Upcoming " . get_the_title() . " Events: </h3>";
                while($relatedEvents->have_posts()){
                  $relatedEvents->the_post();
                  get_template_part('template_parts/customEvents');

                }
                
            } 

           
        ?>

    </div>
<?php
}

get_footer();
?>

