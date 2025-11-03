(function(){
const handleSubmit = async (event) => {
event.preventDefault();
const form = event.target;
const status = form.querySelector('[data-form-status]');

const data = Array.from(new FormData(form)).reduce((acc, [key, value]) => {
acc[key] = value;
return acc;
}, {});

data.nonce = (window.pabloForms && window.pabloForms.nonce) ? window.pabloForms.nonce : '';

try {
const response = await fetch(`${window.pabloForms.endpoint}${form.dataset.formSlug}`, {
method: 'POST',
headers: { 'Content-Type': 'application/json' },
body: JSON.stringify(data)
});

const result = await response.json();

if (result.success) {
status.textContent = window.pabloForms.success;
status.className = 'form-status form-status--success';
form.reset();
window.dataLayer = window.dataLayer || [];
window.dataLayer.push({ event: 'form_submit', form_slug: form.dataset.formSlug });
} else {
status.textContent = result.message || window.pabloForms.error;
status.className = 'form-status form-status--error';
}
} catch (error) {
status.textContent = window.pabloForms.error;
status.className = 'form-status form-status--error';
}
};

document.addEventListener('DOMContentLoaded', () => {
document.querySelectorAll('[data-form-slug]').forEach((form) => {
form.addEventListener('submit', handleSubmit);
});
});
})();
