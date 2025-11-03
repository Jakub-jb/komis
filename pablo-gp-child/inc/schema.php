<?php
/**
 * Structured data helpers.
 *
 * @package pablo-gp
 */

/**
 * Output JSON-LD for LocalBusiness and related entities.
 */
function pablo_gp_output_schema() {
if ( is_admin() ) {
return;
}

$schema = [];

$business = [
'@context'      => 'https://schema.org',
'@type'         => 'AutomotiveBusiness',
'@id'           => home_url( '/#business' ),
'name'          => 'Autohandel & Abschleppdienst Pablo E.U.',
'alternateName' => 'Pablo Abschleppdienst',
'url'           => home_url(),
'logo'          => home_url( '/wp-content/uploads/logo.svg' ),
'image'         => home_url( '/wp-content/uploads/abschleppdienst-placeholder.jpg' ),
'description'   => __( '24/7 Abschleppdienst, Fahrzeughandel, Vermietung und EU-Transport für PKW und leichte Nutzfahrzeuge.', 'pablo-gp' ),
'telephone'     => '+43 664 1261735',
'priceRange'    => '$$',
'areaServed'    => [
'@type' => 'Place',
'name'  => 'Österreich und EU',
],
'address'       => [
'@type'           => 'PostalAddress',
'streetAddress'   => 'Triester Straße 55',
'addressLocality' => 'Graz',
'postalCode'      => '8020',
'addressCountry'  => 'AT',
],
'geo'           => [
'@type'     => 'GeoCoordinates',
'latitude'  => '47.0707',
'longitude' => '15.4395',
],
'openingHoursSpecification' => [
[
'@type'     => 'OpeningHoursSpecification',
'dayOfWeek' => [ 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday' ],
'opens'     => '08:00',
'closes'    => '18:00',
],
[
'@type'     => 'OpeningHoursSpecification',
'dayOfWeek' => [ 'Saturday', 'Sunday' ],
'opens'     => '00:00',
'closes'    => '23:59',
'description' => __( '24/7 Notdienst verfügbar', 'pablo-gp' ),
],
],
'sameAs' => [
'https://www.facebook.com/pabloabschleppdienst',
'https://www.instagram.com/pabloabschleppdienst',
'https://maps.google.com/?cid=0000000000',
],
];

$services = [
[
'@type'        => 'Service',
'name'         => __( 'Abschleppdienst 24/7', 'pablo-gp' ),
'description'  => __( 'Schnelle Hilfe bei Pannen und Unfällen inklusive EU-Rückholung.', 'pablo-gp' ),
'areaServed'   => 'Österreich und EU',
'provider'     => [ '@id' => $business['@id'] ],
'serviceType'  => 'TowingService',
],
[
'@type'       => 'Service',
'name'        => __( 'Fahrzeugankauf und -verkauf', 'pablo-gp' ),
'description' => __( 'Transparente Bewertung, faire Preise und komplette Abwicklung.', 'pablo-gp' ),
'provider'    => [ '@id' => $business['@id'] ],
],
[
'@type'       => 'Service',
'name'        => __( 'EU-Fahrzeugtransport', 'pablo-gp' ),
'description' => __( 'Gesicherter Transport von PKW und Transportern europaweit.', 'pablo-gp' ),
'provider'    => [ '@id' => $business['@id'] ],
],
];

$schema[] = $business;
$schema   = array_merge( $schema, $services );

if ( is_post_type_archive( 'fahrzeuge' ) || is_singular( 'fahrzeuge' ) ) {
$schema[] = pablo_gp_vehicle_schema();
}

if ( is_page_template( 'page-templates/tpl-faq.php' ) ) {
$schema[] = pablo_gp_faq_schema();
}

if ( ! empty( $schema ) ) {
echo '<script type="application/ld+json" id="pablo-schema">' . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) . '</script>';
}
}
add_action( 'wp_head', 'pablo_gp_output_schema', 5 );

/**
 * Vehicle schema for single vehicle.
 *
 * @return array
 */
function pablo_gp_vehicle_schema() {
if ( is_singular( 'fahrzeuge' ) ) {
$post_id = get_the_ID();
$price   = get_post_meta( $post_id, 'cena_brutto', true );
$brand   = wp_get_post_terms( $post_id, 'marke', [ 'fields' => 'names' ] );
$model   = get_the_title( $post_id );

$vehicle = [
'@context'    => 'https://schema.org',
'@type'       => 'Product',
'name'        => $model,
'brand'       => ! empty( $brand ) ? $brand[0] : '',
'description' => wp_strip_all_tags( get_the_excerpt( $post_id ) ),
'image'       => get_the_post_thumbnail_url( $post_id, 'full' ),
'offers'      => [
'@type'         => 'Offer',
'priceCurrency' => 'EUR',
'price'         => $price ?: '0',
'availability'  => 'https://schema.org/InStock',
'url'           => get_permalink( $post_id ),
],
];

return $vehicle;
}

return [];
}

/**
 * FAQ schema.
 *
 * @return array
 */
function pablo_gp_faq_schema() {
$faqs = apply_filters( 'pablo_gp_faq_data', [] );

if ( empty( $faqs ) ) {
return [];
}

return [
'@context'   => 'https://schema.org',
'@type'      => 'FAQPage',
'mainEntity' => array_map(
static function( $faq ) {
return [
'@type'          => 'Question',
'name'           => $faq['question'],
'acceptedAnswer' => [
'@type' => 'Answer',
'text'  => wp_kses_post( wpautop( $faq['answer'] ) ),
],
];
},
$faqs
),
];
}

/**
 * Default FAQ data for schema.
 *
 * @param array $faqs FAQ entries.
 *
 * @return array
 */
function pablo_gp_default_faq_schema( $faqs ) {
if ( ! empty( $faqs ) ) {
return $faqs;
}

return [
[ 'question' => __( 'Wie schnell sind Sie vor Ort?', 'pablo-gp' ), 'answer' => __( 'In Graz und Umgebung innerhalb von 30 Minuten, österreichweit in 90 Minuten.', 'pablo-gp' ) ],
[ 'question' => __( 'Welche Zahlungsarten akzeptieren Sie?', 'pablo-gp' ), 'answer' => __( 'Bar, EC-/Kreditkarte sowie Firmenrechnung mit UID-Nummer.', 'pablo-gp' ) ],
[ 'question' => __( 'Transportieren Sie Fahrzeuge in die EU?', 'pablo-gp' ), 'answer' => __( 'Ja, inklusive Versicherung, Zollabwicklung und Live-Tracking.', 'pablo-gp' ) ],
];
}
add_filter( 'pablo_gp_faq_data', 'pablo_gp_default_faq_schema' );
