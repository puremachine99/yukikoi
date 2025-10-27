import './bootstrap';
import './notifications';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
document.addEventListener('DOMContentLoaded', function () {
    const themeToggleBtn = document.getElementById('theme-toggle');
    const darkIcon = document.getElementById('theme-toggle-dark-icon');
    const lightIcon = document.getElementById('theme-toggle-light-icon');

    // Skip theme toggle wiring on pages that don't include the controls.
    if (!themeToggleBtn || !darkIcon || !lightIcon) {
        return;
    }

    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const storedTheme = typeof localStorage !== 'undefined' ? localStorage.getItem('theme') : null;

    // Load initial theme
    if (storedTheme === 'dark' || (!storedTheme && prefersDark)) {
        document.documentElement.classList.add('dark');
        darkIcon.classList.remove('hidden');
    } else {
        document.documentElement.classList.remove('dark');
        lightIcon.classList.remove('hidden');
    }

    themeToggleBtn.addEventListener('click', function () {
        darkIcon.classList.toggle('hidden');
        lightIcon.classList.toggle('hidden');

        const isDark = document.documentElement.classList.toggle('dark');
        if (typeof localStorage !== 'undefined') {
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
        }
    });
});
