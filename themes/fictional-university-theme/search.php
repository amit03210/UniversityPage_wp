<?php
get_header(); 
page_banner(array(
  'title' => "Search",
  'subtitle' => "You searched for &ldquo;" . esc_html(get_search_query()) . "&rdquo;",
));
?>

<div class="container container--narrow page-section">
  <?php

  if(have_posts()){
      while (have_posts()) {
        the_post();
        echo get_template_part('\template_parts\content', get_post_type());
      }
    } else{
      echo "<h2 style='margin-bottom: 50px;'> No Results found </h2>";
    }

    get_search_form();
    echo paginate_links();
    get_footer();
  ?>
