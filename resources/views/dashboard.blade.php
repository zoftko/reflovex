<x-app-layout>
    <style>
        .apexcharts-canvas{
            margin: auto;
        }
    </style>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @notEmpty($session)
                    {{ __("Last Session on :date", ['date' => date_format(date_create($session->date), 'Y-m-d')]) }}
                    @else
                    {{ __("No last session registered") }}
                    @endnotEmpty
                </div>
                @notEmpty($session)
                <div id="chart" class="h-3/4 mx-3"></div>
                @endnotEmpty
            </div>
            <script type="module">
                //Check dark mode
                let yColor, titleColor
                if(JSON.parse(localStorage.getItem('darkMode'))){
                    yColor = '#E5E7EB'
                    titleColor = '#E5E7EB'
                }
                else{
                    yColor = '#111827'
                    titleColor = '#111827'
                }

                let options = {
                    series: [{
                        name: '°C',
                        data: {{$yAxis}},
                    }],
                    chart: {
                        height: 350,
                        width: '80%',
                        type: 'line',
                        animations: {
                            enabled: true,
                            easing: 'easeinout',
                            speed: 2000,
                            animateGradually: {
                                enabled: true,
                                delay: 1000
                            },
                            dynamicAnimation: {
                                enabled: true,
                                speed: 350
                            }
                        },
                        foreColor: yColor
                    },
                    forecastDataPoints: {
                        count: 7
                    },
                    stroke: {
                        width: 5,
                        curve: 'smooth'
                    },
                    xaxis: {
                        type: 'numeric',
                        categories: {{$xAxis}},
                        tickAmount: 10,
                    },
                    title: {
                        text: "Time elapsed: {{$sessionTime}}",
                        align: 'left',
                        style: {
                            fontSize: "16px",
                            color: titleColor
                        }
                    },
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shade: 'dark',
                            gradientToColors: [ '#FDD835'],
                            shadeIntensity: 1,
                            type: 'horizontal',
                            opacityFrom: 1,
                            opacityTo: 1,
                            stops: [0, 100, 100, 100]
                        },
                    },
                    yaxis: {
                        min: -10,
                        max: {{$yAxis->max() + 10}}
                    }
                };

                let chart = new ApexCharts(document.querySelector("#chart"), options);
                chart.render();
                JSON.parse(localStorage.getItem('darkMode'))

                //We add event when changing switch light mode
                document.querySelector('#switchLight').addEventListener('click', (e) =>{
                    let opt;
                    if( JSON.parse(localStorage.getItem('darkMode')) ){
                        yColor = '#E5E7EB'
                        titleColor = '#E5E7EB'
                    }
                    else{
                        yColor = '#111827'
                        titleColor = '#111827'
                    }
                    //New options to update
                    opt = {
                        title: {
                            style: {
                                color: titleColor
                            }
                        },
                        chart: {
                            foreColor: yColor
                        }
                    }
                    chart.updateOptions(opt, false, false)
                })
            </script>
        </div>
    </div>
</x-app-layout>
