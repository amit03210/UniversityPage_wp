<div class="post-item">
    <ul class="link-list min-list">
        <li class="link-list min-list">
            <a class="professor-card" href="<?php the_permalink()?>">
                <img src="<?php echo get_the_post_thumbnail_url(null, 'professorLandscape'); ?>" alt="" class="professor-card__image">
                <span class="professor-card__name"><?php the_title(); ?></span>
            </a>
        </li>
    </ul>
</div>