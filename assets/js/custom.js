$('.navbar-nav>li>a').on('click', function(){
  $('.navbar-collapse').collapse('hide');
});

const gkey = 'gvil xabh gguw whnw';

const form = document.querySelector('#contact-form')
const toast = document.getElementById('toast');
const toastTitle = document.getElementById('toast-title');
const toastMessage = document.getElementById('toast-message');

function showToast(title, message, titleClass) {
  // Update toast content
  toastTitle.textContent = title;
  toastTitle.className = `me-auto ${titleClass}`;
  toastMessage.textContent = message;

  // Show toast
  const bootstrapToast = new bootstrap.Toast(toast);
  bootstrapToast.show();
}

form.addEventListener('submit', async function(e){
  e.preventDefault();
  const formData = new FormData(form);

  try {
    // Send data via fetch
    const response = await fetch('mail.php', {
      method: 'POST',
      body: formData
    });

    // Handle the response
    if (response.ok) {
      const result = await response.json();
      showToast('Correcto', 'Su mensaje ha sido enviado', 'text-success');
      form.reset();
    } else {
      const error = await response.json();
      showToast('Error', 'El servicio de correo se encuentra temporalmente fuera de servicio', 'text-danger');
    }
  } catch (err) {
    console.error('Fetch error:', err);
    alert('An error occurred while sending the form.');
  }
})