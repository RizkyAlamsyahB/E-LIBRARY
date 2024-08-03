
  const THEME_KEY = "theme";

  /**
   * Set theme for the document
   * @param {"dark"|"light"} theme
   * @param {boolean} persist - Whether to persist the theme in localStorage
   */
  function setTheme(theme, persist = false) {
      document.documentElement.setAttribute("data-bs-theme", theme);

      if (persist) {
          localStorage.setItem(THEME_KEY, theme);
      }
  }

  /**
   * Update logo src based on the current theme
   */
  function updateLogo() {
      const theme = document.documentElement.getAttribute('data-bs-theme');
      const logo = document.getElementById('logo');

      if (logo) {
          const logoDark = logo.getAttribute('data-logo-dark');
          const logoLight = logo.getAttribute('data-logo-light');

          logo.src = (theme === 'dark') ? logoDark : logoLight;
      }
  }

  /**
   * Initialize theme based on localStorage or default to system preference
   */
  function initTheme() {
      const storedTheme = localStorage.getItem(THEME_KEY);

      if (storedTheme) {
          // Apply stored theme
          setTheme(storedTheme);
      } else {
          // Apply system preference if no theme is stored
          const prefersDark =
              window.matchMedia &&
              window.matchMedia("(prefers-color-scheme: dark)").matches;
          setTheme(prefersDark ? "dark" : "light", true);
      }

      // Update logo after setting the theme
      updateLogo();
  }

  window.addEventListener("DOMContentLoaded", () => {
      initTheme();

      const toggler = document.getElementById("toggle-dark");
      if (toggler) {
          // Set initial toggle state based on theme
          toggler.checked =
              document.documentElement.getAttribute("data-bs-theme") === "dark";

          toggler.addEventListener("input", (e) => {
              setTheme(e.target.checked ? "dark" : "light", true);
              updateLogo();
          });
      }
  });

