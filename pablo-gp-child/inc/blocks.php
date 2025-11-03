<?php
/**
 * Custom Gutenberg blocks.
 *
 * @package pablo-gp
 */

/**
 * Register custom block category.
 */
function pablo_gp_block_category( $categories, $post ) {
$categories[] = [
'slug'  => 'pablo-blocks',
'title' => __( 'Pablo Komponenten', 'pablo-gp' ),
];

return $categories;
}
add_filter( 'block_categories_all', 'pablo_gp_block_category', 10, 2 );

/**
 * Register block assets.
 */
function pablo_gp_register_block_assets() {
$asset_file = [
'dependencies' => [ 'wp-blocks', 'wp-element', 'wp-components', 'wp-editor', 'wp-i18n', 'wp-block-editor' ],
'version'      => PABLO_GP_VERSION,
];

wp_register_script(
'pablo-gp-editor-blocks',
PABLO_GP_URI . 'assets/js/editor-blocks.js',
$asset_file['dependencies'],
$asset_file['version'],
true
);

$blocks = [
'pablo/hero',
'pablo/service-grid',
'pablo/vehicle-grid',
'pablo/pricing-grid',
'pablo/contact-cta',
'pablo/steps',
'pablo/faq',
'pablo/reviews',
'pablo/footer-cta',
];

foreach ( $blocks as $block ) {
register_block_type(
$block,
[
'editor_script'   => 'pablo-gp-editor-blocks',
'render_callback' => 'pablo_gp_render_block',
]
);
}
}
add_action( 'init', 'pablo_gp_register_block_assets' );

/**
 * Block render callback.
 *
 * @param array  $attributes Block attributes.
 * @param string $content Inner blocks content.
 * @param WP_Block $block Block instance.
 *
 * @return string
 */
function pablo_gp_render_block( $attributes, $content, $block ) {
switch ( $block->name ) {
case 'pablo/hero':
return pablo_gp_render_hero_block( $attributes );
case 'pablo/service-grid':
return pablo_gp_render_service_grid_block( $attributes );
case 'pablo/vehicle-grid':
return pablo_gp_render_vehicle_grid_block( $attributes );
case 'pablo/pricing-grid':
return pablo_gp_render_pricing_grid_block( $attributes );
case 'pablo/contact-cta':
return pablo_gp_render_contact_cta_block( $attributes );
case 'pablo/steps':
return pablo_gp_render_steps_block( $attributes );
case 'pablo/faq':
return pablo_gp_render_faq_block( $attributes );
case 'pablo/reviews':
return pablo_gp_render_reviews_block( $attributes );
case 'pablo/footer-cta':
return pablo_gp_render_footer_cta_block( $attributes );
default:
return $content;
}
}

/**
 * Utility to get attribute value with fallback.
 *
 * @param array  $attributes Attributes.
 * @param string $key Key.
 * @param mixed  $default Default.
 *
 * @return mixed
 */
function pablo_gp_attr( $attributes, $key, $default = '' ) {
return isset( $attributes[ $key ] ) && '' !== $attributes[ $key ] ? $attributes[ $key ] : $default;
}

/**
 * Render hero block.
 */
function pablo_gp_render_hero_block( $attributes ) {
$headline   = pablo_gp_attr( $attributes, 'headline', __( 'Abschleppdienst & Fahrzeughandel in Graz', 'pablo-gp' ) );
$subline    = pablo_gp_attr( $attributes, 'subheadline', __( '24/7 Einsatzbereit: Abschleppen, Transport, Ankauf & Vermietung – ein Team, alle Lösungen.', 'pablo-gp' ) );
$cta_label  = pablo_gp_attr( $attributes, 'primaryCtaLabel', __( 'Jetzt anrufen (24/7)', 'pablo-gp' ) );
$cta_url    = pablo_gp_attr( $attributes, 'primaryCtaUrl', 'tel:+436641261735' );
$secondary_label = pablo_gp_attr( $attributes, 'secondaryCtaLabel', __( 'Abschleppen bestellen', 'pablo-gp' ) );
$secondary_url   = pablo_gp_attr( $attributes, 'secondaryCtaUrl', home_url( '/kontakt/' ) );
$badge      = pablo_gp_attr( $attributes, 'badge', __( 'Schnelle Hilfe • Karten- & Rechnungszahlung', 'pablo-gp' ) );

ob_start();
get_template_part( 'template-parts/hero', null, compact( 'headline', 'subline', 'cta_label', 'cta_url', 'secondary_label', 'secondary_url', 'badge' ) );
return ob_get_clean();
}

/**
 * Render service grid block.
 */
