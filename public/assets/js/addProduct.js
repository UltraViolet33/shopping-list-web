const recurent_checkbox = document.querySelector("#recurent");

const stockActual_input = document.querySelector("#stockActual");
const stockMin_input = document.querySelector("#stockMin");

recurent_checkbox.addEventListener("change", function () {
  if (recurent_checkbox.checked) {
    stockActual_input.disabled = true;
    stockMin_input.disabled = true;
  } else {
    stockActual_input.disabled = false;
    stockMin_input.disabled = false;
  }
});
