<?php
/**
 * Shortcodes.
 *
 * @package pablo-gp
 */

/**
 * Phone CTA shortcode.
 *
 * @return string
 */
function pablo_gp_shortcode_phone_cta() {
return '<div class="cta-inline"><a class="btn btn--accent" href="tel:+436641261735" data-gtm="cta-call">' . esc_html__( 'Jetzt anrufen (24/7)', 'pablo-gp' ) . '</a></div>';
}
add_shortcode( 'pablo_call_cta', 'pablo_gp_shortcode_phone_cta' );

/**
 * WhatsApp CTA shortcode.
 *
 * @return string
 */
function pablo_gp_shortcode_whatsapp_cta() {
return '<div class="cta-inline"><a class="btn btn--primary" href="https://wa.me/436641261735" target="_blank" rel="noopener" data-gtm="cta-whatsapp">WhatsApp</a></div>';
}
add_shortcode( 'pablo_whatsapp_cta', 'pablo_gp_shortcode_whatsapp_cta' );

/**
 * CTA banner shortcode.
 *
 * @param array $atts Attributes.
 *
 * @return string
 */
function pablo_gp_shortcode_cta_banner( $atts ) {
$atts = shortcode_atts(
[
'title'       => __( 'Schnelle Hilfe in Graz & Umgebung', 'pablo-gp' ),
'description' => __( 'Rufen Sie unsere 24/7 Hotline an oder fordern Sie ein individuelles Angebot an.', 'pablo-gp' ),
'button'      => __( 'Abschleppen bestellen', 'pablo-gp' ),
'url'         => 'tel:+436641261735',
],
$atts,
'pablo_cta_banner'
);

$markup  = '<section class="cta-banner" role="region" aria-label="' . esc_attr__( 'Kontakt CTA', 'pablo-gp' ) . '">';
$markup .= '<div class="cta-banner__inner">';
$markup .= '<div class="cta-banner__content">';
$markup .= '<h2>' . esc_html( $atts['title'] ) . '</h2>';
$markup .= '<p>' . esc_html( $atts['description'] ) . '</p>';
$markup .= '</div>';
$markup .= '<a class="btn btn--accent" href="' . esc_url( $atts['url'] ) . '" data-gtm="cta-banner">' . esc_html( $atts['button'] ) . '</a>';
$markup .= '</div>';
$markup .= '</section>';

return $markup;
}
add_shortcode( 'pablo_cta_banner', 'pablo_gp_shortcode_cta_banner' );
