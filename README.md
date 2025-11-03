Cel dokumentu

Instrukcja operacyjna dla agentów (dev/SEO/QA/Content) pracujących nad stroną Autohandel & Abschleppdienst Pablo E.U. na WordPress (GeneratePress Child, Gutenberg + własne bloki).
Zakres: scaffold, rozwój, SEO, i18n (DE domyślnie), dostępność, wydajność, analityka, release.

1) Kontekst projektu

Motyw: pablo-gp-child (child GeneratePress, bez builderów)

Języki: de (prod, domyślny), przygotowane en, pl

Projekt UI: system z tokenami (navy/gray/accent), Montserrat/Inter, radius 12px, shadow-sm/md/lg

Core Web Vitals 2025: LCP < 2.5s (mobile), CLS < 0.1, INP < 200 ms

WCAG 2.2 AA: focus-visible, kontrast, targety 44×44, klawiatura

SEO: E-E-A-T + Local SEO (Austria), schema.org (AutomotiveBusiness, Service, Product/Vehicle, FAQPage, BreadcrumbList)

Obrazy: responsywne, lazy, WebP/AVIF preferowane; logo w SVG (inline)

Analityka: GTM + dataLayer (click CTA, form submit, call link)

2) Struktura repo (źródło prawdy)
pablo-gp-child/
  style.css
  functions.php
  theme.json
  inc/
    setup.php
    schema.php
    breadcrumbs.php
    shortcodes.php
    blocks.php
    seo.php
    cpt-vehicles.php
    taxonomies.php
    forms.php
  template-parts/
    hero.php
    card-service.php
    card-vehicle.php
    contact-cta.php
  assets/css/{base.css,components.css,utilities.css}
  assets/js/{ui.js,menu.js,forms.js,gtm-dataLayer.js}
  header.php
  footer.php
  sidebar.php
  front-page.php
  page.php
  single.php
  archive.php
  search.php (dodać jeśli brak)
  404.php (dodać jeśli brak)
  page-templates/{tpl-pricing.php, tpl-faq.php, tpl-contact.php}
  languages/{de_DE.po, en_US.po, pl_PL.po}
  readme.md


Uwaga: jeżeli jakiegoś pliku nie ma, agent dev ma go utworzyć zgodnie z poniższymi wytycznymi.

3) Role agentów i odpowiedzialności

Agent Dev
Scaffold motywu, rejestracja bloków i CPT, JS (menu/forms/ui), ACF integracja, szablony, schema, hreflang, krytyczny CSS.

Agent SEO
Title/Meta, OG/Twitter, canonical + rel prev/next, robots.txt, sitemap, schema.org, hreflang, E-E-A-T, GBP/sameAs.

Agent QA/A11y/Perf
Lighthouse, WebPageTest, axe DevTools, testy klawiatury, kontrasty, lazy images, font-display: swap, preconnect.

Agent Content
DE microcopy, strony „must-have”, FAQ, cennik, USP, CTA, 10 pojazdów demo (JSON), zgodność z brand voice.

4) Zasady i standardy (Do & Don’t)

Do

Semantyczny HTML5, aria-*, focus-visible, role region dla sekcji.

Bloki Gutenberg + lekkie shortcody (bez builderów).

Modularny CSS (assets/css/...), tokeny z design systemu.

Konwencje commitów: Conventional Commits (feat:, fix:, docs:, refactor:, chore:, perf:, style:, test:).

PHPCS (WPCS) + PSR-12 (dla PHP); ESLint (JS, jeżeli dodasz config).

i18n: __(), _e(), esc_html__() z pablo-gp.

Don’t

Nie dodawaj ciężkich wtyczek/builderów.

Nie osadzaj inline stylów/JS poza krytycznym CSS i małymi wyjątkami.

Nie używaj obrazów jako tekstu (dostępność).

Nie blokuj renderingu zasobami niekrytycznymi.

