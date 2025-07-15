<?php
get_header(); 
page_banner(array(
  'title' => get_the_archive_title(),
  'subtitle' => get_the_archive_description(),
));
?>

<div class="container container--narrow page-section">
<ul class="link-list min-list">
  <?php
  while (have_posts()) {
    the_post();
    ?>
    <li><a href="<?php echo get_the_permalink() ?>"><?php the_title();?></a> </li>
    <?php
    } ?>
  </ul>
  <?php
  echo paginate_links();
    get_footer();
  ?>
