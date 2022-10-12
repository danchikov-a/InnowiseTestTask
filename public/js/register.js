function checkValidation() {
    let submitButton = document.getElementById("registerButton")

    submitButton.disabled = !(validateField("email")
        && validateField("name")
        && validateField("password"));
}

function validateField(fieldId) {
    let field = document.getElementById(fieldId);

    return field.checkValidity();
}
