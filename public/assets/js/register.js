const steps = document.querySelectorAll('.form-step');
const indicators = document.querySelectorAll('.step-indicator span');
const nextBtns = document.querySelectorAll('.nextBtn');
const prevBtns = document.querySelectorAll('.prevBtn');
const submitBtn = document.getElementById('submitBtn');

let current = 0;

function updateStep() {
    steps.forEach((step, i) => {
        step.classList.toggle('active', i === current);
        indicators[i].classList.toggle('active', i <= current);
    });
}


function validateStep(stepIndex) {
    const inputs = steps[stepIndex].querySelectorAll(
        'input:not([type="file"]):not([type="checkbox"]), textarea, select'
    );

    for (let input of inputs) {
        if (input.value.trim() === "") {
            input.classList.add('is-invalid');
            return false;
        } else {
            input.classList.remove('is-invalid');
        }
    }
    return true;
}


nextBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        if (validateStep(current)) {
            current++;
            updateStep();
        }
    });
});


prevBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        current--;
        updateStep();
    });
});


const finalCheckboxes = document.querySelectorAll(
    '.form-step:last-child input[type="checkbox"]'
);

finalCheckboxes.forEach(cb => {
    cb.addEventListener('change', () => {
        submitBtn.disabled = !Array.from(finalCheckboxes).every(c => c.checked);
    });
});


document.getElementById('businessForm').addEventListener('submit', function(e) {
    if (submitBtn.disabled) {
        e.preventDefault();
    }
});
