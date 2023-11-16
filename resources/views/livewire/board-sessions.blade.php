<div>
    <style>
        @tailwind base;
        @tailwind components;
        @tailwind utilities;

        /* width */
        ::-webkit-scrollbar {
            width: 10px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            background: #888;
            border-radius: 5px;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: #575267;
            border-radius: 5px;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
        #swal2-html-container{
            color: white;
        }
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
    <div class="flex items-center">
        <svg  class="dark:hidden inline-block w-[80px] cursor-pointer" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 3v1.5M4.5 8.25H3m18 0h-1.5M4.5 12H3m18 0h-1.5m-15 3.75H3m18 0h-1.5M8.25 19.5V21M12 3v1.5m0 15V21m3.75-18v1.5m0 15V21m-9-1.5h10.5a2.25 2.25 0 002.25-2.25V6.75a2.25 2.25 0 00-2.25-2.25H6.75A2.25 2.25 0 004.5 6.75v10.5a2.25 2.25 0 002.25 2.25zm.75-12h9v9h-9v-9z" />
        </svg>
        <svg  class="dark:inline-block hidden w-[80px] cursor-pointer" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#fff" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 3v1.5M4.5 8.25H3m18 0h-1.5M4.5 12H3m18 0h-1.5m-15 3.75H3m18 0h-1.5M8.25 19.5V21M12 3v1.5m0 15V21m3.75-18v1.5m0 15V21m-9-1.5h10.5a2.25 2.25 0 002.25-2.25V6.75a2.25 2.25 0 00-2.25-2.25H6.75A2.25 2.25 0 004.5 6.75v10.5a2.25 2.25 0 002.25 2.25zm.75-12h9v9h-9v-9z" />
        </svg>
        <div class="ml-3 dark:text-white">
            <p class="text-3xl">{{$board->name}}</p>
            <p>UUID: {{$board->uuid}}</p>
        </div>
        <div class="flex-1 dark:text-white">
            <p class="t-bold text-right">TOTAL SESSIONS:</p>
            <p class="text-2xl text-right">{{$sessions->count()}}</p>
        </div>
    </div>
    <hr class="mt-2"/>

    {{-- last session of this boards if exists --}}
    @unless($hasSessions)
        <div class="p-4 text-center dark:text-orange-500 border-solid border-[1px] border-gray-700 dark:border-orange-500 rounded-md mt-2">No sessions registered for this board</div>
    @else
        <div id="lastSessionChart" class="h-[400px] mt-6"></div>
    @endunless

    <div class="mx-2 mt-4 dark:text-white max-h-[300px] overflow-y-scroll pr-1.5">
        <table class="w-full border-collapse">
            <thead class="border-solid border-[1px] border-gray-700 dark:border-gray-50">
                <th class="border-solid border-[1px] border-gray-700 dark:border-gray-50">Session Date</th>
                <th class="border-solid border-[1px] border-gray-700 dark:border-gray-50">Soak Temperature</th>
                <th class="border-solid border-[1px] border-gray-700 dark:border-gray-50">Soak Time</th>
                <th class="border-solid border-[1px] border-gray-700 dark:border-gray-50">Reflow Peak Temperature</th>
                <th class="border-solid border-[1px] border-gray-700 dark:border-gray-50">Reflow Max Time</th>
                <th class="border-solid border-[1px] border-gray-700 dark:border-gray-50">Actions</th>
            </thead>
            <tbody>
            @forelse($sessions as $s)
                <tr>
                    <td class="align-middle border-solid border-[1px] border-gray-700 dark:border-gray-50 p-2">{{$s->created_at}} °C</td>
                    <td class="text-center border-solid border-[1px] border-gray-700 dark:border-gray-50 p-2">{{$s->soak_temperature}} °C</td>
                    <td class="text-center border-solid border-[1px] border-gray-700 dark:border-gray-50 p-2">{{$s->soak_time}}s</td>
                    <td class="text-center border-solid border-[1px] border-gray-700 dark:border-gray-50 p-2">{{$s->reflow_peak_temp}} °C</td>
                    <td class="text-center border-solid border-[1px] border-gray-700 dark:border-gray-50 p-2">{{$s->reflow_max_time}}s</td>
                    <td class="text-center w-1/4 justify-end border-solid border-[1px] border-gray-700 dark:border-gray-50 p-2" align="end">
                        <svg class="inline-block w-[30px] cursor-pointer" wire:click="viewSession('{{$s->id}}')" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#06c21f" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </td>
                </tr>
            @empty
                <tr class="border-solid border-[1px] border-gray-700 dark:border-gray-50">
                    <td class="p-2" colspan="6" align="middle">No sessions registered on this board</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($hasSessions)
        @php
            $s = $board->sessions->last();
            $yAxis = $s->measurements->map(function ($measurement) {
                return $measurement->temperature;
            });
            $xAxis = $s->measurements->map(function ($measurement) {
                return $measurement->sequence;
            });
        @endphp
        <script type="module" wire:ignore>
            //Check dark mode
            var lastSessionData = null //this variable is used to update last session data
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
                text: "Time elapsed: {{Carbon\CarbonInterval::seconds($s->measurements->count())->cascade()->forHumans()}}",
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
                min: 0,
                max: {{$yAxis->max() + 10}}
            }
            };

            var chartSession = new ApexCharts(document.querySelector("#lastSessionChart"), options);
            chartSession.render();
            JSON.parse(localStorage.getItem('darkMode'))

            //We add event when changing switch light mode
            document.querySelector('#switchLight').addEventListener('click', (e) =>{
                let newOpt;
                if(!JSON.parse(localStorage.getItem('darkMode'))){
                    yColor = '#E5E7EB'
                    titleColor = '#E5E7EB'
                }
                else{
                    yColor = '#111827'
                    titleColor = '#111827'
                }
                    //New options to update
                    newOpt = {
                        title: {
                        style: {
                        color: titleColor
                        }
                        },
                        chart: {
                        foreColor: yColor
                    }
                }
                chartSession.updateOptions(newOpt, false, false)
            })

            //Event to update last session data
            window.addEventListener('updateSessionChartData', (e) => {
                console.log("Refreshing chart session")
                chartSession.updateOptions({
                xaxis: {
                type: 'numeric',
                categories: e.detail.xdata,
                tickAmount: 10,
                },
                    yaxis:{
                    max: Math.max(...e.detail.ydata) + 2
                },
                    title: {
                    text: "Time elapsed: " + e.detail.sessionTime
                },
                }
                , false, false)
                chartSession.updateSeries([{data: e.detail.ydata}], true)
                console.log("Last session updated")
            })
        </script>
    @endif
</div>
