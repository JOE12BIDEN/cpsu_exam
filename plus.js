
function toggleCheckbox(checkboxId) {
    var checkbox = document.getElementById(checkboxId);
    checkbox.style.display = (checkbox.style.display === 'none' || checkbox.style.display === '') ? 'block' : 'none';
}
