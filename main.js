const inputs = document.querySelectorAll(".input");
const form = document.getElementById("login-form");

function addcl() {
    let parent = this.parentNode.parentNode;
    parent.classList.add("focus");
}

function remcl() {
    let parent = this.parentNode.parentNode;
    if (this.value === "") {
        parent.classList.remove("focus");
    }
}

function validateForm() {
    // Get form input values
    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;

    // Simple form validation
    if (username.trim() === "") {
        alert("Please enter your username.");
        return false;
    }
    
    if (password.trim() === "") {
        alert("Please enter your password.");
        return false;
    }
    
    return true;
}

inputs.forEach(input => {
    input.addEventListener("focus", addcl);
    input.addEventListener("blur", remcl);
});

form.addEventListener("submit", function(event) {
    if (!validateForm()) {
        event.preventDefault(); // Prevent form submission if validation fails
    }
});
