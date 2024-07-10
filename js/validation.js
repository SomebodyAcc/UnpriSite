document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector("form");
  form.addEventListener("submit", function (event) {
    const password = form.querySelector('input[name="pswrd"]').value;
    const confirmPassword = form.querySelector('input[name="confirm_password"]').value;
    const error = form.querySelector(".error");

    if (password !== confirmPassword) {
      event.preventDefault();
      error.textContent = "Password dan konfirmasi password tidak cocok.";
    }
  });
});
