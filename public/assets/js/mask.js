function Mask(input) {
    let value = input.value.replace(/\D/g, '');
    if (value.length > 11) value = value.slice(0, 11);

    let formatted = '';
    if (value.length > 0) {
        if (value[0] === '7' || value[0] === '8') {
            formatted = '+7 ';
            value = value.slice(1);
        } else {
            formatted = '+7 ';
        }

        if (value.length > 0) {
            formatted += value.slice(0, 3);
            if (value.length > 3) {
                formatted += ' ' + value.slice(3, 6);
                if (value.length > 6) {
                    formatted += ' ' + value.slice(6, 8);
                    if (value.length > 8) {
                        formatted += ' ' + value.slice(8, 10);
                    }
                }
            }
        }
    }

    input.value = formatted;
}

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('input[type="tel"]').forEach(input => {
        input.addEventListener('input', function() { Mask(this); });
        
        input.addEventListener('focus', function() {
            if (this.value === '') {
                this.value = '+7 ';
            }
        });
    });
});