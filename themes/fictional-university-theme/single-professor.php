<?php
get_header();

while(have_posts()) {
    the_post(); 
    page_banner();
    ?>
        <div class="container container--narrow page-section">
        <div class="generic-content">
          <div class="row group">
            <div class="one-third">
                <?php the_post_thumbnail('professorPortrait'); ?>
            </div>
            <div class="two-third">
                <?php the_content(); ?>
            </div>
          </div>
        </div> 
        <?php 
        $relatedPrograms = get_field('related_programs');
        if($relatedPrograms){
        echo '&nbsp; <h3> Programs teach </h3>';
        echo '<hr>';
        echo '<ul class="link-list min-list">';
          foreach($relatedPrograms as $program){ ?>
            <li><a href="<?php the_permalink($program) ?>"><?php echo get_the_title($program); ?> </a></li>
            
          <?php
          }
        echo '</ul>';
        }
          ?>
    </div>
    
<?php
} 

get_footer();
?>

