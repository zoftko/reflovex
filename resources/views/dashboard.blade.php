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
            <div class="grid md:grid-cols-2 gap-6 sm:rounded-lg">
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
                @livewire('last-session')
            </div>
        </div>
    </div>
</x-app-layout>
