var darkBtn = document.getElementById("dark-mode-btn")

function toggleDarkMode() {
    darkBtn.classList.toggle("dark-mode-on");
    document.body.classList.toggle("dark-theme");
}

  
darkBtn.onclick = toggleDarkMode;