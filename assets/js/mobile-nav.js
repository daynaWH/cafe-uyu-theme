document.addEventListener("DOMContentLoaded", function () {
    const openBtn = document.querySelector(
        ".wp-block-navigation__responsive-container-open"
    );
    const openBtnIcon = document.querySelector(
        ".wp-block-navigation__responsive-container-open svg"
    );
    const closeBtn = document.querySelector(
        ".wp-block-navigation__responsive-container-close"
    );
    const navContainer = document.querySelector(
        ".wp-block-navigation__responsive-container"
    );

    // Create new hamburger icon
    function createHamburgerIcon() {
        const hamburgerIcon = document.createDocumentFragment();
        for (let i = 0; i < 3; i++) {
            const navLine = document.createElement("span");
            navLine.classList.add("nav-line");
            hamburgerIcon.appendChild(navLine);
        }
        return hamburgerIcon;
    }

    // Remove default close button from DOM and replace the hamburger icon
    closeBtn.remove();
    openBtnIcon.remove();
    openBtn.appendChild(createHamburgerIcon());

    // Toggle navigation visibility
    openBtn.addEventListener("click", function () {
        openBtn.classList.toggle("toggled");

        if (navContainer.classList.contains("has-modal-open")) {
            navContainer.classList.remove("has-modal-open", "is-menu-open");
        } else {
            navContainer.classList.add("has-modal-open", "is-menu-open");
        }
    });
});