function pablo_gp_render_service_grid_block( $attributes ) {
$services = pablo_gp_attr( $attributes, 'items', [] );

if ( empty( $services ) ) {
$services = [
[
'title' => __( 'Abschleppdienst 24/7', 'pablo-gp' ),
'copy'  => __( 'Lawinen-schnell vor Ort, bis 3,5t, Kartenzahlung.', 'pablo-gp' ),
'cta'   => __( 'Abschleppen bestellen', 'pablo-gp' ),
'url'   => home_url( '/leistungen/' ),
],
[
'title' => __( 'Fahrzeugtransport EU', 'pablo-gp' ),
'copy'  => __( 'Transport europaweit mit Live-Tracking & Versicherung.', 'pablo-gp' ),
'cta'   => __( 'Preis berechnen', 'pablo-gp' ),
'url'   => home_url( '/transport/' ),
],
[
'title' => __( 'Ankauf & Verkauf', 'pablo-gp' ),
'copy'  => __( 'Faire Bewertung, sofortige Auszahlung oder Kommission.', 'pablo-gp' ),
'cta'   => __( 'Fahrzeug verkaufen', 'pablo-gp' ),
'url'   => home_url( '/ankauf-verkauf/' ),
],
];
}

ob_start();
echo '<section class="service-grid" aria-label="' . esc_attr__( 'Unsere Leistungen', 'pablo-gp' ) . '">';
echo '<div class="service-grid__inner">';

foreach ( $services as $service ) {
get_template_part( 'template-parts/card', 'service', $service );
}

echo '</div>';
echo '</section>';

return ob_get_clean();
}

/**
 * Render vehicle grid block.
 */
function pablo_gp_render_vehicle_grid_block( $attributes ) {
$atts = wp_parse_args(
$attributes,
[
'postsToShow' => 6,
'categories'  => [],
'marke'       => [],
]
);

$args = [
'post_type'      => 'fahrzeuge',
'posts_per_page' => (int) $atts['postsToShow'],
'post_status'    => 'publish',
];

$tax_query = [];

if ( ! empty( $atts['categories'] ) ) {
$tax_query[] = [
'taxonomy' => 'fahrzeug_kategorie',
'field'    => 'slug',
'terms'    => (array) $atts['categories'],
];
}

if ( ! empty( $atts['marke'] ) ) {
$tax_query[] = [
'taxonomy' => 'marke',
'field'    => 'slug',
'terms'    => (array) $atts['marke'],
];
}

if ( ! empty( $tax_query ) ) {
$args['tax_query'] = $tax_query;
}

$query = new WP_Query( $args );

ob_start();
if ( $query->have_posts() ) {
echo '<section class="vehicle-grid" aria-label="' . esc_attr__( 'Verfügbare Fahrzeuge', 'pablo-gp' ) . '">';
echo '<div class="vehicle-grid__inner">';
while ( $query->have_posts() ) {
$query->the_post();
get_template_part( 'template-parts/card', 'vehicle' );
}
echo '</div>';
echo '<div class="vehicle-grid__cta"><a class="btn btn--secondary" href="' . esc_url( get_post_type_archive_link( 'fahrzeuge' ) ) . '">' . esc_html__( 'Alle Fahrzeuge anzeigen', 'pablo-gp' ) . '</a></div>';
echo '</section>';
wp_reset_postdata();
} else {
echo '<p class="vehicle-grid__empty">' . esc_html__( 'Aktuell keine Fahrzeuge verfügbar. Bitte später erneut prüfen oder kontaktieren Sie uns.', 'pablo-gp' ) . '</p>';
}

return ob_get_clean();
}

/**
 * Render pricing grid block.
 */
