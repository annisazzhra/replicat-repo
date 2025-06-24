<!DOCTYPE html><html lang="id" class="h-full bg-gray-50"><head>    <meta charset="UTF-8">    <meta name="viewport" content="width=device-width, initial-scale=1.0">    <meta name="csrf-token" content="{{ csrf_token() }}">    <title>Dashboard - Hotspot Vigilance Enterprise</title>    <meta name="description" content="Dashboard monitoring kebakaran hutan real-time dengan teknologi AI dan analytics tingkat enterprise.">    @vite(['resources/css/app.css', 'resources/js/app.js'])    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script></head><body class="h-full bg-gray-50" x-data="{     sidebarOpen: false,     stats: {         activeHotspots: 127,         alertsToday: 23,         coverage: 99.8,         responseTime: 4.2     },    notifications: [        { id: 1, type: 'alert', message: 'Hotspot terdeteksi di Kabupaten OKI', time: '2 menit lalu', severity: 'high' },        { id: 2, type: 'info', message: 'Update data satelit berhasil', time: '15 menit lalu', severity: 'low' },        { id: 3, type: 'warning', message: 'Cuaca ekstrem di wilayah Musi Rawas', time: '1 jam lalu', severity: 'medium' }    ]}">    <!-- Enterprise Sidebar -->    <div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">        <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-white border-r border-gray-200 px-6 pb-4">            <!-- Logo -->            <div class="flex h-16 shrink-0 items-center">                <div class="flex items-center">                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center mr-3">                        <i class="fas fa-fire text-white text-lg"></i>                    </div>                    <div>                        <h1 class="text-xl font-bold text-gray-900">Hotspot Vigilance</h1>                        <p class="text-xs text-gray-500">Enterprise Edition</p>                    </div>                </div>            </div>            <!-- Navigation -->            <nav class="flex flex-1 flex-col">                <ul role="list" class="flex flex-1 flex-col gap-y-7">                    <li>                        <ul role="list" class="-mx-2 space-y-1">                            <li>                                <a href="/dashboard" class="bg-indigo-50 text-indigo-700 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">                                    <i class="fas fa-chart-line text-indigo-700 h-5 w-5 shrink-0"></i>                                    Dashboard                                </a>                            </li>                            <li>                                <a href="/peta" class="text-gray-700 hover:text-indigo-600 hover:bg-gray-50 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">                                    <i class="fas fa-map-marked-alt text-gray-400 group-hover:text-indigo-600 h-5 w-5 shrink-0"></i>                                    Peta Interaktif                                </a>                            </li>                            <li>                                <a href="/analitik" class="text-gray-700 hover:text-indigo-600 hover:bg-gray-50 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">                                    <i class="fas fa-chart-analytics text-gray-400 group-hover:text-indigo-600 h-5 w-5 shrink-0"></i>                                    Analytics                                </a>                            </li>                            <li>                                <a href="/laporan" class="text-gray-700 hover:text-indigo-600 hover:bg-gray-50 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">                                    <i class="fas fa-file-alt text-gray-400 group-hover:text-indigo-600 h-5 w-5 shrink-0"></i>                                    Laporan                                </a>                            </li>                        </ul>                    </li>                                        <!-- Secondary Navigation -->                    <li>                        <div class="text-xs font-semibold leading-6 text-gray-400 uppercase tracking-wide">Enterprise</div>                        <ul role="list" class="-mx-2 mt-2 space-y-1">                            <li>                                <a href="#" class="text-gray-700 hover:text-indigo-600 hover:bg-gray-50 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">                                    <i class="fas fa-users text-gray-400 group-hover:text-indigo-600 h-5 w-5 shrink-0"></i>                                    Team Management                                </a>                            </li>                            <li>                                <a href="#" class="text-gray-700 hover:text-indigo-600 hover:bg-gray-50 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">                                    <i class="fas fa-cog text-gray-400 group-hover:text-indigo-600 h-5 w-5 shrink-0"></i>                                    Settings                                </a>                            </li>                            <li>                                <a href="#" class="text-gray-700 hover:text-indigo-600 hover:bg-gray-50 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">                                    <i class="fas fa-shield-alt text-gray-400 group-hover:text-indigo-600 h-5 w-5 shrink-0"></i>                                    Security                                </a>                            </li>                        </ul>                    </li>                    <!-- User Profile -->                    <li class="mt-auto">                        <div class="bg-gray-50 rounded-lg p-3">                            <div class="flex items-center">                                <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center">                                    <i class="fas fa-user text-indigo-600 text-sm"></i>                                </div>                                <div class="ml-3 flex-1">                                    <p class="text-sm font-medium text-gray-700">{{ Auth::user()->name ?? 'Admin User' }}</p>                                    <p class="text-xs text-gray-500">Enterprise Admin</p>                                </div>                                <form method="POST" action="{{ route('logout') }}">                                    @csrf                                    <button type="submit" class="text-gray-400 hover:text-gray-600">                                        <i class="fas fa-sign-out-alt text-sm"></i>                                    </button>                                </form>                            </div>                        </div>                    </li>                </ul>            </nav>        </div>    </div>    <!-- Mobile sidebar -->    <div x-show="sidebarOpen" class="relative z-50 lg:hidden" role="dialog" aria-modal="true">        <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-900/80"></div>        <div class="fixed inset-0 flex">            <div x-show="sidebarOpen" x-transition:enter="transition ease-in-out duration-300 transform" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" class="relative mr-16 flex w-full max-w-xs flex-1">                <div class="absolute left-full top-0 flex w-16 justify-center pt-5">                    <button type="button" @click="sidebarOpen = false" class="-m-2.5 p-2.5">                        <span class="sr-only">Close sidebar</span>                        <i class="fas fa-times h-6 w-6 text-white"></i>                    </button>                </div>                <!-- Mobile sidebar content (same as desktop) -->                <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-white px-6 pb-4">                    <!-- Same navigation as desktop -->                </div>            </div>        </div>    </div>    <!-- Main content -->    <div class="lg:pl-72">        <!-- Top navigation bar -->        <div class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 bg-white px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8">            <button type="button" @click="sidebarOpen = true" class="-m-2.5 p-2.5 text-gray-700 lg:hidden">                <span class="sr-only">Open sidebar</span>                <i class="fas fa-bars h-5 w-5"></i>            </button>            <!-- Separator -->            <div class="h-6 w-px bg-gray-200 lg:hidden"></div>            <!-- Breadcrumb -->            <div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">                <div class="flex items-center gap-x-4">                    <nav class="flex" aria-label="Breadcrumb">                        <ol role="list" class="flex items-center space-x-4">                            <li>                                <div class="flex items-center">                                    <i class="fas fa-home h-4 w-4 text-gray-400"></i>                                    <a href="#" class="ml-2 text-sm font-medium text-gray-500 hover:text-gray-700">Dashboard</a>                                </div>                            </li>                        </ol>                    </nav>                </div>                <!-- Search -->                <div class="flex flex-1 justify-center">                    <div class="w-full max-w-lg">                        <label for="search" class="sr-only">Search</label>                        <div class="relative">                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">                                <i class="fas fa-search h-4 w-4 text-gray-400"></i>                            </div>                            <input id="search" name="search" class="block w-full rounded-md border-0 py-1.5 pl-10 pr-3 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Cari hotspot, lokasi, atau laporan..." type="search">                        </div>                    </div>                </div>                <!-- Right side -->                <div class="flex items-center gap-x-4 lg:gap-x-6">                    <!-- Notifications -->                    <button type="button" class="-m-2.5 p-2.5 text-gray-400 hover:text-gray-500" x-data="{ open: false }" @click="open = !open">                        <span class="sr-only">View notifications</span>                        <div class="relative">                            <i class="fas fa-bell h-5 w-5"></i>                            <span class="absolute -top-1 -right-1 h-4 w-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center" x-text="notifications.length">3</span>                        </div>                    </button>                    <!-- Profile dropdown -->                    <div class="relative" x-data="{ open: false }">                        <button type="button" @click="open = !open" class="-m-1.5 flex items-center p-1.5">                            <span class="sr-only">Open user menu</span>                            <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center">                                <i class="fas fa-user text-indigo-600 text-sm"></i>                            </div>                            <span class="hidden lg:flex lg:items-center">                                <span class="ml-2 text-sm font-semibold leading-6 text-gray-900">{{ Auth::user()->name ?? 'Admin User' }}</span>                                <i class="fas fa-chevron-down ml-2 h-3 w-3 text-gray-400"></i>                            </span>                        </button>                        <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 z-10 mt-2.5 w-32 origin-top-right rounded-md bg-white py-2 shadow-lg ring-1 ring-gray-900/5">                            <a href="#" class="block px-3 py-1 text-sm leading-6 text-gray-900 hover:bg-gray-50">Profile</a>                            <form method="POST" action="{{ route('logout') }}">                                @csrf                                <button type="submit" class="block w-full text-left px-3 py-1 text-sm leading-6 text-gray-900 hover:bg-gray-50">Sign out</button>                            </form>                        </div>                    </div>                </div>            </div>        </div>        <!-- Main dashboard content -->        <main class="py-6">            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">                <!-- Header -->                <div class="mb-8">                    <div class="flex items-center justify-between">                        <div>                            <h1 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">                                Dashboard Monitoring                            </h1>                            <p class="mt-1 text-sm text-gray-500">                                Overview real-time monitoring kebakaran hutan dan lahan di Sumatera Selatan                            </p>                        </div>                        <div class="flex items-center space-x-3">
                            <div class="flex items-center space-x-1">
                                <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                                <span class="text-sm text-gray-600 font-medium">System Online</span>
                            </div>
                            <button type="button" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                                <i class="fas fa-sync-alt mr-2"></i>
                                Refresh Data
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Stats Grid -->
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
                    <!-- Active Hotspots -->
                    <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-fire text-red-600 text-lg"></i>
                                    </div>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">Active Hotspots</dt>
                                        <dd class="text-2xl font-bold text-gray-900" x-text="stats.activeHotspots">127</dd>
                                    </dl>
                                </div>
                                <div class="flex-shrink-0">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        +12
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Alerts Today -->
                    <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-exclamation-triangle text-yellow-600 text-lg"></i>
                                    </div>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">Alerts Hari Ini</dt>
                                        <dd class="text-2xl font-bold text-gray-900" x-text="stats.alertsToday">23</dd>
                                    </dl>
                                </div>
                                <div class="flex-shrink-0">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        -5
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Coverage -->
                    <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-shield-alt text-green-600 text-lg"></i>
                                    </div>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">Coverage</dt>
                                        <dd class="text-2xl font-bold text-gray-900" x-text="stats.coverage + '%'">99.8%</dd>
                                    </dl>
                                </div>
                                <div class="flex-shrink-0">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Optimal
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Response Time -->
                    <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-clock text-blue-600 text-lg"></i>
                                    </div>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">Avg Response</dt>
                                        <dd class="text-2xl font-bold text-gray-900" x-text="stats.responseTime + ' min'">4.2 min</dd>
                                    </dl>
                                </div>
                                <div class="flex-shrink-0">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        Fast
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts and Maps Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <!-- Hotspot Map -->
                    <div class="bg-white shadow-sm rounded-lg border border-gray-200">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Peta Hotspot Real-time</h3>
                            <p class="text-sm text-gray-500">Distribusi hotspot di Sumatera Selatan</p>
                        </div>
                        <div class="p-6">
                            <div class="bg-gradient-to-br from-green-100 to-red-100 rounded-lg h-64 flex items-center justify-center">
                                <div class="text-center">
                                    <i class="fas fa-map-marked-alt text-4xl text-gray-400 mb-3"></i>
                                    <p class="text-gray-600">Interactive Map</p>
                                    <p class="text-sm text-gray-500">127 active hotspots detected</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Activity Chart -->
                    <div class="bg-white shadow-sm rounded-lg border border-gray-200">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Tren Aktivitas Hotspot</h3>
                            <p class="text-sm text-gray-500">7 hari terakhir</p>
                        </div>
                        <div class="p-6">
                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg h-64 flex items-center justify-center">
                                <div class="text-center">
                                    <i class="fas fa-chart-line text-4xl text-gray-400 mb-3"></i>
                                    <p class="text-gray-600">Analytics Chart</p>
                                    <p class="text-sm text-gray-500">Trending downward -15%</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activities and Alerts -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Recent Alerts -->
                    <div class="lg:col-span-2">
                        <div class="bg-white shadow-sm rounded-lg border border-gray-200">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-900">Alert Terbaru</h3>
                                <p class="text-sm text-gray-500">Notifikasi real-time dari sistem monitoring</p>
                            </div>
                            <div class="divide-y divide-gray-200">
                                <template x-for="notification in notifications" :key="notification.id">
                                    <div class="px-6 py-4">
                                        <div class="flex items-center space-x-3">
                                            <div class="flex-shrink-0">
                                                <div class="w-8 h-8 rounded-full flex items-center justify-center" 
                                                     :class="{
                                                         'bg-red-100': notification.severity === 'high',
                                                         'bg-yellow-100': notification.severity === 'medium', 
                                                         'bg-blue-100': notification.severity === 'low'
                                                     }">
                                                    <i class="fas fa-exclamation-triangle text-sm"
                                                       :class="{
                                                           'text-red-600': notification.severity === 'high',
                                                           'text-yellow-600': notification.severity === 'medium',
                                                           'text-blue-600': notification.severity === 'low'
                                                       }"></i>
                                                </div>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900" x-text="notification.message"></p>
                                                <p class="text-sm text-gray-500" x-text="notification.time"></p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <button class="text-gray-400 hover:text-gray-600">
                                                    <i class="fas fa-chevron-right text-sm"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                            <div class="px-6 py-3 bg-gray-50">
                                <a href="/laporan" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                    Lihat semua laporan <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white shadow-sm rounded-lg border border-gray-200">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Quick Actions</h3>
                            <p class="text-sm text-gray-500">Aksi cepat untuk monitoring</p>
                        </div>
                        <div class="p-6 space-y-4">
                            <a href="/peta" class="block w-full bg-indigo-50 hover:bg-indigo-100 text-indigo-700 px-4 py-3 rounded-lg text-sm font-medium transition-colors duration-200">
                                <i class="fas fa-map-marked-alt mr-2"></i>
                                Buka Peta Interaktif
                            </a>
                            <a href="/analitik" class="block w-full bg-green-50 hover:bg-green-100 text-green-700 px-4 py-3 rounded-lg text-sm font-medium transition-colors duration-200">
                                <i class="fas fa-chart-analytics mr-2"></i>
                                Lihat Analytics
                            </a>
                            <a href="/laporan" class="block w-full bg-blue-50 hover:bg-blue-100 text-blue-700 px-4 py-3 rounded-lg text-sm font-medium transition-colors duration-200">
                                <i class="fas fa-file-alt mr-2"></i>
                                Generate Laporan
                            </a>
                            <button type="button" class="block w-full bg-orange-50 hover:bg-orange-100 text-orange-700 px-4 py-3 rounded-lg text-sm font-medium transition-colors duration-200">
                                <i class="fas fa-download mr-2"></i>
                                Export Data
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>