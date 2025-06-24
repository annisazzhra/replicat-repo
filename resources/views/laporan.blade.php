<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <title>Reports - Hotspot Vigilance</title>
</head>
<body class="h-full bg-gray-50" x-data="{ sidebarOpen: false }"
    x-bind:class="sidebarOpen ? 'overflow-hidden' : ''"
    x-on:keydown.escape="sidebarOpen = false">
    
<div class="flex h-full">
    <!-- Mobile sidebar overlay -->
    <div x-show="sidebarOpen" class="fixed inset-0 z-50 lg:hidden" style="display: none;">
        <div class="fixed inset-0 bg-gray-900/80" x-on:click="sidebarOpen = false"></div>
        <div x-show="sidebarOpen" 
             x-transition:enter="transition ease-in-out duration-300 transform"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in-out duration-300 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full"
             class="relative flex w-full max-w-xs flex-1 flex-col bg-white pt-5 pb-4">
            <div class="absolute top-0 right-0 -mr-12 pt-2">
                <button type="button" class="ml-1 flex h-10 w-10 items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                        x-on:click="sidebarOpen = false">
                    <span class="sr-only">Close sidebar</span>
                    <i class="fas fa-times h-6 w-6 text-white"></i>
                </button>
            </div>
            <!-- Mobile sidebar content -->
            <div class="flex flex-shrink-0 items-center px-4">
                <div class="flex items-center">
                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-gradient-to-br from-blue-600 to-blue-700">
                        <i class="fas fa-fire text-white text-sm"></i>
                    </div>
                    <span class="ml-2 text-xl font-bold text-gray-900">Hotspot Vigilance</span>
                </div>
            </div>
            <div class="mt-5 h-0 flex-1 overflow-y-auto">
                <nav class="space-y-1 px-2">
                    <a href="/dashboard" class="flex items-center px-2 py-2 text-sm font-medium text-gray-700 rounded-md hover:text-gray-900 hover:bg-gray-50 group">
                        <i class="fas fa-tachometer-alt text-gray-400 mr-3 flex-shrink-0 h-6 w-6"></i>
                        Dashboard
                    </a>
                    <a href="/peta" class="flex items-center px-2 py-2 text-sm font-medium text-gray-700 rounded-md hover:text-gray-900 hover:bg-gray-50 group">
                        <i class="fas fa-map text-gray-400 mr-3 flex-shrink-0 h-6 w-6"></i>
                        Interactive Map
                    </a>
                    <a href="/analitik" class="flex items-center px-2 py-2 text-sm font-medium text-gray-700 rounded-md hover:text-gray-900 hover:bg-gray-50 group">
                        <i class="fas fa-chart-line text-gray-400 mr-3 flex-shrink-0 h-6 w-6"></i>
                        Analytics
                    </a>
                    <a href="/laporan" class="flex items-center px-2 py-2 text-sm font-medium text-gray-900 bg-gray-100 rounded-md group">
                        <i class="fas fa-file-alt text-gray-500 mr-3 flex-shrink-0 h-6 w-6"></i>
                        Reports
                    </a>
                </nav>
            </div>
        </div>
    </div>

    <!-- Desktop sidebar -->
    <div class="hidden lg:fixed lg:inset-y-0 lg:flex lg:w-64 lg:flex-col">
        <div class="flex min-h-0 flex-1 flex-col bg-white border-r border-gray-200">
            <div class="flex flex-1 flex-col pt-5 pb-4 overflow-y-auto">
                <div class="flex items-center flex-shrink-0 px-4">
                    <div class="flex items-center">
                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-gradient-to-br from-blue-600 to-blue-700">
                            <i class="fas fa-fire text-white text-sm"></i>
                        </div>
                        <span class="ml-2 text-xl font-bold text-gray-900">Hotspot Vigilance</span>
                    </div>
                </div>
                <nav class="mt-5 flex-1 space-y-1 px-2 bg-white">
                    <a href="/dashboard" class="flex items-center px-2 py-2 text-sm font-medium text-gray-700 rounded-md hover:text-gray-900 hover:bg-gray-50 group">
                        <i class="fas fa-tachometer-alt text-gray-400 mr-3 flex-shrink-0 h-6 w-6"></i>
                        Dashboard
                    </a>
                    <a href="/peta" class="flex items-center px-2 py-2 text-sm font-medium text-gray-700 rounded-md hover:text-gray-900 hover:bg-gray-50 group">
                        <i class="fas fa-map text-gray-400 mr-3 flex-shrink-0 h-6 w-6"></i>
                        Interactive Map
                    </a>
                    <a href="/analitik" class="flex items-center px-2 py-2 text-sm font-medium text-gray-700 rounded-md hover:text-gray-900 hover:bg-gray-50 group">
                        <i class="fas fa-chart-line text-gray-400 mr-3 flex-shrink-0 h-6 w-6"></i>
                        Analytics
                    </a>
                    <a href="/laporan" class="flex items-center px-2 py-2 text-sm font-medium text-gray-900 bg-gray-100 rounded-md group">
                        <i class="fas fa-file-alt text-gray-500 mr-3 flex-shrink-0 h-6 w-6"></i>
                        Reports
                    </a>
                </nav>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="flex flex-1 flex-col lg:pl-64">
        <!-- Top navigation -->
        <div class="sticky top-0 z-40 flex h-16 bg-white shadow">
            <button type="button" class="border-r border-gray-200 px-4 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500 lg:hidden"
                    x-on:click="sidebarOpen = true">
                <span class="sr-only">Open sidebar</span>
                <i class="fas fa-bars h-6 w-6"></i>
            </button>
            <div class="flex flex-1 justify-between px-4">
                <div class="flex flex-1">
                    <div class="flex w-full md:ml-0">
                        <label for="search-field" class="sr-only">Search</label>
                        <div class="relative w-full text-gray-400 focus-within:text-gray-600">
                            <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none">
                                <i class="fas fa-search h-5 w-5"></i>
                            </div>
                            <input id="search-field" class="block w-full h-full pl-8 pr-3 py-2 border-transparent text-gray-900 placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-0 focus:border-transparent" placeholder="Search reports..." type="search">
                        </div>
                    </div>
                </div>
                <div class="ml-4 flex items-center md:ml-6">
                    <!-- Notifications -->
                    <button type="button" class="bg-white p-1 rounded-full text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <span class="sr-only">View notifications</span>
                        <i class="fas fa-bell h-6 w-6"></i>
                    </button>

                    <!-- Profile dropdown -->
                    <div class="ml-3 relative" x-data="{ open: false }">
                        <div>
                            <button type="button" class="max-w-xs bg-white flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" 
                                    x-on:click="open = !open">
                                <span class="sr-only">Open user menu</span>
                                <img class="h-8 w-8 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                            </button>
                        </div>
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             x-on:click.away="open = false"
                             style="display: none;"
                             class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Your Profile</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Sign out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Page header -->
        <div class="bg-white border-b border-gray-200 px-4 py-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
            <div class="flex-1 min-w-0">
                <h1 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    Reports & Documentation
                </h1>
                <p class="mt-1 text-sm text-gray-500">
                    Generate, view, and manage incident reports and system documentation
                </p>
            </div>
            <div class="mt-4 flex sm:mt-0 sm:ml-4">
                <button type="button" class="order-1 ml-3 inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:order-0 sm:ml-0">
                    <i class="fas fa-filter -ml-1 mr-2 h-4 w-4 text-gray-500"></i>
                    Filter Reports
                </button>
                <button type="button" class="order-0 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:order-1 sm:ml-3">
                    <i class="fas fa-plus -ml-1 mr-2 h-4 w-4"></i>
                    New Report
                </button>
            </div>
        </div>

        <!-- Main content area -->
        <main class="flex-1 relative overflow-y-auto focus:outline-none">
            <div class="py-6">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <!-- Report categories -->
                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
                        <!-- Incident Reports -->
                        <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-md transition-shadow cursor-pointer">
                            <div class="p-5">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 bg-red-500 rounded-md flex items-center justify-center">
                                            <i class="fas fa-fire text-white text-sm"></i>
                                        </div>
                                    </div>
                                    <div class="ml-5 w-0 flex-1">
                                        <dl>
                                            <dt class="text-sm font-medium text-gray-500 truncate">Incident Reports</dt>
                                            <dd class="text-lg font-medium text-gray-900">342</dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-5 py-3">
                                <div class="text-sm">
                                    <a href="#" class="text-blue-600 hover:text-blue-500 font-medium">View all reports →</a>
                                </div>
                            </div>
                        </div>

                        <!-- Monthly Summaries -->
                        <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-md transition-shadow cursor-pointer">
                            <div class="p-5">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                                            <i class="fas fa-calendar-alt text-white text-sm"></i>
                                        </div>
                                    </div>
                                    <div class="ml-5 w-0 flex-1">
                                        <dl>
                                            <dt class="text-sm font-medium text-gray-500 truncate">Monthly Summaries</dt>
                                            <dd class="text-lg font-medium text-gray-900">12</dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-5 py-3">
                                <div class="text-sm">
                                    <a href="#" class="text-blue-600 hover:text-blue-500 font-medium">View summaries →</a>
                                </div>
                            </div>
                        </div>

                        <!-- System Reports -->
                        <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-md transition-shadow cursor-pointer">
                            <div class="p-5">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                                            <i class="fas fa-cog text-white text-sm"></i>
                                        </div>
                                    </div>
                                    <div class="ml-5 w-0 flex-1">
                                        <dl>
                                            <dt class="text-sm font-medium text-gray-500 truncate">System Reports</dt>
                                            <dd class="text-lg font-medium text-gray-900">28</dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-5 py-3">
                                <div class="text-sm">
                                    <a href="#" class="text-blue-600 hover:text-blue-500 font-medium">View reports →</a>
                                </div>
                            </div>
                        </div>

                        <!-- Custom Reports -->
                        <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-md transition-shadow cursor-pointer">
                            <div class="p-5">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 bg-purple-500 rounded-md flex items-center justify-center">
                                            <i class="fas fa-chart-bar text-white text-sm"></i>
                                        </div>
                                    </div>
                                    <div class="ml-5 w-0 flex-1">
                                        <dl>
                                            <dt class="text-sm font-medium text-gray-500 truncate">Custom Reports</dt>
                                            <dd class="text-lg font-medium text-gray-900">15</dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-5 py-3">
                                <div class="text-sm">
                                    <a href="#" class="text-blue-600 hover:text-blue-500 font-medium">Create custom →</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Report generator -->
                    <div class="bg-white shadow rounded-lg mb-8">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Report Generator</h3>
                            <p class="mt-1 text-sm text-gray-500">Create customized reports with specific criteria and date ranges</p>
                        </div>
                        <div class="p-6">
                            <form class="space-y-6">
                                <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
                                    <div>
                                        <label for="report-type" class="block text-sm font-medium text-gray-700">Report Type</label>
                                        <select id="report-type" name="report-type" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                            <option>Incident Summary</option>
                                            <option>Performance Analysis</option>
                                            <option>Risk Assessment</option>
                                            <option>System Status</option>
                                            <option>Custom Analysis</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="start-date" class="block text-sm font-medium text-gray-700">Start Date</label>
                                        <input type="date" name="start-date" id="start-date" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    <div>
                                        <label for="end-date" class="block text-sm font-medium text-gray-700">End Date</label>
                                        <input type="date" name="end-date" id="end-date" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                    <div>
                                        <label for="region-filter" class="block text-sm font-medium text-gray-700">Region Filter</label>
                                        <select id="region-filter" name="region-filter" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                            <option>All Regions</option>
                                            <option>Riau Province</option>
                                            <option>Central Kalimantan</option>
                                            <option>West Java</option>
                                            <option>East Java</option>
                                            <option>Sumatra</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="severity-filter" class="block text-sm font-medium text-gray-700">Severity Level</label>
                                        <select id="severity-filter" name="severity-filter" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                            <option>All Levels</option>
                                            <option>Critical</option>
                                            <option>High</option>
                                            <option>Medium</option>
                                            <option>Low</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="flex justify-end space-x-3">
                                    <button type="button" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Preview
                                    </button>
                                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <i class="fas fa-download mr-2 h-4 w-4"></i>
                                        Generate Report
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Recent reports -->
                    <div class="bg-white shadow rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200 sm:flex sm:items-center sm:justify-between">
                            <div>
                                <h3 class="text-lg leading-6 font-medium text-gray-900">Recent Reports</h3>
                                <p class="mt-1 text-sm text-gray-500">Latest generated reports and documentation</p>
                            </div>
                            <div class="mt-3 sm:mt-0">
                                <div class="flex space-x-3">
                                    <button type="button" class="bg-white py-1 px-3 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <i class="fas fa-filter mr-1 h-3 w-3"></i>
                                        Filter
                                    </button>
                                    <button type="button" class="bg-white py-1 px-3 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <i class="fas fa-sort mr-1 h-3 w-3"></i>
                                        Sort
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Report Name</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date Range</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Generated By</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                                        <th class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-8 w-8">
                                                    <div class="h-8 w-8 bg-red-100 rounded-lg flex items-center justify-center">
                                                        <i class="fas fa-file-pdf text-red-600 text-sm"></i>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">December 2024 Incident Summary</div>
                                                    <div class="text-sm text-gray-500">Complete monthly analysis</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                Monthly Summary
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Dec 1-31, 2024</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">System Auto</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <i class="fas fa-check mr-1 h-3 w-3"></i>
                                                Ready
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2 hours ago</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex justify-end space-x-2">
                                                <button class="text-blue-600 hover:text-blue-900">
                                                    <i class="fas fa-eye h-4 w-4"></i>
                                                </button>
                                                <button class="text-green-600 hover:text-green-900">
                                                    <i class="fas fa-download h-4 w-4"></i>
                                                </button>
                                                <button class="text-gray-600 hover:text-gray-900">
                                                    <i class="fas fa-share h-4 w-4"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-8 w-8">
                                                    <div class="h-8 w-8 bg-orange-100 rounded-lg flex items-center justify-center">
                                                        <i class="fas fa-file-excel text-orange-600 text-sm"></i>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">Riau Province Risk Assessment</div>
                                                    <div class="text-sm text-gray-500">High-risk area analysis</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                                Risk Assessment
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Nov 15-Dec 15, 2024</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Admin User</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                <i class="fas fa-clock mr-1 h-3 w-3"></i>
                                                Processing
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">1 day ago</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex justify-end space-x-2">
                                                <button class="text-blue-600 hover:text-blue-900">
                                                    <i class="fas fa-eye h-4 w-4"></i>
                                                </button>
                                                <button class="text-gray-400 cursor-not-allowed">
                                                    <i class="fas fa-download h-4 w-4"></i>
                                                </button>
                                                <button class="text-gray-600 hover:text-gray-900">
                                                    <i class="fas fa-share h-4 w-4"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-8 w-8">
                                                    <div class="h-8 w-8 bg-green-100 rounded-lg flex items-center justify-center">
                                                        <i class="fas fa-file-alt text-green-600 text-sm"></i>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">System Performance Report</div>
                                                    <div class="text-sm text-gray-500">Weekly system health check</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                System Report
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Dec 9-15, 2024</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">System Auto</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <i class="fas fa-check mr-1 h-3 w-3"></i>
                                                Ready
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">3 days ago</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex justify-end space-x-2">
                                                <button class="text-blue-600 hover:text-blue-900">
                                                    <i class="fas fa-eye h-4 w-4"></i>
                                                </button>
                                                <button class="text-green-600 hover:text-green-900">
                                                    <i class="fas fa-download h-4 w-4"></i>
                                                </button>
                                                <button class="text-gray-600 hover:text-gray-900">
                                                    <i class="fas fa-share h-4 w-4"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                            <div class="flex-1 flex justify-between sm:hidden">
                                <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">Previous</a>
                                <a href="#" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">Next</a>
                            </div>
                            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                                <div>
                                    <p class="text-sm text-gray-700">
                                        Showing <span class="font-medium">1</span> to <span class="font-medium">10</span> of <span class="font-medium">97</span> results
                                    </p>
                                </div>
                                <div>
                                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                                        <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                            <span class="sr-only">Previous</span>
                                            <i class="fas fa-chevron-left h-5 w-5"></i>
                                        </a>
                                        <a href="#" class="bg-blue-50 border-blue-500 text-blue-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium">1</a>
                                        <a href="#" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">2</a>
                                        <a href="#" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">3</a>
                                        <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                            <span class="sr-only">Next</span>
                                            <i class="fas fa-chevron-right h-5 w-5"></i>
                                        </a>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
</body>
</html>