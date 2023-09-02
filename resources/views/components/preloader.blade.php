
<div id="preloaderWrapper"
     class="bg-pld_light dark:bg-black top-0 left-0  flex justify-center fixed w-full h-full"
    style="transition: opacity 2s ease-in;"
>
    {{-- Light mode --}}
    <div class="flex preloader_img dark:hidden h-3/4 self-center" id="lightGif">
        <img src="{{asset('preloader.gif')}}" alt="Loading...s">
    </div>
    {{-- Dark mode --}}
    <div class="hidden preloader_img dark:flex h-3/4 self-center" id="darkGif">
        <img src="{{asset('dark_preloader.gif')}}" alt="Loading...s">
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function(event) {
            const preloader = document.getElementById('preloaderWrapper')
            preloader.addEventListener("transitionend", (e) => {
                preloader.style.display = 'none'
            })
            window.onload = (event) => {
                preloader.style.opacity = 0
            };
        });
    </script>
</div>
