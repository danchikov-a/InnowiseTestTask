const EXTENSION_PART = 1;
const EXTENSION_MISMATCH_MESSAGE = "Extension mismatch";
const FILE_ID = "file";
const VALID_EXTENSIONS = ["png", "jpg", "txt"];

function validateFile() {
    if (!validateExtension()) {
        let file = document.getElementById(FILE_ID);
        file.setCustomValidity(EXTENSION_MISMATCH_MESSAGE);

        return false;
    }

    return true;
}

function validateExtension() {
    let file = document.getElementById(FILE_ID);
    let filename = file.value;
    let extension = filename.split(".")[EXTENSION_PART];

    return VALID_EXTENSIONS.includes(extension);
}