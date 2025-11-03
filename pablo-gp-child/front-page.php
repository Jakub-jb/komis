<?php
/**
 * Front page template.
 *
 * @package pablo-gp
 */

get_header();

echo do_blocks( '<!-- wp:pablo/hero {"headline":"Abschleppdienst & Fahrzeughandel Pablo","subheadline":"24/7 Abschleppen, EU-Transport, Ankauf & Vermietung – zuverlässig in Graz & europaweit.","primaryCtaLabel":"Jetzt anrufen (24/7)","primaryCtaUrl":"tel:+436641261735","secondaryCtaLabel":"Abschleppen bestellen","secondaryCtaUrl":"/kontakt/","badge":"Schnell vor Ort • Kartenzahlung • Rechnung/Firma"} /-->' );

echo do_blocks( '<!-- wp:pablo/service-grid /-->' );

echo do_blocks( '<!-- wp:pablo/pricing-grid /-->' );

echo do_blocks( '<!-- wp:pablo/vehicle-grid /-->' );

echo do_blocks( '<!-- wp:pablo/steps /-->' );

echo do_blocks( '<!-- wp:pablo/faq /-->' );

echo do_blocks( '<!-- wp:pablo/reviews /-->' );

echo do_blocks( '<!-- wp:pablo/footer-cta /-->' );

echo do_shortcode( '[pablo_cta_banner title="24/7 Notruf Graz" description="Wir sind innerhalb von 30 Minuten bei Ihnen vor Ort." button="Jetzt anrufen" url="tel:+436641261735"]' );

get_footer();
