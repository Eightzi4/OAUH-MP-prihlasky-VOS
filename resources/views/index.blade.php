<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Přihlášky VOŠ - OA a VOŠ Uherské Hradiště</title>
    @vite('resources/css/app.css')
    <script>
        if (localStorage.getItem('color-theme') === 'dark' ||
           (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="bg-white dark:bg-gray-900 font-sans antialiased">

    <div class="bg-gray-900 flex flex-col h-screen">

        <header class="bg-[#1e293b] z-30">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <a href="https://www.oauh.cz/" class="flex items-center group gap-4 text-gray-300 hover:text-white transition-colors">
                        <img src="https://www.oauh.cz/www/web/images/logo.png" alt="Logo OA a VOŠ Uherské Hradiště" class="h-10 w-auto">
                        <span class="text-sm">← Zpět na web školy</span>
                    </a>
                    <button id="theme-toggle" type="button" class="text-gray-400 hover:text-white focus:outline-none rounded-lg text-sm p-2.5">
                        <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                        <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 S0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 100 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
                    </button>
                </div>
            </div>
        </header>

        <main class="flex-grow relative flex">
            <div class="absolute inset-0 z-0">
                <img src="https://www.oauh.cz/content/banners/1/1_72.jpg" class="object-cover w-full h-full" alt="Budova školy">
                <div class="absolute inset-0 bg-black/50"></div>
            </div>

            <div class="absolute top-1/3 left-1/2 -translate-x-1/2 -translate-y-1/2 text-white text-center pointer-events-none z-20">
                <h1 class="text-4xl md:text-6xl font-extrabold" style="text-shadow: 2px 2px 8px rgba(0,0,0,0.7);">Přihlášky VOŠ OAUH</h1>
                <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-200">Online portál pro podání přihlášky ke studiu.</p>
            </div>

            <a href="/register" class="group w-1/2 h-full relative z-10">
                <div class="pointer-events-none absolute inset-y-0 left-0 w-full bg-gradient-to-r from-red-600/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="absolute top-3/5 -translate-y-1/2 left-8 md:left-16 lg:left-24 text-white text-left transition-transform duration-500 ease-out group-hover:scale-110">
                    <h2 class="text-4xl md:text-6xl font-extrabold" style="text-shadow: 2px 2px 8px rgba(0,0,0,0.7);">Založit přihlášku</h2>
                    <p class="mt-2 text-lg text-gray-300">Pro nové uchazeče</p>
                </div>
            </a>

            <a href="/login" class="group w-1/2 h-full relative z-10">
                <div class="pointer-events-none absolute inset-y-0 right-0 w-full bg-gradient-to-l from-red-600/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="absolute top-3/5 -translate-y-1/2 right-8 md:right-16 lg:right-24 text-white text-right transition-transform duration-500 ease-out group-hover:scale-110">
                    <h2 class="text-4xl md:text-6xl font-extrabold" style="text-shadow: 2px 2px 8px rgba(0,0,0,0.7);">Přihlásit se</h2>
                    <p class="mt-2 text-lg text-gray-300">Zobrazit stav přihlášky</p>
                </div>
            </a>
        </main>

        <footer class="bg-[#1e293b] z-30">
             <div class="container mx-auto px-6 py-4 text-center text-sm text-gray-400">
                <p>&copy; 2025 Obchodní akademie a Vyšší odborná škola, Uherské Hradiště</p>
            </div>
        </footer>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const themeToggleBtn = document.getElementById('theme-toggle');
            const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
            const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

            const applyTheme = (isDark) => {
                if (isDark) {
                    document.documentElement.classList.add('dark');
                    themeToggleLightIcon.classList.remove('hidden');
                    themeToggleDarkIcon.classList.add('hidden');
                } else {
                    document.documentElement.classList.remove('dark');
                    themeToggleDarkIcon.classList.remove('hidden');
                    themeToggleLightIcon.classList.add('hidden');
                }
            };

            applyTheme(document.documentElement.classList.contains('dark'));

            themeToggleBtn.addEventListener('click', () => {
                const isCurrentlyDark = document.documentElement.classList.contains('dark');
                localStorage.setItem('color-theme', isCurrentlyDark ? 'light' : 'dark');
                applyTheme(!isCurrentlyDark);
            });
        });
    </script>
</body>
</html>

<!-- TODO: navbar and footer should be made of small (semitransparent) islands wrapping their content, animate 3 images based on hovered-over position: register, neutral, login -->
