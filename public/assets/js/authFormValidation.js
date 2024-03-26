const validationRules = {
  email: {
    pattern: /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,3}$/,
    message: "Invalid email format",
  },
  username: { min: 3, max: 20, message: "Username must be 3-20 characters" },
  password: { min: 8, max: 16, message: "Password must be 8-16 characters" },
  currentPassword: { min: 8, max: 16, message: "Current password must be 8-16 characters" },
  newPassword: { min: 8, max: 16, message: "New password must be 8-16 characters" },
  confirmPassword: { message: "Passwords do not match" },
  fullName: {
    pattern: /^[a-zA-Z]{3,50} [a-zA-Z]{3,50}$/,
    message: "Full name must be 3-50 characters and contain first name and last name"
  },
  title: { min: 10, max: 150, message: "Title must be 10-150 characters" },
  description: {
    min: 10,
    max: 550,
    message: "Description must be 10-550 characters",
  },
  bio: { min: 0, max: 150, message: "Bio must be less than 150 characters" },
  subject: { min: 3, max: 50, message: "Subject must be 3-50 characters" },
  classFaculty: {
    min: 3,
    max: 15,
    message: "Class faculty must be 3-15 characters",
  },
  author: { min: 3, max: 25, message: "Author must be 3-25 characters" },
  url: {
    pattern: /^(http|https):\/\/[^ "]+$/,
    message: "Invalid URL format",
  },
  phoneNumber: {
    pattern: /^\d{10}$/,
    message: "Invalid phone number format (10 digits)",
  },
  enrolledCourse: {
    min: 3,
    max: 15,
    message: "Enrolled course must be 3-15 characters",
  },
  school: { min: 3, max: 50, message: "School name must be 3-50 characters" },
  email_username: {
    message: "Invalid email or username",
  },
};

const forms = document.querySelectorAll("form");

forms.forEach((form) => {
  form.addEventListener("submit", (e) => {
    e.preventDefault();
    const inputs = form.querySelectorAll("input");
    const textareas = form.querySelectorAll("textarea");

    inputs.forEach((input) => {
      validateInput(input);
    });

    textareas.forEach((textarea) => {
      validateInput(textarea);
    });

    if (form.querySelector(".form-error")) {
      return;
    }

    form.submit();
  });
});

const inputs = document.querySelectorAll("input");
const textareas = document.querySelectorAll("textarea");

inputs.forEach((input) => {
  input.addEventListener("blur", () => {
    validateInput(input);
  });
});

textareas.forEach((textarea) => {
  textarea.addEventListener("blur", () => {
    validateInput(textarea);
  });
});

function validateInput(input) {
  const id = input.id;
  const value = input.value.trim();
  const rules = validationRules[id];

  if (!rules) return;

  let isValid;

  if (id === "confirmPassword") {
    isValid = isValidConfirmPassword(value);
  } else if (id === "email_username") {
    isValid = isValidEmail(value) || isValidUsername(value);
  } else {
    isValid = validate(value, rules);
  }

  isValid ? showSuccess(input) : showError(input);
}

function isValidConfirmPassword(value) {
  const password = document.querySelector('#password')?.value || document.querySelector('#newPassword')?.value;
  return value === password;
}

function validate(value, rules) {
  if (rules.pattern) {
    return rules.pattern.test(value);
  } else {
    return value.length >= rules.min && value.length <= rules.max;
  }
}

function isValidEmail(value) {
  return validationRules.email.pattern.test(value);
}

function isValidUsername(value) {
  return value.length >= validationRules.username.min && value.length <= validationRules.username.max;
}

function showError(input) {
  const message = validationRules[input.id].message;

  input.style.borderColor = "red";
  input.style.color = "red";

  // Remove existing error message if any
  const existingErrorMessage = input.parentNode.querySelector('.form-error');
  if (existingErrorMessage) {
    existingErrorMessage.remove();
  }

  // Display error message
  input.insertAdjacentHTML("afterend", `<span class="form-error">${message}</span>`);
}

function showSuccess(input) {
  input.style.borderColor = "initial";
  input.style.color = "initial";
  // Remove existing error message if any
  const existingErrorMessage = input.parentNode.querySelector('.form-error');
  if (existingErrorMessage) {
    existingErrorMessage.remove();
  }
}
