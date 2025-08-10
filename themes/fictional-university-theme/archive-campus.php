<?php
get_header(); 
page_banner(array(
  'title' => "Our Campus",
  'subtitle' => "Campus are listed here!"
));
?>

<div class="container container--narrow page-section">
<div class="acf-map">
  <?php
  while (have_posts()) {
    the_post();
    $mapLocation = get_field('campus_map');

    ?>
    <div class="marker" data-lat="<?php echo $mapLocation['lat'];?>" data-lng="<?php echo $mapLocation['lng'];?>">
      <h2><a href="<?php the_permalink() ?>"><?php echo get_the_title();?></a></h2>
      <p><?php echo $mapLocation['address'];?></p>
    </div>

    <?php
    } ?>
  </div>
  <?php
  // print_r($mapLocation);
  echo paginate_links();
    get_footer();
  ?>
