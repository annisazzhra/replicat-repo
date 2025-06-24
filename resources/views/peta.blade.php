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
    <style>
        /* Custom popup styling */
        .modern-popup .leaflet-popup-content-wrapper {
            border-radius: 12px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .modern-popup .leaflet-popup-tip {
            border-radius: 2px;
        }
        
        /* Map controls styling */
        .leaflet-control-layers {
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        .leaflet-control-zoom {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        .leaflet-control-zoom a {
            border-radius: 12px 12px 0 0;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .leaflet-control-zoom a:last-child {
            border-radius: 0 0 12px 12px;
            border-bottom: none;
        }
        
    // Enhanced CSS styling
    .leaflet-control-scale {
        border-radius: 8px;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
    }
    
    /* Modern tooltip styling */
    .modern-tooltip {
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
    }
    
    /* Search results styling */
    .search-count-badge {
        font-size: 10px;
        min-width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    /* Enhanced popup styling */
    .modern-popup .leaflet-popup-content {
        margin: 0;
        line-height: normal;
    }
    
    .modern-popup .leaflet-popup-content-wrapper {
        border-radius: 16px;
        padding: 0;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        border: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .modern-popup .leaflet-popup-tip {
        background: white;
        border: 1px solid rgba(0, 0, 0, 0.05);
        border-radius: 3px;
    }
    </style>
</head>
<body class="h-full bg-gray-50" x-data="{ sidebarOpen: false }"
    x-bind:class="sidebarOpen ? 'overflow-hidden' : ''"
    x-on:keydown.escape="sidebarOpen = false">
    
<div class="flex h-full">
    <!-- Mobile sidebar overlay -->
    <div x-show="sidebarOpen" class="fixed inset-0 z-50 lg:hidden" style="display: none;">
        <div class="fixed inset-0 bg-gray-900/80" x-on:click="sidebarOpen = false"></div>
        <div             x-show="sidebarOpen"
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
                            <input id="search-field" class="block w-full h-full pl-8 pr-12 py-2 border-transparent text-gray-900 placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-0 focus:border-transparent" placeholder="Search hotspots by location..." type="search" oninput="searchHotspots(this.value)" autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="ml-4 flex items-center md:ml-6 space-x-4">
                    <!-- Map controls -->
                    <div class="flex items-center space-x-2">
                        <button type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-layer-group mr-2 h-4 w-4"></i>
                            Layers
                        </button>
                        <button type="button" onclick="refreshHotspotData()" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-sync-alt mr-2 h-4 w-4"></i>
                            Refresh Data
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

            <!-- Map controls (modern floating buttons) -->
            <div class="absolute bottom-6 right-6 flex flex-col space-y-3 z-40">
                <button type="button" onclick="map.locate({setView: true, maxZoom: 10})" 
                        class="bg-blue-600 hover:bg-blue-700 text-white p-3 rounded-full shadow-lg border border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 backdrop-blur-lg">
                    <i class="fas fa-location-arrow h-5 w-5"></i>
                </button>
                <button type="button" onclick="map.setView([-2.5489, 118.0149], 5)" 
                        class="bg-white/90 hover:bg-white text-gray-700 p-3 rounded-full shadow-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 backdrop-blur-lg">
                    <i class="fas fa-home h-5 w-5"></i>
                </button>
                <button type="button" onclick="toggleFullscreen()" 
                        class="bg-white/90 hover:bg-white text-gray-700 p-3 rounded-full shadow-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 backdrop-blur-lg">
                    <i class="fas fa-expand h-5 w-5"></i>
                </button>
            </div>

            <!-- Map status indicator -->
            <div class="absolute top-6 left-6 z-40">
                <div class="bg-white/90 backdrop-blur-lg rounded-xl shadow-lg border border-gray-200/50 px-4 py-3">
                    <div class="flex items-center space-x-3">
                        <div class="w-3 h-3 bg-green-500 rounded-full shadow-sm"></div>
                        <div>
                            <span class="text-sm font-semibold text-gray-900">Live Monitoring</span>
                            <div class="text-xs text-gray-500 mt-0.5">Last updated: 2 minutes ago</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Initialize the map when the page loads
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Leaflet map
    var map = L.map('map', {
        zoomControl: false, // We'll add custom controls
        attributionControl: true
    }).setView([-2.5489, 118.0149], 5); // Center on Indonesia

    // Multiple tile layer options for modern look
    var baseLayers = {
        "Satellite": L.tileLayer('https://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
            attribution: '© Google'
        }),
        "Dark Theme": L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
            attribution: '© CARTO',
            maxZoom: 19
        }),
        "Light Theme": L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 19
        }),
        "Terrain": L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenTopoMap contributors',
            maxZoom: 17
        })
    };

    // Add default layer (Dark theme for modern look)
    baseLayers["Dark Theme"].addTo(map);

    // Add layer control
    L.control.layers(baseLayers).addTo(map);

    // Add custom zoom control at bottom left
    L.control.zoom({
        position: 'bottomleft'
    }).addTo(map);

    // Add scale control
    L.control.scale({
        position: 'bottomright',
        metric: true,
        imperial: false
    }).addTo(map);

    // Fetch real hotspot data from API
    fetchHotspotData();

    async function fetchHotspotData() {
        try {
            const response = await fetch('https://opsroom.sipongidata.my.id/api/opsroom/indoHotspot?wilayah=IN&filterperiode=false&from=&to=&late=24&satelit[]=NASA-MODIS&satelit[]=NASA-SNPP&satelit[]=NASA-NOAA20&confidence[]=low&confidence[]=medium&confidence[]=high&provinsi=&kabkota=');
            const data = await response.json();
            
            if (data && data.features) {
                addHotspotsToMap(data.features);
                updateActiveAlerts(data.features);
                updateStatistics(data.features);
            }
        } catch (error) {
            console.error('Error fetching hotspot data:', error);
            // Fallback to sample data if API fails
            loadSampleData();
        }
    }

    function addHotspotsToMap(features) {
        // Clear existing hotspots
        hotspotLayerGroup.clearLayers();
        currentHotspots = features;

        features.forEach(function(feature, index) {
            const props = feature.properties;
            const coords = feature.geometry.coordinates;
            
            // Convert coordinates [lng, lat] to [lat, lng] for Leaflet
            const lat = coords[1];
            const lng = coords[0];
            
            const severity = getSeverityFromConfidence(props.confidence_level);
            const color = getColorBySeverity(severity);
            const confidence = parseFloat(props.confidence) || 30;
            
            // Create modern circle marker with dynamic sizing
            const baseRadius = Math.max(confidence * 20, 200);
            
            // Create main hotspot marker
            var circle = L.circle([lat, lng], {
                color: color,
                fillColor: color,
                fillOpacity: 0.7,
                radius: baseRadius,
                weight: 3
            });

            circle.addTo(hotspotLayerGroup);

            // Store original data for search
            circle.hotspotData = {
                index: index,
                properties: props,
                severity: severity,
                color: color,
                confidence: confidence
            };

            // Enhanced popup with modern styling
            circle.bindPopup(`
                <div class="p-5 min-w-80 bg-white rounded-xl shadow-2xl border border-gray-100">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h4 class="font-bold text-xl text-gray-900 mb-1">${props.desa || 'Unknown Location'}</h4>
                            <p class="text-sm text-gray-600">${props.kecamatan}, ${props.kabkota}</p>
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold shadow-sm" style="background: linear-gradient(135deg, ${color}20, ${color}40); color: ${color}; border: 1px solid ${color}30;">
                            ${severity.toUpperCase()}
                        </span>
                    </div>
                    
                    <div class="space-y-3 text-sm">
                        <div class="grid grid-cols-2 gap-3">
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <span class="font-semibold text-gray-700 block">Province</span>
                                <p class="text-gray-900 mt-1">${props.nama_provinsi}</p>
                            </div>
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <span class="font-semibold text-gray-700 block">Source</span>
                                <p class="text-gray-900 mt-1">${props.sumber}</p>
                            </div>
                        </div>
                        
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <span class="font-semibold text-gray-700 block">Detection Time</span>
                            <p class="text-gray-900 mt-1">${new Date(props.date_hotspot).toLocaleString()}</p>
                        </div>
                        
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <span class="font-semibold text-gray-700 block">Coordinates</span>
                            <p class="text-gray-900 font-mono text-xs mt-1">${lat.toFixed(6)}, ${lng.toFixed(6)}</p>
                        </div>
                        
                        <div class="bg-gradient-to-r from-blue-50 to-blue-100 p-4 rounded-lg border border-blue-200">
                            <div class="flex items-center justify-between mb-2">
                                <span class="font-semibold text-blue-900">Confidence Level</span>
                                <span class="text-blue-900 font-bold text-lg">${confidence}%</span>
                            </div>
                            <div class="w-full bg-blue-200 rounded-full h-3 overflow-hidden">
                                <div class="h-3 rounded-full bg-gradient-to-r from-blue-500 to-blue-600" style="width: ${confidence}%;"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-5 pt-4 border-t border-gray-200 flex gap-3">
                        <button onclick="zoomToHotspot(${lat}, ${lng})" class="flex-1 inline-flex justify-center items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-search-plus mr-2"></i>
                            Zoom Here
                        </button>
                        <a href="${props.route_create}" target="_blank" class="flex-1 inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-md">
                            <i class="fas fa-file-plus mr-2"></i>
                            Create Report
                        </a>
                    </div>
                </div>
            `, {
                maxWidth: 400,
                className: 'modern-popup'
            });

            // Simple hover effects without animations
            circle.on('mouseover', function() {
                this.setStyle({
                    weight: 5,
                    fillOpacity: 0.9
                });
                
                // Show mini tooltip
                var tooltip = L.tooltip({
                    permanent: false,
                    direction: 'top',
                    className: 'modern-tooltip'
                }).setContent(`
                    <div class="bg-black/80 text-white px-3 py-2 rounded-lg text-xs font-medium">
                        <div class="font-semibold">${props.desa || 'Unknown Location'}</div>
                        <div class="text-gray-300">${severity.toUpperCase()} - ${confidence}%</div>
                    </div>
                `);
                this.bindTooltip(tooltip).openTooltip();
            });

            circle.on('mouseout', function() {
                this.setStyle({
                    weight: 3,
                    fillOpacity: 0.7
                });
                this.closeTooltip();
            });

            // Click to center and zoom
            circle.on('click', function() {
                map.setView([lat, lng], Math.max(map.getZoom(), 12));
            });
        });

        updateLoadingState(false);
        updateSearchResultsCount(features.length);
    }

    function getSeverityFromConfidence(confidenceLevel) {
        switch(confidenceLevel) {
            case 'high': return 'critical';
            case 'medium': return 'high';
            case 'low': return 'medium';
            default: return 'low';
        }
    }

    function loadSampleData() {
        // Fallback sample data
        var hotspots = [
            { lat: 0.7893, lng: 113.9213, temp: 85, severity: 'critical', location: 'Riau Forest Sector 7' },
            { lat: -2.2180, lng: 113.9209, temp: 72, severity: 'high', location: 'Central Kalimantan A3' },
            { lat: -6.8885, lng: 107.6440, temp: 58, severity: 'medium', location: 'West Java Highlands' }
        ];

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
                </div>
            `);
        });
    }

    function getColorBySeverity(severity) {
        switch(severity) {
            case 'critical': return '#EF4444';
            case 'high': return '#F59E0B';
            case 'medium': return '#EAB308';
            case 'low': return '#22C55E';
            default: return '#6B7280';
        }
    }

    function updateActiveAlerts(features) {
        // Filter recent high-risk hotspots for alerts
        const alerts = features
            .filter(f => f.properties.confidence >= 30)
            .slice(0, 10) // Show only top 10 alerts
            .map(f => {
                const props = f.properties;
                const severity = getSeverityFromConfidence(props.confidence_level);
                return {
                    severity: severity,
                    location: `${props.desa || props.kecamatan}, ${props.kabkota}`,
                    province: props.nama_provinsi,
                    confidence: props.confidence,
                    date: props.date_hotspot,
                    source: props.sumber
                };
            });

        // Log the alerts since panel is removed
        console.log('Active Alerts:', alerts);
    }

    function updateAlertsDisplay(alerts) {
        const alertsContainer = document.querySelector('.lg\\:col-span-1:first-child .space-y-3.max-h-64.overflow-y-auto');
        if (alertsContainer && alerts.length > 0) {
            // Clear existing sample alerts
            alertsContainer.innerHTML = '';
            
            // Add real alerts from API
            alerts.slice(0, 5).forEach(alert => {
                const alertElement = document.createElement('div');
                alertElement.className = `flex items-start space-x-3 p-3 bg-gradient-to-r ${getAlertColorClass(alert.severity)} rounded-xl border ${getAlertBorderClass(alert.severity)}`;
                
                alertElement.innerHTML = `
                    <div class="flex-shrink-0">
                        <div class="w-3 h-3 ${getAlertDotClass(alert.severity)} rounded-full mt-1"></div>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-medium ${getAlertTextClass(alert.severity)}">${alert.severity.charAt(0).toUpperCase() + alert.severity.slice(1)} Alert</p>
                        <p class="text-sm ${getAlertLocationClass(alert.severity)}">${alert.location}</p>
                        <p class="text-xs ${getAlertDetailClass(alert.severity)} mt-1">Confidence: ${alert.confidence}% | ${new Date(alert.date).toLocaleDateString()}</p>
                    </div>
                `;
                
                alertsContainer.appendChild(alertElement);
            });
        }
    }
    
    function getAlertColorClass(severity) {
        switch(severity) {
            case 'critical': return 'from-red-50 to-red-100/50';
            case 'high': return 'from-orange-50 to-orange-100/50';
            case 'medium': return 'from-yellow-50 to-yellow-100/50';
            default: return 'from-green-50 to-green-100/50';
        }
    }
    
    function getAlertBorderClass(severity) {
        switch(severity) {
            case 'critical': return 'border-red-200/50';
            case 'high': return 'border-orange-200/50';
            case 'medium': return 'border-yellow-200/50';
            default: return 'border-green-200/50';
        }
    }
    
    function getAlertDotClass(severity) {
        switch(severity) {
            case 'critical': return 'bg-red-500';
            case 'high': return 'bg-orange-500';
            case 'medium': return 'bg-yellow-500';
            default: return 'bg-green-500';
        }
    }
    
    function getAlertTextClass(severity) {
        switch(severity) {
            case 'critical': return 'text-red-900';
            case 'high': return 'text-orange-900';
            case 'medium': return 'text-yellow-900';
            default: return 'text-green-900';
        }
    }
    
    function getAlertLocationClass(severity) {
        switch(severity) {
            case 'critical': return 'text-red-700';
            case 'high': return 'text-orange-700';
            case 'medium': return 'text-yellow-700';
            default: return 'text-green-700';
        }
    }
    
    function getAlertDetailClass(severity) {
        switch(severity) {
            case 'critical': return 'text-red-600';
            case 'high': return 'text-orange-600';
            case 'medium': return 'text-yellow-600';
            default: return 'text-green-600';
        }
    }

    function updateStatistics(features) {
        const stats = {
            totalHotspots: features.length,
            criticalHotspots: features.filter(f => f.properties.confidence >= 80).length,
            highRiskHotspots: features.filter(f => f.properties.confidence >= 50 && f.properties.confidence < 80).length,
            mediumRiskHotspots: features.filter(f => f.properties.confidence >= 30 && f.properties.confidence < 50).length,
            lowRiskHotspots: features.filter(f => f.properties.confidence < 30).length
        };

        // Log the statistics since panel is removed
        console.log('Hotspot Statistics:', stats);
    }

    function updateStatsDisplay(stats) {
        // Update the statistics in the panel using specific selectors
        const statsContainer = document.querySelector('.lg\\:col-span-1:last-child .grid.grid-cols-2.gap-3');
        if (statsContainer) {
            const statCards = statsContainer.querySelectorAll('.text-center');
            if (statCards.length >= 4) {
                // Update active hotspots
                statCards[0].querySelector('.text-xl').textContent = stats.totalHotspots;
                
                // Update high risk areas (high + critical)
                const highRiskCount = stats.criticalHotspots + stats.highRiskHotspots;
                statCards[1].querySelector('.text-xl').textContent = highRiskCount;
                
                // Update critical hotspots count in first card if needed
                if (stats.criticalHotspots > 0) {
                    statCards[0].querySelector('.text-xl').textContent = stats.criticalHotspots;
                    statCards[0].querySelector('.text-xs').textContent = 'Critical Hotspots';
                }
            }
        }
    }

    // Global variables for layer management
    let hotspotLayerGroup = L.layerGroup().addTo(map);
    let currentHotspots = [];

    // Modern refresh function with loading animation
    function refreshHotspotData() {
        updateLoadingState(true);
        
        fetchHotspotData();
    }

    function updateLoadingState(isLoading) {
        const statusIndicator = document.querySelector('.absolute.top-6.left-6 .w-3.h-3');
        const statusText = document.querySelector('.absolute.top-6.left-6 .text-sm.font-semibold');
        const lastUpdated = document.querySelector('.absolute.top-6.left-6 .text-xs.text-gray-500');
        
        if (isLoading) {
            if (statusIndicator) {
                statusIndicator.className = 'w-3 h-3 bg-yellow-500 rounded-full shadow-sm';
            }
            if (statusText) {
                statusText.textContent = 'Loading Data...';
            }
            if (lastUpdated) {
                lastUpdated.textContent = 'Refreshing...';
            }
        } else {
            if (statusIndicator) {
                statusIndicator.className = 'w-3 h-3 bg-green-500 rounded-full shadow-sm';
            }
            if (statusText) {
                statusText.textContent = 'Live Monitoring';
            }
            if (lastUpdated) {
                lastUpdated.textContent = `Last updated: ${new Date().toLocaleTimeString()}`;
            }
        }
    }

    // Enhanced search function with real-time feedback
    function searchHotspots(searchTerm) {
        const term = searchTerm.toLowerCase().trim();
        
        // Clear previous search highlights
        hotspotLayerGroup.eachLayer(function(layer) {
            if (layer.hotspotData) {
                const originalColor = layer.hotspotData.color;
                layer.setStyle({ 
                    opacity: 1, 
                    fillOpacity: 0.7,
                    color: originalColor,
                    fillColor: originalColor,
                    weight: 3
                });
            }
        });
        
        if (term === '') {
            updateSearchResultsCount(currentHotspots.length);
            hideSearchResultsPanel();
            return;
        }

        let matchCount = 0;
        let matchedHotspots = [];
        
        hotspotLayerGroup.eachLayer(function(layer) {
            if (layer.hotspotData) {
                const props = layer.hotspotData.properties;
                
                // Enhanced search fields
                const searchableText = [
                    props.desa || '',
                    props.kecamatan || '',
                    props.kabkota || '',
                    props.nama_provinsi || '',
                    props.sumber || '',
                    layer.hotspotData.severity || ''
                ].join(' ').toLowerCase();
                
                if (searchableText.includes(term)) {
                    // Highlight matched hotspots
                    layer.setStyle({ 
                        opacity: 1, 
                        fillOpacity: 0.9,
                        color: '#FFD700',
                        fillColor: layer.hotspotData.color,
                        weight: 5
                    });
                    matchCount++;
                    matchedHotspots.push({
                        layer: layer,
                        data: layer.hotspotData
                    });
                } else {
                    // Dim non-matched hotspots
                    layer.setStyle({ 
                        opacity: 0.3, 
                        fillOpacity: 0.2,
                        weight: 1
                    });
                }
            }
        });

        updateSearchResultsCount(matchCount);
        showSearchResults(matchedHotspots, term);
        
        // Auto-fit bounds to matched results if any
        if (matchCount > 0) {
            const group = new L.featureGroup(matchedHotspots.map(m => m.layer));
            map.fitBounds(group.getBounds(), { 
                padding: [20, 20],
                maxZoom: 10 
            });
        }
    }
    
    function updateSearchResultsCount(count) {
        const searchInput = document.getElementById('search-field');
        if (searchInput) {
            const searchContainer = searchInput.parentElement;
            let countBadge = searchContainer.querySelector('.search-count-badge');
            
            if (!countBadge) {
                countBadge = document.createElement('div');
                countBadge.className = 'search-count-badge absolute right-3 top-1/2 transform -translate-y-1/2 bg-blue-500 text-white text-xs px-2 py-1 rounded-full';
                searchContainer.appendChild(countBadge);
            }
            
            countBadge.textContent = count;
            countBadge.style.display = count > 0 ? 'block' : 'none';
        }
    }
    
    function showSearchResults(matches, term) {
        hideSearchResultsPanel(); // Remove any existing panel
        
        if (matches.length === 0) {
            showNoResultsMessage(term);
            return;
        }
        
        const resultsPanel = document.createElement('div');
        resultsPanel.id = 'search-results-panel';
        resultsPanel.className = 'absolute top-20 left-6 right-6 max-w-md bg-white/95 backdrop-blur-lg rounded-xl shadow-2xl border border-gray-200/50 z-50 max-h-80 overflow-y-auto';
        
        resultsPanel.innerHTML = `
            <div class="p-4 border-b border-gray-200/50">
                <div class="flex items-center justify-between">
                    <h3 class="font-semibold text-gray-900">Search Results</h3>
                    <button onclick="hideSearchResultsPanel()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <p class="text-sm text-gray-600 mt-1">${matches.length} hotspot(s) found for "${term}"</p>
            </div>
            <div class="p-2">
                ${matches.slice(0, 5).map((match, index) => {
                    const props = match.data.properties;
                    const severity = match.data.severity;
                    const color = match.data.color;
                    
                    return `
                        <div class="p-3 hover:bg-gray-50 rounded-lg cursor-pointer" onclick="focusOnHotspot(${match.layer.getLatLng().lat}, ${match.layer.getLatLng().lng})">
                            <div class="flex items-start space-x-3">
                                <div class="w-3 h-3 rounded-full mt-1.5" style="background-color: ${color};"></div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-medium text-gray-900 text-sm">${props.desa || 'Unknown Location'}</p>
                                    <p class="text-xs text-gray-600">${props.kecamatan}, ${props.kabkota}</p>
                                    <div class="flex items-center mt-1 space-x-2">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium" style="background-color: ${color}20; color: ${color};">
                                            ${severity.toUpperCase()}
                                        </span>
                                        <span class="text-xs text-gray-500">${match.data.confidence}% confidence</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                }).join('')}
                ${matches.length > 5 ? `<div class="p-2 text-center text-sm text-gray-500">... and ${matches.length - 5} more results</div>` : ''}
            </div>
        `;
        
        document.querySelector('.flex-1.relative').appendChild(resultsPanel);
    }
    
    function showNoResultsMessage(term) {
        const noResultsPanel = document.createElement('div');
        noResultsPanel.id = 'search-results-panel';
        noResultsPanel.className = 'absolute top-20 left-6 right-6 max-w-md bg-white/95 backdrop-blur-lg rounded-xl shadow-2xl border border-gray-200/50 z-50';
        
        noResultsPanel.innerHTML = `
            <div class="p-6 text-center">
                <div class="mx-auto w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-search text-gray-400 text-xl"></i>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">No results found</h3>
                <p class="text-sm text-gray-600 mb-4">No hotspots match "${term}". Try a different search term.</p>
                <button onclick="hideSearchResultsPanel()" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">
                    Clear Search
                </button>
            </div>
        `;
        
        document.querySelector('.flex-1.relative').appendChild(noResultsPanel);
    }
    
    function hideSearchResultsPanel() {
        const existingPanel = document.getElementById('search-results-panel');
        if (existingPanel) {
            existingPanel.remove();
        }
    }
    
    function focusOnHotspot(lat, lng) {
        hideSearchResultsPanel();
        map.setView([lat, lng], 14);
        
        // Find and open popup for this hotspot
        hotspotLayerGroup.eachLayer(function(layer) {
            if (layer.getLatLng && Math.abs(layer.getLatLng().lat - lat) < 0.0001 && Math.abs(layer.getLatLng().lng - lng) < 0.0001) {
                layer.openPopup();
            }
        });
    }
    
    function zoomToHotspot(lat, lng) {
        map.setView([lat, lng], 16);
    }

    // Fullscreen toggle function
    function toggleFullscreen() {
        if (!document.fullscreenElement) {
            document.documentElement.requestFullscreen();
        } else {
            document.exitFullscreen();
        }
    }

    // Auto-refresh every 5 minutes
    setInterval(function() {
        console.log('Auto-refreshing hotspot data...');
        refreshHotspotData();
    }, 5 * 60 * 1000);

    // Close search results when clicking outside
    document.addEventListener('click', function(event) {
        const searchPanel = document.getElementById('search-results-panel');
        const searchField = document.getElementById('search-field');
        
        if (searchPanel && !searchPanel.contains(event.target) && event.target !== searchField) {
            hideSearchResultsPanel();
        }
    });

    // Clear search when escape is pressed
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            const searchField = document.getElementById('search-field');
            if (searchField) {
                searchField.value = '';
                searchHotspots('');
            }
            hideSearchResultsPanel();
        }
    });

    // Make functions globally available
    window.refreshHotspotData = refreshHotspotData;
    window.searchHotspots = searchHotspots;
    window.toggleFullscreen = toggleFullscreen;
    window.hideSearchResultsPanel = hideSearchResultsPanel;
    window.focusOnHotspot = focusOnHotspot;
    window.zoomToHotspot = zoomToHotspot;
});
</script>

</body>
</html>