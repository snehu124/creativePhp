document.addEventListener('DOMContentLoaded', function () {
  const dateInput = document.querySelector('.datepicker');
  if (dateInput) {
    $(dateInput).datepicker({ format: 'yyyy-mm-dd' });
  }

  // Add User
  document.getElementById('addUserForm').addEventListener('submit', async function (e) {
    e.preventDefault();
    const formData = new FormData(this);
    const response = await fetch('add_user.php', {
      method: 'POST',
      body: formData
    });
    const result = await response.text();
    showResult(result);
  });

  // Delete User
  document.getElementById('deleteUserForm').addEventListener('submit', async function (e) {
    e.preventDefault();
    const formData = new FormData(this);
    const response = await fetch('delete_user.php', {
      method: 'POST',
      body: formData
    });
    const result = await response.text();
    showResult(result);
  });

  function showResult(msg) {
    const resultDiv = document.getElementById('result');
    resultDiv.textContent = msg;
    resultDiv.classList.remove('d-none');
    setTimeout(() => resultDiv.classList.add('d-none'), 3000);
  }
});
