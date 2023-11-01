<div class="grid sm:grid-cols-2 gap-6 sm:rounded-lg">
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
                    @if($b['active'])
                        <span class="text-sm h-fit py-[2px] px-[7px] rounded-lg bg-green-600">Active</span>
                    @else
                        <span class="text-sm h-fit py-[2px] px-[7px] rounded-lg bg-red-500">Inactive</span>
                    @endif
                </div>
            </header>
            <hr class="mt-2">
            <p class="mt-3 text-sm">{{$b['uuid']}}</p>
            @if($b['active'])
                <p class="mb-2 text-sm">IP: {{$b['ip']}}</p>
            @else
                <p class="mb-2 text-sm">Last seen: {{$b['last_seen']}}</p>
            @endif
        </div>
    @empty
        <div class="
                         flex justify-center min-h-[100px] rounded-lg p-2 col-span-2
                         shadow-[0_0_5px_1px_rgba(255,255,255,0.3)] dark:text-white
                         transition-all duration-150 transform hover:scale-105 cursor-pointer
                         bg-white dark:bg-gray-800
                         "
        >
            <p class="col-span-4 text-xl my-auto">No boards added yet. Go to Boards menu to register</p>
        </div>
    @endforelse
</div>
