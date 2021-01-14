(function ($) {

    $('body').addClass('wp-dark-mode-ignore');

    $(document).ready(function () {
        const sliders = $('.brightness, .contrast, .sepia');

        sliders.each(function () {
            const $slider = $(this).find('.wppool-slider');

            $slider.slider({
                slide: (e, ui) => {
                    const handle = $(".wppool-slider-handle", $slider);
                    $("input", $(this)).val(ui.value);
                    handle.text(ui.value);

                    const brightness = $("[name='wp_dark_mode_color[brightness]']").val();
                    const contrast = $("[name='wp_dark_mode_color[contrast]']").val();
                    const sepia = $("[name='wp_dark_mode_color[sepia]']").val();

                    DarkReader.enable({
                        brightness,
                        contrast,
                        sepia,
                    });
                }
            });


        });

    });
})(jQuery);