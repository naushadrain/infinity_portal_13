{{-- Top contact bar --}}
<div class="bg-black text-white">
    <div class="max-w-7xl mx-auto px-4 py-2 flex items-center justify-between text-sm">
        <div class="flex items-center gap-6 flex-wrap">
            <a href="mailto:info@infiniteability.com.au"
               class="flex items-center gap-2 hover:text-sky-400 transition">
                <i data-lucide="mail" class="w-4 h-4"></i>
                info@infiniteability.com.au
            </a>
            <a href="tel:1300044422"
               class="flex items-center gap-2 hover:text-sky-400 transition">
                <i data-lucide="phone" class="w-4 h-4"></i>
                1300044422
            </a>
        </div>
        <div class="flex items-center gap-2">
            <a href="https://www.facebook.com/profile.php?id=100063740582391&mibextid=ZbWKwL"
               target="_blank" rel="noopener"
               class="w-8 h-8 rounded-full hover:bg-slate-700 flex items-center justify-center transition"
               aria-label="Facebook">
                <i data-lucide="facebook" class="w-4 h-4"></i>
            </a>
            <a href="https://twitter.com/"
               target="_blank" rel="noopener"
               class="w-8 h-8 rounded-full hover:bg-slate-700 flex items-center justify-center transition"
               aria-label="Twitter">
                <i data-lucide="twitter" class="w-4 h-4"></i>
            </a>
        </div>
    </div>
</div>

{{-- Main header / nav --}}
<header class="bg-white shadow-sm sticky top-0 z-40">
    <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between gap-4">

        {{-- Logo --}}
        <a href="https://infiniteability.com.au/" class="shrink-0">
            <img src="https://infiniteability.com.au/wp-content/uploads/2024/10/logo-ndis.png"
                 class="h-14" alt="Infinite Ability">
        </a>

        {{-- Desktop nav --}}
        

        {{-- Enquiries CTA --}}
        <a href="https://infiniteability.com.au"
           class="hidden lg:inline-flex items-center gap-2 bg-sky-600 hover:bg-sky-700 text-white text-sm font-semibold px-4 py-2.5 rounded-lg transition shrink-0">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Home
        </a>

        {{-- Mobile menu toggle --}}
        <button id="mobileMenuBtn"
                class="lg:hidden p-2 rounded-lg hover:bg-slate-100 transition"
                aria-label="Toggle menu" aria-expanded="false">
            <i data-lucide="menu" class="w-6 h-6" id="menuIconOpen"></i>
            <i data-lucide="x" class="w-6 h-6 hidden" id="menuIconClose"></i>
        </button>
    </div>

    {{-- Mobile nav drawer --}}
    <div id="mobileMenu"
         class="hidden lg:hidden border-t border-slate-100 bg-white px-4 pb-5 pt-4">
        <nav class="flex flex-col gap-1 text-sm font-medium text-slate-700">
            <a href="https://infiniteability.com.au/"
               class="px-3 py-2 rounded-lg hover:bg-slate-50 hover:text-sky-600 transition">Home</a>
            <a href="https://infiniteability.com.au/about-us/"
               class="px-3 py-2 rounded-lg hover:bg-slate-50 hover:text-sky-600 transition">About Us</a>
            <a href="https://infiniteability.com.au/services/"
               class="px-3 py-2 rounded-lg hover:bg-slate-50 hover:text-sky-600 transition">Services</a>
            <a href="https://infiniteability.com.au/accommodations/"
               class="px-3 py-2 rounded-lg hover:bg-slate-50 hover:text-sky-600 transition">Accommodations</a>
            <a href="https://infiniteability.com.au/about-ndis/"
               class="px-3 py-2 rounded-lg hover:bg-slate-50 hover:text-sky-600 transition">About NDIS</a>
            <a href="https://infiniteability.com.au/new-intake-form/"
               class="px-3 py-2 rounded-lg text-lime-600 font-semibold hover:bg-slate-50 transition">Referral</a>
            <a href="https://infiniteability.com.au/gallery/"
               class="px-3 py-2 rounded-lg hover:bg-slate-50 hover:text-sky-600 transition">Gallery</a>
            <a href="https://infiniteability.com.au/blogs/"
               class="px-3 py-2 rounded-lg hover:bg-slate-50 hover:text-sky-600 transition">Blogs</a>
            <a href="https://infiniteability.com.au/contact-us/"
               class="px-3 py-2 rounded-lg hover:bg-slate-50 hover:text-sky-600 transition">Contact Us</a>
            <a href="https://infiniteability.com.au/contact-us/"
               class="mt-3 flex items-center justify-center bg-sky-600 hover:bg-sky-700 text-white font-semibold px-4 py-2.5 rounded-lg transition">
                Enquiries
            </a>
        </nav>
    </div>
</header>

<script>
    (function () {
        var btn  = document.getElementById('mobileMenuBtn');
        var menu = document.getElementById('mobileMenu');
        var open = document.getElementById('menuIconOpen');
        var close = document.getElementById('menuIconClose');
        if (!btn) return;
        btn.addEventListener('click', function () {
            var expanded = btn.getAttribute('aria-expanded') === 'true';
            btn.setAttribute('aria-expanded', String(!expanded));
            menu.classList.toggle('hidden');
            open.classList.toggle('hidden');
            close.classList.toggle('hidden');
        });
    })();
</script>
