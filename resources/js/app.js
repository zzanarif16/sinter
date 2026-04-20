import "./bootstrap";

function initNavbarScrollOpacity() {
    const navbar = document.querySelector("[data-site-navbar]");

    if (!navbar) {
        return;
    }

    const updateScrolledState = () => {
        navbar.classList.toggle("is-scrolled", window.scrollY > 16);
    };

    updateScrolledState();

    window.addEventListener("scroll", updateScrolledState, {
        passive: true,
    });
}

function initMobileNavbar() {
    const toggleButton = document.querySelector("[data-nav-toggle]");
    const mobileNavRoot = document.querySelector("[data-mobile-nav-root]");
    const mobileDrawer = document.querySelector("[data-mobile-nav]");
    const mobileBackdrop = document.querySelector("[data-mobile-nav-backdrop]");
    const closeButton = document.querySelector("[data-mobile-nav-close]");

    if (!toggleButton || !mobileNavRoot || !mobileDrawer || !mobileBackdrop) {
        return;
    }

    let isOpen = false;

    const onEscapeKey = (event) => {
        if (event.key === "Escape") {
            closeMenu();
        }
    };

    const closeMenu = () => {
        if (!isOpen) {
            return;
        }

        isOpen = false;
        toggleButton.setAttribute("aria-expanded", "false");
        document.body.classList.remove("overflow-hidden");
        mobileBackdrop.classList.add("opacity-0");
        mobileDrawer.classList.add("translate-x-full");
        document.removeEventListener("keydown", onEscapeKey);

        window.setTimeout(() => {
            if (!isOpen) {
                mobileNavRoot.classList.add("hidden");
            }
        }, 300);
    };

    const openMenu = () => {
        if (isOpen) {
            return;
        }

        isOpen = true;
        mobileNavRoot.classList.remove("hidden");
        document.body.classList.add("overflow-hidden");
        toggleButton.setAttribute("aria-expanded", "true");
        requestAnimationFrame(() => {
            mobileBackdrop.classList.remove("opacity-0");
            mobileDrawer.classList.remove("translate-x-full");
        });
        document.addEventListener("keydown", onEscapeKey);
    };

    toggleButton.addEventListener("click", () => {
        const isExpanded =
            toggleButton.getAttribute("aria-expanded") === "true";

        if (isExpanded) {
            closeMenu();
            return;
        }

        openMenu();
    });

    mobileDrawer.querySelectorAll("[data-mobile-nav-link]").forEach((link) => {
        link.addEventListener("click", closeMenu);
    });

    mobileBackdrop.addEventListener("click", closeMenu);

    if (closeButton) {
        closeButton.addEventListener("click", closeMenu);
    }

    window.addEventListener("resize", () => {
        if (window.innerWidth >= 768) {
            closeMenu();
        }
    });
}

function initSiteUi() {
    initNavbarScrollOpacity();
    initMobileNavbar();
}

if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initSiteUi);
} else {
    initSiteUi();
}
