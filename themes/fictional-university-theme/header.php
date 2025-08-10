<!DOCTYPE html>
<html <?php language_attributes() ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <header class="site-header">
    <div class="container">
      <h1 class="school-logo-text float-left">
        <a href="<?php echo site_url() ?>"><strong>Fictional</strong> University</a>
      </h1>
      <a href="<?php echo esc_url(site_url('./search/')) ?>" class="js-search-trigger site-header__search-trigger"><i
          class="fa fa-search" aria-hidden="true"></i></a>
      <i class="site-header__menu-trigger fa fa-bars" aria-hidden="true"></i>
      <div class="site-header__menu group">
        <nav class="main-navigation">
          <ul>
            <li <?php if (is_page('about-us') or wp_get_post_parent_id(0) == 12)
              echo 'class="current-menu-item"'; ?>><a
                href="<?php echo site_url('./about-us') ?>">About Us</a></li>
            <li <?php if (get_post_type() == 'program')
              echo "class='current-menu-item'"; ?>><a
                href="<?php echo get_post_type_archive_link('program') ?>">Programs</a></li>
            <li <?php if (get_post_type() == 'event' or is_page('past-events'))
              echo 'class="current-menu-item"'; ?>><a
                href="<?php echo get_post_type_archive_link('event'); ?>">Events</a></li>
            <li><a href="<?php echo get_post_type_archive_link('campus') ?>">Campuses</a></li>
            <li <?php if (is_home())
              echo 'class="current-menu-item"' ?>><a
                  href="<?php echo site_url('./blog') ?>">Blog</a></li>
          </ul>
        </nav>
        <div class="site-header__util">
          <?php
          if (is_user_logged_in()) { ?>
            <a href="<?php echo esc_url(site_url('/my-notes/')); ?>"
              class="btn btn--small btn--orange float-left push-right">Notes</a>
            <a href="<?php echo esc_url(wp_logout_url(home_url())); ?>"
              class="btn btn--small btn--orange float-left push-right">
              <span class="btn__text">Logout</span>
              <!-- <span class="" ><?php echo get_avatar(get_current_user_id(), 60); ?></span> -->
            </a>
            <?php
          } else { ?>
            <a href="<?php echo esc_url(wp_login_url()) ?>"
              class="btn btn--small btn--orange float-left push-right">Login</a>
            <a href="<?php echo esc_url(wp_registration_url()) ?>" class="btn btn--small btn--dark-orange float-left">Sign
              Up</a>
          <?php }
          ?>
          <a href="<?php echo esc_url(site_url('./search/')) ?>" class="search-trigger js-search-trigger"><i
              class="fa fa-search" aria-hidden="true"></i></a>
        </div>
      </div>
    </div>
  </header>


  <!-- 
### 🧠 Why `is_page('past-events')` Is Often Included
Even though your `page-past-events.php` template uses a custom query for `'post_type' => 'event'`, WordPress’s **main query** still thinks it’s rendering a **Page**, not an Event archive. So:

- `get_post_type()` returns `'page'` — because the main post object is the Page titled “Past Events”
- `is_post_type_archive('event')` returns `false` — because you're not on the actual archive page for the `event` post type

That’s why developers often add:
```php
if (get_post_type() == 'event' || is_page('past-events'))
```
This ensures the query modification runs **even when you're on a custom page** that manually queries events.

---

### 🔍 What’s Happening in `page-past-events.php`
You’re likely using a custom `WP_Query` like:
```php
$args = array(
  'post_type' => 'event',
  // other filters
);
$past_events = new WP_Query($args);
```
This works fine for displaying events, but it doesn’t change the **main query** — so `pre_get_posts` won’t target it unless you explicitly check for `is_page('past-events')`.

---

### ✅ Alternative Approach
If you want to avoid hardcoding the page name, you could use:
```php
if (is_page() && get_the_ID() == YOUR_PAGE_ID)
```
Or even better, use a custom page template and check:
```php
if (is_page_template('template-past-events.php'))
``` -->