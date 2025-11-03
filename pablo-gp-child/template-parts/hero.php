<?php
/**
 * Hero template.
 *
 * @package pablo-gp
 */

$defaults = [
'headline'        => __( 'Abschleppdienst & Fahrzeughandel Pablo', 'pablo-gp' ),
'subline'         => __( '24/7 Abschleppen, EU-Transport, Ankauf & Vermietung – zuverlässig in Graz & europaweit.', 'pablo-gp' ),
'cta_label'       => __( 'Jetzt anrufen (24/7)', 'pablo-gp' ),
'cta_url'         => 'tel:+436641261735',
'secondary_label' => __( 'Abschleppen bestellen', 'pablo-gp' ),
'secondary_url'   => home_url( '/kontakt/' ),
'badge'           => __( 'Schnell vor Ort • Kartenzahlung • Rechnung/Firma', 'pablo-gp' ),
];

$args = wp_parse_args( $args, $defaults );
?>
<section class="hero" aria-labelledby="hero-title">
<div class="hero__inner">
<p class="hero__badge"><?php echo esc_html( $args['badge'] ); ?></p>
<h1 id="hero-title"><?php echo esc_html( $args['headline'] ); ?></h1>
<p class="hero__subline"><?php echo esc_html( $args['subline'] ); ?></p>
<div class="hero__actions">
<a class="btn btn--accent" href="<?php echo esc_url( $args['cta_url'] ); ?>" data-gtm="hero-primary"><?php echo esc_html( $args['cta_label'] ); ?></a>
<a class="btn btn--secondary" href="<?php echo esc_url( $args['secondary_url'] ); ?>" data-gtm="hero-secondary"><?php echo esc_html( $args['secondary_label'] ); ?></a>
</div>
<ul class="hero__usp" role="list">
<li>24/7</li>
<li><?php esc_html_e( 'EU-Transport', 'pablo-gp' ); ?></li>
<li><?php esc_html_e( 'Kartenzahlung', 'pablo-gp' ); ?></li>
<li><?php esc_html_e( 'Rechnung/Firma', 'pablo-gp' ); ?></li>
</ul>
</div>
</section>
