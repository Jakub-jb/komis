<?php
/**
 * Template Name: FAQ
 * Template Post Type: page
 *
 * @package pablo-gp
 */

get_header();

while ( have_posts() ) :
the_post();
echo '<div class="container">';
pablo_gp_breadcrumbs();
echo '<article class="page-content">';
echo '<header class="page-header"><h1>' . esc_html( get_the_title() ) . '</h1><p class="text-muted">' . esc_html__( 'Antworten auf häufige Fragen zu Abschleppdienst, Transport und Fahrzeughandel.', 'pablo-gp' ) . '</p></header>';
echo '<div class="page-body">';
the_content();
echo do_blocks( '<!-- wp:pablo/faq /-->' );
echo '</div>';
echo '</article>';
echo '</div>';
endwhile;

get_footer();
