document.addEventListener('DOMContentLoaded', () => {
    const forms = document.querySelectorAll('.form-egreso');

    forms.forEach(form => {
        form.addEventListener('submit', e => {
            let formIsValid = true;

            const rucInput = form.querySelector('.ruc-input');
            const rucErrorDiv = form.querySelector('.ruc-error');

            rucErrorDiv.textContent = '';

            const rucValue = rucInput.value.trim();

            if (!/^\d{11}$/.test(rucValue)) {
                rucErrorDiv.textContent = 'El RUC debe tener exactamente 11 dígitos numéricos.';
                formIsValid = false;
            }

            if (!formIsValid) {
                e.preventDefault();
            }
        });
    });
});
