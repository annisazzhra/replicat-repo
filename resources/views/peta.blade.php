<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <title>Interactive Map - Hotspot Vigilance</title>
</head>
<body class="h-full bg-gray-50" x-data="{ sidebarOpen: false, mapPanelOpen: true }"
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
                    <a href="/peta" class="flex items-center px-2 py-2 text-sm font-medium text-gray-900 bg-gray-100 rounded-md group">
                        <i class="fas fa-map text-gray-500 mr-3 flex-shrink-0 h-6 w-6"></i>
                        Interactive Map
                    </a>
                    <a href="/analitik" class="flex items-center px-2 py-2 text-sm font-medium text-gray-700 rounded-md hover:text-gray-900 hover:bg-gray-50 group">
                        <i class="fas fa-chart-line text-gray-400 mr-3 flex-shrink-0 h-6 w-6"></i>
                        Analytics
                    </a>
                    <a href="/laporan" class="flex items-center px-2 py-2 text-sm font-medium text-gray-700 rounded-md hover:text-gray-900 hover:bg-gray-50 group">
                        <i class="fas fa-file-alt text-gray-400 mr-3 flex-shrink-0 h-6 w-6"></i>
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
                    <a href="/peta" class="flex items-center px-2 py-2 text-sm font-medium text-gray-900 bg-gray-100 rounded-md group">
                        <i class="fas fa-map text-gray-500 mr-3 flex-shrink-0 h-6 w-6"></i>
                        Interactive Map
                    </a>
                    <a href="/analitik" class="flex items-center px-2 py-2 text-sm font-medium text-gray-700 rounded-md hover:text-gray-900 hover:bg-gray-50 group">
                        <i class="fas fa-chart-line text-gray-400 mr-3 flex-shrink-0 h-6 w-6"></i>
                        Analytics
                    </a>
                    <a href="/laporan" class="flex items-center px-2 py-2 text-sm font-medium text-gray-700 rounded-md hover:text-gray-900 hover:bg-gray-50 group">
                        <i class="fas fa-file-alt text-gray-400 mr-3 flex-shrink-0 h-6 w-6"></i>
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
                            <input id="search-field" class="block w-full h-full pl-8 pr-3 py-2 border-transparent text-gray-900 placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-0 focus:border-transparent" placeholder="Search locations..." type="search">
                        </div>
                    </div>
                </div>
                <div class="ml-4 flex items-center md:ml-6 space-x-4">
                    <!-- Map controls -->
                    <div class="flex items-center space-x-2">
                        <button type="button" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-layer-group mr-2 h-4 w-4"></i>
                            Layers
                        </button>
                        <button type="button" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                x-on:click="mapPanelOpen = !mapPanelOpen">
                            <i class="fas fa-info-circle mr-2 h-4 w-4"></i>
                            <span x-text="mapPanelOpen ? 'Hide Panel' : 'Show Panel'"></span>
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

        <!-- Map interface -->
        <div class="flex-1 relative">
            <!-- Map container -->
            <div class="absolute inset-0">
                <div id="map" class="h-full w-full"></div>
            </div>

            <!-- Map overlay panel -->
            <div x-show="mapPanelOpen" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="transform translate-x-full"
                 x-transition:enter-end="transform translate-x-0"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="transform translate-x-0"
                 x-transition:leave-end="transform translate-x-full"
                 class="absolute top-0 right-0 h-full w-80 bg-white shadow-xl border-l border-gray-200 z-10 overflow-y-auto">
                
                <!-- Panel header -->
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-900">Map Information</h3>
                        <button type="button" x-on:click="mapPanelOpen = false" class="text-gray-400 hover:text-gray-500">
                            <i class="fas fa-times h-5 w-5"></i>
                        </button>
                    </div>
                </div>

                <!-- Active alerts -->
                <div class="p-6 border-b border-gray-200">
                    <h4 class="text-sm font-medium text-gray-900 mb-4">Active Alerts</h4>
                    <div class="space-y-3">
                        <div class="flex items-start space-x-3 p-3 bg-red-50 rounded-lg border border-red-200">
                            <div class="flex-shrink-0">
                                <div class="w-3 h-3 bg-red-500 rounded-full mt-1"></div>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-medium text-red-900">Critical Alert</p>
                                <p class="text-sm text-red-700">Riau Forest Sector 7</p>
                                <p class="text-xs text-red-600 mt-1">Temperature: 85°C | 2 hours ago</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-3 p-3 bg-orange-50 rounded-lg border border-orange-200">
                            <div class="flex-shrink-0">
                                <div class="w-3 h-3 bg-orange-500 rounded-full mt-1"></div>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-medium text-orange-900">High Risk</p>
                                <p class="text-sm text-orange-700">Central Kalimantan A3</p>
                                <p class="text-xs text-orange-600 mt-1">Temperature: 72°C | 5 hours ago</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-3 p-3 bg-yellow-50 rounded-lg border border-yellow-200">
                            <div class="flex-shrink-0">
                                <div class="w-3 h-3 bg-yellow-500 rounded-full mt-1"></div>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-medium text-yellow-900">Medium Risk</p>
                                <p class="text-sm text-yellow-700">West Java Highlands</p>
                                <p class="text-xs text-yellow-600 mt-1">Temperature: 58°C | 1 day ago</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Map legend -->
                <div class="p-6 border-b border-gray-200">
                    <h4 class="text-sm font-medium text-gray-900 mb-4">Legend</h4>
                    <div class="space-y-2">
                        <div class="flex items-center space-x-3">
                            <div class="w-4 h-4 bg-red-500 rounded-full"></div>
                            <span class="text-sm text-gray-700">Critical Hotspots (>80°C)</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-4 h-4 bg-orange-500 rounded-full"></div>
                            <span class="text-sm text-gray-700">High Risk (60-80°C)</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-4 h-4 bg-yellow-500 rounded-full"></div>
                            <span class="text-sm text-gray-700">Medium Risk (40-60°C)</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-4 h-4 bg-green-500 rounded-full"></div>
                            <span class="text-sm text-gray-700">Low Risk (<40°C)</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-4 h-4 bg-blue-500 rounded-full"></div>
                            <span class="text-sm text-gray-700">Monitoring Stations</span>
                        </div>
                    </div>
                </div>

                <!-- Layer controls -->
                <div class="p-6 border-b border-gray-200">
                    <h4 class="text-sm font-medium text-gray-900 mb-4">Layer Controls</h4>
                    <div class="space-y-3">
                        <label class="flex items-center">
                            <input type="checkbox" checked class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">Hotspot Markers</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" checked class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">Heat Map Overlay</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">Weather Data</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" checked class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">Monitoring Stations</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">Administrative Boundaries</span>
                        </label>
                    </div>
                </div>

                <!-- Quick statistics -->
                <div class="p-6">
                    <h4 class="text-sm font-medium text-gray-900 mb-4">Current Statistics</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-red-600">23</div>
                            <div class="text-xs text-gray-500">Active Hotspots</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600">156</div>
                            <div class="text-xs text-gray-500">Sensors Online</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600">98.7%</div>
                            <div class="text-xs text-gray-500">System Uptime</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-purple-600">4.2m</div>
                            <div class="text-xs text-gray-500">Avg Response</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Map controls (floating) -->
            <div class="absolute bottom-4 left-4 flex flex-col space-y-2 z-10">
                <button type="button" class="bg-white p-2 rounded-md shadow-lg border border-gray-200 text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <i class="fas fa-plus h-5 w-5"></i>
                </button>
                <button type="button" class="bg-white p-2 rounded-md shadow-lg border border-gray-200 text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <i class="fas fa-minus h-5 w-5"></i>
                </button>
                <button type="button" class="bg-white p-2 rounded-md shadow-lg border border-gray-200 text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <i class="fas fa-crosshairs h-5 w-5"></i>
                </button>
                <button type="button" class="bg-white p-2 rounded-md shadow-lg border border-gray-200 text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <i class="fas fa-expand h-5 w-5"></i>
                </button>
            </div>

            <!-- Map status indicator -->
            <div class="absolute top-4 left-4 z-10">
                <div class="bg-white rounded-md shadow-lg border border-gray-200 px-3 py-2">
                    <div class="flex items-center space-x-2">
                        <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                        <span class="text-sm font-medium text-gray-900">Live Monitoring</span>
                    </div>
                    <div class="text-xs text-gray-500 mt-1">Last updated: 2 minutes ago</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Initialize the map when the page loads
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Leaflet map
    var map = L.map('map').setView([-2.5489, 118.0149], 5); // Center on Indonesia

    // Add tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Sample hotspot data
    var hotspots = [
        { lat: 0.7893, lng: 113.9213, temp: 85, severity: 'critical', location: 'Riau Forest Sector 7' },
        { lat: -2.2180, lng: 113.9209, temp: 72, severity: 'high', location: 'Central Kalimantan A3' },
        { lat: -6.8885, lng: 107.6440, temp: 58, severity: 'medium', location: 'West Java Highlands' },
        { lat: -0.7893, lng: 100.6501, temp: 45, severity: 'low', location: 'Sumatra West Coast' },
        { lat: -7.2575, lng: 112.7521, temp: 67, severity: 'high', location: 'East Java Region' }
    ];

    // Add hotspot markers
    hotspots.forEach(function(hotspot) {
        var color = getColorBySeverity(hotspot.severity);
        var circle = L.circle([hotspot.lat, hotspot.lng], {
            color: color,
            fillColor: color,
            fillOpacity: 0.7,
            radius: hotspot.temp * 100
        }).addTo(map);

        circle.bindPopup(`
            <div class="p-2">
                <h4 class="font-bold text-sm">${hotspot.location}</h4>
                <p class="text-sm">Temperature: ${hotspot.temp}°C</p>
                <p class="text-sm">Severity: <span class="capitalize font-medium">${hotspot.severity}</span></p>
                <div class="mt-2">
                    <button class="bg-blue-500 text-white px-2 py-1 text-xs rounded">View Details</button>
                </div>
            </div>
        `);
    });

    // Monitoring stations
    var stations = [
        { lat: 0.5889, lng: 101.3443, name: 'Station Alpha' },
        { lat: -3.3194, lng: 114.5906, name: 'Station Beta' },
        { lat: -6.2088, lng: 106.8456, name: 'Station Gamma' },
        { lat: -7.7956, lng: 110.3695, name: 'Station Delta' }
    ];

    // Add monitoring stations
    stations.forEach(function(station) {
        var marker = L.marker([station.lat, station.lng], {
            icon: L.divIcon({
                className: 'custom-div-icon',
                html: '<div style="background-color:#3B82F6;width:12px;height:12px;border-radius:50%;border:2px solid white;"></div>',
                iconSize: [16, 16],
                iconAnchor: [8, 8]
            })
        }).addTo(map);

        marker.bindPopup(`
            <div class="p-2">
                <h4 class="font-bold text-sm">${station.name}</h4>
                <p class="text-sm">Status: <span class="text-green-600 font-medium">Online</span></p>
                <p class="text-sm">Last check: 5 minutes ago</p>
            </div>
        `);
    });

    function getColorBySeverity(severity) {
        switch(severity) {
            case 'critical': return '#EF4444';
            case 'high': return '#F59E0B';
            case 'medium': return '#EAB308';
            case 'low': return '#22C55E';
            default: return '#6B7280';
        }
    }
});
</script>

</body>
</html>