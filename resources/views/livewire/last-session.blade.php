<div>
    <div wire:ignore class="bg-white dark:bg-gray-800 overflow-hidden sm:rounded-lg bg-[#01273e] lightBox shadow transition-all duration-150 transform hover:scale-[1.02] cursor-pointer dark:shadow-[0_0_5px_1px_rgba(255,255,255,0.3)]">
        <div class="p-6 text-gray-900 dark:text-gray-100 grid grid-cols-2">
            @notEmpty($session)
            <span> {{ __("Last Session on :date", ['date' => date_format(date_create($session->created_at), 'Y-m-d')]) }}</span>
            <div class="flex justify-end items-center">
                <svg class="block h-5 w-5 stroke-current h-9 w-9 animate-spin text-gray-400" wire:loading.block wire:target="updateLastSessionChart" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span wire:click="updateLastSessionChart" class="h-fit py-[2px] px-[7px] rounded-lg bg-blue-300 dark:bg-blue-500">Reload</span>
            </div>
            @else
                {{ __("No last session registered") }}
            @endnotEmpty
        </div>
        @notEmpty($session)
        <div id="chartLastSession" class="h-[385px] mx-3"></div>
        @endnotEmpty
    </div>
    @notEmpty($session)
    <script type="module">
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

        var chartLastSession = new ApexCharts(document.querySelector("#chartLastSession"), options);
        chartLastSession.render();
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
            chartLastSession.updateOptions(opt, false, false)
            activeSessionChart.updateOptions(opt, true, true, true)
        })

        //Event to update last session data
        window.addEventListener('updateLastSessionChartData', (e) => {
            console.log("Refreshing last session")
            chartLastSession.updateOptions({
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
            chartLastSession.updateSeries([{data: e.detail.ydata}], true)
            console.log("Last session updated")
        })
    </script>
    @endnotEmpty
</div>
