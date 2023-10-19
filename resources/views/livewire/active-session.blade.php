<div>
    <div wire:ignore wire:poll.visible="lastSession" id="pollerLastSession"></div>
    <div wire:ignore wire:poll.visible="sessionMeasurements" id="pollerSessionMeasurements" class="hidden"></div>
    <div class="dark:text-white text-center rounded-lg
                         dark:shadow-[0_0_5px_1px_rgba(255,255,255,0.3)] pt-8 pb-4
                         transition-all duration-150 transform hover:scale-[1.02] cursor-pointer
                         bg-white dark:bg-gray-800
                         lightBox
                         "
         id="noActiveSessionMessage"
         wire:ignore
    >
        <object class="hidden dark:block mx-auto h-[150px]" data="{{asset('img/circuit_package_white.svg')}}" width="80%"></object>
        <object class="block dark:hidden mx-auto h-[150px]" data="{{asset('img/circuit_package.svg')}}" width="80%"></object>
        <p class="w-full mt-2 text-xl">No active sessions</p>
        <p>When a session starts here will be shown</p>
    </div>
    <div wire:ignore.self id="activeSessionDom" class="hidden bg-white dark:bg-gray-800 overflow-hidden sm:rounded-lg bg-[#01273e] lightBox shadow transition-all duration-150 transform hover:scale-[1.02] cursor-pointer dark:shadow-[0_0_5px_1px_rgba(255,255,255,0.3)]">
        <div class="grid grid-cols-3 mt-3">
            <div> </div>
            <div>
                @if($activeSession)
                    <span class="bg-green-600 text-white p-[5px] rounded-md shadow-[0_0_5px_1px_rgba(0,255,137,0.5)]">LIVE</span>
                    <span class="bg-gray-700 text-gray-500 p-[5px] rounded-md shadow-[0_0_5px_1px_rgba(79,83,81,0.5)] ml-3">FINISHED</span>
                @else
                    <span class="bg-gray-700 text-gray-500 p-[5px] rounded-md shadow-[0_0_5px_1px_rgba(79,83,81,0.5)]">LIVE</span>
                    <span class="bg-red-600 text-white p-[5px] rounded-md shadow-[0_0_5px_1px_rgba(255,98,7,0.5)] ml-3">FINISHED</span>
                @endif
            </div>
            <div class="justify-items-end">
                @if(!$activeSession)
                <span
                    class="bg-red-400 dark:text-white text-2xl px-[10px] rounded-md absolute right-0 top-[8px] mr-5 shadow-[0_0_5px_1px_rgba(255,98,7,0.5)]"
                    onclick="closeChartActiveSession()"
                >&times;</span>
                @endif
            </div>
        </div>
        <div wire:ignore id="activeSessionChart" class="h-[250] mx-3 mt-3"></divwire:ignore>
    </div>

    <script type="text/javascript">
        function updateActiveSessionChart(){
            activeSessionChart.updateSeries([{data: yData}])
            activeSessionChart.updateOptions({yaxis:{max: Math.max(...yData) + 2}})
        }

        function stopActiveSessionChart(){
            clearInterval(activeSessionUpdater)
            activeSessionUpdater = null
            console.log('Active Session Updater Stopped')
        }

        function closeChartActiveSession(){
            let noActiveMessage = document.querySelector('#noActiveSessionMessage')
            let activeSessionDom = document.querySelector('#activeSessionDom')
            noActiveMessage.classList.remove('hidden')
            activeSessionDom.classList.add('hidden')
        }

        //Event to start showing graph
        window.addEventListener('startActiveSessionUpdater', (e) => {
            let noActiveMessage = document.querySelector('#noActiveSessionMessage')
            let activeSessionDom = document.querySelector('#activeSessionDom')
            let pollerLastSession = document.querySelector('#pollerLastSession')
            let pollerSessionMeasurements = document.querySelector('#pollerSessionMeasurements')

            noActiveMessage.classList.add('hidden')
            activeSessionDom.classList.remove('hidden')
            pollerLastSession.classList.add('hidden')
            pollerSessionMeasurements.classList.remove('hidden')

            activeSessionUpdater = setInterval(updateActiveSessionChart, 1000)
            console.log('Active Session Updater Started')
        })

        //Event to receive session measurements and append to graph
        window.addEventListener('getSessionMeasurements', (e) => {
            //console.log(e.detail)
            yData = e.detail
        })

        //Event to stop interval javascript who updates chart data
        window.addEventListener('stopActiveSessionUpdater', (e) =>{
            let pollerLastSession = document.querySelector('#pollerLastSession')
            let pollerSessionMeasurements = document.querySelector('#pollerSessionMeasurements')

            stopActiveSessionChart()
            pollerLastSession.classList.remove('hidden')
            pollerSessionMeasurements.classList.add('hidden')
            yData = []
        })

        let activeSessionUpdater = null //Interval to update the active session chart

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

        var yData = [] //Active session data
        var xData = []
        let options = {
            series: [{
                name: '°C',
                data: yData.slice(),
            }],
            chart: {
                height: 250,
                width: '100%',
                type: 'line',
                animations: {
                    enabled: false,
                    easing: 'linear',
                    dynamicAnimation: {
                        enabled: true,
                        speed: 3000
                    }
                },
                foreColor: yColor,
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
                tickAmount: 10
            },
            title: {
                text: "Active session",
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
                max: Math.max(yData) + 10
            }
        };
        var activeSessionChart
    </script>
    <script type="module">
        activeSessionChart = new ApexCharts(document.querySelector("#activeSessionChart"), options);
        activeSessionChart.render();
    </script>
</div>
