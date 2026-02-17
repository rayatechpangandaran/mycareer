document.addEventListener('DOMContentLoaded', function () {
const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
tooltipTriggerList.forEach(function (tooltipTriggerEl) {
    new bootstrap.Tooltip(tooltipTriggerEl);
});
});
document.addEventListener('click', function(e) {
  const toggle = e.target.closest('.toggle-password');
  if (!toggle) return;

  const targetId = toggle.dataset.target;
  const input = document.getElementById(targetId);
  const icon = toggle.querySelector('i');

  if (!input || !icon) return;

  if (input.type === 'password') {
    input.type = 'text';
    icon.classList.remove('fa-eye');
    icon.classList.add('fa-eye-slash');
  } else {
    input.type = 'password';
    icon.classList.remove('fa-eye-slash');
    icon.classList.add('fa-eye');
  }
});

const generateBtn = document.getElementById('generatePasswordBtn');
generateBtn.addEventListener('click', function() {
  const passwordInput = document.getElementById('passwordReg');
  const repeatInput = document.getElementById('repeatPasswordReg');

  const randomPass = generateRandomPassword(12); 
  passwordInput.value = randomPass;
  repeatInput.value = randomPass;

  
  document.getElementById('passwordRegError').textContent = '';
  document.getElementById('repeatPasswordRegError').textContent = '';
});


function generateRandomPassword(length = 12){
  const chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+[]{}|;:,.<>?";
  let password = "";
  for(let i=0; i<length; i++){
    password += chars.charAt(Math.floor(Math.random() * chars.length));
  }
  return password;
}
const registerForm = document.querySelector('#registerPelamarModal form');

registerForm.addEventListener('submit', function(e) {
    e.preventDefault();

    const password = document.getElementById('passwordReg');
    const repeat = document.getElementById('passwordRepeatReg');

    const passwordError = document.getElementById('passwordRegError');
    const repeatError = document.getElementById('repeatPasswordRegError');

    passwordError.textContent = '';
    repeatError.textContent = '';

    let valid = true;

    if(password.value.length < 8){
        passwordError.textContent = 'Password minimal 8 karakter.';
        valid = false;
    }

    if(password.value !== repeat.value){
        repeatError.textContent = 'Password tidak cocok.';
        valid = false;
    }

    if(valid){
        registerForm.submit(); 
    }
});
