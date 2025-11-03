<?php
/**
 * Vehicle card.
 *
 * @package pablo-gp
 */

$post_id = get_the_ID();
$price   = get_post_meta( $post_id, 'cena_brutto', true );
$year    = get_post_meta( $post_id, 'rok', true );
$mileage = get_post_meta( $post_id, 'przebieg_km', true );
$fuel    = get_post_meta( $post_id, 'paliwo', true );
$gearbox = get_post_meta( $post_id, 'skrzynia', true );
$power   = get_post_meta( $post_id, 'moc_kw', true );
?>
<article class="card vehicle-card" itemscope itemtype="https://schema.org/Product">
<a href="<?php the_permalink(); ?>" class="vehicle-card__media" itemprop="url">
<?php if ( has_post_thumbnail() ) : ?>
<?php the_post_thumbnail( 'pablo-vehicle-card', [ 'itemprop' => 'image' ] ); ?>
<?php else : ?>
<img src="<?php echo esc_url( pablo_gp_asset( 'assets/images/vehicle-placeholder.jpg' ) ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" />
<?php endif; ?>
</a>
<div class="vehicle-card__body">
<h3 class="vehicle-card__title" itemprop="name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
<ul class="vehicle-card__meta" role="list">
<?php if ( $year ) : ?><li><span><?php esc_html_e( 'Erstzulassung', 'pablo-gp' ); ?></span><strong><?php echo esc_html( $year ); ?></strong></li><?php endif; ?>
<?php if ( $mileage ) : ?><li><span><?php esc_html_e( 'Kilometer', 'pablo-gp' ); ?></span><strong><?php echo esc_html( $mileage ); ?> km</strong></li><?php endif; ?>
<?php if ( $fuel ) : ?><li><span><?php esc_html_e( 'Kraftstoff', 'pablo-gp' ); ?></span><strong><?php echo esc_html( $fuel ); ?></strong></li><?php endif; ?>
<?php if ( $gearbox ) : ?><li><span><?php esc_html_e( 'Getriebe', 'pablo-gp' ); ?></span><strong><?php echo esc_html( $gearbox ); ?></strong></li><?php endif; ?>
<?php if ( $power ) : ?><li><span><?php esc_html_e( 'Leistung', 'pablo-gp' ); ?></span><strong><?php echo esc_html( $power ); ?> kW</strong></li><?php endif; ?>
</ul>
<?php if ( $price ) : ?>
<p class="vehicle-card__price" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
<meta itemprop="priceCurrency" content="EUR" />
<span itemprop="price"><?php echo esc_html( $price ); ?></span>
</p>
<?php endif; ?>
<a class="btn btn--secondary" href="<?php the_permalink(); ?>" data-gtm="vehicle-card"><?php esc_html_e( 'Zum Fahrzeug', 'pablo-gp' ); ?></a>
</div>
</article>
