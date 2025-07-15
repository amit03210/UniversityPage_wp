<?php
get_header(); 
page_banner(array(
  'title' => "Welcome to our Blog",
  'subtitle' => "Keep up with our latest news",
));
?>

<div class="container container--narrow page-section">
  <?php
  while (have_posts()) {
    the_post();
    ?>

    <div class="metabox metabox--position-up metabox--with-home-link">
    <p>
      <a class="metabox__blog-home-link" href="<?php  echo site_url("./blog") ?>"><i class="fa fa-home" aria-hidden="true"></i> Back Blog</a> <span class="metabox__main">Posted by <?php the_author_posts_link(); ?> on <?php the_time('m/Y g:i a') ?> </span>
    </p>
  </div>
  
    <div class="post-item">
      <h2 class="headline headline--medium headline--post-title"><a
          href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

      <div class="metabox">
        <p>Posted by <?php the_author_posts_link(); ?> on <?php the_time('m/Y g:i a') ?> in
          <?php echo get_the_category_list(', '); ?></p>
      </div>

      <div class="generic-content">
        <?php the_excerpt(); ?>
        <p class="btn btn--blue"><a href="<?php the_permalink() ?>" style="color:white; text-decoration:none;">continue
            reading &raquo; </a></p>
      </div>

    </div>
  <?php }
  echo paginate_links();
  get_footer();
  ?>
