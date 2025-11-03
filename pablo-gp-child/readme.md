# Pablo Abschleppdienst – GeneratePress Child Theme

## Anforderungen
- WordPress 6.5+
- GeneratePress Parent Theme
- PHP 8.2+
- Empfohlene Plugins: Advanced Custom Fields (Free), WP Mail SMTP, Koko Analytics (optional), Slim SEO, LiteSpeed Cache oder FlyingPress.

## Installation
1. Lade den Ordner `pablo-gp-child` in das Verzeichnis `wp-content/themes/`.
2. Aktiviere das GeneratePress Parent Theme und anschließend das Child Theme.
3. Stelle sicher, dass ACF installiert ist. Importiere das bereitgestellte JSON unter `acf-json/pablo-gp.json` (siehe unten).
4. Navigiere zu **Einstellungen > Permalinks** und speichere, um Custom Post Types zu aktivieren.
5. Lege die notwendigen Menüs an (Hauptnavigation, Footer, Legal) und weise sie den Theme-Locations zu.

## Blöcke & Komponenten
Das Theme registriert serverseitige Gutenberg-Blöcke unter dem Namespace `pablo/`:
- `pablo/hero`
- `pablo/service-grid`
- `pablo/vehicle-grid`
- `pablo/pricing-grid`
- `pablo/contact-cta`
- `pablo/steps`
- `pablo/faq`
- `pablo/reviews`
- `pablo/footer-cta`

Im Editor stehen Konfigurationspanels zur Verfügung. Im Frontend werden die Renderfunktionen aus `inc/blocks.php` genutzt.

## ACF Felder (JSON)
Erstelle den Ordner `wp-content/themes/pablo-gp-child/acf-json/` und füge dort die Datei `pablo-gp.json` mit den Feldgruppen für den CPT `fahrzeuge` ein. Enthaltene Felder:
- `cena_brutto` (Preis Brutto)
- `rok` (Erstzulassung)
- `przebieg_km` (Kilometer)
- `paliwo` (Kraftstoff)
- `skrzynia` (Getriebe)
- `moc_kw` (Leistung in kW)
- `vin` (VIN, hidden)
- `galerie` (Galerie, multiple)

## Demo-Inhalte
Beispiel-Fahrzeuge (JSON) zur WP-All-Import Verwendung:
```
[
  {"title":"VW Crafter 35 TDI","price":"29.900","year":"2020","mileage":"48000","fuel":"Diesel","gearbox":"Automatik","power":"103","kategorie":"transport","marke":"vw"},
  {"title":"Mercedes Sprinter 316 L3","price":"31.500","year":"2019","mileage":"62000","fuel":"Diesel","gearbox":"Automatik","power":"120","kategorie":"transport","marke":"mercedes"},
  {"title":"Audi A6 Avant Quattro","price":"37.900","year":"2021","mileage":"28000","fuel":"Hybrid","gearbox":"Automatik","power":"180","kategorie":"limousine","marke":"audi"},
  {"title":"Skoda Octavia RS","price":"24.400","year":"2020","mileage":"35000","fuel":"Benzin","gearbox":"Automatik","power":"180","kategorie":"kombis","marke":"skoda"},
  {"title":"BMW X3 xDrive20d","price":"36.700","year":"2020","mileage":"42000","fuel":"Diesel","gearbox":"Automatik","power":"140","kategorie":"suv","marke":"bmw"},
  {"title":"Opel Vivaro Doppelkabine","price":"23.900","year":"2018","mileage":"75000","fuel":"Diesel","gearbox":"Manuell","power":"92","kategorie":"transport","marke":"opel"},
  {"title":"Ford Ranger Wildtrak","price":"39.900","year":"2022","mileage":"18000","fuel":"Diesel","gearbox":"Automatik","power":"151","kategorie":"pickup","marke":"ford"},
  {"title":"Renault Master Pritsche","price":"27.100","year":"2021","mileage":"52000","fuel":"Diesel","gearbox":"Manuell","power":"110","kategorie":"transport","marke":"renault"},
  {"title":"Peugeot Boxer L2H2","price":"21.800","year":"2019","mileage":"81000","fuel":"Diesel","gearbox":"Manuell","power":"96","kategorie":"transport","marke":"peugeot"},
  {"title":"Fiat Ducato Maxi","price":"19.400","year":"2018","mileage":"99000","fuel":"Diesel","gearbox":"Manuell","power":"96","kategorie":"transport","marke":"fiat"}
]
```

## Core Web Vitals Checkliste
- **LCP**: Hero-Bereich optimiert, kritisches CSS per `wp_add_inline_style` eingebunden.
- **CLS**: Feste Bildgrößen (Vehicle Cards), Sticky Navigation mit stabilen Höhen.
- **INP**: Minimale JavaScript (ohne jQuery), Debounce-freie Eventlistener.
- Prüfe regelmäßig mit PageSpeed Insights & Lighthouse (Mobile), zusätzlich WebPageTest.

## Weitere Hinweise
- Formular-Endpunkte siehe `inc/forms.php` (REST API). Webhooks können per `rest_request_after_callbacks` erweitert werden.
- Schema Markup befindet sich in `inc/schema.php` und deckt LocalBusiness, Services, Vehicles, FAQ und Breadcrumbs ab.
- SEO Meta Handling über `inc/seo.php` inklusive Canonical, Open Graph und Hreflang.
- Für Datenschutz: Ergänze Cookie-Banner (z.B. CookieYes) und prüfe DSVO-Konformität.
