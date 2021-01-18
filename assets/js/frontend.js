(function () {

    const app = {

        init: () => {

            //return if wpDarkMode is undefined or the page is excluded
            if (wpDarkMode.is_excluded) {
                return;
            }

            //return if elementor editor
            if (typeof elementor !== 'undefined') {
                return;
            }

            //handle includes
            if ('' !== wpDarkMode.includes) {
                app.handleIncludes();
            }

            //handle excludes
            app.handleExcludes();

            //on the initialize darkmode
            app.initDarkmode();

            //check OS mode
            if (wpDarkMode.enable_os_mode && localStorage.getItem('wp_dark_mode_active') != 0) {
                app.checkOsMode();
            }

            //handle switch click
            document.querySelectorAll('.wp-dark-mode-switcher').forEach(switcher => {
                switcher.addEventListener('click', app.handleToggle);
            });


            window.addEventListener('wp_dark_mode', function (e) {
                const active = e.detail.active;

                if (active) {

                    if (!app.isEnabled()) {
                        app.enable();
                    }

                    document.querySelectorAll('.wp-dark-mode-switcher').forEach((switcher) => switcher.classList.add('active'));
                } else {
                    app.disable();

                    document.querySelectorAll('.wp-dark-mode-switcher').forEach((switcher) => switcher.classList.remove('active'));
                }

            });

        },

        initDarkmode: function () {

            //const is_saved = sessionStorage.getItem('wp_dark_mode_frontend');
            const is_saved = localStorage.getItem('wp_dark_mode_active');

            if ((is_saved && is_saved != 0) || (!is_saved && wpDarkMode.default_mode)) {
                document.querySelector('html').classList.add('wp-dark-mode-active');

                app.enable();

                document.querySelectorAll('.wp-dark-mode-switcher').forEach((switcher) => switcher.classList.add('active'));
            }
        },

        handleToggle: function () {

            const html = document.querySelector('html');
            html.classList.toggle('wp-dark-mode-active');

            const is_saved = html.classList.contains('wp-dark-mode-active') ? 1 : 0;

            sessionStorage.setItem('wp_dark_mode_frontend', is_saved);
            localStorage.setItem('wp_dark_mode_active', is_saved);

            window.dispatchEvent(new CustomEvent('wp_dark_mode', {detail: {active: is_saved}}));
        },

        /**
         * enable the darkmode
         */
        enable: () => {
            const {config: {brightness, contrast, sepia}} = wpDarkMode;

            DarkReader.enable({
                brightness,
                contrast,
                sepia
            });
        },

        disable: () => DarkReader.disable(),

        isEnabled: () => DarkReader.enabled,

        checkOsMode: function () {
            const darkMediaQuery = window.matchMedia('(prefers-color-scheme: dark)');

            //set darkmode
            if (darkMediaQuery.matches) {
                app.enable();
            }

            //watch changes
            try {
                // Chrome & Firefox
                darkMediaQuery.addEventListener('change', function (e) {
                    const newColorScheme = e.matches ? 'dark' : 'light';
                    window.dispatchEvent(new CustomEvent('wp_dark_mode', {detail: {active: 'dark' === newColorScheme}}));
                });
            } catch (e1) {
                try {
                    // Safari
                    darkMediaQuery.addListener(function (e) {
                        const newColorScheme = e.matches ? 'dark' : 'light';
                        window.dispatchEvent(new CustomEvent('wp_dark_mode', {detail: {active: 'dark' === newColorScheme}}));
                    });
                } catch (e2) {
                    console.error(e2);
                }

            }
        },

        handleExcludes: function () {

            if ('' === wpDarkMode.excludes) {
                return;
            }

            const elements = document.querySelectorAll(wpDarkMode.excludes);

            elements.forEach((element) => {
                element.classList.add('wp-dark-mode-ignore');
                const children = element.querySelectorAll('*');

                children.forEach((child) => {
                    child.classList.add('wp-dark-mode-ignore');
                })
            });
        },

        handleIncludes: function () {

            const elements = document.querySelectorAll(wpDarkMode.includes);

            elements.forEach((element) => {
                element.classList.add('wp-dark-mode-include');
                const children = element.querySelectorAll('*');

                children.forEach((child) => {
                    child.classList.add('wp-dark-mode-include');
                })
            });
        },

    };

    document.addEventListener('DOMContentLoaded', app.init);

})();

//check if main element
window.wp_dark_mode_is_main_element = (tagName) => {
    const elements = [
        'MARK',
        'CODE',
        'PRE',
        'INS',
        'OPTION',
        'INPUT',
        'SELECT',
        'TEXTAREA',
        'BUTTON',
        'A',
        'VIDEO',
        'CANVAS',
        'PROGRESS',
        'IFRAME',
        'SVG',
        'PATH',
    ];

    return !elements.includes(tagName);

};