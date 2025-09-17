<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'StudyFlow') }}</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <style>
        .gordeng-transition {
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .nav-button {
            transition: all 0.3s ease;
            cursor: pointer;
            z-index: 60;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background-color: white;
            box-shadow: 0 4px 4px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(0, 0, 0, 0.1);
        }
        .nav-button:hover {
            transform: translateY(2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .arrow {
            transition: transform 0.3s ease;
        }
        .arrow.up {
            transform: rotate(0deg);
        }
        .arrow.down {
            transform: rotate(180deg);
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-full bg-gray-50">
    <div x-data="{
        open: false,
        init() {
            this.$refs.navContainer.style.transform = 'translateY(-100%)';

            document.addEventListener('click', (e) => {
                if (this.open && !this.$refs.navContainer.contains(e.target) &&
                    !this.$refs.toggleButton.contains(e.target)) {
                    this.toggleNav();
                }
            });
        },
        toggleNav() {
            this.open = !this.open;
            if (this.open) {
                this.$refs.navContainer.style.transform = 'translateY(0)';
                this.$refs.toggleButton.classList.remove('top-0');
                this.$refs.toggleButton.classList.add('top-23');
            } else {
                this.$refs.navContainer.style.transform = 'translateY(-100%)';
                this.$refs.toggleButton.classList.remove('top-23');
                this.$refs.toggleButton.classList.add('top-0');
            }
        }
    }"
    class="flex flex-col h-screen">

        <header class="fixed top-0 left-0 right-0 bg-white border-b border-gray-200 px-8 py-6 z-30">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-900">{{ $header ?? '' }}</h1>
                <div class="flex items-center space-x-3">
                    {{ $headerActions ?? '' }}
                </div>
            </div>
        </header>

        <div class="fixed left-1/2 transform -translate-x-1/2 z-50 top-0 transition-top duration-400"
             x-ref="toggleButton">
            <div class="flex flex-col items-center">
                <div class="nav-button" @click="toggleNav">
                    <svg class="arrow" :class="open ? 'up' : 'down'" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 10L8 6L4 10" stroke="#4B5563" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="fixed top-0 left-0 right-0 z-40 gordeng-transition" x-ref="navContainer" style="transform: translateY(-100%)">
            <div class="bg-white">
                <x-navigation />
            </div>
        </div>

        <main class="flex-1 overflow-y-auto pt-24">
            <div class="p-8">
                {{ $slot }}
            </div>
        </main>
    </div>

    @if (session('success'))
        <x-toast type="success" message="{{ session('success') }}" />
    @endif

    @if (session('error'))
        <x-toast type="error" message="{{ session('error') }}" />
    @endif

    <script>
        window._oldQuestions = @json(old('questions')) || ["", "", ""];
    </script>

</body>

</html>
