<?php
/**
 * Search template.
 *
 * @package pablo-gp
 */

get_header();

echo '<div class="container">';
pablo_gp_breadcrumbs();
echo '<header class="search-header"><h1>' . sprintf( esc_html__( 'Suchergebnisse für: %s', 'pablo-gp' ), esc_html( get_search_query() ) ) . '</h1></header>';

if ( have_posts() ) {
echo '<div class="search-results">';
while ( have_posts() ) {
the_post();
echo '<article id="post-' . get_the_ID() . '" ' . get_post_class( 'search-card card' ) . '>';
echo '<h2><a href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . '</a></h2>';
echo '<p>' . esc_html( wp_trim_words( get_the_excerpt(), 30 ) ) . '</p>';
echo '</article>';
}
echo '</div>';
the_posts_pagination();
} else {
echo '<p>' . esc_html__( 'Keine Treffer gefunden.', 'pablo-gp' ) . '</p>';
}

echo '</div>';

get_footer();
