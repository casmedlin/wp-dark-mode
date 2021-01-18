import './components/slider';

;(function () {

    const app = {
        init: () => {

            //handle switch click
            const darkmodeSwitch = document.querySelector('.wp-dark-mode-switch');
            if (darkmodeSwitch) {
                darkmodeSwitch.addEventListener('click', app.handleToggle);
            }

            app.initDarkmode();
            app.blockSwitches();
            app.blockPresets();
            app.checkCategories();

            app.checkDesc();
            app.checkFloating();
            app.checkSwitchDeps();
            app.checkCustomize();
            app.checkPresetDeps();
            app.checkTimeBasedDeps();

            app.checkSwitchMenu();
            app.checkSwitchText();
            app.checkSwitchIcon();

            const enable_frontend = document.querySelector('.enable_frontend input[type=checkbox]');
            if (enable_frontend) {
                enable_frontend.addEventListener('change', app.checkFloating);
            }

            const enable_darkmode_checkbox = document.querySelector('.enable_os_mode input[type=checkbox]');
            if (enable_darkmode_checkbox) {
                enable_darkmode_checkbox.addEventListener('change', app.checkDesc);
            }

            const show_switcher_checkbox = document.querySelector('.show_switcher input[type=checkbox]');
            if (show_switcher_checkbox) {
                show_switcher_checkbox.addEventListener('change', app.checkSwitchDeps);
            }

            const customize_colors_checkbox = document.querySelector('.customize_colors input[type=checkbox]');
            if (customize_colors_checkbox) {
                customize_colors_checkbox.addEventListener('change', app.checkCustomize);
            }

            const enable_preset_checkbox = document.querySelector('.enable_preset input[type=checkbox]');
            if (enable_preset_checkbox) {
                enable_preset_checkbox.addEventListener('change', app.checkPresetDeps);
            }

            const switch_menu_checkbox = document.querySelector('.enable_menu_switch input[type=checkbox]');
            if (switch_menu_checkbox) {
                switch_menu_checkbox.addEventListener('change', app.checkSwitchMenu);
            }

            const switch_text_checkbox = document.querySelector('.custom_switch_text input[type=checkbox]');
            if (switch_text_checkbox) {
                switch_text_checkbox.addEventListener('change', app.checkSwitchText);
            }

            const switch_icon_checkbox = document.querySelector('.custom_switch_icon input[type=checkbox]');
            if (switch_icon_checkbox) {
                switch_icon_checkbox.addEventListener('change', app.checkSwitchIcon);
            }


            const specific_cat = document.querySelector('.specific_category input[type=checkbox]');
            if (specific_cat) {
                specific_cat.addEventListener('change', app.checkCategories);
            }

            const tab_links = document.querySelectorAll('.tab-links .tab-link');
            tab_links.forEach((tab_link) => {
                tab_link.addEventListener('click', function (e) {
                    e.preventDefault();

                    document.querySelectorAll('.tab-links .tab-link, .tab-content').forEach(active => {
                        active.classList.remove('active');
                    });

                    tab_link.classList.add('active');

                    const target = tab_link.getAttribute('href');
                    document.querySelector(`#${target}`).classList.add('active');

                });
            });

            document.querySelectorAll(`.color-palette td`).forEach((element) => {
                element.classList.add('wp-dark-mode-ignore');
            });


            /**--- handle promo popups ---**/
            setTimeout(() => document.querySelectorAll('.image-choose-opt.disabled, .form-table tr.disabled').forEach((element) => {
                element.addEventListener('click', app.showPopup);
            }), 100);

        },

        //handle switch toggle
        handleToggle: function (e) {

            const html = document.querySelector('html');
            html.classList.toggle('wp-dark-mode-active');

            const is_saved = html.classList.contains('wp-dark-mode-active') ? 1 : 0;

            document.querySelector('.wp-dark-mode-switcher').classList.toggle('active');

            if (is_saved) {
                app.enable();
            } else {
                DarkReader.disable();
            }

            localStorage.setItem('wp_dark_mode_active', is_saved);

            window.dispatchEvent(new CustomEvent('wp_dark_mode', {active: is_saved}));
        },

        showPopup: (e) => {
            e.preventDefault();

            document.querySelector('.wp-dark-mode-promo').classList.remove('hidden');
        },

        initDarkmode: function () {
            const is_saved = localStorage.getItem('wp_dark_mode_active');

            if (wpDarkMode.enable_backend && 1 == is_saved && !wpDarkMode.is_block_editor) {

                document.querySelector('html').classList.add('wp-dark-mode-active');
                document.querySelector('.wp-dark-mode-switcher').classList.add('active');

                app.enable();

                window.dispatchEvent(new CustomEvent('wp_dark_mode', {active: is_saved}));
            }
        },

        enable: () => {
            //const {brightness, contrast, sepia} = wpDarkMode.config;

            DarkReader.enable({
                brightness: 100,
                contrast: 90,
                sepia: 10
            });
        },

        blockSwitches: function () {
            if (wpDarkMode.is_pro_active || wpDarkMode.is_ultimate_active) {
                return;
            }

            const image_opts = document.querySelectorAll('.switch_style .image-choose-opt');
            image_opts.forEach((image_opt, i) => {
                if (i < 2) {
                    return;
                }
                image_opt.classList.add('disabled');
                const div = document.createElement('DIV');
                div.classList.add('disabled-text', 'wp-dark-mode-ignore');

                image_opt.appendChild(div);
            });

            document.querySelectorAll(`
                    .remember_darkmode,
                    .start_at,
                    .end_at,
                    .specific_category,
                    .time_based_mode,
                    .custom_switch_icon,
                    .switch_icon_light, 
                    .switch_icon_dark,
                    .custom_switch_text,
                   .switch_text_light, 
                   .switch_text_dark, 
                   .show_above_post, 
                   .show_above_page, 
                   .includes, 
                   .excludes, 
                   .exclude_pages, 
                   .exclude_pages, 
                   .enable_menu_switch, 
                   .switch_menus,
                   .image_settings,
                   .custom_css,
                   .brightness,
                   .contrast,
                   .sepia
                   `).forEach((element) => {
                element.classList.add('disabled');
            });
        },

        blockPresets: function () {

            if (wpDarkMode.is_pro_active || wpDarkMode.is_ultimate_active) {
                return;
            }

            const image_opts = document.querySelectorAll('.color_preset .image-choose-opt');
            image_opts.forEach((image_opt, i) => {
                if (i < 2) {
                    return;
                }
                image_opt.classList.add('disabled');
                const div = document.createElement('DIV');
                div.classList.add('disabled-text', 'wp-dark-mode-ignore');

                image_opt.appendChild(div);
            });

            const customize_colors_checkbox = document.querySelector('.customize_colors');
            if (customize_colors_checkbox) {
                customize_colors_checkbox.classList.add('disabled');
            }
        },

        checkFloating: function () {
            const checkBox = document.querySelector('.enable_frontend input[type=checkbox]');
            if (!checkBox) {
                return;
            }
            const is_darkmode_enabled = checkBox.checked;

            if (is_darkmode_enabled) {
                document.querySelector('.show_switcher').style.display = 'revert';
            } else {
                document.querySelector('.show_switcher').style.display = 'none';
            }
        },

        checkDesc: function () {
            const checkBox = document.querySelector('.enable_os_mode input[type=checkbox]');
            if (!checkBox) {
                return;
            }
            const is_darkmode_enabled = checkBox.checked;

            if (is_darkmode_enabled) {
                document.querySelector('.enable_os_mode .description').style.display = 'block';
            } else {
                document.querySelector('.enable_os_mode .description').style.display = 'none';
            }
        },

        checkSwitchDeps: function () {
            const checkBox = document.querySelector('.show_switcher input[type=checkbox]');
            if (!checkBox) {
                return;
            }
            const checked = checkBox.checked;

            if (checked) {
                document.querySelector('.switcher_position, .switch_style').style.display = 'contents';
            } else {
                document.querySelector('.switcher_position, .switch_style').style.display = 'none';
            }
        },

        checkCustomize: function () {
            const checkBox = document.querySelector('.customize_colors input[type=checkbox]');
            if (!checkBox) {
                return;
            }

            const is_customized = checkBox.checked;

            const isPro = wpDarkMode.is_pro_active || wpDarkMode.is_ultimate_active;

            if (isPro && is_customized) {
                document.querySelectorAll('.darkmode_bg_color, .darkmode_text_color, .darkmode_link_color').forEach((element) => {
                    element.style.display = 'table-row';
                });
            } else {
                document.querySelectorAll('.darkmode_bg_color, .darkmode_text_color, .darkmode_link_color').forEach((element) => {
                    element.style.display = 'none';
                });
            }
        },

        checkPresetDeps: function () {

            const checkBox = document.querySelector('.enable_preset input[type=checkbox]');
            if (!checkBox) {
                return;
            }

            if (checkBox.checked) {
                document.querySelector('.brightness').classList.add('hidden');
                document.querySelector('.contrast').classList.add('hidden');
                document.querySelector('.sepia').classList.add('hidden');
                document.querySelector('.filter_preview').classList.add('hidden');

                document.querySelector('.color_preset').classList.remove('hidden');
            } else {
                document.querySelector('.brightness').classList.remove('hidden');
                document.querySelector('.contrast').classList.remove('hidden');
                document.querySelector('.sepia').classList.remove('hidden');
                document.querySelector('.filter_preview').classList.remove('hidden');

                document.querySelector('.color_preset').classList.add('hidden');
            }
        },

        checkSwitchMenu: function () {
            const checkBox = document.querySelector('.enable_menu_switch input[type=checkbox]');
            if (!checkBox) {
                return;
            }
            const is_on = checkBox.checked;

            if (is_on) {
                document.querySelector('.switch_menus').style.display = 'table-row';
            } else {
                document.querySelector('.switch_menus').style.display = 'none';
            }
        },

        checkCategories: function () {
            const checkBox = document.querySelector('.specific_category input[type=checkbox]');
            if (!checkBox) {
                return;
            }

            const is_on = checkBox.checked;

            if (is_on) {
                document.querySelector('.specific_categories').style.display = 'table-row';
            } else {
                document.querySelector('.specific_categories').style.display = 'none';
            }
        },

        checkSwitchText: function () {
            const checkBox = document.querySelector('.custom_switch_text input[type=checkbox]');
            if (!checkBox) {
                return;
            }
            const is_on = checkBox.checked;

            if (is_on) {
                document.querySelector('.switch_text_light').style.display = 'table-row';
                document.querySelector('.switch_text_dark').style.display = 'table-row';
            } else {
                document.querySelector('.switch_text_light').style.display = 'none';
                document.querySelector('.switch_text_dark').style.display = 'none';
            }
        },

        checkSwitchIcon: function () {
            const checkBox = document.querySelector('.custom_switch_icon input[type=checkbox]');
            if (!checkBox) {
                return;
            }
            const is_on = checkBox.checked;

            if (is_on) {
                document.querySelector('.switch_icon_light').style.display = 'table-row';
                document.querySelector('.switch_icon_dark').style.display = 'table-row';
            } else {
                document.querySelector('.switch_icon_light').style.display = 'none';
                document.querySelector('.switch_icon_dark').style.display = 'none';
            }
        },

        checkTimeBasedDeps: function () {

            const checkBox = document.querySelector('.time_based_mode input[type=checkbox]');
            if (!checkBox) {
                return;
            }

            if (checkBox.checked) {
                document.querySelector('.start_at').classList.remove('hidden');
                document.querySelector('.end_at').classList.remove('hidden');
            } else {
                document.querySelector('.start_at').classList.add('hidden');
                document.querySelector('.end_at').classList.add('hidden');
            }
        },

    };

    document.addEventListener('DOMContentLoaded', app.init);

})();