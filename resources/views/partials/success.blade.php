@if(session('success'))
    <div id="flash-message" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div id="flash-message" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        {{ session('error') }}
    </div>
@endif

<script>
    // Auto-hide flash message after 3 seconds (3000 ms)
    setTimeout(() => {
        const flash = document.getElementById('flash-message');
        if (flash) {
            // fade out effect (optional)
            flash.style.transition = 'opacity 0.5s ease';
            flash.style.opacity = '0';

            // after fade out, remove from DOM
            setTimeout(() => flash.remove(), 500);
        }
    }, 3000);
</script>

@if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        {{ session('error') }}
    </div>
@endif
