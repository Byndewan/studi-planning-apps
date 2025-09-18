<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full smooth-scroll">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'StudyFlow') }}</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* Loading Animation */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            transition: opacity 0.5s ease-out;
        }

        .loading-spinner {
            width: 40px;
            height: 40px;
            border: 3px solid rgba(37, 99, 235, 0.1);
            border-top: 3px solid #2563eb;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Navbar Animation */
        .nav-container {
            transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .nav-toggle {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(10px);
        }

        .nav-toggle:hover {
            transform: scale(1.1) translateY(-2px);
        }

        /* Smooth Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.6s ease-out;
        }

        .animate-slideIn {
            animation: slideIn 0.6s ease-out;
        }

        /* Glass Effect */
        .glass-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        /* Content Animation */
        .content-enter {
            animation: fadeInUp 0.8s ease-out;
        }

        /* Card Hover Effect */
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-full bg-gradient-to-br from-slate-50 to-slate-100">
    <!-- Loading Overlay -->
    <div id="loading-overlay" class="loading-overlay">
        <div class="loading-spinner"></div>
    </div>

    <div x-data="{
        open: false,
        init() {
            this.$refs.navContainer.style.transform = 'translateY(-100%)';

            // Close nav when clicking outside
            document.addEventListener('click', (e) => {
                if (this.open && !this.$refs.navContainer.contains(e.target) && !this.$refs.toggleButton.contains(e.target)) {
                    this.toggleNav();
                }
            });

            // Remove loading overlay
            setTimeout(() => {
                const loadingOverlay = document.getElementById('loading-overlay');
                if (loadingOverlay) {
                    loadingOverlay.style.opacity = '0';
                    setTimeout(() => loadingOverlay.remove(), 500);
                }
            }, 800);
        },
        toggleNav() {
            this.open = !this.open;
            if (this.open) {
                this.$refs.navContainer.style.transform = 'translateY(0)';
            } else {
                this.$refs.navContainer.style.transform = 'translateY(-100%)';
            }
        }
    }" class="flex flex-col h-screen">

        <!-- Glass Header -->
        <header class="fixed top-0 left-0 right-0 glass-header px-6 py-4 z-30">
            <div class="flex justify-between items-center max-w-7xl mx-auto">
                <h1 class="text-2xl font-semibold text-gray-800 tracking-tight">
                    {{ $header ?? '' }}
                </h1>
                <div class="flex items-center space-x-3">
                    {{ $headerActions ?? '' }}
                </div>
            </div>
        </header>

        <!-- Navigation Toggle -->
        <div class="fixed left-1/2 transform -translate-x-1/2 z-40 top-0 transition-all duration-500"
            x-ref="toggleButton" :class="open ? 'h-33' : 'h-10'">
            <div class="nav-toggle bg-white/90 backdrop-blur-lg rounded-b-xl w-12 h-full shadow-sm border border-gray-200 cursor-pointer flex justify-center group transition-all duration-500"
                :class="open ? 'items-end pb-2' : 'items-center'" @click="toggleNav">
                <svg class="w-5 h-5 text-gray-600 group-hover:text-gray-800 transition-transform duration-300"
                    :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </div>
        </div>

        <!-- Navigation Container -->
        <div class="fixed top-0 left-0 right-0 z-50 nav-container" x-ref="navContainer"
            style="transform: translateY(-100%)">
            <div class="bg-white/95 backdrop-blur-xl shadow-sm py-4">
                <x-navigation />
            </div>
        </div>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto pt-24">
            <div class="max-w-7xl mx-auto px-6 py-8 content-enter">
                {{ $slot }}
            </div>
        </main>
    </div>

    <!-- Toast Notifications -->
    @if (session('success'))
        <x-toast type="success" message="{{ session('success') }}" />
    @endif

    @if (session('error'))
        <x-toast type="error" message="{{ session('error') }}" />
    @endif

    <script>
        // Initialize Alpine data
        window._oldQuestions = @json(old('questions')) || ["", "", ""];

        // Add smooth transitions to all interactive elements
        document.addEventListener('DOMContentLoaded', function() {
            // Animate cards on load
            const cards = document.querySelectorAll('.card');
            cards.forEach((card, index) => {
                card.style.animation = `fadeInUp 0.6s ease-out ${index * 0.1}s both`;
            });

            // Add hover effects to buttons
            const buttons = document.querySelectorAll('button, .btn-primary, .btn-secondary');
            buttons.forEach(button => {
                button.classList.add('interactive');
            });
        });
    </script>
</body>

</html>
