<!DOCTYPE html>
<html lang="id" class="h-full bg-gradient-to-br from-gray-50 to-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - Hotspot Vigilance</title>
    <meta name="description" content="Dashboard monitoring kebakaran hutan real-time untuk Sumatera Selatan.">
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
          stats: {
              activeHotspots: 0,
              alertsToday: 0,
              coverage: 0,
              responseTime: 0
          },
          notifications: [],
          realtimeStatus: 'connecting',
          lastUpdate: null,
          
          // Initialize dashboard
          init() {
              this.loadDashboardData();
              this.connectWebSocket();
              setInterval(() => this.loadDashboardData(), 30000); // Refresh every 30 seconds
          },
          
          // Load dashboard data from API
          async loadDashboardData() {
              this.refreshing = true;
              try {
                  // Replace with actual API endpoints
                  const response = await fetch('/api/dashboard/stats');
                  if (response.ok) {
                      const data = await response.json();
                      this.stats = data.stats || {
                          activeHotspots: 0,
                          alertsToday: 0,
                          coverage: 0,
                          responseTime: 0
                      };
                      this.notifications = data.notifications || [];
                      this.lastUpdate = new Date().toLocaleTimeString('id-ID');
                      this.realtimeStatus = 'connected';
                  }
              } catch (error) {
                  console.error('Error loading dashboard data:', error);
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
                      if (data.type === 'stats_update') {
                          this.stats = data.stats;
                      } else if (data.type === 'new_alert') {
                          this.notifications.unshift(data.alert);
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
              await this.loadDashboardData();
          }
      }">

    <!-- Dashboard Sidebar -->
    <div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:flex-col transition-all duration-300 ease-in-out"
         :class="sidebarCollapsed ? 'lg:w-20' : 'lg:w-80'">
        <div class="flex grow flex-col gap-y-5 overflow-y-auto glass-effect border-r border-gray-200/50 shadow-xl px-6 pb-4">
            <!-- Logo -->
            <div class="flex h-20 shrink-0 items-center" :class="sidebarCollapsed ? 'justify-center' : ''">
                <div class="flex items-center">
                    <div class="relative">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 via-purple-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-fire text-white text-xl"></i>
                        </div>
                        <div class="absolute -top-1 -right-1 w-4 h-4 bg-green-400 rounded-full pulse-ring"></div>
                        <div class="absolute -top-1 -right-1 w-4 h-4 bg-green-400 rounded-full"></div>
                    </div>
                    <div class="ml-4 transition-opacity duration-300" :class="sidebarCollapsed ? 'opacity-0 lg:hidden' : 'opacity-100'">
                        <h1 class="text-xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 bg-clip-text text-transparent">Hotspot Vigilance</h1>
                        <p class="text-xs font-medium text-blue-600 tracking-wide uppercase">Monitoring System</p>
                    </div>
                </div>
            </div>
            
            <!-- Collapse Toggle -->
            <div class="flex" :class="sidebarCollapsed ? 'justify-center' : 'justify-end'">
                <button @click="sidebarCollapsed = !sidebarCollapsed" 
                        class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100/50 rounded-lg transition-all duration-200 group">
                    <i class="fas fa-chevron-left h-4 w-4 group-hover:scale-110 transition-transform duration-200" 
                       :class="sidebarCollapsed ? 'rotate-180' : ''"></i>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="flex flex-1 flex-col">
                <ul role="list" class="flex flex-1 flex-col gap-y-7">
                    <li>
                        <ul role="list" class="space-y-1">
                            <li>
                                <div class="relative group">
                                    <a href="/dashboard" class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white group flex gap-x-3 rounded-xl p-3 text-sm leading-6 font-semibold shadow-lg"
                                       :class="sidebarCollapsed ? 'justify-center' : ''">
                                        <i class="fas fa-chart-line h-5 w-5 shrink-0"></i>
                                        <span class="transition-opacity duration-300" :class="sidebarCollapsed ? 'opacity-0 lg:hidden' : 'opacity-100'">Dashboard</span>
                                    </a>
                                    <div x-show="sidebarCollapsed" 
                                         class="hidden lg:block absolute left-full ml-3 px-3 py-2 bg-gray-900 text-white text-sm rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap z-50 shadow-lg"
                                         style="top: 50%; transform: translateY(-50%);">
                                        Dashboard
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="relative group">
                                    <a href="/peta" class="text-gray-700 hover:text-indigo-600 hover:bg-indigo-50/50 group flex gap-x-3 rounded-xl p-3 text-sm leading-6 font-semibold transition-all duration-200"
                                       :class="sidebarCollapsed ? 'justify-center' : ''">
                                        <i class="fas fa-map-marked-alt text-gray-400 group-hover:text-indigo-600 h-5 w-5 shrink-0 transition-colors duration-200"></i>
                                        <span class="transition-opacity duration-300" :class="sidebarCollapsed ? 'opacity-0 lg:hidden' : 'opacity-100'">Peta Interaktif</span>
                                    </a>
                                    <div x-show="sidebarCollapsed" 
                                         class="hidden lg:block absolute left-full ml-3 px-3 py-2 bg-gray-900 text-white text-sm rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap z-50 shadow-lg"
                                         style="top: 50%; transform: translateY(-50%);">
                                        Peta Interaktif
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="relative group">
                                    <a href="/analitik" class="text-gray-700 hover:text-indigo-600 hover:bg-indigo-50/50 group flex gap-x-3 rounded-xl p-3 text-sm leading-6 font-semibold transition-all duration-200"
                                       :class="sidebarCollapsed ? 'justify-center' : ''">
                                        <i class="fas fa-chart-bar text-gray-400 group-hover:text-indigo-600 h-5 w-5 shrink-0 transition-colors duration-200"></i>
                                        <span class="transition-opacity duration-300" :class="sidebarCollapsed ? 'opacity-0 lg:hidden' : 'opacity-100'">Analytics</span>
                                    </a>
                                    <div x-show="sidebarCollapsed" 
                                         class="hidden lg:block absolute left-full ml-3 px-3 py-2 bg-gray-900 text-white text-sm rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap z-50 shadow-lg"
                                         style="top: 50%; transform: translateY(-50%);">
                                        Analytics
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="relative group">
                                    <a href="/laporan" class="text-gray-700 hover:text-indigo-600 hover:bg-indigo-50/50 group flex gap-x-3 rounded-xl p-3 text-sm leading-6 font-semibold transition-all duration-200"
                                       :class="sidebarCollapsed ? 'justify-center' : ''">
                                        <i class="fas fa-file-alt text-gray-400 group-hover:text-indigo-600 h-5 w-5 shrink-0 transition-colors duration-200"></i>
                                        <span class="transition-opacity duration-300" :class="sidebarCollapsed ? 'opacity-0 lg:hidden' : 'opacity-100'">Laporan</span>
                                    </a>
                                    <div x-show="sidebarCollapsed" 
                                         class="hidden lg:block absolute left-full ml-3 px-3 py-2 bg-gray-900 text-white text-sm rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap z-50 shadow-lg"
                                         style="top: 50%; transform: translateY(-50%);">
                                        Laporan
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </li>

                    <!-- User Profile -->
                    <li class="mt-auto">
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
                                        <p class="text-xs text-gray-500">System Administrator</p>
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
                    </li>
                </ul>
            </nav>
        </div>
    </div>    <!-- Mobile sidebar -->
    <div x-show="sidebarOpen" class="relative z-50 lg:hidden" role="dialog" aria-modal="true">
        <div x-show="sidebarOpen" 
             x-transition:enter="transition-opacity ease-linear duration-300" 
             x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-100" 
             x-transition:leave="transition-opacity ease-linear duration-300" 
             x-transition:leave-start="opacity-100" 
             x-transition:leave-end="opacity-0" 
             class="fixed inset-0 bg-gray-900/80"></div>
        <div class="fixed inset-0 flex">
            <div x-show="sidebarOpen" 
                 x-transition:enter="transition ease-in-out duration-300 transform" 
                 x-transition:enter-start="-translate-x-full" 
                 x-transition:enter-end="translate-x-0" 
                 x-transition:leave="transition ease-in-out duration-300 transform" 
                 x-transition:leave-start="translate-x-0" 
                 x-transition:leave-end="-translate-x-full" 
                 class="relative mr-16 flex w-full max-w-xs flex-1">
                <div class="absolute left-full top-0 flex w-16 justify-center pt-5">
                    <button type="button" @click="sidebarOpen = false" class="-m-2.5 p-2.5">
                        <span class="sr-only">Close sidebar</span>
                        <i class="fas fa-times h-6 w-6 text-white"></i>
                    </button>
                </div>
                <!-- Mobile sidebar content (simplified version of desktop) -->
                <div class="flex grow flex-col gap-y-5 overflow-y-auto glass-effect px-6 pb-4">
                    <div class="flex h-16 shrink-0 items-center">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center">
                                <i class="fas fa-fire text-white text-lg"></i>
                            </div>
                            <div class="ml-3">
                                <h1 class="text-xl font-bold text-gray-900">Hotspot Vigilance</h1>
                                <p class="text-xs text-blue-600 font-medium">Monitoring</p>
                            </div>
                        </div>
                    </div>
                    <!-- Mobile navigation -->
                    <nav class="space-y-1">
                        <a href="/dashboard" class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white group flex gap-x-3 rounded-xl p-3 text-sm leading-6 font-semibold">
                            <i class="fas fa-chart-line h-5 w-5 shrink-0"></i>
                            Dashboard
                        </a>
                        <a href="/peta" class="text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 group flex gap-x-3 rounded-xl p-3 text-sm leading-6 font-semibold">
                            <i class="fas fa-map-marked-alt text-gray-400 group-hover:text-indigo-600 h-5 w-5 shrink-0 transition-colors duration-200"></i>
                            Peta Interaktif
                        </a>
                        <a href="/analitik" class="text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 group flex gap-x-3 rounded-xl p-3 text-sm leading-6 font-semibold">
                            <i class="fas fa-chart-bar text-gray-400 group-hover:text-indigo-600 h-5 w-5 shrink-0 transition-colors duration-200"></i>
                            Analytics
                        </a>
                        <a href="/laporan" class="text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 group flex gap-x-3 rounded-xl p-3 text-sm leading-6 font-semibold">
                            <i class="fas fa-file-alt text-gray-400 group-hover:text-indigo-600 h-5 w-5 shrink-0 transition-colors duration-200"></i>
                            Laporan
                        </a>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="transition-all duration-300 ease-in-out" :class="sidebarCollapsed ? 'lg:pl-20' : 'lg:pl-80'">
        <!-- Enhanced Top navigation bar -->
        <div class="sticky top-0 z-40 flex h-20 shrink-0 items-center gap-x-4 glass-effect border-b border-gray-200/50 px-4 shadow-lg sm:gap-x-6 sm:px-6 lg:px-8">
            <button type="button" @click="sidebarOpen = true" class="-m-2.5 p-2.5 text-gray-700 lg:hidden hover:bg-gray-100 rounded-lg transition-colors duration-200">
                <span class="sr-only">Open sidebar</span>
                <i class="fas fa-bars h-5 w-5"></i>
            </button>
            
            <!-- Separator -->
            <div class="h-8 w-px bg-gray-200 lg:hidden"></div>
            
            <!-- Enhanced Breadcrumb & Status -->
            <div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">
                <div class="flex items-center gap-x-6">
                    <nav class="flex" aria-label="Breadcrumb">
                        <ol role="list" class="flex items-center space-x-4">
                            <li>
                                <div class="flex items-center">
                                    <i class="fas fa-home h-4 w-4 text-gray-400"></i>
                                    <span class="ml-2 text-sm font-medium text-gray-900">Dashboard</span>
                                </div>
                            </li>
                        </ol>
                    </nav>
                    
                    <!-- Real-time Status Indicator -->
                    <div class="flex items-center space-x-2">
                        <div class="flex items-center space-x-1">
                            <div class="w-2 h-2 rounded-full" 
                                 :class="{
                                     'bg-green-400 animate-pulse': realtimeStatus === 'connected',
                                     'bg-yellow-400 animate-pulse': realtimeStatus === 'connecting',
                                     'bg-red-400': realtimeStatus === 'error',
                                     'bg-gray-400': realtimeStatus === 'disconnected'
                                 }"></div>
                            <span class="text-xs font-medium text-gray-600" x-text="realtimeStatus === 'connected' ? 'Live Data' : 
                                     realtimeStatus === 'connecting' ? 'Connecting...' : 
                                     realtimeStatus === 'error' ? 'Connection Error' : 'Offline'"></span>
                        </div>
                        <span class="text-xs text-gray-500" x-show="lastUpdate" x-text="'Last update: ' + lastUpdate"></span>
                    </div>
                </div>
                
                <!-- Enhanced Search -->
                <div class="flex flex-1 justify-center">
                    <div class="w-full max-w-lg">
                        <label for="search" class="sr-only">Search</label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <i class="fas fa-search h-4 w-4 text-gray-400"></i>
                            </div>
                            <input id="search" name="search" 
                                   class="block w-full rounded-xl border-0 py-2.5 pl-10 pr-4 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 transition-all duration-200" 
                                   placeholder="Cari hotspot, lokasi, atau analisis..." 
                                   type="search">
                        </div>
                    </div>
                </div>
                
                <!-- Enhanced Right side -->
                <div class="flex items-center gap-x-4 lg:gap-x-6">
                    <!-- Quick Actions -->
                    <div class="hidden sm:flex items-center space-x-2">
                        <button type="button" @click="refreshData()" 
                                class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-all duration-200 group"
                                :class="{ 'animate-spin': refreshing }">
                            <i class="fas fa-sync-alt h-4 w-4 group-hover:scale-110 transition-transform duration-200"></i>
                        </button>
                        
                        <button type="button" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-all duration-200 group">
                            <i class="fas fa-download h-4 w-4 group-hover:scale-110 transition-transform duration-200"></i>
                        </button>
                    </div>
                    
                    <!-- Enhanced Notifications -->
                    <div class="relative" x-data="{ open: false }">
                        <button type="button" @click="open = !open" 
                                class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-all duration-200 group">
                            <span class="sr-only">View notifications</span>
                            <div class="relative">
                                <i class="fas fa-bell h-5 w-5 group-hover:scale-110 transition-transform duration-200"></i>
                                <span x-show="notifications.length > 0" 
                                      class="absolute -top-1 -right-1 h-4 w-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center animate-pulse" 
                                      x-text="notifications.length"></span>
                            </div>
                        </button>
                        
                        <!-- Notification dropdown -->
                        <div x-show="open" @click.away="open = false" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 z-50 mt-2 w-80 origin-top-right rounded-xl bg-white py-3 shadow-xl ring-1 ring-gray-900/5">
                            <div class="px-4 py-2 border-b border-gray-100">
                                <h3 class="text-sm font-semibold text-gray-900">Notifications</h3>
                            </div>
                            <div class="max-h-96 overflow-y-auto">
                                <template x-for="notification in notifications.slice(0, 5)" :key="notification.id">
                                    <div class="px-4 py-3 hover:bg-gray-50 transition-colors duration-200">
                                        <div class="flex items-start space-x-3">
                                            <div class="flex-shrink-0 mt-0.5">
                                                <div class="w-2 h-2 rounded-full" 
                                                     :class="{
                                                         'bg-red-500': notification.severity === 'high',
                                                         'bg-yellow-500': notification.severity === 'medium',
                                                         'bg-blue-500': notification.severity === 'low'
                                                     }"></div>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm text-gray-900" x-text="notification.message"></p>
                                                <p class="text-xs text-gray-500" x-text="notification.time"></p>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                                <div x-show="notifications.length === 0" class="px-4 py-8 text-center">
                                    <i class="fas fa-bell-slash text-2xl text-gray-300 mb-2"></i>
                                    <p class="text-sm text-gray-500">No new notifications</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Enhanced Profile dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button type="button" @click="open = !open" class="flex items-center p-1.5 hover:bg-gray-100 rounded-lg transition-all duration-200">
                            <span class="sr-only">Open user menu</span>
                            <div class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center shadow-lg">
                                <i class="fas fa-user text-white text-sm"></i>
                            </div>
                            <span class="hidden lg:flex lg:items-center ml-3">
                                <span class="text-sm font-semibold leading-6 text-gray-900">{{ Auth::user()->name ?? 'Admin User' }}</span>
                                <i class="fas fa-chevron-down ml-2 h-3 w-3 text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
                            </span>
                        </button>
                        
                        <div x-show="open" @click.away="open = false" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-xl bg-white py-2 shadow-xl ring-1 ring-gray-900/5">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200">Profile Settings</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200">Team Management</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200">API Keys</a>
                            <hr class="my-1 border-gray-100">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Sign out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>        <!-- Enterprise Main dashboard content -->
        <main class="py-8">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <!-- Enhanced Header -->
                <div class="mb-10">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-3xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 bg-clip-text text-transparent sm:text-4xl sm:tracking-tight">
                                Dashboard Monitoring
                            </h1>
                            <p class="mt-2 text-lg text-gray-600">
                                Real-time forest fire monitoring untuk Sumatera Selatan
                            </p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center space-x-2 px-4 py-2 bg-green-50 rounded-xl border border-green-200">
                                <div class="flex items-center space-x-1">
                                    <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                                    <span class="text-sm text-green-700 font-medium">System Online</span>
                                </div>
                            </div>
                            <button type="button" @click="refreshData()" 
                                    class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-6 py-3 rounded-xl text-sm font-semibold transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1"
                                    :class="{ 'animate-pulse': refreshing }">
                                <i class="fas fa-sync-alt mr-2" :class="{ 'animate-spin': refreshing }"></i>
                                <span x-text="refreshing ? 'Refreshing...' : 'Refresh Data'"></span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Stats Grid -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-10">
                    <!-- Active Hotspots -->
                    <div class="gradient-border hover-lift">
                        <div class="gradient-border-content p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center shadow-lg">
                                        <i class="fas fa-fire text-white text-xl"></i>
                                    </div>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">Active Hotspots</dt>
                                        <dd class="text-3xl font-bold text-gray-900" x-text="stats.activeHotspots || '---'"></dd>
                                        <dd class="text-xs text-gray-500">Real-time monitoring</dd>
                                    </dl>
                                </div>
                                <div class="flex-shrink-0">
                                    <div class="text-right">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Live
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Alerts Today -->
                    <div class="gradient-border hover-lift">
                        <div class="gradient-border-content p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-xl flex items-center justify-center shadow-lg">
                                        <i class="fas fa-exclamation-triangle text-white text-xl"></i>
                                    </div>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">Alerts Today</dt>
                                        <dd class="text-3xl font-bold text-gray-900" x-text="stats.alertsToday || '---'"></dd>
                                        <dd class="text-xs text-gray-500">Automated detection</dd>
                                    </dl>
                                </div>
                                <div class="flex-shrink-0">
                                    <div class="text-right">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            24h
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Coverage Area -->
                    <div class="gradient-border hover-lift">
                        <div class="gradient-border-content p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                                        <i class="fas fa-shield-alt text-white text-xl"></i>
                                    </div>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">Coverage</dt>
                                        <dd class="text-3xl font-bold text-gray-900" x-text="(stats.coverage || 0) + '%'"></dd>
                                        <dd class="text-xs text-gray-500">Monitoring area</dd>
                                    </dl>
                                </div>
                                <div class="flex-shrink-0">
                                    <div class="text-right">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Optimal
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Response Time -->
                    <div class="gradient-border hover-lift">
                        <div class="gradient-border-content p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                                        <i class="fas fa-clock text-white text-xl"></i>
                                    </div>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">Response Time</dt>
                                        <dd class="text-3xl font-bold text-gray-900" x-text="(stats.responseTime || 0) + ' min'"></dd>
                                        <dd class="text-xs text-gray-500">Average response</dd>
                                    </dl>
                                </div>
                                <div class="flex-shrink-0">
                                    <div class="text-right">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            Fast
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Features Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10">
                    <!-- Real-time Map -->
                    <div class="lg:col-span-2">
                        <div class="gradient-border hover-lift h-full">
                            <div class="gradient-border-content h-full">
                                <div class="px-6 py-4 border-b border-gray-100">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900">Real-time Hotspot Map</h3>
                                            <p class="text-sm text-gray-500">Monitoring distribusi hotspot</p>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <button type="button" class="p-2 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                                                <i class="fas fa-expand-alt h-4 w-4"></i>
                                            </button>
                                            <button type="button" class="p-2 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                                                <i class="fas fa-cog h-4 w-4"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-6">
                                    <div class="bg-gradient-to-br from-green-50 via-blue-50 to-red-50 rounded-xl h-80 flex items-center justify-center border border-gray-100">
                                        <div class="text-center">
                                            <i class="fas fa-map-marked-alt text-5xl text-gray-300 mb-4"></i>
                                            <p class="text-lg font-medium text-gray-600">Interactive Map Loading...</p>
                                            <p class="text-sm text-gray-500 mt-2">Connecting to satellite data stream</p>
                                            <div class="mt-4">
                                                <div class="w-16 h-1 bg-gray-200 rounded-full mx-auto overflow-hidden">
                                                    <div class="w-full h-full bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full animate-pulse"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- AI Insights Panel -->
                    <div class="space-y-6">
                        <!-- Quick Insights -->
                        <div class="gradient-border hover-lift">
                            <div class="gradient-border-content p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-lg font-semibold text-gray-900">System Insights</h3>
                                    <i class="fas fa-lightbulb text-indigo-600"></i>
                                </div>
                                <div class="space-y-4">
                                    <div class="p-3 bg-blue-50 rounded-lg">
                                        <div class="flex items-start space-x-3">
                                            <i class="fas fa-chart-line text-blue-600 mt-1"></i>
                                            <div>
                                                <p class="text-sm font-medium text-blue-900">Data Analysis</p>
                                                <p class="text-xs text-blue-700">Loading analysis...</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-3 bg-green-50 rounded-lg">
                                        <div class="flex items-start space-x-3">
                                            <i class="fas fa-chart-bar text-green-600 mt-1"></i>
                                            <div>
                                                <p class="text-sm font-medium text-green-900">Trend Analysis</p>
                                                <p class="text-xs text-green-700">Fetching trend data...</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-3 bg-purple-50 rounded-lg">
                                        <div class="flex items-start space-x-3">
                                            <i class="fas fa-weather-sun text-purple-600 mt-1"></i>
                                            <div>
                                                <p class="text-sm font-medium text-purple-900">Weather Impact</p>
                                                <p class="text-xs text-purple-700">Analyzing conditions...</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="gradient-border hover-lift">
                            <div class="gradient-border-content p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                                <div class="space-y-3">
                                    <a href="/peta" class="block w-full bg-gradient-to-r from-indigo-50 to-purple-50 hover:from-indigo-100 hover:to-purple-100 text-indigo-700 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 border border-indigo-100">
                                        <i class="fas fa-map-marked-alt mr-2"></i>
                                        Open Interactive Map
                                    </a>
                                    <a href="/analitik" class="block w-full bg-gradient-to-r from-green-50 to-emerald-50 hover:from-green-100 hover:to-emerald-100 text-green-700 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 border border-green-100">
                                        <i class="fas fa-chart-bar mr-2"></i>
                                        View Advanced Analytics
                                    </a>
                                    <a href="/laporan" class="block w-full bg-gradient-to-r from-blue-50 to-cyan-50 hover:from-blue-100 hover:to-cyan-100 text-blue-700 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 border border-blue-100">
                                        <i class="fas fa-file-alt mr-2"></i>
                                        Generate Reports
                                    </a>
                                    <button type="button" class="block w-full bg-gradient-to-r from-orange-50 to-red-50 hover:from-orange-100 hover:to-red-100 text-orange-700 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 border border-orange-100">
                                        <i class="fas fa-download mr-2"></i>
                                        Export Data
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Advanced Analytics Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
                    <!-- Predictive Analytics Chart -->
                    <div class="gradient-border hover-lift">
                        <div class="gradient-border-content">
                            <div class="px-6 py-4 border-b border-gray-100">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">Risk Analysis</h3>
                                        <p class="text-sm text-gray-500">7-day analysis overview</p>
                                    </div>
                                    <div class="flex items-center space-x-1">
                                        <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                                        <span class="text-xs text-gray-500">Live Data</span>
                                    </div>
                                </div>
                            </div>
                            <div class="p-6">
                                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl h-64 flex items-center justify-center border border-blue-100">
                                    <div class="text-center">
                                        <i class="fas fa-chart-line text-4xl text-blue-300 mb-3"></i>
                                        <p class="text-blue-600 font-medium">Analytics Loading</p>
                                        <p class="text-sm text-blue-500">Processing data models...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Real-time Activity Feed -->
                    <div class="gradient-border hover-lift">
                        <div class="gradient-border-content">
                            <div class="px-6 py-4 border-b border-gray-100">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">Real-time Activity</h3>
                                        <p class="text-sm text-gray-500">Live system events dan alerts</p>
                                    </div>
                                    <button type="button" class="text-gray-400 hover:text-gray-600">
                                        <i class="fas fa-external-link-alt h-4 w-4"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="p-6">
                                <div class="space-y-4 max-h-64 overflow-y-auto">
                                    <template x-for="notification in notifications.slice(0, 6)" :key="notification.id">
                                        <div class="flex items-start space-x-3 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                                            <div class="flex-shrink-0 mt-1">
                                                <div class="w-2 h-2 rounded-full" 
                                                     :class="{
                                                         'bg-red-500': notification.severity === 'high',
                                                         'bg-yellow-500': notification.severity === 'medium',
                                                         'bg-blue-500': notification.severity === 'low'
                                                     }"></div>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900" x-text="notification.message"></p>
                                                <p class="text-xs text-gray-500" x-text="notification.time"></p>
                                            </div>
                                        </div>
                                    </template>
                                    <div x-show="notifications.length === 0" class="text-center py-8">
                                        <i class="fas fa-satellite-dish text-3xl text-gray-300 mb-3"></i>
                                        <p class="text-gray-500">Connecting to data stream...</p>
                                        <p class="text-xs text-gray-400">Waiting for real-time events</p>
                                    </div>
                                </div>
                                <div class="mt-4 pt-4 border-t border-gray-100">
                                    <a href="/laporan" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 flex items-center">
                                        View all activity 
                                        <i class="fas fa-arrow-right ml-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
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

    <!-- Dashboard JavaScript -->
    <script>
        // Initialize Chart.js for dashboard analytics
        document.addEventListener('DOMContentLoaded', function() {
            // Configure Chart.js defaults for dashboard theme
            if (typeof Chart !== 'undefined') {
                Chart.defaults.font.family = 'Inter, sans-serif';
                Chart.defaults.color = '#6B7280';
                Chart.defaults.borderColor = '#E5E7EB';
                Chart.defaults.backgroundColor = 'rgba(99, 102, 241, 0.1)';
            }
            
            // Load dashboard data
            if (typeof window.Alpine !== 'undefined') {
                console.log('Dashboard initialized');
            }
        });

        // WebSocket connection for real-time data
        function initializeWebSocket() {
            // This would connect to your WebSocket endpoint
            // Example: wss://your-api.com/ws/dashboard
            console.log('WebSocket connection initialized');
        }

        // Auto-refresh for dashboard
        setInterval(() => {
            if (document.visibilityState === 'visible') {
                // Trigger data refresh when page is visible
                document.dispatchEvent(new CustomEvent('dashboard-refresh'));
            }
        }, 60000); // Refresh every minute

        // Initialize dashboard features
        document.addEventListener('alpine:init', () => {
            // Additional Alpine.js initialization for dashboard features
            console.log('Alpine.js Dashboard features initialized');
        });
    </script>
</body>
</html>