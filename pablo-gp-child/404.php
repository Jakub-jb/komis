<?php
/**
 * 404 template.
 *
 * @package pablo-gp
 */

get_header();

echo '<div class="container">';
echo '<section class="error-404">';
echo '<h1>' . esc_html__( 'Seite nicht gefunden', 'pablo-gp' ) . '</h1>';
echo '<p>' . esc_html__( 'Die angeforderte Seite existiert nicht. Prüfen Sie die URL oder nutzen Sie die Suche.', 'pablo-gp' ) . '</p>';
get_search_form();
echo '<a class="btn btn--accent" href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Zur Startseite', 'pablo-gp' ) . '</a>';
echo '</section>';
echo '</div>';

get_footer();
