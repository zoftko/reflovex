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
    </style>
    <div class="flex justify-center items-center">
        <input wire:model="search" class="w-3/4 bg-gray-100 dark:bg-gray-900 rounded-3xl dark:text-white" type="text" placeholder="Filter by Board name, UUID">
        <svg class="block absolute right-[11%] h-5 w-5 stroke-current h-9 w-9 animate-spin text-gray-400" wire:loading.block wire:target="search" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
        </svg>
    </div>
    <div class="mt-6 grid grid-cols-4 dark:text-white">
        <div class="text-center p-2">Name</div>
        <div class="text-center p-2">UUID</div>
        <div class="text-center p-2">Last Seen</div>
        <div class="text-center p-2">Actions</div>
        <hr class="col-span-4 mb-4 mr-2 ml-2 border-t-gray-700 dark:border-gray-50">
    </div>
    <div class="mx-2 dark:text-white max-h-[300px] overflow-y-scroll pr-1.5">
        <table class="w-full border-collapse">
            <tbody>
            @forelse($boards as $b)
                <tr>
                    <td class="w-1/4 align-middle border-solid border-[1px] border-gray-700 dark:border-gray-50 p-2">{{$b->name}}</td>
                    <td class="w-1/4 align-middle border-solid border-[1px] border-gray-700 dark:border-gray-50 p-2">{{$b->uuid}}</td>
                    <td class="w-1/4 align-middle border-solid border-[1px] border-gray-700 dark:border-gray-50 p-2">{{$b->last_seen}}</td>
                    <td class="w-1/4 justify-end border-solid border-[1px] border-gray-700 dark:border-gray-50 p-2" align="end">
                        <svg class="inline-block w-[30px] cursor-pointer" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ff5500" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                        </svg>
                        <svg class="inline-block w-[30px] cursor-pointer" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ff0000" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                        </svg>
                    </td>
                </tr>
                <!--
                <div class="p-2 align-middle border-solid border-2 border-gray-700 dark:border-gray-50"></div>
                <div class="p-2 align-middle border-solid border-2 border-gray-700 dark:border-gray-50"></div>
                <div class="p-2 align-middle border-solid border-2 border-gray-700 dark:border-gray-50"></div>
                <div class="flex justify-end items-center pr-2 border-solid border-2 border-gray-700 dark:border-gray-50"> -->
            @empty
                <div>No boards registered</div>
            @endforelse
            </tbody>
        </table>
    </div>
    <hr class=" mt-6 col-span-4 mb-4 mr-2 ml-2 border-t-gray-700 dark:border-gray-50">
    <p class="text-center dark:text-white text-xl mb-3">Add new board</p>
    <div class="flex items-center justify-center mb-10">
        <svg wire:click="addBoard" class="w-[50px] mr-3 cursor-pointer" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#27a308" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <input wire:model="addBName" class="bg-gray-100 dark:bg-gray-900 rounded-md dark:text-white mr-2 w-1/2" type="text" placeholder="Board name"/>
        <input wire:model="addBUuid" class="bg-gray-100 dark:bg-gray-900 rounded-md dark:text-white" type="text" placeholder="UUID: FFAAFFAAFFAA"/>
    </div>
    <p class="text-center dark:text-white text-xl mb-3">Edit board data</p>
    <p class="text-center dark:text-white text-sm mb-3">Click on edit button on board using table above</p>
    <div class="flex items-center justify-center">
        <svg class="w-[50px] mr-3 cursor-pointer" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2f7aeb" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
        </svg>
        <input class="bg-gray-100 dark:bg-gray-900 rounded-md dark:text-white mr-2 w-1/2" type="text" placeholder="Board name"/>
        <input class="bg-gray-100 dark:bg-gray-900 rounded-md dark:text-white" type="text" placeholder="UUID: FFAAFFAAFFAA"/>
    </div>
</div>
