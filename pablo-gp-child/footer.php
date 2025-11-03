<?php
/**
 * Footer template.
 *
 * @package pablo-gp
 */
?>
</main>
<footer class="site-footer" role="contentinfo">
<div class="site-footer__top">
<section>
<h2 class="footer__widget-title"><?php esc_html_e( 'Autohandel & Abschleppdienst Pablo E.U.', 'pablo-gp' ); ?></h2>
<p>Triester Straße 55<br>8020 Graz<br>ATU 12345678</p>
<p><a href="tel:+436641261735" data-gtm="footer-call">+43 664 1261735</a><br><a href="mailto:office@abschlepp-pablo.at">office@abschlepp-pablo.at</a></p>
</section>
<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
<?php dynamic_sidebar( 'footer-1' ); ?>
<?php endif; ?>
<?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
<?php dynamic_sidebar( 'footer-2' ); ?>
<?php endif; ?>
</div>
<div class="site-footer__bottom">
<nav aria-label="<?php esc_attr_e( 'Footer Navigation', 'pablo-gp' ); ?>">
<?php wp_nav_menu( [ 'theme_location' => 'footer', 'container' => false, 'menu_class' => 'footer-nav', 'depth' => 1 ] ); ?>
</nav>
<nav aria-label="<?php esc_attr_e( 'Rechtliches', 'pablo-gp' ); ?>">
<?php wp_nav_menu( [ 'theme_location' => 'legal', 'container' => false, 'menu_class' => 'footer-legal', 'depth' => 1 ] ); ?>
</nav>
<p>© <?php echo esc_html( date_i18n( 'Y' ) ); ?> Autohandel & Abschleppdienst Pablo E.U.</p>
</div>
</footer>
</div>
<?php wp_footer(); ?>
</body>
</html>
