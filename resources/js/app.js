import * as Sentry from "@sentry/browser";
import * as Highcharts from "highcharts";

setInterval(function () {
    let listoverflow = document.querySelectorAll('.overflower')
    for(let ov of listoverflow) {
        ov.scrollBy({
            left: 100000,

        });
    }
}, 50)


document.addEventListener("DOMContentLoaded", (event) => {
    var history = [];

    const tz = Intl.DateTimeFormat().resolvedOptions().timeZone;


    window.addEventListener('updateGraph', event => {

        let details = event.detail[0];

        setTimeout(() => {

            renderUniqueGraph(details.data, details.target)
        }, 400)
    });


    window.addEventListener('updateDoubleGraph', event => {
        let details = event.detail[0];

        setTimeout(() => {

            renderDoubleGraph(details.data[0], details.data[1], details.target)
        }, 400)
    });


    function renderDoubleGraph(data, data1, target) {
        if (!document.querySelector('.'+target)) {
            console.log("Graph not ready")
            return;
        }
        Highcharts.chart(target, {
            chart: {
                type: 'spline',
                zoomType: 'x',
                animation: Highcharts.svg, // smoother animation, only if SVG is supported
                backgroundColor: null,
                gridLineColor: null,

            },
            credits: {enabled: false},
            title: undefined,
            exporting: {
                enabled: false
            },

            xAxis: {
                type: 'datetime',
                gridLineColor: null,

            },
            yAxis: {
                gridLineColor: null,
                title: {
                    text: 'bit/s' // Définissez l'unité ici
                },
            },
            time: {
                timezone: tz
            },
            legend: {
                enabled: false
            },
            plotOptions: {
                areaspline: {

                    color: 'rgb(81,98,248)',

                    marker: {
                        enabled: false // Disable markers for a cleaner look
                    },

                    shadow: true,

                    lineWidth: 1,


                }
            },

            series: [{
                type: 'areaspline',
                name: 'In',
                data: data,
                marker: {
                    enabled: false // Disable markers for a cleaner look
                },
                color: {
                    linearGradient: {x1: 0, x2: 0, y1: 0, y2: 1},
                    stops: [
                        [0, 'rgba(110,171,42,0.15)'],
                        [1, 'rgb(110,171,42)']
                    ]

                },
                fillColor: {
                    linearGradient: {
                        x1: 0,
                        y1: 0,
                        x2: 0,
                        y2: 1
                    },
                    stops: [
                        [0, 'rgba(110,171,42,0.15)'], // Blue at the top
                        [1, 'rgb(110,171,42)'] // Fades to white
                    ]
                },
            }, {
                type: 'areaspline',
                name: 'Out',
                data: data1,
                color: {
                    linearGradient: {x1: 0, x2: 0, y1: 0, y2: 1},
                    stops: [
                        [0, 'rgb(109,109,236)'],
                        [1, 'rgb(109,109,236)']
                    ]

                },
                fillColor: {
                    linearGradient: {
                        x1: 0,
                        y1: 0,
                        x2: 0,
                        y2: 1
                    },
                    stops: [
                        [0, 'rgb(109,109,236)'], // Blue at the top
                        [1, 'rgba(109,109,236,0.15)'] // Fades to white
                    ]
                },
            }]
        });
    }

    function checkExist(target) {
        const element = document.getElementById(target);

        if (element) {
            setTimeout(() => {
                checkExist(target)
            }, 200)
        } else {
            delete history[target];
        }
    }

    function renderUniqueGraph(data, target) {


        if (history.hasOwnProperty(target)) {
            let currentHist = history[target]
            let addablePoint = [];
            let updated = false;
            for (let i = 0; i < data.length; i++) {
                if (data[i][0] > currentHist.lastTime + 30000) {
                    console.log("add ôpint")
                    currentHist.chart.series[0].addPoint(data[i]);
                    updated = true;
                }
            }
            if (updated) {
                history[target] = {lastTime: data[data.length - 1][0], chart: currentHist.chart};
            }

        } else {
            if (!document.querySelector('.'+target)) {
                console.log("Graph not ready")
                return;
            }
            let chart = Highcharts.chart(target, {
                chart: {
                    type: 'spline',
                    zoomType: 'x',
                    animation: Highcharts.svg, // smoother animation, only if SVG is supported
                    backgroundColor: null,
                    gridLineColor: null,

                },
                time: {
                    timezone: tz
                },
                credits: {enabled: false},
                title: undefined,
                exporting: {
                    enabled: false
                },
                xAxis: {
                    type: 'datetime',
                    gridLineColor: null,

                },
                yAxis: {
                    gridLineColor: null,
                    title: undefined,
                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    areaspline: {


                        marker: {
                            enabled: false
                        },

                        shadow: true,
                        lineWidth: 1,
                        turboThreshold: true,
                        softThreshold: true,


                    }
                },

                series: [{
                    type: 'areaspline',
                    name: '',
                    data: data,
                    color: {
                        linearGradient: {x1: 0, x2: 0, y1: 0, y2: 1},
                        stops: [
                            [0, 'rgba(253,100,100,0.58)'],
                            [1, 'rgba(100,117,253,0.58)']
                        ]

                    },
                    fillColor: {
                        linearGradient: {
                            x1: 0,
                            y1: 0,
                            x2: 0,
                            y2: 1
                        },
                        stops: [
                            [0, 'rgba(100,117,253,0.58)'], // Blue at the top
                            [1, 'rgba(100,117,253,0.27)'] // Fades to white
                        ]
                    },
                }]
            });


            history[target] = {lastTime: data[data.length - 1][0], chart: chart};
            checkExist(target)
        }


    }
});
Sentry.init({
    dsn: import.meta.env.VITE_SENTRY_DSN_PUBLIC,
});


