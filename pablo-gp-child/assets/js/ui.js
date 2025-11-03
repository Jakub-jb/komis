(function(){
const faqButtons = () => {
document.querySelectorAll('.faq__trigger').forEach((button) => {
button.addEventListener('click', () => {
const expanded = 'true' === button.getAttribute('aria-expanded');
button.setAttribute('aria-expanded', String(! expanded));
const panel = document.getElementById(button.getAttribute('aria-controls'));
if (panel) {
panel.toggleAttribute('hidden', expanded);
}
});
});
};

document.addEventListener('DOMContentLoaded', faqButtons);
})();