function pablo_gp_render_pricing_grid_block( $attributes ) {
$plans = pablo_gp_attr( $attributes, 'plans', [] );

if ( empty( $plans ) ) {
$plans = [
[
'label'       => __( 'Innerhalb Graz', 'pablo-gp' ),
'price'       => 'ab 89 €',
'description' => __( 'Soforthilfe im Stadtgebiet inkl. 20 km, Zahlung per Karte möglich.', 'pablo-gp' ),
'cta'         => __( 'Abschleppen bestellen', 'pablo-gp' ),
'url'         => 'tel:+436641261735',
],
[
'label'       => __( 'Österreich Autobahn', 'pablo-gp' ),
'price'       => 'ab 149 €',
'description' => __( 'Sicherung, Abschleppen und Abstellen im Partnerhof.', 'pablo-gp' ),
'cta'         => __( 'Preis berechnen', 'pablo-gp' ),
'url'         => home_url( '/transport/' ),
'highlight'   => true,
],
[
'label'       => __( 'EU-Transport', 'pablo-gp' ),
'price'       => 'ab 0,95 €/km',
'description' => __( 'Door-to-door europaweit, Zollpapiere & Versicherung inklusive.', 'pablo-gp' ),
'cta'         => __( 'Angebot anfordern', 'pablo-gp' ),
'url'         => home_url( '/transport/' ),
],
];
}

ob_start();
echo '<section class="pricing-grid" aria-label="' . esc_attr__( 'Preisliste Abschleppdienst', 'pablo-gp' ) . '">';
echo '<div class="pricing-grid__inner">';
foreach ( $plans as $plan ) {
$classes = 'card pricing-grid__item';
if ( ! empty( $plan['highlight'] ) ) {
$classes .= ' pricing-grid__item--highlight';
}
echo '<article class="' . esc_attr( $classes ) . '">';
echo '<h3>' . esc_html( $plan['label'] ) . '</h3>';
echo '<p class="pricing-grid__price">' . esc_html( $plan['price'] ) . '</p>';
if ( ! empty( $plan['description'] ) ) {
echo '<p>' . esc_html( $plan['description'] ) . '</p>';
}
if ( ! empty( $plan['cta'] ) && ! empty( $plan['url'] ) ) {
echo '<a class="btn btn--accent" href="' . esc_url( $plan['url'] ) . '">' . esc_html( $plan['cta'] ) . '</a>';
}
echo '</article>';
}
echo '</div>';
echo '</section>';

return ob_get_clean();
}

/**
 * Render contact CTA block.
 */
function pablo_gp_render_contact_cta_block( $attributes ) {
$channels = pablo_gp_attr( $attributes, 'channels', [] );

if ( empty( $channels ) ) {
$channels = [
[
'label' => __( 'Hotline 24/7', 'pablo-gp' ),
'value' => '+43 664 1261735',
'url'   => 'tel:+436641261735',
],
[
'label' => 'WhatsApp',
'value' => '+43 664 1261735',
'url'   => 'https://wa.me/436641261735',
],
[
'label' => __( 'E-Mail', 'pablo-gp' ),
'value' => 'office@abschlepp-pablo.at',
'url'   => 'mailto:office@abschlepp-pablo.at',
],
];
}

ob_start();
get_template_part( 'template-parts/contact', 'cta', compact( 'channels' ) );
return ob_get_clean();
}

/**
 * Render steps block.
 */
function pablo_gp_render_steps_block( $attributes ) {
$steps = pablo_gp_attr( $attributes, 'steps', [] );

if ( empty( $steps ) ) {
$steps = [
[ 'title' => __( 'Kontakt aufnehmen', 'pablo-gp' ), 'description' => __( 'Hotline anrufen oder Formular ausfüllen, wir melden uns in Minuten.', 'pablo-gp' ) ],
[ 'title' => __( 'Fahrzeug sichern', 'pablo-gp' ), 'description' => __( 'Unser Team ist schnell vor Ort, sichert und lädt Ihr Fahrzeug.', 'pablo-gp' ) ],
[ 'title' => __( 'Transport & Übergabe', 'pablo-gp' ), 'description' => __( 'Lieferung in Wunschwerkstatt, Leihwagen optional verfügbar.', 'pablo-gp' ) ],
];
}

$contextual = pablo_gp_attr( $attributes, 'contextual', __( 'So funktioniert unser Abschleppdienst', 'pablo-gp' ) );

$output  = '<section class="steps" aria-label="' . esc_attr( $contextual ) . '">';
$output .= '<h2>' . esc_html( $contextual ) . '</h2>';
$output .= '<ol class="steps__list">';
foreach ( $steps as $index => $step ) {
$output .= '<li class="steps__item"><span class="steps__number" aria-hidden="true">' . ( $index + 1 ) . '</span><div class="steps__content"><h3>' . esc_html( $step['title'] ) . '</h3><p>' . esc_html( $step['description'] ) . '</p></div></li>';
}
$output .= '</ol>';
$output .= '</section>';

return $output;
}

/**
 * Render FAQ block.
 */