5) Setup lokalny / środowiskowy

Wymagania

PHP 8.2+, WP 6.4+, GeneratePress aktywny.

Wtyczki (lekkie):

Advanced Custom Fields (ACF) – dla pól fahrzeuge

Cache (np. LiteSpeed Cache / WP Super Cache)

(Opcjonalnie) RankMath/Yoast – jeśli klient wymaga meta GUI

(Dev only) Query Monitor

WP-CLI – szybki bootstrap

# język + strefa + permalink
wp language core install de_DE --activate
wp option update timezone_string "Europe/Vienna"
wp rewrite structure '/%postname%/' --hard
wp rewrite flush --hard

# ustawienie strony startowej
wp post create --post_type=page --post_title='Startseite' --post_status=publish
wp option update show_on_front 'page'
wp option update page_on_front $(wp post list --post_type=page --name=startseite --field=ID)

# menu
wp menu create "Hauptmenü"
wp menu create "Footer"
wp menu create "Rechtliches"
wp menu location assign hauptmenu primary
wp menu location assign footer footer
wp menu location assign rechtliches legal

6) Komendy „/slash” dla agentów (copy-paste w zadaniach)

/scaffold-theme – uzupełnij brakujące pliki z sekcji struktura, zachowując standardy.

/blocks-refresh – zarejestruj bloki w inc/blocks.php (hero, service-grid, vehicle-grid, pricing-grid, steps, faq, reviews, footer-cta) i zapewnij ich dynamiczny render (PHP).

/schema-wire – dodaj/uzupełnij JSON-LD: AutomotiveBusiness, Service, Product/Vehicle, FAQPage, BreadcrumbList.

/forms-abschlepp – skonfiguruj endpoint REST i markup formularzy (nonce, walidacja, honeypot); wyślij mail + log w WP.

/i18n-sync de en pl – przeleć po funkcjach tłumaczeń, dodaj stringi do .po.

/perf-pass – dodaj preconnect do fontów, font-display: swap, sprawdź lazy, minifikację, inline critical CSS.

/seo-pass – title/meta/og/twitter/canonical/hreflang; prev/next; robots + sitemap (jeśli brak).

/a11y-pass – keyboard nav, focus, aria dla akordeonów (FAQ), kontrast.

/content-seed – utwórz strony: Leistungen, Ankauf/Verkauf, Vermietung, Transport, Preisliste, Fahrzeuge, Kontakt, FAQ, Über uns, Blog (DE copy placeholder).

/vehicles-demo 10 – dodaj 10 pojazdów demo z polami ACF (patrz format w sekcji 11).

7) Design system (skrót operacyjny)

Kolory (tokeny): navy/gray/accent zdefiniowane w base.css i theme.json

Typografia: Montserrat 600 (nagłówki), Inter 400/500 (UI)

Komponenty: .btn, .card, .hero, .faq, .pricing-grid, .steps, .contact-cta, .vehicle-card

Nawigacja: sticky, blur, link aktywny z podkreśleniem, mobile toggle (JS)

Focus: :focus-visible + ring --focus-ring

Motion: 150–250ms, --ease, bez animacji focus

Źródło: assets/css/{base,components,utilities}.css, theme.json

8) Bloki i shortcody (jak używać)

Bloki dynamiczne (PHP render callbacks):

pablo/hero → używa template-parts/hero.php

pablo/service-grid → siatka kart usług

pablo/vehicle-grid → listuje fahrzeuge z filtrami podstawowymi (min. markup + miejsce pod przyszłe filtry)

pablo/pricing-grid → 3–4 planów, wyróżnienie

pablo/steps → „jak działamy” (holowanie/ankauf)

pablo/faq → akordeon + schema

pablo/reviews → kartki z ocenami

pablo/footer-cta → baner końcowy CTA

Shortcody:

[pablo_call_cta] – przycisk „Jetzt anrufen (24/7)”

