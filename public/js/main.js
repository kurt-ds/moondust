// header
const header = document.querySelector(".header");

if (header) {
  const userButton = document.querySelector(".header-user");
  const userAuth = document.querySelector(".header-user__auth");

  userButton.addEventListener("click", () => {
    userAuth.classList.toggle("--active");
  });
}