function pablo_gp_render_faq_block( $attributes ) {
$faqs = pablo_gp_attr( $attributes, 'items', [] );

if ( empty( $faqs ) ) {
$faqs = [
[ 'question' => __( 'Wie schnell sind Sie vor Ort?', 'pablo-gp' ), 'answer' => __( 'In Graz und Umgebung sind wir in 30 Minuten zur Stelle. In ganz Österreich innerhalb von 90 Minuten.', 'pablo-gp' ) ],
[ 'question' => __( 'Welche Fahrzeuge können abgeschleppt werden?', 'pablo-gp' ), 'answer' => __( 'Wir transportieren PKW, Transporter bis 3,5 Tonnen sowie E-Fahrzeuge mit Hochvoltsicherung.', 'pablo-gp' ) ],
[ 'question' => __( 'Kann ich mit Karte bezahlen?', 'pablo-gp' ), 'answer' => __( 'Ja, wir akzeptieren EC-/Kreditkarte, Barzahlung sowie Firmenrechnung mit UID.', 'pablo-gp' ) ],
];
}

$accordion_id = 'faq-' . wp_unique_id();

ob_start();
echo '<section class="faq" aria-label="' . esc_attr__( 'Häufige Fragen', 'pablo-gp' ) . '">';
echo '<div class="faq__items" id="' . esc_attr( $accordion_id ) . '">';
foreach ( $faqs as $index => $faq ) {
$question_id = $accordion_id . '-q' . $index;
$panel_id    = $accordion_id . '-a' . $index;
echo '<div class="faq__item">';
echo '<button class="faq__trigger" id="' . esc_attr( $question_id ) . '" aria-expanded="' . ( 0 === $index ? 'true' : 'false' ) . '" aria-controls="' . esc_attr( $panel_id ) . '"><span>' . esc_html( $faq['question'] ) . '</span><span class="faq__icon" aria-hidden="true">+</span></button>';
echo '<div class="faq__panel" id="' . esc_attr( $panel_id ) . '" role="region" aria-labelledby="' . esc_attr( $question_id ) . '"' . ( 0 === $index ? '' : ' hidden' ) . '>' . wpautop( esc_html( $faq['answer'] ) ) . '</div>';
echo '</div>';
}
echo '</div>';
echo '</section>';

return ob_get_clean();
}

/**
 * Render reviews block.
 */
function pablo_gp_render_reviews_block( $attributes ) {
$reviews = pablo_gp_attr( $attributes, 'items', [] );

if ( empty( $reviews ) ) {
$reviews = [
[ 'name' => 'Stefan H.', 'rating' => 5, 'comment' => __( 'Sehr schnelle Hilfe mitten in der Nacht. Freundliches Team und faire Preise.', 'pablo-gp' ) ],
[ 'name' => 'Michaela K.', 'rating' => 5, 'comment' => __( 'Transport nach München problemlos, ständige Updates. Absolut empfehlenswert.', 'pablo-gp' ) ],
[ 'name' => 'Firma AutoPlus', 'rating' => 4, 'comment' => __( 'Regelmäßige Abschlepp- und Transportaufträge – zuverlässig und professionell.', 'pablo-gp' ) ],
];
}

$output  = '<section class="reviews" aria-label="' . esc_attr__( 'Kundenstimmen', 'pablo-gp' ) . '">';
$output .= '<div class="reviews__inner">';
foreach ( $reviews as $review ) {
$stars = str_repeat( '★', (int) $review['rating'] );
$output .= '<article class="card reviews__item"><p class="reviews__rating" aria-hidden="true">' . esc_html( $stars ) . '</p><blockquote><p>' . esc_html( $review['comment'] ) . '</p><cite>' . esc_html( $review['name'] ) . '</cite></blockquote></article>';
}
$output .= '</div>';
$output .= '</section>';

return $output;
}

/**
 * Render footer CTA block.
 */
function pablo_gp_render_footer_cta_block( $attributes ) {
$title       = pablo_gp_attr( $attributes, 'headline', __( 'Bereit, jetzt Hilfe zu bekommen?', 'pablo-gp' ) );
$description = pablo_gp_attr( $attributes, 'description', __( 'Rufen Sie uns 24/7 an oder senden Sie ein kurzes Formular. Wir sind in Minuten auf dem Weg.', 'pablo-gp' ) );
$cta_label   = pablo_gp_attr( $attributes, 'ctaLabel', __( 'Angebot anfordern', 'pablo-gp' ) );
$cta_url     = pablo_gp_attr( $attributes, 'ctaUrl', home_url( '/kontakt/' ) );

$output  = '<section class="footer-cta" aria-label="' . esc_attr__( 'Abschließender Call-to-Action', 'pablo-gp' ) . '">';
$output .= '<div class="footer-cta__inner">';
$output .= '<div class="footer-cta__content"><h2>' . esc_html( $title ) . '</h2><p>' . esc_html( $description ) . '</p></div>';
$output .= '<a class="btn btn--accent" href="' . esc_url( $cta_url ) . '">' . esc_html( $cta_label ) . '</a>';
$output .= '</div>';
$output .= '</section>';

return $output;
}
