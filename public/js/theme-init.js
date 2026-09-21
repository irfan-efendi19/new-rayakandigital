(() => {
    const root = document.documentElement;
    let savedTheme = null;

    try {
        savedTheme = localStorage.getItem('dark-mode');
    } catch (_) {
        // Private browsing or blocked storage should still respect the OS preference.
    }

    const dark = savedTheme === 'true'
        || (savedTheme === null && window.matchMedia('(prefers-color-scheme: dark)').matches);

    root.classList.toggle('dark', dark);
    root.style.colorScheme = dark ? 'dark' : 'light';
})();
