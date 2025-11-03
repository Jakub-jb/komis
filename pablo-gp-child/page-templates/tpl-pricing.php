<?php
/**
 * Template Name: Preisliste
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
echo '<header class="page-header"><h1>' . esc_html( get_the_title() ) . '</h1><p class="text-muted">' . esc_html__( 'Transparente Preise für Abschleppdienst, Transport und Zusatzleistungen.', 'pablo-gp' ) . '</p></header>';
echo '<div class="page-body">';
the_content();
echo do_blocks( '<!-- wp:pablo/pricing-grid /-->' );
echo '<section class="p-section">';
echo '<h2>' . esc_html__( 'Zusatzleistungen', 'pablo-gp' ) . '</h2>';
echo '<table class="table"><thead><tr><th>' . esc_html__( 'Leistung', 'pablo-gp' ) . '</th><th>' . esc_html__( 'Preis ab', 'pablo-gp' ) . '</th></tr></thead><tbody>';
echo '<tr><td>' . esc_html__( 'Bergung aus Garage / Tiefgarage', 'pablo-gp' ) . '</td><td>79 €</td></tr>';
echo '<tr><td>' . esc_html__( 'E-Fahrzeug Hochvoltsicherung', 'pablo-gp' ) . '</td><td>59 €</td></tr>';
echo '<tr><td>' . esc_html__( 'Ersatzwagen pro Tag', 'pablo-gp' ) . '</td><td>49 €</td></tr>';
echo '</tbody></table>';
echo '</section>';
echo '</div>';
echo '</article>';
echo '</div>';
endwhile;

get_footer();
