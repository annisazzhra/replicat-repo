<!DOCTYPE html>
<html lang="en" class="h-full bg-gradient-to-br from-gray-50 to-gray-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <title>Reports - Hotspot Vigilance</title>
    <style>
        * { font-family: 'Inter', sans-serif; }
        .glass-effect { backdrop-filter: blur(10px); background-color: rgba(255, 255, 255, 0.95); }
        .gradient-border { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 1px; border-radius: 12px; }
        .gradient-border-content { background: white; border-radius: 11px; }
        .hover-lift { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .hover-lift:hover { transform: translateY(-2px); box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); }
    </style>
</head>
<body class="h-full bg-gradient-to-br from-gray-50 to-gray-100" 
      x-data="{ 
          sidebarOpen: false, 
          sidebarCollapsed: false,
          reportData: {
              reports: [],
              filters: {
                  dateRange: '7d',
                  severity: 'all',
                  region: 'all',
                  type: 'incident'
              },
              stats: {
                  totalReports: 0,
                  avgResponseTime: 0,
                  resolutionRate: 0,
                  activeIncidents: 0
              }
          },
          loading: false,
          
          init() {
              this.loadReports();
          },
          
          async loadReports() {
              this.loading = true;
              try {
                  const response = await fetch('/api/reports');
                  if (response.ok) {
                      const data = await response.json();
                      this.reportData = { ...this.reportData, ...data };
                  }
              } catch (error) {
                  console.error('Error loading reports:', error);
              } finally {
                  this.loading = false;
              }
          },
          
          async generateReport(type) {
              try {
                  const response = await fetch(`/api/reports/generate/${type}`, {
                      method: 'POST',
                      headers: { 'Content-Type': 'application/json' },
                      body: JSON.stringify(this.reportData.filters)
                  });
                  if (response.ok) {
                      const blob = await response.blob();
                      const url = window.URL.createObjectURL(blob);
                      const a = document.createElement('a');
                      a.href = url;
                      a.download = `${type}_report_${new Date().toISOString().split('T')[0]}.pdf`;
                      a.click();
                      window.URL.revokeObjectURL(url);
                  } else {
                      console.log(`Demo: ${type.toUpperCase()} report would be generated with current filters`);
                  }
              } catch (error) {
                  console.error('Error generating report:', error);
                  console.log(`Demo: ${type.toUpperCase()} report generation failed`);
              }
          },
          
          async refreshData() {
              await this.loadReports();
          }
      }"
      x-bind:class="sidebarOpen ? 'overflow-hidden lg:overflow-auto' : ''"
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
             class="relative flex w-full max-w-xs flex-1 flex-col glass-effect pt-5 pb-4">
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
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-fire text-white text-lg"></i>
                    </div>
                    <div class="ml-3">
                        <h1 class="text-xl font-bold text-gray-900">Hotspot Vigilance</h1>
                        <p class="text-xs text-blue-600 font-medium">Reports</p>
                    </div>
                </div>
            </div>
            <div class="mt-5 h-0 flex-1 overflow-y-auto">
                <nav class="space-y-1 px-2">
                    <a href="/dashboard" class="flex items-center px-3 py-2.5 text-sm font-medium text-gray-700 rounded-xl hover:text-gray-900 hover:bg-gray-100/50 group transition-all duration-200">
                        <i class="fas fa-tachometer-alt text-gray-400 mr-3 flex-shrink-0 h-5 w-5"></i>
                        Dashboard
                    </a>
                    <a href="/peta" class="flex items-center px-3 py-2.5 text-sm font-medium text-gray-700 rounded-xl hover:text-gray-900 hover:bg-gray-100/50 group transition-all duration-200">
                        <i class="fas fa-map text-gray-400 mr-3 flex-shrink-0 h-5 w-5"></i>
                        Interactive Map
                    </a>
                    <a href="/analitik" class="flex items-center px-3 py-2.5 text-sm font-medium text-gray-700 rounded-xl hover:text-gray-900 hover:bg-gray-100/50 group transition-all duration-200">
                        <i class="fas fa-chart-line text-gray-400 mr-3 flex-shrink-0 h-5 w-5"></i>
                        Analytics
                    </a>
                    <a href="/laporan" class="flex items-center px-3 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl shadow-md">
                        <i class="fas fa-file-alt text-white mr-3 flex-shrink-0 h-5 w-5"></i>
                        Reports
                    </a>
                </nav>
            </div>
        </div>
    </div>

    <!-- Desktop sidebar -->
    <div class="hidden lg:fixed lg:inset-y-0 lg:flex lg:flex-col transition-all duration-300 ease-in-out z-30"
         :class="sidebarCollapsed ? 'lg:w-20' : 'lg:w-80'">
        <div class="flex min-h-0 flex-1 flex-col glass-effect border-r border-gray-200/50 shadow-xl px-6 pb-4">
            <div class="flex flex-1 flex-col pt-6 pb-4 overflow-y-auto">
                <div class="flex items-center flex-shrink-0 px-4" :class="sidebarCollapsed ? 'justify-center' : ''">
                    <div class="flex items-center">
                        <div class="relative">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 via-purple-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                                <i class="fas fa-fire text-white text-xl"></i>
                            </div>
                            <div class="absolute -top-1 -right-1 w-4 h-4 bg-green-400 rounded-full animate-pulse"></div>
                        </div>
                        <div class="ml-4 transition-opacity duration-300" :class="sidebarCollapsed ? 'opacity-0 lg:hidden' : 'opacity-100'">
                            <h1 class="text-xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 bg-clip-text text-transparent">Hotspot Vigilance</h1>
                            <p class="text-xs font-medium text-blue-600 tracking-wide uppercase">Reports</p>
                        </div>
                    </div>
                </div>
                
                <!-- Collapse Toggle -->
                <div class="flex mt-6" :class="sidebarCollapsed ? 'justify-center' : 'justify-end'">
                    <button @click="sidebarCollapsed = !sidebarCollapsed" 
                            class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100/50 rounded-lg transition-all duration-200 group">
                        <i class="fas fa-chevron-left h-4 w-4 group-hover:scale-110 transition-transform duration-200" 
                           :class="sidebarCollapsed ? 'rotate-180' : ''"></i>
                    </button>
                </div>

                <nav class="mt-6 flex-1 space-y-1 px-3">
                    <div class="relative group">
                        <a href="/dashboard" class="flex items-center px-3 py-2.5 text-sm font-medium text-gray-700 rounded-lg hover:text-gray-900 hover:bg-gray-100/50 group transition-all duration-200"
                           :class="sidebarCollapsed ? 'justify-center' : ''">
                            <i class="fas fa-tachometer-alt text-gray-400 group-hover:text-blue-500 flex-shrink-0 h-5 w-5 transition-colors duration-200" 
                               :class="sidebarCollapsed ? '' : 'mr-3'"></i>
                            <span class="transition-opacity duration-300" 
                                  :class="sidebarCollapsed ? 'opacity-0 lg:hidden' : 'opacity-100'">Dashboard</span>
                        </a>
                        <div x-show="sidebarCollapsed" 
                             class="hidden lg:block absolute left-full ml-3 px-3 py-2 bg-gray-900 text-white text-sm rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap z-50 shadow-lg"
                             style="top: 50%; transform: translateY(-50%);">
                            Dashboard
                        </div>
                    </div>
                    
                    <div class="relative group">
                        <a href="/peta" class="flex items-center px-3 py-2.5 text-sm font-medium text-gray-700 rounded-lg hover:text-gray-900 hover:bg-gray-100/50 group transition-all duration-200"
                           :class="sidebarCollapsed ? 'justify-center' : ''">
                            <i class="fas fa-map text-gray-400 group-hover:text-blue-500 flex-shrink-0 h-5 w-5 transition-colors duration-200" 
                               :class="sidebarCollapsed ? '' : 'mr-3'"></i>
                            <span class="transition-opacity duration-300" 
                                  :class="sidebarCollapsed ? 'opacity-0 lg:hidden' : 'opacity-100'">Interactive Map</span>
                        </a>
                        <div x-show="sidebarCollapsed" 
                             class="hidden lg:block absolute left-full ml-3 px-3 py-2 bg-gray-900 text-white text-sm rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap z-50 shadow-lg"
                             style="top: 50%; transform: translateY(-50%);">
                            Interactive Map
                        </div>
                    </div>
                    
                    <div class="relative group">
                        <a href="/analitik" class="flex items-center px-3 py-2.5 text-sm font-medium text-gray-700 rounded-lg hover:text-gray-900 hover:bg-gray-100/50 group transition-all duration-200"
                           :class="sidebarCollapsed ? 'justify-center' : ''">
                            <i class="fas fa-chart-line text-gray-400 group-hover:text-blue-500 flex-shrink-0 h-5 w-5 transition-colors duration-200" 
                               :class="sidebarCollapsed ? '' : 'mr-3'"></i>
                            <span class="transition-opacity duration-300" 
                                  :class="sidebarCollapsed ? 'opacity-0 lg:hidden' : 'opacity-100'">Analytics</span>
                        </a>
                        <div x-show="sidebarCollapsed" 
                             class="hidden lg:block absolute left-full ml-3 px-3 py-2 bg-gray-900 text-white text-sm rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap z-50 shadow-lg"
                             style="top: 50%; transform: translateY(-50%);">
                            Analytics
                        </div>
                    </div>
                    
                    <div class="relative group">
                        <a href="/laporan" class="flex items-center px-3 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow-md group"
                           :class="sidebarCollapsed ? 'justify-center' : ''">
                            <i class="fas fa-file-alt text-white flex-shrink-0 h-5 w-5" 
                               :class="sidebarCollapsed ? '' : 'mr-3'"></i>
                            <span class="transition-opacity duration-300" 
                                  :class="sidebarCollapsed ? 'opacity-0 lg:hidden' : 'opacity-100'">Reports</span>
                        </a>
                        <div x-show="sidebarCollapsed" 
                             class="hidden lg:block absolute left-full ml-3 px-3 py-2 bg-gray-900 text-white text-sm rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap z-50 shadow-lg"
                             style="top: 50%; transform: translateY(-50%);">
                            Reports
                        </div>
                    </div>
                </nav>

                <!-- User Profile -->
                <div class="mt-auto">
                    <div class="gradient-border">
                        <div class="gradient-border-content p-4">
                            <div class="flex items-center" :class="sidebarCollapsed ? 'justify-center' : ''">
                                <div class="relative">
                                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                                        <i class="fas fa-user text-white text-sm"></i>
                                    </div>
                                    <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-400 border-2 border-white rounded-full"></div>
                                </div>
                                <div class="ml-3 flex-1 transition-opacity duration-300" :class="sidebarCollapsed ? 'opacity-0 lg:hidden' : 'opacity-100'">
                                    <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->name ?? 'Admin User' }}</p>
                                    <p class="text-xs text-gray-500">Report Manager</p>
                                </div>
                                <form method="POST" action="{{ route('logout') }}" class="transition-opacity duration-300" :class="sidebarCollapsed ? 'opacity-0 lg:hidden' : 'opacity-100'">
                                    @csrf
                                    <button type="submit" class="text-gray-400 hover:text-gray-600 p-1 rounded transition-colors duration-200">
                                        <i class="fas fa-sign-out-alt text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="flex flex-1 flex-col transition-all duration-300 ease-in-out"
         :class="sidebarCollapsed ? 'lg:pl-20' : 'lg:pl-80'">
        <!-- Top navigation -->
        <div class="sticky top-0 z-40 flex h-16 glass-effect shadow-sm border-b border-gray-200/50">
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
                            <input id="search-field" class="block w-full h-full pl-8 pr-3 py-2 border-transparent text-gray-900 placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-0 focus:border-transparent bg-transparent" placeholder="Search reports..." type="search">
                        </div>
                    </div>
                </div>
                <div class="ml-4 flex items-center md:ml-6 space-x-4">
                    <!-- Report actions -->
                    <div class="flex items-center space-x-2">
                        <button type="button" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                x-on:click="generateReport('pdf')">
                            <i class="fas fa-file-pdf mr-2 h-4 w-4 text-red-500"></i>
                            PDF
                        </button>
                        <button type="button" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                x-on:click="generateReport('excel')">
                            <i class="fas fa-file-excel mr-2 h-4 w-4 text-green-500"></i>
                            Excel
                        </button>
                    </div>

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
                             class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50">
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
        <div class="glass-effect border-b border-gray-200/50 px-6 py-6">
            <div class="flex items-center justify-between">
                <div class="min-w-0 flex-1">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg mr-4">
                            <i class="fas fa-file-alt text-white text-lg"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">
                                Reports & Analytics
                                <span x-show="loading" class="inline-flex items-center ml-3">
                                    <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-blue-500"></div>
                                </span>
                            </h1>
                            <p class="text-sm text-gray-600 mt-1">
                                Generate comprehensive reports and analyze system performance
                                <span class="inline-flex items-center ml-2 px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <span class="w-1.5 h-1.5 bg-green-400 rounded-full mr-1.5 animate-pulse"></span>
                                    Live Data
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <button type="button" x-on:click="refreshData()" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                        <i class="h-4 w-4 mr-2" :class="loading ? 'fas fa-spinner animate-spin' : 'fas fa-sync-alt'"></i>
                        <span x-text="loading ? 'Refreshing...' : 'Refresh'"></span>
                    </button>
                    <button type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                        <i class="fas fa-filter mr-2 h-4 w-4"></i>
                        Filter Reports
                    </button>
                    <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                        <i class="fas fa-plus mr-2 h-4 w-4"></i>
                        New Report
                    </button>
                </div>
            </div>
        </div>

        <!-- Main content area -->
        <main class="flex-1 relative overflow-y-auto">
            <div class="p-6 space-y-8">
                <!-- Statistics Overview -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <div class="gradient-border hover-lift">
                        <div class="gradient-border-content p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center shadow-lg">
                                        <i class="fas fa-file-alt text-white text-lg"></i>
                                    </div>
                                </div>
                                <div class="ml-4 flex-1">
                                    <p class="text-sm font-medium text-gray-600">Total Reports</p>
                                    <p class="text-2xl font-bold text-gray-900" x-text="reportData.stats.totalReports || '0'"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="gradient-border hover-lift">
                        <div class="gradient-border-content p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-xl flex items-center justify-center shadow-lg">
                                        <i class="fas fa-clock text-white text-lg"></i>
                                    </div>
                                </div>
                                <div class="ml-4 flex-1">
                                    <p class="text-sm font-medium text-gray-600">Avg Response Time</p>
                                    <p class="text-2xl font-bold text-gray-900" x-text="reportData.stats.avgResponseTime ? reportData.stats.avgResponseTime + 'm' : '0m'"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="gradient-border hover-lift">
                        <div class="gradient-border-content p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                                        <i class="fas fa-check-circle text-white text-lg"></i>
                                    </div>
                                </div>
                                <div class="ml-4 flex-1">
                                    <p class="text-sm font-medium text-gray-600">Resolution Rate</p>
                                    <p class="text-2xl font-bold text-gray-900" x-text="reportData.stats.resolutionRate ? reportData.stats.resolutionRate + '%' : '0%'"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="gradient-border hover-lift">
                        <div class="gradient-border-content p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                                        <i class="fas fa-exclamation-triangle text-white text-lg"></i>
                                    </div>
                                </div>
                                <div class="ml-4 flex-1">
                                    <p class="text-sm font-medium text-gray-600">Active Incidents</p>
                                    <p class="text-2xl font-bold text-gray-900" x-text="reportData.stats.activeIncidents || '0'"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Report Generator -->
                <div class="gradient-border hover-lift">
                    <div class="gradient-border-content">
                        <div class="p-6 border-b border-gray-200/50">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Advanced Report Generator</h3>
                                    <p class="text-sm text-gray-600 mt-1">Create custom reports with advanced filtering and analytics</p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <span class="w-1.5 h-1.5 bg-blue-400 rounded-full mr-1.5"></span>
                                        Ready
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Report Type</label>
                                    <select x-model="reportData.filters.type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                        <option value="incident">Incident Analysis</option>
                                        <option value="performance">Performance Report</option>
                                        <option value="risk">Risk Assessment</option>
                                        <option value="summary">Monthly Summary</option>
                                        <option value="custom">Custom Report</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Date Range</label>
                                    <select x-model="reportData.filters.dateRange" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                        <option value="7d">Last 7 Days</option>
                                        <option value="30d">Last 30 Days</option>
                                        <option value="90d">Last 3 Months</option>
                                        <option value="1y">Last Year</option>
                                        <option value="custom">Custom Range</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Severity Level</label>
                                    <select x-model="reportData.filters.severity" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                        <option value="all">All Levels</option>
                                        <option value="critical">Critical Only</option>
                                        <option value="high">High Risk</option>
                                        <option value="medium">Medium Risk</option>
                                        <option value="low">Low Risk</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Region Filter</label>
                                    <select x-model="reportData.filters.region" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                        <option value="all">All Regions</option>
                                        <option value="north">North Region</option>
                                        <option value="south">South Region</option>
                                        <option value="east">East Region</option>
                                        <option value="west">West Region</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Format</label>
                                    <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                        <option value="pdf">PDF Document</option>
                                        <option value="excel">Excel Spreadsheet</option>
                                        <option value="csv">CSV Data</option>
                                        <option value="json">JSON Export</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Include Charts</label>
                                    <div class="flex items-center mt-2">
                                        <input type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <label class="ml-2 text-sm text-gray-700">Include visual charts and graphs</label>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between mt-6 pt-6 border-t border-gray-200/50">
                                <div class="flex items-center space-x-4">
                                    <button type="button" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                                        <i class="fas fa-eye mr-2 h-4 w-4"></i>
                                        Preview
                                    </button>
                                    <button type="button" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                                        <i class="fas fa-save mr-2 h-4 w-4"></i>
                                        Save Template
                                    </button>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <button type="button" x-on:click="generateReport('pdf')" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-red-500 to-red-600 rounded-lg hover:from-red-600 hover:to-red-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                                        <i class="fas fa-file-pdf mr-2 h-4 w-4"></i>
                                        Generate PDF
                                    </button>
                                    <button type="button" x-on:click="generateReport('excel')" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-green-500 to-green-600 rounded-lg hover:from-green-600 hover:to-green-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                                        <i class="fas fa-file-excel mr-2 h-4 w-4"></i>
                                        Generate Excel
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Reports -->
                <div class="gradient-border hover-lift">
                    <div class="gradient-border-content">
                        <div class="p-6 border-b border-gray-200/50">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Recent Reports</h3>
                                    <p class="text-sm text-gray-600 mt-1">Latest generated reports and documentation</p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <button type="button" class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                                        <i class="fas fa-filter mr-1 h-3 w-3"></i>
                                        Filter
                                    </button>
                                    <button type="button" class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                                        <i class="fas fa-sort mr-1 h-3 w-3"></i>
                                        Sort
                                    </button>
                                    <button type="button" x-on:click="refreshData()" class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                                        <i class="h-3 w-3 mr-1" :class="loading ? 'fas fa-spinner animate-spin' : 'fas fa-sync-alt'"></i>
                                        Refresh
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Loading State -->
                        <div x-show="loading" class="p-8 text-center">
                            <div class="inline-flex items-center">
                                <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-500"></div>
                                <span class="ml-2 text-gray-600">Loading reports...</span>
                            </div>
                        </div>

                        <!-- Empty State (API-ready placeholder) -->
                        <div x-show="!loading && (!reportData.reports || reportData.reports.length === 0)" class="text-center py-12">
                            <div class="w-16 h-16 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm">
                                <i class="fas fa-file-alt text-gray-400 text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No reports available</h3>
                            <p class="text-gray-500 mb-6">Reports will appear here once generated or loaded from the API</p>
                            <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                                <i class="fas fa-plus mr-2 h-4 w-4"></i>
                                Generate Report
                            </button>
                        </div>

                        <!-- Reports Table (when data is available) -->
                        <div x-show="!loading && reportData.reports && reportData.reports.length > 0" class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50/50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Report</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <template x-for="report in reportData.reports" :key="report.id">
                                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        <div class="h-10 w-10 rounded-lg flex items-center justify-center shadow-sm"
                                                             :class="{
                                                                 'bg-red-100': report.type === 'incident',
                                                                 'bg-blue-100': report.type === 'performance',
                                                                 'bg-green-100': report.type === 'system',
                                                                 'bg-purple-100': report.type === 'custom'
                                                             }">
                                                            <i class="text-sm"
                                                               :class="{
                                                                   'fas fa-fire text-red-600': report.type === 'incident',
                                                                   'fas fa-chart-line text-blue-600': report.type === 'performance',
                                                                   'fas fa-cog text-green-600': report.type === 'system',
                                                                   'fas fa-file-alt text-purple-600': report.type === 'custom'
                                                               }"></i>
                                                        </div>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900" x-text="report.name"></div>
                                                        <div class="text-sm text-gray-500" x-text="report.description"></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium capitalize"
                                                      :class="{
                                                          'bg-red-100 text-red-800': report.type === 'incident',
                                                          'bg-blue-100 text-blue-800': report.type === 'performance',
                                                          'bg-green-100 text-green-800': report.type === 'system',
                                                          'bg-purple-100 text-purple-800': report.type === 'custom'
                                                      }"
                                                      x-text="report.type"></span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                                      :class="{
                                                          'bg-green-100 text-green-800': report.status === 'ready',
                                                          'bg-yellow-100 text-yellow-800': report.status === 'processing',
                                                          'bg-red-100 text-red-800': report.status === 'failed'
                                                      }">
                                                    <i class="mr-1 h-3 w-3"
                                                       :class="{
                                                           'fas fa-check': report.status === 'ready',
                                                           'fas fa-clock': report.status === 'processing',
                                                           'fas fa-times': report.status === 'failed'
                                                       }"></i>
                                                    <span x-text="report.status"></span>
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" x-text="report.created"></td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex items-center space-x-3">
                                                    <button class="text-blue-600 hover:text-blue-900 transition-colors duration-200 p-1 rounded hover:bg-blue-50">
                                                        <i class="fas fa-eye h-4 w-4"></i>
                                                    </button>
                                                    <button class="text-green-600 hover:text-green-900 transition-colors duration-200 p-1 rounded hover:bg-green-50" 
                                                            :class="{ 'text-gray-400 cursor-not-allowed': report.status !== 'ready' }"
                                                            :disabled="report.status !== 'ready'">
                                                        <i class="fas fa-download h-4 w-4"></i>
                                                    </button>
                                                    <button class="text-gray-600 hover:text-gray-900 transition-colors duration-200 p-1 rounded hover:bg-gray-50">
                                                        <i class="fas fa-share h-4 w-4"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
</body>
</html>