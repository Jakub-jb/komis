<?php
/**
 * Archive template.
 *
 * @package pablo-gp
 */

get_header();

echo '<div class="container">';
pablo_gp_breadcrumbs();
echo '<header class="archive-header"><h1>' . get_the_archive_title() . '</h1>';
if ( get_the_archive_description() ) {
echo '<p class="archive-description">' . get_the_archive_description() . '</p>';
}
echo '</header>';

if ( have_posts() ) {
echo '<div class="archive-grid">';
while ( have_posts() ) {
the_post();
echo '<article id="post-' . get_the_ID() . '" ' . get_post_class( 'archive-card card' ) . '>';
if ( has_post_thumbnail() ) {
the_post_thumbnail( 'medium_large' );
}
echo '<h2><a href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . '</a></h2>';
echo '<p>' . esc_html( wp_trim_words( get_the_excerpt(), 30 ) ) . '</p>';
echo '<a class="btn btn--ghost" href="' . esc_url( get_permalink() ) . '">' . esc_html__( 'Weiterlesen', 'pablo-gp' ) . '</a>';
echo '</article>';
}
echo '</div>';
the_posts_pagination();
} else {
echo '<p>' . esc_html__( 'Keine Beiträge gefunden.', 'pablo-gp' ) . '</p>';
}

echo '</div>';

get_footer();
