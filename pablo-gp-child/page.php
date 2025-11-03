<?php
/**
 * Page template.
 *
 * @package pablo-gp
 */

get_header();

while ( have_posts() ) :
the_post();
echo '<div class="container">';
pablo_gp_breadcrumbs();
echo '<article id="post-' . get_the_ID() . '" ' . get_post_class( 'page-content' ) . '>';
echo '<header class="page-header"><h1>' . esc_html( get_the_title() ) . '</h1></header>';
echo '<div class="page-body">';
the_content();
echo '</div>';
echo '</article>';
echo '</div>';
endwhile;

get_footer();
