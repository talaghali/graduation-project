/**
 * Global JavaScript for Voices of Gaza
 * Handles common functionality and prevents errors
 */

// Wait for DOM to be ready
document.addEventListener('DOMContentLoaded', function() {

    // Initialize Bootstrap dropdowns
    initializeDropdowns();

    // Fix navbar active states
    fixNavbarActiveStates();

    // Add smooth scroll behavior
    enableSmoothScroll();
});

/**
 * Initialize Bootstrap Dropdowns
 */
function initializeDropdowns() {
    const dropdownElements = document.querySelectorAll('[data-bs-toggle="dropdown"]');

    if (dropdownElements.length > 0 && typeof bootstrap !== 'undefined') {
        dropdownElements.forEach(element => {
            new bootstrap.Dropdown(element);
        });
    }
}

/**
 * Fix Navbar Active States
 * Excludes dropdown toggles from active state management
 */
function fixNavbarActiveStates() {
    const navLinks = document.querySelectorAll('.navbar-nav .nav-link:not(.dropdown-toggle)');

    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Only prevent default for hash links
            if (this.getAttribute('href') === '#' || this.getAttribute('href') === '') {
                e.preventDefault();
            }

            // Remove active from all links
            navLinks.forEach(l => l.classList.remove('active'));

            // Add active to clicked link
            this.classList.add('active');
        });
    });
}

/**
 * Enable Smooth Scroll
 */
function enableSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');

            // Only handle hash links that aren't just "#"
            if (href && href !== '#' && href.startsWith('#')) {
                const target = document.querySelector(href);

                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
    });
}

/**
 * Safe Element Selection
 * Returns null if element doesn't exist
 */
function safeSelect(selector) {
    try {
        return document.querySelector(selector);
    } catch (e) {
        console.warn(`Element not found: ${selector}`);
        return null;
    }
}

/**
 * Safe Element Selection (All)
 * Returns empty array if elements don't exist
 */
function safeSelectAll(selector) {
    try {
        const elements = document.querySelectorAll(selector);
        return elements.length > 0 ? elements : [];
    } catch (e) {
        console.warn(`Elements not found: ${selector}`);
        return [];
    }
}

// Export for use in other scripts
window.VoicesOfGaza = {
    safeSelect,
    safeSelectAll
};
