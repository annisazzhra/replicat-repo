<!DOCTYPE html>
<html lang="id" class="h-full bg-gradient-to-br from-gray-50 to-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Analytics - Hotspot Vigilance</title>
    <meta name="description" content="Analytics dan laporan monitoring kebakaran hutan real-time untuk Sumatera Selatan.">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        * { font-family: 'Inter', sans-serif; }
        .glass-effect { backdrop-filter: blur(10px); background-color: rgba(255, 255, 255, 0.95); }
        .gradient-border { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 1px; border-radius: 12px; }
        .gradient-border-content { background: white; border-radius: 11px; }
        .hover-lift { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .hover-lift:hover { transform: translateY(-4px); box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); }
        .pulse-ring { animation: pulse-ring 2s cubic-bezier(0.455, 0.03, 0.515, 0.955) infinite; }
        @keyframes pulse-ring { 0% { transform: scale(0.33); } 40%, 50% { opacity: 0; } 100% { opacity: 0; transform: scale(1.2); } }
    </style>
</head>
<body class="h-full bg-gradient-to-br from-gray-50 to-gray-100" 
      x-data="{
          sidebarOpen: false,
          sidebarCollapsed: false,
          refreshing: false,
          analyticsData: {
              totalIncidents: 0,
              highRiskAreas: 0,
              activeSensors: 0,
              avgResponseTime: 0,
              trends: [],
              heatmapData: [],
              alerts: []
          },
          realtimeStatus: 'connecting',
          lastUpdate: null,
          
          // Initialize analytics
          init() {
              this.loadAnalyticsData();
              this.connectWebSocket();
              setInterval(() => this.loadAnalyticsData(), 30000); // Refresh every 30 seconds
          },
          
          // Load analytics data from API
          async loadAnalyticsData() {
              this.refreshing = true;
              try {
                  // Replace with actual API endpoints
                  const response = await fetch('/api/analytics/data');
                  if (response.ok) {
                      const data = await response.json();
                      this.analyticsData = data || {
                          totalIncidents: 0,
                          highRiskAreas: 0,
                          activeSensors: 0,
                          avgResponseTime: 0,
                          trends: [],
                          heatmapData: [],
                          alerts: []
                      };
                      this.lastUpdate = new Date().toLocaleTimeString('id-ID');
                      this.realtimeStatus = 'connected';
                  }
              } catch (error) {
                  console.error('Error loading analytics data:', error);
                  this.realtimeStatus = 'error';
              } finally {
                  this.refreshing = false;
              }
          },
          
          // Connect to WebSocket for real-time updates
          connectWebSocket() {
              try {
                  // Replace with actual WebSocket endpoint
                  const ws = new WebSocket('wss://your-websocket-endpoint');
                  ws.onopen = () => { this.realtimeStatus = 'connected'; };
                  ws.onmessage = (event) => {
                      const data = JSON.parse(event.data);
                      if (data.type === 'analytics_update') {
                          this.analyticsData = { ...this.analyticsData, ...data.payload };
                      }
                  };
                  ws.onclose = () => { this.realtimeStatus = 'disconnected'; };
                  ws.onerror = () => { this.realtimeStatus = 'error'; };
              } catch (error) {
                  this.realtimeStatus = 'error';
              }
          },
          
          // Manual refresh
          async refreshData() {
              await this.loadAnalyticsData();
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
                        <p class="text-xs text-blue-600 font-medium">Analytics</p>
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
                    <a href="/analitik" class="flex items-center px-3 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl shadow-md">
                        <i class="fas fa-chart-line text-white mr-3 flex-shrink-0 h-5 w-5"></i>
                        Analytics
                    </a>
                    <a href="/laporan" class="flex items-center px-3 py-2.5 text-sm font-medium text-gray-700 rounded-xl hover:text-gray-900 hover:bg-gray-100/50 group transition-all duration-200">
                        <i class="fas fa-file-alt text-gray-400 mr-3 flex-shrink-0 h-5 w-5"></i>
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
                            <div class="absolute -top-1 -right-1 w-4 h-4 bg-green-400 rounded-full" 
                                 :class="{
                                     'animate-pulse': realtimeStatus === 'connected',
                                     'bg-yellow-400': realtimeStatus === 'connecting',
                                     'bg-red-400': realtimeStatus === 'error'
                                 }"></div>
                        </div>
                        <div class="ml-4 transition-opacity duration-300" :class="sidebarCollapsed ? 'opacity-0 lg:hidden' : 'opacity-100'">
                            <h1 class="text-xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 bg-clip-text text-transparent">Hotspot Vigilance</h1>
                            <p class="text-xs font-medium text-blue-600 tracking-wide uppercase">Analytics</p>
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
                        <a href="/analitik" class="flex items-center px-3 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow-md group"
                           :class="sidebarCollapsed ? 'justify-center' : ''">
                            <i class="fas fa-chart-line text-white flex-shrink-0 h-5 w-5" 
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
                        <a href="/laporan" class="flex items-center px-3 py-2.5 text-sm font-medium text-gray-700 rounded-lg hover:text-gray-900 hover:bg-gray-100/50 group transition-all duration-200"
                           :class="sidebarCollapsed ? 'justify-center' : ''">
                            <i class="fas fa-file-alt text-gray-400 group-hover:text-blue-500 flex-shrink-0 h-5 w-5 transition-colors duration-200" 
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
                                    <p class="text-xs text-gray-500">Analytics Manager</p>
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
                            <input id="search-field" class="block w-full h-full pl-8 pr-3 py-2 border-transparent text-gray-900 placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-0 focus:border-transparent" placeholder="Search analytics data..." type="search">
                        </div>
                    </div>
                </div>
                <div class="ml-4 flex items-center md:ml-6 space-x-4">
                    <!-- Refresh button -->
                    <button type="button" @click="refreshData()" 
                            :disabled="refreshing"
                            class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50">
                        <i class="fas fa-sync-alt mr-2 h-4 w-4" :class="refreshing ? 'animate-spin' : ''"></i>
                        <span x-text="refreshing ? 'Refreshing...' : 'Refresh'"></span>
                    </button>

                    <!-- Export button -->
                    <button type="button" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-download mr-2 h-4 w-4"></i>
                        Export Data
                    </button>

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

        <!-- Page header with status indicator -->
        <div class="bg-white/80 backdrop-blur-sm border-b border-gray-200 px-4 py-6 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
            <div class="flex-1 min-w-0">
                <div class="flex items-center space-x-3">
                    <div class="relative">
                        <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-chart-line text-white text-xl"></i>
                        </div>
                        <div class="absolute -top-1 -right-1 w-4 h-4 rounded-full" 
                             :class="{
                                 'bg-green-400 animate-pulse': realtimeStatus === 'connected',
                                 'bg-yellow-400 animate-pulse': realtimeStatus === 'connecting',
                                 'bg-red-400': realtimeStatus === 'error'
                             }"></div>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 bg-clip-text text-transparent sm:text-3xl">
                            Analytics Dashboard
                        </h1>
                        <p class="mt-1 text-sm text-gray-500">
                            Comprehensive hotspot monitoring and analysis
                        </p>
                        <div class="mt-1 flex items-center space-x-4">
                            <span class="text-xs" 
                                  :class="{
                                      'text-green-600': realtimeStatus === 'connected',
                                      'text-yellow-600': realtimeStatus === 'connecting',
                                      'text-red-600': realtimeStatus === 'error'
                                  }"
                                  x-text="realtimeStatus === 'connected' ? 'Real-time Data Active' : 
                                         realtimeStatus === 'connecting' ? 'Connecting...' : 'Connection Error'"></span>
                            <span class="text-xs text-gray-400" x-show="lastUpdate" x-text="`Last updated: ${lastUpdate}`"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4 flex space-x-3 sm:mt-0 sm:ml-4">
                <button type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 hover-lift">
                    <i class="fas fa-cog -ml-1 mr-2 h-4 w-4 text-gray-500"></i>
                    Settings
                </button>
                <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 hover-lift">
                    <i class="fas fa-file-export -ml-1 mr-2 h-4 w-4"></i>
                    Generate Report
                </button>
            </div>
        </div>

        <!-- Main content area -->
        <main class="flex-1 relative overflow-y-auto focus:outline-none">
            <div class="py-8">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <!-- Stats overview with modern cards -->
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-8">
                        <!-- Total Incidents Card -->
                        <div class="gradient-border hover-lift">
                            <div class="gradient-border-content p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center shadow-lg">
                                            <i class="fas fa-fire text-white text-lg"></i>
                                        </div>
                                    </div>
                                    <div class="ml-4 w-0 flex-1">
                                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide">Total Incidents</h3>
                                        <p class="text-2xl font-bold text-gray-900" x-text="analyticsData.totalIncidents || '0'">0</p>
                                    </div>
                                </div>
                                <div class="mt-4 flex items-center text-sm">
                                    <div class="flex items-center text-green-600">
                                        <i class="fas fa-arrow-up text-xs mr-1"></i>
                                        <span class="font-medium">Live Data</span>
                                    </div>
                                    <span class="text-gray-500 ml-2">from API</span>
                                </div>
                            </div>
                        </div>

                        <!-- High Risk Areas Card -->
                        <div class="gradient-border hover-lift">
                            <div class="gradient-border-content p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg">
                                            <i class="fas fa-exclamation-triangle text-white text-lg"></i>
                                        </div>
                                    </div>
                                    <div class="ml-4 w-0 flex-1">
                                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide">High Risk Areas</h3>
                                        <p class="text-2xl font-bold text-gray-900" x-text="analyticsData.highRiskAreas || '0'">0</p>
                                    </div>
                                </div>
                                <div class="mt-4 flex items-center text-sm">
                                    <div class="flex items-center text-blue-600">
                                        <i class="fas fa-sync-alt text-xs mr-1"></i>
                                        <span class="font-medium">Real-time</span>
                                    </div>
                                    <span class="text-gray-500 ml-2">monitoring</span>
                                </div>
                            </div>
                        </div>

                        <!-- Active Sensors Card -->
                        <div class="gradient-border hover-lift">
                            <div class="gradient-border-content p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                                            <i class="fas fa-satellite-dish text-white text-lg"></i>
                                        </div>
                                    </div>
                                    <div class="ml-4 w-0 flex-1">
                                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide">Active Sensors</h3>
                                        <p class="text-2xl font-bold text-gray-900" x-text="analyticsData.activeSensors || '0'">0</p>
                                    </div>
                                </div>
                                <div class="mt-4 flex items-center text-sm">
                                    <div class="flex items-center text-green-600">
                                        <i class="fas fa-circle text-xs mr-1"></i>
                                        <span class="font-medium">Online</span>
                                    </div>
                                    <span class="text-gray-500 ml-2">sensors</span>
                                </div>
                            </div>
                        </div>

                        <!-- Response Time Card -->
                        <div class="gradient-border hover-lift">
                            <div class="gradient-border-content p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                                            <i class="fas fa-clock text-white text-lg"></i>
                                        </div>
                                    </div>
                                    <div class="ml-4 w-0 flex-1">
                                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide">Avg Response</h3>
                                        <p class="text-2xl font-bold text-gray-900" x-text="analyticsData.avgResponseTime ? analyticsData.avgResponseTime + ' min' : '0 min'">0 min</p>
                                    </div>
                                </div>
                                <div class="mt-4 flex items-center text-sm">
                                    <div class="flex items-center text-purple-600">
                                        <i class="fas fa-chart-line text-xs mr-1"></i>
                                        <span class="font-medium">Analytics</span>
                                    </div>
                                    <span class="text-gray-500 ml-2">tracking</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Charts and analytics section -->
                    <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
                        <!-- Incident Trends Chart -->
                        <div class="bg-white/80 backdrop-blur-sm shadow-xl rounded-2xl border border-gray-200/50 hover-lift">
                            <div class="px-6 py-4 border-b border-gray-200/50">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-semibold text-gray-900">Incident Trends</h3>
                                    <div class="flex items-center space-x-2">
                                        <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                                        <span class="text-xs text-gray-500">Live Data</span>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-500 mt-1">Historical incident pattern analysis</p>
                            </div>
                            <div class="p-6">
                                <div class="h-64 flex items-center justify-center bg-gray-50 rounded-lg">
                                    <div class="text-center">
                                        <i class="fas fa-chart-line text-gray-400 text-3xl mb-4"></i>
                                        <p class="text-gray-500 text-sm">Chart will be populated with API data</p>
                                        <button type="button" class="mt-2 text-blue-600 text-sm hover:text-blue-700" onclick="initChart('trendsChart')">Load Chart</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Area Distribution Chart -->
                        <div class="bg-white/80 backdrop-blur-sm shadow-xl rounded-2xl border border-gray-200/50 hover-lift">
                            <div class="px-6 py-4 border-b border-gray-200/50">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-semibold text-gray-900">Risk Distribution</h3>
                                    <div class="flex items-center space-x-2">
                                        <div class="w-2 h-2 bg-blue-400 rounded-full animate-pulse"></div>
                                        <span class="text-xs text-gray-500">Regional Data</span>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-500 mt-1">Risk level distribution by region</p>
                            </div>
                            <div class="p-6">
                                <div class="h-64 flex items-center justify-center bg-gray-50 rounded-lg">
                                    <div class="text-center">
                                        <i class="fas fa-map text-gray-400 text-3xl mb-4"></i>
                                        <p class="text-gray-500 text-sm">Distribution chart will load from API</p>
                                        <button type="button" class="mt-2 text-blue-600 text-sm hover:text-blue-700" onclick="initChart('distributionChart')">Load Chart</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Alert Status Overview -->
                        <div class="bg-white/80 backdrop-blur-sm shadow-xl rounded-2xl border border-gray-200/50 hover-lift">
                            <div class="px-6 py-4 border-b border-gray-200/50">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-semibold text-gray-900">Alert Status</h3>
                                    <div class="flex items-center space-x-2">
                                        <div class="w-2 h-2 bg-yellow-400 rounded-full animate-pulse"></div>
                                        <span class="text-xs text-gray-500">Active Monitoring</span>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-500 mt-1">Current alert status and severity levels</p>
                            </div>
                            <div class="p-6">
                                <div class="space-y-4" x-show="analyticsData.alerts && analyticsData.alerts.length > 0">
                                    <template x-for="alert in analyticsData.alerts" :key="alert.id">
                                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                            <div class="flex items-center space-x-3">
                                                <div class="w-3 h-3 rounded-full" 
                                                     :class="{
                                                         'bg-red-500': alert.severity === 'critical',
                                                         'bg-orange-500': alert.severity === 'high',
                                                         'bg-yellow-500': alert.severity === 'medium',
                                                         'bg-green-500': alert.severity === 'low'
                                                     }"></div>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900" x-text="alert.title"></p>
                                                    <p class="text-xs text-gray-500" x-text="alert.location"></p>
                                                </div>
                                            </div>
                                            <span class="text-xs text-gray-400" x-text="alert.time"></span>
                                        </div>
                                    </template>
                                </div>
                                <div x-show="!analyticsData.alerts || analyticsData.alerts.length === 0" class="text-center py-8">
                                    <i class="fas fa-shield-alt text-gray-400 text-3xl mb-4"></i>
                                    <p class="text-gray-500 text-sm">No active alerts</p>
                                    <p class="text-gray-400 text-xs">All systems operating normally</p>
                                </div>
                            </div>
                        </div>

                        <!-- Performance Metrics -->
                        <div class="bg-white/80 backdrop-blur-sm shadow-xl rounded-2xl border border-gray-200/50 hover-lift">
                            <div class="px-6 py-4 border-b border-gray-200/50">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-semibold text-gray-900">Performance Metrics</h3>
                                    <div class="flex items-center space-x-2">
                                        <div class="w-2 h-2 bg-purple-400 rounded-full animate-pulse"></div>
                                        <span class="text-xs text-gray-500">System Health</span>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-500 mt-1">System performance and uptime statistics</p>
                            </div>
                            <div class="p-6">
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600">System Uptime</span>
                                        <span class="text-sm font-medium text-green-600">99.9%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-green-500 h-2 rounded-full" style="width: 99.9%"></div>
                                    </div>
                                    
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600">Data Processing</span>
                                        <span class="text-sm font-medium text-blue-600">95.2%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-blue-500 h-2 rounded-full" style="width: 95.2%"></div>
                                    </div>
                                    
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600">Alert Response</span>
                                        <span class="text-sm font-medium text-purple-600">97.8%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-purple-500 h-2 rounded-full" style="width: 97.8%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
                                    <p class="mt-1 text-sm text-gray-500">Monthly hotspot incidents over the past year</p>
                                </div>
                                <div class="p-6">
                                    <canvas id="incidentTrendsChart" class="w-full h-64"></canvas>
                                </div>
                            </div>

                            <!-- Risk Level Distribution -->
                            <div class="bg-white shadow rounded-lg">
                                <div class="px-6 py-4 border-b border-gray-200">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900">Risk Level Distribution</h3>
                                    <p class="mt-1 text-sm text-gray-500">Current distribution of risk levels across regions</p>
                                </div>
                                <div class="p-6">
                                    <canvas id="riskDistributionChart" class="w-full h-64"></canvas>
                                </div>
                            </div>

                            <!-- Response Time Analysis -->
                            <div class="bg-white shadow rounded-lg">
                                <div class="px-6 py-4 border-b border-gray-200">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900">Response Time Analysis</h3>
                                    <p class="mt-1 text-sm text-gray-500">Average response times by incident severity</p>
                                </div>
                                <div class="p-6">
                                    <canvas id="responseTimeChart" class="w-full h-64"></canvas>
                                </div>
                            </div>

                            <!-- Geographic Heat Map -->
                            <div class="bg-white shadow rounded-lg">
                                <div class="px-6 py-4 border-b border-gray-200">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900">Geographic Distribution</h3>
                                    <p class="mt-1 text-sm text-gray-500">Hotspot incidents by region</p>
                                </div>
                                <div class="p-6">
                                    <div class="bg-gray-100 rounded-lg h-64 flex items-center justify-center">
                                        <div class="text-center">
                                            <i class="fas fa-map-marked-alt text-4xl text-gray-400 mb-4"></i>
                                            <p class="text-gray-600">Interactive heat map coming soon</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


