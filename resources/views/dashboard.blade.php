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
            margin:-40px;
            left: 0;
            width:80px;
            height:80px;
            transform:rotate(45deg);
            background-color:#871ba9;
        }

    </style>

    <div class="py-12">
        {{-- Summary boxes --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-3">

        </div>

        {{-- Boards and and current active session --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-3">
            <div class="grid md:grid-cols-2 gap-4 sm:rounded-lg">
                {{-- Boards --}}
                <div class="grid sm:grid-cols-2 gap-4 sm:rounded-lg">
                    @forelse($recentBoards as $b)
                        <div class="
                             min-h-[100px] bg-center bg-cover bg-no-repeat rounded-lg p-2
                             shadow-[0_0_5px_1px_rgba(255,255,255,0.3)] dark:text-white boardBox
                             transition-all duration-150 transform hover:scale-105 cursor-pointer
                             bg-white dark:bg-gray-800
                             "
                        >
                                <header class="grid grid-cols-6 items-center">
                                    <p class="col-span-4 text-xl">{{$b['name']}}</p>
                                    <div class="col-span-2 flex justify-end align-middle text-white">
                                        <span class="text-sm h-fit py-[2px] px-[7px] rounded-lg bg-green-600">Active</span>
                                    </div>
                                </header>
                                <hr class="mt-2">
                                <p class="mt-3 text-sm">{{$b['uuid']}}</p>
                                <p class="mb-2 text-sm">IP: {{$b['ip']}}</p>
                        </div>
                    @empty
                        <div class="
                         min-h-[100px] bg-center bg-cover bg-no-repeat rounded-lg p-2
                         shadow-[0_0_5px_1px_rgba(255,255,255,0.3)] dark:text-white boardBox
                         transition-all duration-150 transform hover:scale-105 cursor-pointer
                         bg-white dark:bg-gray-800
                         "
                        >
                            <header class="grid grid-cols-6 items-center">
                                <p class="col-span-4 text-xl">NO BOARDS</p>
                                <div class="col-span-2 flex justify-end align-middle text-white">
                                    <span class="text-sm h-fit py-[2px] px-[7px] rounded-lg bg-red-500">Inactive</span>
                                </div>
                            </header>
                            <hr class="mt-2">
                            <p class="mt-3 text-sm">{{$b->uuid}}</p>
                            <p class="mb-2 text-sm">IP: {{$b->ip}}</p>
                        </div>
                    @endforelse
                </div>
                {{-- Current session --}}
                <div class="dark:text-white text-center rounded-lg
                         dark:shadow-[0_0_5px_1px_rgba(255,255,255,0.3)] pt-8 pb-4
                         transition-all duration-150 transform hover:scale-[1.02] cursor-pointer
                         bg-white dark:bg-gray-800
                         lightBox
                         "
                >
                    <object class="hidden dark:block mx-auto h-[150px]" data="{{asset('img/circuit_package_white.svg')}}" width="80%"></object>
                    <object class="block dark:hidden mx-auto h-[150px]" data="{{asset('img/circuit_package.svg')}}" width="80%"></object>
                    <p class="w-full mt-2 text-xl">No active sessions</p>
                    <p>When a session starts here will be shown</p>
                </div>
            </div>
        </div>

        {{-- Last session hart and statistics --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 shadow mt-8">
            <div class="grid md:grid-cols-2 gap-4">
                <div class=" sm:rounded-lg">
                    <div class="grid md:grid-cols-3 gap-4">
                        {{-- Links --}}
                        <div class="bg-white dark:bg-gray-800 h-[100px] md:h-[150px]
                        rounded-md text-center  transition-all duration-150 transform
                        hover:scale-105 cursor-pointer flex md:block items-center
                        max-md:flex-row-reverse lightBox
                        text-green-500 dark:shadow-[0_0_5px_1px_rgba(255,255,255,0.3)]
                        ">
                            <div class="min-w-[100px] mt-1">
                                <img src="{{asset('img/board.png')}}" class="my-0 inline-flex md:block md:mx-auto md:w-[80%] max-w-[100px] ">
                            </div>
                            <p class=" font bold text-[20px]">Boards</p>
                            <p class="text-[24px] max-md:absolute max-md:ml-8 left-0 max-md:text-[42px]">{{$boardsCount}}</p>
                        </div>
                        <div class="bg-white dark:bg-gray-800 h-[100px] md:h-[150px] rounded-md
                        text-center
                        transition-all duration-150 transform hover:scale-105
                        cursor-pointer flex md:block items-center lightBox
                        text-orange-500 dark:shadow-[0_0_5px_1px_rgba(255,255,255,0.3)]
                        ">
                            <div class="min-w-[100px]">
                                <img src="{{asset('img/reflovex.png')}}" class="h-[70px] ml-2 block md:mx-auto mt-1"/>
                            </div>
                            <p class="font bold text-[20px]">Sessions</p>
                            <p class="text-[24px] max-md:absolute max-md:mr-8 right-0 max-md:text-[42px]">{{$sessionsCount}}</p>
                        </div>
                        <div class="bg-white dark:bg-gray-800 h-[100px] md:h-[150px] rounded-md text-center
                        transition-all duration-150 transform hover:scale-105
                        cursor-pointer flex md:block items-center max-md:flex-row-reverse lightBox
                        text-purple-500 dark:shadow-[0_0_5px_1px_rgba(255,255,255,0.3)]
                        ">
                            <div class="min-w-[100px] mt-2 ml-3">
                                <img src="{{asset('img/termometer.png')}}" class="h-[65px] block md:mx-auto md:w-[60%] max-w-[80px] ">
                            </div>
                            <p class="font bold text-[20px]">Profiles</p>
                            <p class="text-[24px] max-md:absolute max-md:ml-8 left-0 max-md:text-[42px]">{{$profilesCount}}</p>
                        </div>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-4 mt-4">
                        @for($i=0;$i<6;$i++)
                            <div class="lightBox dark:shadow-[0_0_5px_1px_rgba(255,255,255,0.3)] statsBox
                                bg-white dark:bg-gray-800
                                relative min-h-[80px] overflow-hidden
                                dark:text-white text-center grid
                                after:shadow-[0_0_5px_1px_rgba(255,255,255,0.3)]
                                transition-all duration-150 transform hover:scale-105
                            ">
                                <p class="w-100 block mt-[10px]">Temperature</p>
                                <p class="block">36°</p>
                            </div>
                        @endfor
                    </div>
                </div>
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
