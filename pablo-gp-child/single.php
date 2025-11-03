<?php
/**
 * Single post template.
 *
 * @package pablo-gp
 */

get_header();

echo '<div class="container">';
pablo_gp_breadcrumbs();

while ( have_posts() ) :
the_post();
echo '<article id="post-' . get_the_ID() . '" ' . get_post_class( 'single-content' ) . '>';
echo '<header class="single-header"><h1>' . esc_html( get_the_title() ) . '</h1>';
if ( has_post_thumbnail() ) {
echo '<div class="single-featured">';
the_post_thumbnail( 'large' );
echo '</div>';
}
echo '</header>';
echo '<div class="single-body">';
the_content();
echo '</div>';

if ( comments_open() || get_comments_number() ) {
comments_template();
}
echo '</article>';
endwhile;

echo '</div>';

get_footer();
