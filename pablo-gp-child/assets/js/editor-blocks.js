(function(wp){
const { registerBlockType } = wp.blocks;
const { __ } = wp.i18n;
const { Fragment } = wp.element;
const { InspectorControls, RichText, URLInputButton } = wp.blockEditor;
const { PanelBody, TextControl, TextareaControl, Button, Notice } = wp.components;

const blockDefinitions = {
'pablo/hero': {
title: __('Pablo Hero', 'pablo-gp'),
icon: 'megaphone',
category: 'pablo-blocks',
attributes: {
headline: { type: 'string', default: __('Abschleppdienst & Fahrzeughandel Pablo', 'pablo-gp') },
subheadline: { type: 'string', default: __('24/7 Abschleppen, EU-Transport, Ankauf & Vermietung – zuverlässig in Graz & europaweit.', 'pablo-gp') },
primaryCtaLabel: { type: 'string', default: __('Jetzt anrufen (24/7)', 'pablo-gp') },
primaryCtaUrl: { type: 'string', default: 'tel:+436641261735' },
secondaryCtaLabel: { type: 'string', default: __('Abschleppen bestellen', 'pablo-gp') },
secondaryCtaUrl: { type: 'string', default: '/kontakt/' },
badge: { type: 'string', default: __('Schnell vor Ort • Kartenzahlung • Rechnung/Firma', 'pablo-gp') }
}
},
'pablo/service-grid': {
title: __('Pablo Leistungen', 'pablo-gp'),
icon: 'grid-view',
category: 'pablo-blocks',
attributes: {
items: { type: 'array', default: [] }
}
},
'pablo/vehicle-grid': {
title: __('Pablo Fahrzeuggrid', 'pablo-gp'),
icon: 'car',
category: 'pablo-blocks',
attributes: {
postsToShow: { type: 'number', default: 6 },
categories: { type: 'array', default: [] },
marke: { type: 'array', default: [] }
}
},
'pablo/pricing-grid': {
title: __('Pablo Preistabelle', 'pablo-gp'),
icon: 'money-alt',
category: 'pablo-blocks',
attributes: {
plans: { type: 'array', default: [] }
}
},
'pablo/contact-cta': {
title: __('Pablo Kontakt CTA', 'pablo-gp'),
icon: 'phone',
category: 'pablo-blocks',
attributes: {
channels: { type: 'array', default: [] }
}
},
'pablo/steps': {
title: __('Pablo Schritte', 'pablo-gp'),
icon: 'list-view',
category: 'pablo-blocks',
attributes: {
steps: { type: 'array', default: [] },
contextual: { type: 'string', default: __('So funktioniert unser Abschleppdienst', 'pablo-gp') }
}
},
'pablo/faq': {
title: __('Pablo FAQ', 'pablo-gp'),
icon: 'editor-help',
category: 'pablo-blocks',
attributes: {
items: { type: 'array', default: [] }
}
},
'pablo/reviews': {
title: __('Pablo Bewertungen', 'pablo-gp'),
icon: 'star-filled',
category: 'pablo-blocks',
attributes: {
items: { type: 'array', default: [] }
}
},
'pablo/footer-cta': {
title: __('Pablo Footer CTA', 'pablo-gp'),
icon: 'feedback',
category: 'pablo-blocks',
attributes: {
headline: { type: 'string', default: __('Bereit, jetzt Hilfe zu bekommen?', 'pablo-gp') },
description: { type: 'string', default: __('Rufen Sie uns 24/7 an oder senden Sie ein kurzes Formular. Wir sind in Minuten auf dem Weg.', 'pablo-gp') },
ctaLabel: { type: 'string', default: __('Angebot anfordern', 'pablo-gp') },
ctaUrl: { type: 'string', default: '/kontakt/' }
}
}
};

const ListField = ({ items = [], onChange, labels }) => {
const addItem = () => onChange([ ...items, {} ]);
const updateItem = (index, key, value) => {
const updated = items.map((item, i) => (i === index ? { ...item, [key]: value } : item));
onChange(updated);
};
const removeItem = (index) => {
onChange(items.filter((_, i) => i !== index));
};

return wp.element.createElement(Fragment, {},
items.length === 0 && wp.element.createElement(Notice, { status: 'info', isDismissible: false }, __('Noch keine Einträge. Fügen Sie neue hinzu.', 'pablo-gp')),
items.map((item, index) => wp.element.createElement('div', { className: 'pablo-block-panel-list', key: index },
labels.map((field) => wp.element.createElement(TextControl, {
label: field.label,
value: item[field.key] || '',
onChange: (value) => updateItem(index, field.key, value)
})),
wp.element.createElement(Button, { isDestructive: true, onClick: () => removeItem(index) }, __('Entfernen', 'pablo-gp'))
)),
wp.element.createElement(Button, { variant: 'primary', onClick: addItem }, __('Eintrag hinzufügen', 'pablo-gp'))
);
};

Object.entries(blockDefinitions).forEach(([name, config]) => {
registerBlockType(name, {
...config,
supports: { align: false },
edit: (props) => {
const { attributes, setAttributes } = props;

const controls = [];

if (name === 'pablo/service-grid' || name === 'pablo/pricing-grid') {
controls.push(wp.element.createElement(ListField, {
items: attributes.items || attributes.plans || [],
onChange: (value) => setAttributes(name === 'pablo/service-grid' ? { items: value } : { plans: value }),
labels: [
{ key: 'title', label: __('Titel', 'pablo-gp') },
{ key: 'copy', label: __('Beschreibung', 'pablo-gp') },
{ key: 'cta', label: __('CTA Label', 'pablo-gp') },
{ key: 'url', label: __('Link', 'pablo-gp') },
]
}));
}

if (name === 'pablo/pricing-grid') {
controls.pop();
controls.push(wp.element.createElement(ListField, {
items: attributes.plans || [],
onChange: (value) => setAttributes({ plans: value }),
labels: [
{ key: 'label', label: __('Bezeichnung', 'pablo-gp') },
{ key: 'price', label: __('Preis', 'pablo-gp') },
{ key: 'description', label: __('Beschreibung', 'pablo-gp') },
{ key: 'cta', label: __('CTA Label', 'pablo-gp') },
{ key: 'url', label: __('Link', 'pablo-gp') },
]
}));
}

if (name === 'pablo/contact-cta') {
controls.push(wp.element.createElement(ListField, {
items: attributes.channels || [],
onChange: (value) => setAttributes({ channels: value }),
labels: [
{ key: 'label', label: __('Label', 'pablo-gp') },
{ key: 'value', label: __('Wert', 'pablo-gp') },
{ key: 'url', label: __('Link', 'pablo-gp') },
]
}));
}

if (name === 'pablo/steps') {
controls.push(wp.element.createElement(TextControl, {
label: __('Überschrift', 'pablo-gp'),
value: attributes.contextual,
onChange: (value) => setAttributes({ contextual: value })
}));
controls.push(wp.element.createElement(ListField, {
items: attributes.steps || [],
onChange: (value) => setAttributes({ steps: value }),
labels: [
{ key: 'title', label: __('Titel', 'pablo-gp') },
{ key: 'description', label: __('Beschreibung', 'pablo-gp') },
]
}));
}

if (name === 'pablo/faq') {
controls.push(wp.element.createElement(ListField, {
items: attributes.items || [],
onChange: (value) => setAttributes({ items: value }),
labels: [
{ key: 'question', label: __('Frage', 'pablo-gp') },
{ key: 'answer', label: __('Antwort', 'pablo-gp') },
]
}));
}

if (name === 'pablo/reviews') {
controls.push(wp.element.createElement(ListField, {
items: attributes.items || [],
onChange: (value) => setAttributes({ items: value }),
labels: [
{ key: 'name', label: __('Name', 'pablo-gp') },
{ key: 'rating', label: __('Bewertung (1-5)', 'pablo-gp') },
{ key: 'comment', label: __('Kommentar', 'pablo-gp') },
]
}));
}

if (name === 'pablo/footer-cta') {
controls.push(wp.element.createElement(TextControl, {
label: __('Headline', 'pablo-gp'),
value: attributes.headline,
onChange: (value) => setAttributes({ headline: value })
}));
controls.push(wp.element.createElement(TextareaControl, {
label: __('Beschreibung', 'pablo-gp'),
value: attributes.description,
onChange: (value) => setAttributes({ description: value })
}));
controls.push(wp.element.createElement(TextControl, {
label: __('CTA Label', 'pablo-gp'),
value: attributes.ctaLabel,
onChange: (value) => setAttributes({ ctaLabel: value })
}));
controls.push(wp.element.createElement(TextControl, {
label: __('CTA Link', 'pablo-gp'),
value: attributes.ctaUrl,
onChange: (value) => setAttributes({ ctaUrl: value })
}));
}

if (name === 'pablo/hero') {
controls.push(wp.element.createElement(TextControl, {
label: __('Badge', 'pablo-gp'),
value: attributes.badge,
onChange: (value) => setAttributes({ badge: value })
}));
controls.push(wp.element.createElement(TextControl, {
label: __('CTA URL', 'pablo-gp'),
value: attributes.primaryCtaUrl,
onChange: (value) => setAttributes({ primaryCtaUrl: value })
}));
controls.push(wp.element.createElement(TextControl, {
label: __('Sekundäre CTA URL', 'pablo-gp'),
value: attributes.secondaryCtaUrl,
onChange: (value) => setAttributes({ secondaryCtaUrl: value })
}));
}

const inspector = wp.element.createElement(InspectorControls, {}, wp.element.createElement(PanelBody, { title: __('Block Einstellungen', 'pablo-gp'), initialOpen: true }, controls));

let preview = null;

if (name === 'pablo/hero') {
preview = wp.element.createElement('div', { className: 'pablo-block-preview hero' },
wp.element.createElement('h2', null, attributes.headline),
wp.element.createElement('p', null, attributes.subheadline),
wp.element.createElement('div', { className: 'hero__actions' },
wp.element.createElement('span', { className: 'btn btn--accent' }, attributes.primaryCtaLabel),
wp.element.createElement('span', { className: 'btn btn--secondary' }, attributes.secondaryCtaLabel)
)
);
} else {
preview = wp.element.createElement('div', { className: 'pablo-block-placeholder' }, __('Vorderansicht im Frontend sichtbar.', 'pablo-gp'));
}

return wp.element.createElement(Fragment, {}, inspector, preview);
},
save: () => null
});
});
})(window.wp);
