<?php
/**
 * Contact CTA section.
 *
 * @package pablo-gp
 */

$defaults = [
'channels' => [
[ 'label' => __( 'Hotline 24/7', 'pablo-gp' ), 'value' => '+43 664 1261735', 'url' => 'tel:+436641261735' ],
[ 'label' => 'WhatsApp', 'value' => '+43 664 1261735', 'url' => 'https://wa.me/436641261735' ],
[ 'label' => __( 'E-Mail', 'pablo-gp' ), 'value' => 'office@abschlepp-pablo.at', 'url' => 'mailto:office@abschlepp-pablo.at' ],
],
];

$args = wp_parse_args( $args, $defaults );
?>
<section class="contact-cta" aria-label="<?php esc_attr_e( 'Direkte Kontaktwege', 'pablo-gp' ); ?>">
<div class="contact-cta__inner">
<h2><?php esc_html_e( 'Jetzt Kontakt aufnehmen', 'pablo-gp' ); ?></h2>
<p><?php esc_html_e( 'Hotline, WhatsApp oder E-Mail – wir antworten innerhalb weniger Minuten.', 'pablo-gp' ); ?></p>
<ul class="contact-cta__list" role="list">
<?php foreach ( $args['channels'] as $channel ) : ?>
<li>
<strong><?php echo esc_html( $channel['label'] ); ?></strong>
<a href="<?php echo esc_url( $channel['url'] ); ?>" data-gtm="contact-cta"><?php echo esc_html( $channel['value'] ); ?></a>
</li>
<?php endforeach; ?>
</ul>
</div>
</section>
