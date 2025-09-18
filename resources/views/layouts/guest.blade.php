<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'StudyFlow') }}</title>

        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <style>
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

            @keyframes slideInLeft {
                from {
                    opacity: 0;
                    transform: translateX(-30px);
                }
                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }

            .animate-fadeInUp {
                animation: fadeInUp 0.8s ease-out;
            }

            .animate-slideInLeft {
                animation: slideInLeft 0.8s ease-out;
            }

            /* Card hover effect */
            .card-hover {
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .card-hover:hover {
                transform: translateY(-4px);
                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            }

            /* Gradient background */
            .gradient-bg {
                background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            }

            /* Glass effect */
            .glass-card {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.2);
            }

            /* Button animation */
            .btn-animate {
                position: relative;
                overflow: hidden;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .btn-animate::before {
                content: '';
                position: absolute;
                top: 50%;
                left: 50%;
                width: 0;
                height: 0;
                background: rgba(255, 255, 255, 0.2);
                border-radius: 50%;
                transform: translate(-50%, -50%);
                transition: width 0.6s, height 0.6s;
            }

            .btn-animate:hover::before {
                width: 300px;
                height: 300px;
            }

            /* Form input focus */
            .form-input-focus:focus {
                outline: none;
                border-color: #2563eb;
                box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1), 0 0 0 1px #2563eb;
                transform: translateY(-1px);
            }

            /* Loading spinner */
            .loading-spinner {
                width: 20px;
                height: 20px;
                border: 2px solid rgba(37, 99, 235, 0.1);
                border-top: 2px solid #2563eb;
                border-radius: 50%;
                animation: spin 1s linear infinite;
            }

            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
        </style>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased gradient-bg min-h-screen">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 px-4">
            <!-- Logo dengan animasi -->
            <div class="mb-8 animate-fadeInUp">
                <div class="flex items-center justify-center space-x-4 group">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-all duration-300 group-hover:scale-105">
                        <i class="fas fa-graduation-cap text-white text-2xl group-hover:animate-bounce"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-blue-700 bg-clip-text text-transparent">
                            StudyFlow
                        </h1>
                        <p class="text-sm text-gray-600 mt-1">Sistem Manajemen Belajar</p>
                    </div>
                </div>
            </div>

            <!-- Card Container dengan glass effect -->
            <div class="w-full sm:max-w-md animate-slideInLeft">
                <div class="glass-card rounded-2xl shadow-xl overflow-hidden card-hover">
                    {{ $slot }}
                </div>
            </div>

            <!-- Footer info -->
            <div class="mt-8 text-center text-sm text-gray-500 animate-fadeInUp delay-200">
                <p>&copy; {{ date('Y') }} StudyFlow. All rights reserved.</p>
            </div>
        </div>

        <script>
            // Add smooth animations
            document.addEventListener('DOMContentLoaded', function() {
                // Animate form inputs
                const inputs = document.querySelectorAll('input, select, textarea');
                inputs.forEach(input => {
                    input.classList.add('form-input-focus');
                });

                // Add ripple effect to buttons
                const buttons = document.querySelectorAll('button, .btn-animate');
                buttons.forEach(button => {
                    button.addEventListener('click', function(e) {
                        const ripple = document.createElement('span');
                        const rect = this.getBoundingClientRect();
                        const size = Math.max(rect.width, rect.height);
                        const x = e.clientX - rect.left - size / 2;
                        const y = e.clientY - rect.top - size / 2;

                        ripple.style.width = ripple.style.height = size + 'px';
                        ripple.style.left = x + 'px';
                        ripple.style.top = y + 'px';
                        ripple.classList.add('absolute', 'bg-white', 'bg-opacity-30', 'rounded-full', 'animate-ping');

                        this.appendChild(ripple);

                        setTimeout(() => {
                            ripple.remove();
                        }, 600);
                    });
                });
            });
        </script>
    </body>
</html>
