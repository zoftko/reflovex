<x-app-layout>
    <style>
        .apexcharts-canvas{
            margin: auto;
        }
        .boardBox{
            position: relative;
        }
        .boardBox:not(.dark .boardBox){
            box-shadow: 1px 1px 5px 1px rgba(73, 72, 83, 0.5);
        }

        .boardBox::before{
            content: "";
            background-image: url({{asset('img/circuit.png')}});
            background-position: center;
            background-size: cover;
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            opacity: 0.3;
        }

        .lightBox:not(.dark .lightBox){
            box-shadow: 1px 1px 5px 1px rgba(73, 72, 83, 0.5);
        }
        .statsBox::after{
            content: "";
            position:absolute;
            left: 0;
            width:100%;
            height:3px;
            /*background-color: #6083f6;*/
        }

        /* Classes from server to render different color on statistics boxes */
        .afterTodayTemp:after{background-color: #f59905 !important;}
        .afterMaxTemp:after{background-color: #f50d05 !important;}
        .afterLongSession:after{background-color: #3af81f !important;}
        .afterMostSessions:after{background-color: #00a2e6 !important;}

        .apexcharts-title-text{
            fill: black;
        }
        .dark .apexcharts-title-text{
            fill: white;
        }
        .apexcharts-yaxis-texts-g text, .apexcharts-xaxis-texts-g text{
            fill: black;
        }
        .dark .apexcharts-yaxis-texts-g text, .dark .apexcharts-xaxis-texts-g text{
            fill: white;
        }

    </style>

    <div class="py-12 mx-4">

        {{-- Boards and and current active session --}}
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8 mb-3">
            <div class="grid md:grid-cols-2 gap-6 sm:rounded-lg items-center">
                {{-- Boards --}}
                @livewire("recent-boards")
                {{-- Current session --}}
                @livewire("active-session")
            </div>
        </div>

        {{-- Last session hart and statistics --}}
        <div class="max-w-8xl mx-auto mt-8 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-6">
                @livewire('summary-boxes')
                <div class="bg-white dark:bg-gray-800 overflow-hidden sm:rounded-lg bg-[#01273e] lightBox shadow transition-all duration-150 transform hover:scale-[1.02] cursor-pointer dark:shadow-[0_0_5px_1px_rgba(255,255,255,0.3)]">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        @notEmpty($session)
                        {{ __("Last Session on :date", ['date' => date_format(date_create($session->created_at), 'Y-m-d')]) }}
                        @else
                            {{ __("No last session registered") }}
                            @endnotEmpty
                    </div>
                    @notEmpty($session)
                    <div id="chart" class="h-3/4 mx-3"></div>
                    @endnotEmpty
                </div>
            </div>
            @notEmpty($session)
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
                        data: @json($yAxis),
                    }],
                    chart: {
                        height: 350,
                        width: '100%',
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
                        categories: @json($xAxis),
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
                    if(!JSON.parse(localStorage.getItem('darkMode'))){
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
                    activeSessionChart.updateOptions(opt, true, true, true)
                })
            </script>
            @endnotEmpty
        </div>
    </div>
</x-app-layout>
