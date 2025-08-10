<?php
get_header();

while(have_posts()) {
    the_post(); 
    page_banner();
    ?>

    <div class="container container--narrow page-section">

        <div class="metabox metabox--position-up metabox--with-home-link">
            <p>
                <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('campus') ?>"><i class="fa fa-home" aria-hidden="true"></i> All Campus</a>
                
          <?php echo get_the_category_list(', '); ?></span>
            </p>
        </div>

        <div class="generic-content"><?php the_content() ?></div>
        <div class="acf-map">
        <?php
            $mapLocation = get_field('campus_map');
            ?>
            <div class="marker" data-lat="<?php echo $mapLocation['lat'];?>" data-lng="<?php echo $mapLocation['lng'];?>">
            <h2><?php echo get_the_title();?></h2>
            <p><?php echo $mapLocation['address'];?></p>
            </div>
        </div>
            

        <?php 
            $relatedProgram = new WP_Query(array(
                'post_type' => 'program',
                'posts_per_page' => '-1',
                'order' => 'ASC',
                'orderby' => 'title',
                'meta_query' => array(
                    array(
                        'key' => 'related_campus',
                        'compare' => 'LIKE',
                        'value' => "". get_the_ID() . "",
                    )
                )
            ));

            if($relatedProgram->have_posts()){ ?>
            <hr class="section-break">
            <h2>Programs teaches into <?php the_title();?> Campus:</h2>
            <ul class="link-list min-list">
<?php
                while($relatedProgram->have_posts()){
                    $relatedProgram->the_post(); ?>
                    <li><a href="<?php echo get_the_permalink() ?>"><?php echo get_the_title() ?></a></li>

<?php
                }
                wp_reset_postdata();
            }
        ?>
        </ul>
        </div>
<?php
}

get_footer();
?>

