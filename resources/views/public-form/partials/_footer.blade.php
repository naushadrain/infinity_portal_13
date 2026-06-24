<footer class="bg-slate-900 text-white mt-12">
    <div class="max-w-7xl mx-auto px-4 py-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">

        {{-- Brand --}}
        <div>
            <a href="https://infiniteability.com.au/">
                <img src="https://infiniteability.com.au/wp-content/uploads/2024/10/logo-ndis.png"
                     class="h-14 bg-white rounded p-1 mb-4" alt="Infinite Ability">
            </a>
            <p class="text-sm text-slate-300 mb-5 leading-relaxed">
                Infinite Ability is a registered NDIS provider delivering quality disability support services across Australia.
            </p>
            <div class="flex items-center gap-2">
                <a href="https://www.facebook.com/profile.php?id=100063740582391&mibextid=ZbWKwL"
                   target="_blank" rel="noopener"
                   class="w-9 h-9 rounded-full bg-slate-700 hover:bg-sky-600 flex items-center justify-center transition"
                   aria-label="Facebook">
                    <i data-lucide="facebook" class="w-4 h-4"></i>
                </a>
                <a href="https://twitter.com/"
                   target="_blank" rel="noopener"
                   class="w-9 h-9 rounded-full bg-slate-700 hover:bg-sky-600 flex items-center justify-center transition"
                   aria-label="Twitter">
                    <i data-lucide="twitter" class="w-4 h-4"></i>
                </a>
            </div>
        </div>

        {{-- Quick Links --}}
        <div>
            <h3 class="font-bold mb-4 text-white text-sm uppercase tracking-wide">Quick Links</h3>
            <ul class="space-y-2 text-sm text-slate-300">
                <li><a href="https://infiniteability.com.au/" class="hover:text-white transition">Home</a></li>
                <li><a href="https://infiniteability.com.au/about-us/" class="hover:text-white transition">About Us</a></li>
                <li><a href="https://infiniteability.com.au/about-ndis/" class="hover:text-white transition">About NDIS</a></li>
                <li><a href="https://infiniteability.com.au/blogs/" class="hover:text-white transition">Blogs</a></li>
            </ul>
        </div>

        {{-- Resources --}}
        <div>
            <h3 class="font-bold mb-4 text-white text-sm uppercase tracking-wide">Resources</h3>
            <ul class="space-y-2 text-sm text-slate-300">
                <li><a href="https://infiniteability.com.au/services/" class="hover:text-white transition">Services</a></li>
                <li><a href="https://infiniteability.com.au/accommodations/" class="hover:text-white transition">Accommodations</a></li>
                <li><a href="https://infiniteability.com.au/gallery/" class="hover:text-white transition">Gallery</a></li>
                <li><a href="https://infiniteability.com.au/new-intake-form/" class="hover:text-white transition">Intake / Referral Form</a></li>
            </ul>
        </div>

        {{-- Contact --}}
        <div>
            <h3 class="font-bold mb-4 text-white text-sm uppercase tracking-wide">Contact</h3>
            <ul class="space-y-2 text-sm text-slate-300">
                <li>
                    <a href="mailto:info@infiniteability.com.au" class="flex items-center gap-2 hover:text-white transition">
                        <i data-lucide="mail" class="w-4 h-4 shrink-0"></i>
                        info@infiniteability.com.au
                    </a>
                </li>
                <li>
                    <a href="tel:1300044422" class="flex items-center gap-2 hover:text-white transition">
                        <i data-lucide="phone" class="w-4 h-4 shrink-0"></i>
                        1300044422
                    </a>
                </li>
                <li class="pt-1">
                    <a href="https://infiniteability.com.au/contact-us/" class="hover:text-white transition">Contact Us</a>
                </li>
                <li>
                    <a href="https://infiniteability.com.au/your-rights-privacy-and-feedback/" class="hover:text-white transition">Privacy &amp; Feedback</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="border-t border-slate-700 py-4 text-center text-sm text-slate-400">
        Copyright &copy; {{ date('Y') }} Infinite Ability |
        <a href="https://infiniteability.com.au/sitemap/" class="hover:text-white transition">Sitemap</a>.
        All rights reserved.
    </div>
</footer>
