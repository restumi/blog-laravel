<!DOCTYPE html>
<html lang="zxx" dir="ltr" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashcode')</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo/favicon.svg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- CSS Template -->
    <link rel="stylesheet" href="{{ asset('assets/css/rt-plugins.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <script src="{{ asset('assets/js/settings.js') }}" sync></script>

    <!-- Summernote CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">

    @stack('styles')
</head>
<body class="font-inter dashcode-app" id="body_class">
    <main class="app-wrapper">
        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Settings Toggle Button -->
        <button class="fixed ltr:md:right-[-29px] ltr:right-0 rtl:left-0 rtl:md:left-[-29px] top-1/2 z-[888] translate-y-1/2 bg-slate-800 text-slate-50 dark:bg-slate-700 dark:text-slate-300 cursor-pointer transform rotate-90 flex items-center text-sm font-medium px-2 py-2 shadow-deep ltr:rounded-b rtl:rounded-t" data-bs-toggle="offcanvas" data-bs-target="#offcanvas" aria-controls="offcanvas">
            <iconify-icon class="text-slate-50 text-lg animate-spin" icon="material-symbols:settings-outline-rounded"></iconify-icon>
            <span class="hidden md:inline-block ltr:ml-2 rtl:mr-2">Settings</span>
        </button>

        <!-- Settings Offcanvas -->
        @include('layouts.settings')

        <!-- Header -->
        @include('layouts.header')

        <!-- Konten Dinamis -->
        <div class="flex flex-col justify-between min-h-screen">
            <div>
                <div class="content-wrapper transition-all duration-150 ltr:ml-[248px] rtl:mr-[248px]" id="content_wrapper">
                    <div class="page-content">
                        <div class="transition-all duration-150 container-fluid" id="page_layout">
                            <div id="content_layout">
                                @yield('content') 
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer (opsional) -->
            <footer class="md:block hidden" id="footer">
                <div class="site-footer px-6 bg-white dark:bg-slate-800 text-slate-500 dark:text-slate-300 py-4 ltr:ml-[248px] rtl:mr-[248px]">
                    <div class="grid md:grid-cols-2 grid-cols-1 md:gap-5">
                        <div class="text-center ltr:md:text-start rtl:md:text-right text-sm">
                            COPYRIGHT © <span id="thisYear"></span> Dashcode, All rights Reserved
                        </div>
                        <div class="ltr:md:text-right rtl:md:text-end text-center text-sm">
                            Hand-crafted & Made by
                            <a href="https://codeshaper.net" target="_blank" class="text-primary-500 font-semibold">
                                Codeshaper
                            </a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>

        <!-- Mobile Footer -->
        <div class="bg-white bg-no-repeat custom-dropshadow footer-bg dark:bg-slate-700 flex justify-around items-center
            backdrop-filter backdrop-blur-[40px] fixed left-0 bottom-0 w-full z-[9999] bothrefm-0 py-[12px] px-4 md:hidden">
            <a href="chat.html">
                <div>
                    <span class="relative cursor-pointer rounded-full text-[20px] flex flex-col items-center justify-center mb-1 dark:text-white text-slate-900">
                        <iconify-icon icon="heroicons-outline:mail"></iconify-icon>
                        <span class="absolute right-[5px] lg:hrefp-0 -hrefp-2 h-4 w-4 bg-red-500 text-[8px] font-semibold flex flex-col items-center justify-center rounded-full text-white z-[99]">10</span>
                    </span>
                    <span class="block text-[11px] text-slate-600 dark:text-slate-300">Messages</span>
                </div>
            </a>
            <a href="profile.html" class="relative bg-white bg-no-repeat backdrop-filter backdrop-blur-[40px] rounded-full footer-bg dark:bg-slate-700 h-[65px] w-[65px] z-[-1] -mt-[40px] flex justify-center items-center">
                <div class="h-[50px] w-[50px] rounded-full relative left-[0px] hrefp-[0px] custom-dropshadow">
                    <img src="{{ asset('assets/images/users/user-1.jpg') }}" alt="" class="w-full h-full rounded-full border-2 border-slate-100">
                </div>
            </a>
            <a href="#">
                <div>
                    <span class="relative cursor-pointer rounded-full text-[20px] flex flex-col items-center justify-center mb-1 dark:text-white text-slate-900">
                        <iconify-icon icon="heroicons-outline:bell"></iconify-icon>
                        <span class="absolute right-[17px] lg:hrefp-0 -hrefp-2 h-4 w-4 bg-red-500 text-[8px] font-semibold flex flex-col items-center justify-center rounded-full text-white z-[99]">2</span>
                    </span>
                    <span class="block text-[11px] text-slate-600 dark:text-slate-300">Notifications</span>
                </div>
            </a>
        </div>
    </main>

    <!-- Scripts -->
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/rt-plugins.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>

    <script>
        document.getElementById('thisYear').textContent = new Date().getFullYear();
    </script>

    <!-- Summernote JS -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>

    @stack('scripts')
</body>
</html>
