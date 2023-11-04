<div class=" sm:rounded-lg">
    {{-- Update statistics polling --}}
    <div class="hidden" wire:poll.5000ms="updateStatistics"></div>
    {{-- Summary Boards, Profiles and Sessions --}}
    <div class="grid md:grid-cols-3 gap-6">
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
    {{-- Statistics --}}
    <div class="grid sm:grid-cols-2 gap-6 mt-6">
        @forelse($statistics as $title => $data)
            <div class="lightBox dark:shadow-[0_0_5px_1px_rgba(255,255,255,0.3)] statsBox
                                bg-white dark:bg-gray-800
                                relative min-h-[130px] overflow-hidden
                                dark:text-white text-center grid
                                after:shadow-[0_0_5px_1px_rgba(255,255,255,0.3)]
                                transition-all duration-150 transform hover:scale-105
                                content-center
                                {{$data["class"]}}
                            ">
                <p class="w-100 block mt-[10px]">{{$title}}</p>
                <p class="block text-xl mt-2">{!! $data["data"] !!}</p>
            </div>
        @empty
            <div class="lightBox dark:shadow-[0_0_5px_1px_rgba(255,255,255,0.3)] statsBox
                                bg-white dark:bg-gray-800
                                relative min-h-[80px] overflow-hidden
                                dark:text-white text-center grid
                                after:shadow-[0_0_5px_1px_rgba(255,255,255,0.3)]
                                transition-all duration-150 transform hover:scale-105
                            ">
                <p class="w-100 block mt-[10px]">No statistics</p>
                <p class="block">No data</p>
            </div>
        @endforelse
    </div>
</div>