[pablo_whatsapp_cta] – link do WhatsApp

[pablo_cta_banner title="" description="" button="" url=""]

9) CPT + taksonomie + ACF

CPT: fahrzeuge

supports: title, editor, excerpt, thumbnail, revisions

rewrite: /fahrzeuge

Tax:

fahrzeug_kategorie (hierarchical: osobowe/dostawcze…)

marke (non-hierarchical: brand)

ACF – pola (klucze umowne, typy):

cena_brutto (text / price)

rok (number / year)

przebieg_km (number)

paliwo (select: Benzin/Diesel/Hybrid/EV)

skrzynia (select: Manuell/Automatik)

moc_kw (number)

vin (text, hidden)

galerie (gallery, multiple)

Agent Dev: zapewnij acf-json/ eksport w motywie (auto-sync ACF).

10) SEO „must-have”

Title/meta/og/twitter w inc/seo.php – fallback z excerpt/opisu.

Canonical, rel prev/next (singles/archives).

hreflang: de, en, pl (+ x-default na /de/).

Robots + sitemap (jeśli brak – użyj wtyczki SEO lub prosty generator).

Schema.org:

AutomotiveBusiness (NAP, ATU, tel, geo, areaServed)

Service (Abschleppdienst, Transport, Vermietung, Ankauf/Verkauf)

Product/Vehicle (dla kart pojazdów: marka, model, cena)

FAQPage (/faq/)

BreadcrumbList

E-E-A-T: strona Über uns, Kontakt z NAP, ATU, godziny; stopka ze stałym NAP.

11) Demo content – pojazdy (JSON)

Format przykładowy (dla importera skryptowego/REST):

[
  {
    "post_title": "Volkswagen Golf 1.5 TSI",
    "tax": { "marke": ["Volkswagen"], "fahrzeug_kategorie": ["PKW"] },
    "acf": {
      "cena_brutto": "16 990",
      "rok": 2019,
      "przebieg_km": 78500,
      "paliwo": "Benzin",
      "skrzynia": "Manuell",
      "moc_kw": 96,
      "vin": "WVWZZZ...123"
    },
    "featured_image": "https://via.placeholder.com/960x640.webp"
  }
]


Agent Content: przygotuj 10 szt. z różnymi markami/kategoriami.

12) Formularze (REST)

Endpoint: pablo-gp/v1/form/{slug}
Slugi: abschlepp, ankauf, transport
Zabezpieczenia: nonce (wp_create_nonce), walidacja, honeypot (dodaj pole ukryte), rate-limit (opcjonalnie).

DataLayer eventy:

form_submit (slug), cta_click (data-gtm), theme_loaded

13) QA – checklisty

A11y

Klawiatura: menu/akordeony/formularze działają tab/enter/space/esc

Focus ring widoczny, nieprzesadnie animowany

Kontrast: min 4.5:1 tekst, 3:1 UI

Nagłówki w kolejności (H1 → H2 → H3)

Performance

Lighthouse Mobile ≥ 90; LCP < 2.5s; CLS < 0.1; INP < 200ms

Preconnect do fontów, font-display: swap

Lazy dla <img> i decoding="async"

SEO

Jedno H1, poprawny title/meta, canonical

Schemy obecne i poprawne (Rich Results Test)

hreflang poprawny

14) CI / jakość

PHPCS (WPCS)

phpcs --standard=WordPress pablo-gp-child --extensions=php


Conventional Commits – przykłady

feat(blocks): add pricing-grid highlighted plan

fix(schema): correct AutomotiveBusiness addressCountry=AT

perf(css): inline critical nav/hero styles

chore(i18n): update de_DE.po strings

PR Template (zalecany)

## Zakres
- [ ] Dev
- [ ] SEO
- [ ] A11y
- [ ] Perf
- [ ] Content

## Co zmieniono
- …

## Testy
- Lighthouse (mobile): _score_ / LCP / CLS / INP
- Axe: _wynik_
- Rich Results: _ok/uwagi_

