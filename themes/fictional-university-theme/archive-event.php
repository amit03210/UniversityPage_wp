<?php
get_header(); 
page_banner(array(
  'title' => get_the_archive_title(),
  'subtitle' => get_the_archive_description(),
));
?>

<div class="container container--narrow page-section">
  <?php
  while (have_posts()) {
    the_post();
    get_template_part('template_parts/customEvents');
    
  } 
     ?>
    <hr class="section-break">
    <p>Want to go to Past Event <a href="<?php echo site_url('./past-events')  ?>"> please click here...</a></p>
  <?php
  echo paginate_links();
 get_footer();
  ?>
