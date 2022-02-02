define([
    'jquery',
    'uiComponent',
    'mage/url'
], function ($, Component, url) {
    'use strict';

    return Component.extend({

        getAjaxWeather: (function () {
            const timeout = 600000;
            getWeatherData();
            setInterval(function () {
                getWeatherData();
            }, timeout);

            function getWeatherData() {
                $.ajax({
                    url: url.build('leon_weather/weather'),
                    success: function(data) {
                        let parsed = JSON.parse(data);
                        if (parsed.weather[0] !== undefined && parsed.weather[0].main !== undefined) {
                            $('.weather .main .value').text(parsed.weather[0].main);
                        }
                        $('.weather .temp .value').text(parsed.main.temp ? parsed.main.temp + ' ℃' : "-");
                        $('.weather .feels_like .value').text(parsed.main.feels_like ? parsed.main.feels_like + ' ℃' : "-");
                    }
                });
            }
        })(),

    });
});
