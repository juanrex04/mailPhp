const form = document.getElementById("form");
const username = document.getElementById("username");
const email = document.getElementById("email");
const textarea = document.getElementById("textarea");
const send = document.getElementById("send");

form.addEventListener("submit", (e) => {
  e.preventDefault();
  e.stopPropagation();

  const dataForm = new FormData(form);

  /*Valida si hay espacios en los inputs, si esta vacio o
  con espacios en blancos solo*/

  if (!dataForm.get("name").trim()) {
    inputsError(username);
    return;
  } else {
    inputsValid(username);
  }

  if (!dataForm.get("mail").trim()) {
    inputsError(email);
    return;
  } else {
    inputsValid(email);
  }

  if (!dataForm.get("message").trim()) {
    inputsError(textarea);
    return;
  } else {
    inputsValid(textarea);
  }

  fetch("./php/formulario.php", {
    method: "POST",
    body: dataForm,
  })
    .then((res) => res.json())
    .then((data) => {

      if (data.error && data.input === "name") {
        inputsError(username);
        return;
      }
      inputsValid(username);

      if (data.error && data.input === "mail") {
        inputsError(email);
        return;
      }
      inputsValid(email);

      if (data.error && data.input === "message") {
        inputsError(textarea);
        return;
      }
      inputsValid(textarea);

      if (!data.error) {
        cleanForm();
        inputsValid(send);
      }
    })
    .catch((e) => console.log(e));
});

//Funciones validar si hay texto en los inputs
const inputsError = (input) => {
  input.classList.add("is-invalid");
  input.classList.remove("is-valid");
};

const inputsValid = (input) => {
  input.classList.add("is-valid");
  input.classList.remove("is-invalid");
};

const cleanForm = () => {
  form.reset();
  removeClass();
};

const removeClass = () => {
  username.classList.remove("is-valid");
  email.classList.remove("is-valid");
  textarea.classList.remove("is-valid");
};
