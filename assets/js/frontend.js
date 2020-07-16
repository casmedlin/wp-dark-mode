;(function ($) {

    const app = {

        init: () => {
            app.initDarkMode();
            app.checkDarkMode();
            $('.wp-dark-mode-switch').on('change', app.handleToggle);

        },

        /** initialize object holder */
        darkMode: null,

        /** check if the darkmode is active or not on initialize */
        checkDarkMode: function () {
            if (app.darkMode.isActivated()) {
                $('.wp-dark-mode-switch').prop('checked', true);
            } else {
                $('.wp-dark-mode-switch').prop('checked', false);
            }
        },

        /** init dark mode */
        initDarkMode: function () {
            var options = {
                saveInCookies: false,
            };

            app.darkMode = new Darkmode(options);

            /*-------- check os mode --------*/
            if (wpDarkModeFrontend.matchSystem) {
                if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                    if (!app.darkMode.isActivated()) {
                        app.darkMode.toggle();
                    }
                }
            }

        },

        /** handle dark mode toggle */
        handleToggle: function () {
            app.darkMode.toggle();
            app.checkDarkMode();
        },

        setTimeBasedMode: function () {
            if (app.checkTime(wpDarkModeFrontend.startAt, wpDarkModeFrontend.endAt)) {
                app.darkMode.setMode('dark');
            }
        },

        checkTime: function (startTime, endTime) {
            currentDate = new Date();

            startDate = new Date(currentDate.getTime());
            startDate.setHours(startTime.split(":")[0]);
            startDate.setMinutes(startTime.split(":")[1]);

            endDate = new Date(currentDate.getTime());
            endDate.setHours(endTime.split(":")[0]);
            endDate.setMinutes(endTime.split(":")[1]);

            return startDate < currentDate && endDate > currentDate;
        }

    };

    $(document).ready(app.init);
})(jQuery);