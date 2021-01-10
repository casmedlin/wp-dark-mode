(function () {

    const app = {

        init: () => {

            //return if wpDarkModeFrontend is undefined or the page is excluded
            if (wpDarkModeFrontend.is_excluded) {
                return;
            }

            //return if elementor editor
            if (typeof elementor !== 'undefined') {
                return;
            }

            //handle includes
            if ('' !== wpDarkModeFrontend.includes) {
                app.handleIncludes();
            }

            //handle excludes
            app.handleExcludes();

            //on the initialize darkmode
            app.initDarkmode();

            //check OS mode
            if (typeof wpDarkModeAdmin === 'undefined') {

                if (sessionStorage.getItem('wp_dark_mode_frontend') != 0) {
                    app.checkOsMode();
                }
            }

            //handle switch click
            const darkmodeSwitch = document.querySelector('.wp-dark-mode-switch');
            if (darkmodeSwitch) {
                darkmodeSwitch.addEventListener('click', app.handleToggle);
            }

        },

        initDarkmode: function () {

            if (typeof wpDarkModeAdmin !== 'undefined') {
                return;
            }

            const is_saved = sessionStorage.getItem('wp_dark_mode_frontend');

            if (1 == is_saved) {
                document.querySelector('html').classList.add('wp-dark-mode-active');
            }

            app.checkDarkMode();

            window.dispatchEvent(new CustomEvent('wp_dark_mode', {active: is_saved}));
        },

        handleToggle: function () {

            const html = document.querySelector('html');
            html.classList.toggle('wp-dark-mode-active');

            app.checkDarkMode();

            const is_saved = html.classList.contains('wp-dark-mode-active') ? 1 : 0;

            sessionStorage.setItem('wp_dark_mode_frontend', is_saved);
            localStorage.setItem('wp_dark_mode_active', is_saved);

            window.dispatchEvent(new CustomEvent('wp_dark_mode', {active: is_saved}));
        },

        /** check if the darkmode is active or not */
        checkDarkMode: () => {

            if (document.querySelector('html').classList.contains('wp-dark-mode-active')) {
                app.enable();

                //add active class from the switch
                document.querySelectorAll('.wp-dark-mode-switcher').forEach((switcher) => switcher.classList.add('active'));
            } else {
                DarkReader.disable();

                //remove active class from the switch
                document.querySelectorAll('.wp-dark-mode-switcher').forEach((switcher) => switcher.classList.remove('active'));
            }

        },

        /**
         * enable the darkmode
         */
        enable: () => {
            const {config: {brightness, contrast, sepia}} = wpDarkModeFrontend;

            DarkReader.enable({
                brightness,
                contrast,
                sepia
            });
        },

        checkOsMode: function () {

        },

        handleExcludes: function () {

            if (typeof wpDarkModeFrontend === 'undefined') {
                return;
            }

            const elements = document.querySelectorAll(wpDarkModeFrontend.excludes);

            elements.forEach((element) => {
                element.classList.add('wp-dark-mode-ignore');
                const children = element.querySelectorAll('*');

                children.forEach((child) => {
                    child.classList.add('wp-dark-mode-ignore');
                })
            });
        },

        handleIncludes: function () {

            if (typeof wpDarkModeFrontend === 'undefined') {
                return;
            }

            const elements = document.querySelectorAll(wpDarkModeFrontend.includes);

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