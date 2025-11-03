<?php
/**
 * Template Name: Kontakt
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
echo '<header class="page-header"><h1>' . esc_html( get_the_title() ) . '</h1><p class="text-muted">' . esc_html__( '24/7 Hotline, WhatsApp und Standort in Graz.', 'pablo-gp' ) . '</p></header>';
echo '<div class="page-body contact-page">';
echo '<section class="contact-details">';
echo '<h2>' . esc_html__( 'Standort & Öffnungszeiten', 'pablo-gp' ) . '</h2>';
echo '<p>Triester Straße 55, 8020 Graz<br>' . esc_html__( 'Hotline', 'pablo-gp' ) . ': <a href="tel:+436641261735">+43 664 1261735</a></p>';
echo '<p>' . esc_html__( 'Montag–Freitag: 08:00–18:00 • Notdienst 24/7', 'pablo-gp' ) . '</p>';
echo '<iframe title="Google Maps" src="https://maps.google.com/maps?q=Triester%20Stra%C3%9Fe%2055%20Graz&t=&z=13&ie=UTF8&iwloc=&output=embed" style="width:100%;height:320px;border:0;border-radius:var(--radius)" loading="lazy"></iframe>';
echo '</section>';
echo '<section class="contact-form">';
echo '<h2>' . esc_html__( 'Abschleppen bestellen', 'pablo-gp' ) . '</h2>';
echo '<form class="contact-form__form" data-form-slug="abschlepp">';
echo '<div class="form-group"><label class="label" for="abschlepp-name">' . esc_html__( 'Name', 'pablo-gp' ) . '</label><input class="input" id="abschlepp-name" name="name" required></div>';
echo '<div class="form-group"><label class="label" for="abschlepp-phone">' . esc_html__( 'Telefon', 'pablo-gp' ) . '</label><input class="input" id="abschlepp-phone" name="phone" type="tel" required></div>';
echo '<div class="form-group"><label class="label" for="abschlepp-location">' . esc_html__( 'Standort', 'pablo-gp' ) . '</label><input class="input" id="abschlepp-location" name="location"></div>';
echo '<div class="form-group"><label class="label" for="abschlepp-vehicle">' . esc_html__( 'Fahrzeugtyp', 'pablo-gp' ) . '</label><input class="input" id="abschlepp-vehicle" name="vehicle"></div>';
echo '<div class="form-group"><label class="label" for="abschlepp-message">' . esc_html__( 'Beschreibung', 'pablo-gp' ) . '</label><textarea class="textarea" id="abschlepp-message" name="message"></textarea></div>';
echo '<label class="checkbox"><input type="checkbox" name="privacy" value="1" required> ' . esc_html__( 'Ich stimme der Verarbeitung meiner Daten laut Datenschutz zu.', 'pablo-gp' ) . '</label>';
echo '<div class="form-actions"><button class="btn btn--primary" type="submit" data-gtm="form-abschlepp">' . esc_html__( 'Jetzt absenden', 'pablo-gp' ) . '</button></div>';
echo '<p class="form-status" data-form-status></p>';
echo '</form>';
echo '</section>';
echo '</div>';
echo '</article>';
echo '</div>';
endwhile;

get_footer();