<script>
// Initialize analytics dashboard when page loads
document.addEventListener('DOMContentLoaded', function() {
    console.log('Analytics dashboard loaded');
    
    // Initialize empty charts that will be populated by API data
    window.initChart = function(chartId) {
        console.log('Initializing chart:', chartId);
        
        if (chartId === 'trendsChart') {
            // This would be replaced with actual chart initialization using Chart.js
            alert('Trends chart would be initialized with API data');
        } else if (chartId === 'distributionChart') {
            // This would be replaced with actual chart initialization using Chart.js
            alert('Distribution chart would be initialized with API data');
        }
    };
    
    // Sample function to demonstrate real-time updates
    window.updateAnalyticsData = function(newData) {
        console.log('Updating analytics with new data:', newData);
        // This would update the Alpine.js data store
        // The actual implementation would depend on your WebSocket/API structure
    };
});

// Chart initialization functions that would be called by Alpine.js or API responses
function initIncidentTrendsChart(data) {
    // Chart.js implementation for incident trends
    console.log('Initializing incident trends chart with data:', data);
    
    // Example implementation - replace with actual Chart.js code
    // const ctx = document.getElementById('trendsChart').getContext('2d');
    // new Chart(ctx, {
    //     type: 'line',
    //     data: data,
    //     options: { responsive: true, maintainAspectRatio: false }
    // });
}

function initRiskDistributionChart(data) {
    // Chart.js implementation for risk distribution
    console.log('Initializing risk distribution chart with data:', data);
    
    // Example implementation - replace with actual Chart.js code
    // const ctx = document.getElementById('distributionChart').getContext('2d');
    // new Chart(ctx, {
    //     type: 'doughnut',
    //     data: data,
    //     options: { responsive: true, maintainAspectRatio: false }
    // });
}

function initPerformanceMetrics(data) {
    // Update performance metrics with real data
    console.log('Updating performance metrics with data:', data);
}

// Function to export analytics data
function exportAnalyticsData() {
    console.log('Exporting analytics data...');
    // This would trigger data export functionality
    alert('Export functionality would be implemented here');
}

// Function to generate reports
function generateReport() {
    console.log('Generating analytics report...');
    // This would trigger report generation
    alert('Report generation would be implemented here');
}
</script>

</body>
</html>