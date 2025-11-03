<?php
/**
 * Service card.
 *
 * @package pablo-gp
 */

$defaults = [
'title' => __( 'Service', 'pablo-gp' ),
'copy'  => __( 'Beschreibung', 'pablo-gp' ),
'cta'   => __( 'Mehr erfahren', 'pablo-gp' ),
'url'   => '#',
];

$args = wp_parse_args( $args, $defaults );
?>
<article class="card service-card">
<h3><?php echo esc_html( $args['title'] ); ?></h3>
<p><?php echo esc_html( $args['copy'] ); ?></p>
<?php if ( ! empty( $args['url'] ) ) : ?>
<a class="btn btn--ghost" href="<?php echo esc_url( $args['url'] ); ?>" data-gtm="service-card"><?php echo esc_html( $args['cta'] ); ?></a>
<?php endif; ?>
</article>
