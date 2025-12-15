<!-- BEGIN: Header -->
<div class="z-[9]" id="app_header">
    <div class="app-header z-[999] ltr:ml-[248px] rtl:mr-[248px] bg-white dark:bg-slate-800 shadow-sm dark:shadow-slate-700">
        <div class="flex justify-between items-center h-full">
            <div class="flex items-center md:space-x-4 space-x-2 xl:space-x-0 rtl:space-x-reverse vertical-box">
                <a href="{{ route('home') }}" class="mobile-logo xl:hidden inline-block">
                    <img src="{{ asset('assets/images/logo/logo-c.svg') }}" class="black_logo" alt="logo">
                    <img src="{{ asset('assets/images/logo/logo-c-white.svg') }}" class="white_logo" alt="logo">
                </a>
                <button class="smallDeviceMenuController hidden md:inline-block xl:hidden">
                    <iconify-icon class="leading-none bg-transparent relative text-xl top-[2px] text-slate-900 dark:text-white" icon="heroicons-outline:menu-alt-3"></iconify-icon>
                </button>
            </div>
            <!-- end vertcial -->
            <div class="items-center space-x-4 rtl:space-x-reverse horizental-box">
                <a href="{{ route('home') }}">
                    <span class="xl:inline-block hidden">
        <img src="{{ asset('assets/images/logo/logo.svg') }}" class="black_logo " alt="logo">
        <img src="{{ asset('assets/images/logo/logo-white.svg') }}" class="white_logo" alt="logo">
    </span>
                    <span class="xl:hidden inline-block">
        <img src="{{ asset('assets/images/logo/logo-c.svg') }}" class="black_logo " alt="logo">
        <img src="{{ asset('assets/images/logo/logo-c-white.svg') }}" class="white_logo " alt="logo">
    </span>
                </a>
                <button class="smallDeviceMenuController open-sdiebar-controller xl:hidden inline-block">
                    <iconify-icon class="leading-none bg-transparent relative text-xl top-[2px] text-slate-900 dark:text-white" icon="heroicons-outline:menu-alt-3"></iconify-icon>
                </button>
            </div>
            <!-- end horizental -->
            <div class="main-menu">
                <ul>
                    <li class="menu-item-has-children">
                        <a href="javascript:void()">
                            <div class="flex flex-1 items-center space-x-[6px] rtl:space-x-reverse">
                                <span class="icon-box">
                    <iconify-icon icon="heroicons-outline:home"></iconify-icon>
                  </span>
                                <div class="text-box">Dashboard</div>
                            </div>
                            <div class="flex-none text-sm ltr:ml-3 rtl:mr-3 leading-[1] relative top-1">
                                <iconify-icon icon="heroicons-outline:chevron-down"></iconify-icon>
                            </div>
                        </a>
                        <ul class="sub-menu">
                            <li><a href="#">Analytics Dashboard</a></li>
                            <li><a href="#">Hobbies</a></li>
                            <li><a href="#">Students</a></li>
                        </ul>
                    </li>
                    <!-- Tambahkan menu lain sesuai kebutuhan -->
                </ul>
            </div>
            <!-- end top menu -->
            <div class="nav-tools flex items-center lg:space-x-5 space-x-3 rtl:space-x-reverse leading-0">
                <!-- Toggle Theme -->
                <div>
                    <button id="themeMood" class="h-[28px] w-[28px] lg:h-[32px] lg:w-[32px] lg:bg-gray-500-f7 bg-slate-50 dark:bg-slate-900 lg:dark:bg-slate-900 dark:text-white text-slate-900 cursor-pointer rounded-full text-[20px] flex flex-col items-center justify-center">
                        <iconify-icon class="text-slate-800 dark:text-white text-xl dark:block hidden" id="moonIcon" icon="line-md:sunny-outline-to-moon-alt-loop-transition"></iconify-icon>
                        <iconify-icon class="text-slate-800 dark:text-white text-xl dark:hidden block" id="sunIcon" icon="line-md:moon-filled-to-sunny-filled-loop-transition"></iconify-icon>
                    </button>
                </div>
                <!-- Gray Scale -->
                <div>
                    <button id="grayScale" class="lg:h-[32px] lg:w-[32px] lg:bg-slate-100 lg:dark:bg-slate-900 dark:text-white text-slate-900 cursor-pointer rounded-full text-[20px] flex flex-col items-center justify-center">
                        <iconify-icon class="text-slate-800 dark:text-white text-xl" icon="mdi:paint-outline"></iconify-icon>
                    </button>
                </div>
                <!-- Profile Dropdown -->
                <div class="md:block hidden w-full">
                    <button class="text-slate-800 dark:text-white focus:ring-0 focus:outline-none font-medium rounded-lg text-sm text-center inline-flex items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="lg:h-8 lg:w-8 h-7 w-7 rounded-full flex-1 ltr:mr-[10px] rtl:ml-[10px]">
                            <img src="{{ asset('assets/images/all-img/user.png') }}" alt="user" class="block w-full h-full object-cover rounded-full">
                        </div>
                        <span class="flex-none text-slate-600 dark:text-white text-sm font-normal items-center lg:flex hidden overflow-hidden text-ellipsis whitespace-nowrap">nbgdvzc</span>
                        <svg class="w-[16px] h-[16px] dark:text-white hidden lg:inline-block text-base inline-block ml-[10px] rtl:mr-[10px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="dropdown-menu z-10 hidden bg-white divide-y divide-slate-100 shadow w-44 dark:bg-slate-800 border dark:border-slate-700 !top-[23px] rounded-md overflow-hidden">
                        <ul class="py-1 text-sm text-slate-800 dark:text-slate-200">
                            <li><a href="{{ route('home') }}" class="block px-4 py-2 hover:bg-slate-100 dark:hover:bg-slate-600 dark:hover:text-white">Dashboard</a></li>
                            <li><a href="#" class="block px-4 py-2 hover:bg-slate-100 dark:hover:bg-slate-600 dark:hover:text-white">Profile</a></li>
                            <li>
                                <form action="#" method="POST" class="block px-4 py-2">
                                    @csrf
                                    <button type="submit" class="block px-4 py-2 btn btn-danger">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- Mobile Menu Button -->
                <button class="smallDeviceMenuController md:hidden block leading-0">
                    <iconify-icon class="cursor-pointer text-slate-900 dark:text-white text-2xl" icon="heroicons-outline:menu-alt-3"></iconify-icon>
                </button>
            </div>
            <!-- end nav tools -->
        </div>
    </div>
</div>
<!-- END: Header -->

        <div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
          <div class="modal-dialog relative w-auto pointer-events-none top-1/4">
            <div class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white dark:bg-slate-900 bg-clip-padding rounded-md outline-none text-current">
              <form>
                <div class="relative">
                  <input type="text" class="form-control !py-3 !pr-12" placeholder="Search">
                  <button class="absolute right-0 top-1/2 -translate-y-1/2 w-9 h-full border-l text-xl border-l-slate-200 dark:border-l-slate-600 dark:text-slate-300 flex items-center justify-center">
                    <iconify-icon icon="heroicons-solid:search"></iconify-icon>
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
