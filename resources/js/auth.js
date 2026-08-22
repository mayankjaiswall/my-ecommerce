function clearFieldErrors(form) {
    form.querySelectorAll('.is-invalid').forEach((el) => el.classList.remove('is-invalid'));
    form.querySelectorAll('[data-field-error]').forEach((el) => {
        el.textContent = '';
    });
}

function showFieldErrors(form, errors) {
    Object.keys(errors).forEach((field) => {
        const input = form.querySelector(`[name="${field}"]`);
        const errorEl = form.querySelector(`[data-field-error="${field}"]`);

        if (input) {
            input.classList.add('is-invalid');
        }

        if (errorEl) {
            errorEl.textContent = errors[field][0];
        }
    });
}

function showGeneralError(form, message) {
    const alertEl = form.querySelector('[data-auth-general-error]');
    if (!alertEl) return;
    alertEl.textContent = message;
    alertEl.classList.remove('d-none');
}

function hideGeneralError(form) {
    const alertEl = form.querySelector('[data-auth-general-error]');
    if (!alertEl) return;
    alertEl.textContent = '';
    alertEl.classList.add('d-none');
}

function setSubmitting(form, submitting) {
    const btn = form.querySelector('button[type="submit"]');
    if (!btn) return;

    if (submitting) {
        btn.dataset.originalText = btn.dataset.originalText || btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = 'Please wait&hellip;';
    } else {
        btn.disabled = false;
        if (btn.dataset.originalText) {
            btn.innerHTML = btn.dataset.originalText;
        }
    }
}

function messageForStatus(status) {
    switch (status) {
        case 401:
            return 'The provided credentials are incorrect.';
        case 403:
            return 'You are not authorized to perform this action.';
        case 419:
            return 'Your session has expired. Please refresh the page and try again.';
        case 429:
            return 'Too many attempts. Please wait a moment and try again.';
        default:
            return 'Something went wrong. Please try again.';
    }
}

async function handleAuthSubmit(form, endpoint, payload) {
    hideGeneralError(form);
    clearFieldErrors(form);
    setSubmitting(form, true);

    try {
        await window.axios.get('/sanctum/csrf-cookie');
        await window.axios.post(endpoint, payload);

        window.location.href = '/';
    } catch (error) {
        const status = error.response ? error.response.status : null;
        const data = error.response ? error.response.data : null;

        if (status === 422 && data && data.errors) {
            showFieldErrors(form, data.errors);
        } else if (data && data.message) {
            showGeneralError(form, data.message);
        } else {
            showGeneralError(form, messageForStatus(status));
        }

        setSubmitting(form, false);
    }
}

function initLoginForm() {
    const form = document.querySelector('[data-auth-form="login"]');
    if (!form) return;

    form.addEventListener('submit', (event) => {
        event.preventDefault();

        handleAuthSubmit(form, '/api/login', {
            email: form.querySelector('#email').value,
            password: form.querySelector('#password').value,
            remember: form.querySelector('#remember') ? form.querySelector('#remember').checked : false,
        });
    });
}

function initRegisterForm() {
    const form = document.querySelector('[data-auth-form="register"]');
    if (!form) return;

    form.addEventListener('submit', (event) => {
        event.preventDefault();

        handleAuthSubmit(form, '/api/register', {
            name: form.querySelector('#name').value,
            email: form.querySelector('#email').value,
            password: form.querySelector('#password').value,
            password_confirmation: form.querySelector('#password-confirm').value,
        });
    });
}

document.addEventListener('DOMContentLoaded', () => {
    initLoginForm();
    initRegisterForm();
});
