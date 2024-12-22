function toggleSection(targetId) {
    const targetElement = document.getElementById(targetId);

    if (targetElement) {
        targetElement.classList.toggle("open");

        // Mémoriser l'état dans le localStorage
        if (targetElement.classList.contains("open")) {
            localStorage.setItem(targetId, "open");
        } else {
            localStorage.removeItem(targetId);
        }
    }
}
