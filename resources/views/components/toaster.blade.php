@if (session('success') || session('error') || session('fail'))
    @php
        $type = session('success') ? 'success' : 'error';
        $message = session('success') ?? (session('error') ?? session('fail'));

        $classes = $type === 'success' ? 'bg-emerald-600 border-emerald-500' : 'bg-red-600 border-red-500';

        $icon = $type === 'success' ? 'check-circle' : 'x-circle';
        $title = $type === 'success' ? 'Success' : 'Error';
    @endphp

    <div id="appToast"
        class="fixed top-5 right-5 z-[9999] w-[420px] max-w-[calc(100vw-2rem)] rounded-xl border {{ $classes }} text-white shadow-2xl overflow-hidden">

        <div class="flex items-start gap-3 p-4">
            <i data-lucide="{{ $icon }}" class="w-5 h-5 mt-0.5 shrink-0"></i>

            <div class="flex-1">
                <h4 class="text-sm font-semibold">{{ $title }}</h4>
                <p class="text-sm text-white/90 mt-0.5">
                    {{ $message }}
                </p>
            </div>

            <button type="button" onclick="closeToast()" class="text-white/80 hover:text-white">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>

        <div class="h-1 bg-white/25">
            <div id="toastProgress" class="h-full bg-white/80"></div>
        </div>
    </div>

    <script>
        function closeToast() {
            const toast = document.getElementById('appToast');
            if (toast) {
                toast.classList.add('opacity-0', 'translate-x-5');
                setTimeout(() => toast.remove(), 300);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const toast = document.getElementById('appToast');
            const progress = document.getElementById('toastProgress');

            if (toast) {
                toast.classList.add('transition-all', 'duration-300');
            }

            if (progress) {
                progress.style.width = '100%';
                progress.style.transition = 'width 4s linear';

                setTimeout(() => {
                    progress.style.width = '0%';
                }, 100);
            }

            setTimeout(closeToast, 4200);

            if (window.lucide) {
                lucide.createIcons();
            }
        });
    </script>
@endif
