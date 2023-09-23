<x-app-layout>
    <style>
        .apexcharts-canvas{
            margin: auto;
        }
        .boardBox{
            position: relative;
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
            opacity: 0.1;

        }

    </style>

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

        {{-- Boards and and current active session --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-3">
            <div class="grid md:grid-cols-2 gap-4 sm:rounded-lg">
                {{-- Boards --}}
                <div class="grid grid-cols-2 gap-2 sm:rounded-lg">
                    @for($i=0; $i<3; $i++)
                    <div class="
                         min-h-[100px]
                         bg-center
                         bg-cover
                         bg-no-repeat
                         rounded-lg p-2
                         shadow-[0_0_5px_1px_rgba(255,255,255,0.3)]
                         text-white
                         boardBox
                         transition-all duration-150 transform hover:scale-105 cursor-pointer
                         "
                    >
                            <header class="grid grid-cols-6 items-center">
                                <p class="col-span-4 text-white text-xl">Board name</p>
                                <div class="col-span-2 flex justify-end align-middle text-white">
                                    <span class="text-sm h-fit py-[2px] px-[7px] rounded-lg bg-green-600">Active</span>
                                </div>
                            </header>
                            <hr class="mt-2">
                            <p class="mt-3 text-sm">MAC: FF4523BA0990</p>
                            <p class="mb-2 text-sm">IP: 192.168.0.1</p>
                    </div>
                    @endfor
                        <div class="
                         min-h-[100px]
                         bg-center
                         bg-cover
                         bg-no-repeat
                         rounded-lg p-2
                         shadow-[0_0_5px_1px_rgba(255,255,255,0.3)]
                         text-white
                         boardBox
                         transition-all duration-150 transform hover:scale-105 cursor-pointer
                         "
                        >
                            <header class="grid grid-cols-6 items-center">
                                <p class="col-span-4 text-white text-xl">Board name</p>
                                <div class="col-span-2 flex justify-end align-middle text-white">
                                    <span class="text-sm h-fit py-[2px] px-[7px] rounded-lg bg-red-500">Inactive</span>
                                </div>
                            </header>
                            <hr class="mt-2">
                            <p class="mt-3 text-sm">MAC: FF4523BA0990</p>
                            <p class="mb-2 text-sm">Last seen: 16/09/2023 5:00pm</p>
                        </div>
                </div>
                {{-- Current session --}}
                <div>

                </div>
            </div>
        </div>

        {{-- Last session hart --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 shadow">
            <div class="bg-white dark:bg-gray-800 overflow-hidden sm:rounded-lg bg-[#01273e] boxLightHover shadow">
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
            @endnotEmpty
        </div>
    </div>
</x-app-layout>
