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
        {{-- Summary boxes --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-3">
            <div class="grid md:grid-cols-3 gap-4 sm:rounded-lg">
                {{-- Boards --}}
                <div class="bg-white dark:bg-gray-800 h-[100px] md:h-auto rounded-md text-center bg-gradient-to-r from-[#210983] to-[#A1B6E5] transition-all duration-150 transform hover:scale-105 cursor-pointer flex md:block items-center max-md:flex-row-reverse boxLightHover">
                    <div class="min-w-[100px]">
                        <img src="{{asset('img/board.png')}}" class="my-0 h-[70px] inline-flex md:block md:h-auto md:mx-auto md:w-[180px] md:mt-12 ">
                    </div>
                    <p class="text-2xl font bold text-[28px] text-white">Boards</p>
                    <p class="text-[28px] text-white max-md:absolute max-md:ml-8 left-0 max-md:text-[42px]">{{$boardsCount}}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 h-[100px] md:h-auto rounded-md text-center bg-gradient-to-r from-[#ffc165] to-[#1c1b67] transition-all duration-150 transform hover:scale-105 cursor-pointer flex md:block items-center boxLightHover">
                    <div class="min-w-[100px]">
                        <img  src="{{asset('img/reflovex.png')}}" class="h-[90px] md:h-auto ml-2 block md:mx-auto md:w-[130px] md:mt-2 "/>
                    </div>
                    <p class="text-2xl font bold text-[28px] text-white">Sessions</p>
                    <p class="text-[28px] text-white max-md:absolute max-md:mr-8 right-0 max-md:text-[42px]">{{$sessionsCount}}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 h-[100px] md:h-auto rounded-md text-center bg-gradient-to-r from-[#7a12eb] to-[#d577ca] transition-all duration-150 transform hover:scale-105 cursor-pointer flex md:block items-center max-md:flex-row-reverse boxLightHover">
                    <div class="min-w-[100px]">
                        <img src="{{asset('img/termometer.png')}}" class="ml-2 h-[75px] md:h-auto block md:mx-auto md:w-[130px] md:mt-8 md:mb-4 ">
                    </div>
                    <p class="text-2xl font bold text-[28px] text-white">Profiles</p>
                    <p class="text-[28px] text-white max-md:absolute max-md:ml-8 left-0 max-md:text-[42px]">{{$profilesCount}}</p>
                </div>
            </div>
        </div>

        {{-- Last session hart --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 shadow">
            <div class="bg-white dark:bg-gray-800 overflow-hidden sm:rounded-lg bg-[#01273e] boxLightHover shadow">
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
