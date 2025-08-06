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
    // MutationObserver to wait for closeBtn to appear
    const observer = new MutationObserver(() => {
        if (closeBtn) {
            closeBtn.remove(); // remove it once found
            observer.disconnect();
        }
    });

    observer.observe(document.body, {
        childList: true,
        subtree: true,
    });

    // Replace default hamburger icon
    if (openBtnIcon) {
        openBtnIcon.remove();
        openBtn.appendChild(createHamburgerIcon());
    }

    // Toggle navigation visibility
    openBtn.addEventListener("click", function (e) {
        e.stopPropagation();
        openBtn.classList.toggle("toggled");

        const isOpen = navContainer.classList.toggle("has-modal-open");
        navContainer.classList.toggle("is-menu-open", isOpen);

        // Force enable scrolling
        document.body.style.overflow = "auto";
    });

    // Close menu when click outside the nav container
    document.addEventListener("click", function (e) {
        if (!navContainer.contains(e.target) && !openBtn.contains(e.target)) {
            navContainer.classList.remove("has-modal-open", "is-menu-open");
            openBtn.classList.remove("toggled");
            document.body.style.overflow = "auto";
        }
    });
});