## Screens/Video
- …

15) Deployment / prod

Cache (strona + obiektowy; Redis jeśli dostępny).

CDN (Cloudflare) + image optimization (AVIF/WebP).

Minifikacja CSS/JS (bez łamania krytycznego CSS).

Zabezpieczenia: DISALLOW_FILE_EDIT, ograniczenie REST (opcjonalnie).

Backupy i monitoring uptime.

After-deploy checklist

Test call tel: i WhatsApp

Formularze (mail + log)

Mapy i NAP w stopce

hreflang i schema walidacja

Robots/sitemap dostępne

16) Strony „must-have” (DE – szkielety)

Leistungen – kafle usług (Abschleppen 24/7, Transport EU, Vermietung, Ankauf/Verkauf, Service) + CTA

Ankauf/Verkauf – formularz wyceny, opis procesu (Steps)

Vermietung – klasy, cennik, zapytanie

Transport – EU trasy, wycena A→B

Preisliste – 3–4 boxy cenowe, zastrzeżenia

Fahrzeuge – grid CPT, filtry podstawowe

Kontakt – mapa, NAP, godziny, formularz, CTA „Jetzt anrufen (24/7)”

FAQ – akordeon + schema

Über uns – E-E-A-T, zaufanie, zdjęcie zespołu (placeholder)

Blog – news/porady

17) Playbooki

Nowa sekcja hero na stronie:

W edytorze → blok Hero (pablo/hero)

Ustaw: headline, subheadline, primary/secondary CTA, badge

Zapisz i sprawdź kontrast (biały na navy)

Dodanie FAQ:

Strona /faq/ → blok FAQ

Wpisz pytania/odpowiedzi → publikuj

Zweryfikuj FAQPage w testerze wyników rozszerzonych

Dodanie pojazdu:

Fahrzeuge → Dodaj nowy

Uzupełnij ACF (cena, rok, przebieg, paliwo, skrzynia, moc, VIN), taksonomie

Miniaturka + galeria → publikuj

18) Recovery / troubleshooting

Menu mobilne nie działa → sprawdź assets/js/menu.js i data-nav-toggle, data-primary-nav w header.php

Formularz zwraca 403 → nonce w inc/forms.php i wp_localize_script (pablo_gp_form_data)

Brak schemy → upewnij się, że inc/schema.php jest wczytane i hook w wp_head

CLS > 0.1 → zdefiniuj wymiary <img>, unikaj layout shift w hero/na nav

LCP > 2.5s → zoptymalizuj hero (obraz tła?), włącz HTTP/2 push/early hints jeśli możliwe

19) Granice i priorytety

Minimalne wtyczki (ACF + cache + ew. SEO).

Brak builderów.

Wszystko musi być edytowalne w Gutenbergu lub prostych blokach/shortcodach.

Najpierw A11y i wydajność; potem „ładne efekty”.

20) Definicja „gotowe do release”

✅ Wszystkie pliki motywu obecne i bez błędów PHP (error_log czysty)

✅ Lighthouse Mobile ≥ 90; LCP/CLS/INP w budżecie

✅ axe: brak blockerów/critical issues

✅ Schema i hreflang przechodzą walidację

✅ Formularze dostarczają maile i logują wpisy

✅ Menu, strony i CPT skonfigurowane; 10 pojazdów demo

✅ README.md uzupełniony (instalacja, wymagane wtyczki, ACF JSON)

21) Kontakt/brand dane (placeholdery do podmiany)

Nazwa: Autohandel & Abschleppdienst Pablo E.U.

Adres: Triester Straße 55, 8020 Graz, AT

ATU: (uzupełnić prawidłowy)

Telefon 24/7: +43 664 1261735

E-mail: office@abschlepp-pablo.at

Agent SEO: upewnij się, że NAP spójny w stopce, /kontakt i w LocalBusiness schema.
