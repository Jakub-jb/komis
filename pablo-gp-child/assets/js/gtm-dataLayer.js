window.dataLayer = window.dataLayer || [];
window.dataLayer.push({
event: 'theme_loaded',
timestamp: Date.now()
});

document.addEventListener('click', (event) => {
const target = event.target.closest('[data-gtm]');
if (!target) {
return;
}

window.dataLayer.push({
event: 'cta_click',
action: target.dataset.gtm,
label: target.textContent.trim()
});
});
