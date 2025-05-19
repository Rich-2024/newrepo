{{-- Flash Messages --}}
@if(session('success'))
    <div id="messagePopup" class="popup success">
        {{ session('success') }}
    </div>
@endif

@if($errors->any() && !session('success'))
    <div id="messagePopup" class="popup error">
        @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

{{-- Flash Message Auto Dismiss --}}
<script>
    window.onload = function () {
        const popup = document.getElementById('messagePopup');
        if (popup) {
            setTimeout(() => {
                popup.style.display = 'none';
            }, 3000);
        }
    };
</script>

{{-- Flash Message Styling --}}
<style>
    .popup {
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        padding: 15px;
        border-radius: 8px;
        font-weight: bold;
        z-index: 9999;
        display: none;
    }
    .success {
        background-color: #28a745;
        color: white;
        display: block;
    }
    .error {
        background-color: #dc3545;
        color: white;
        display: block;
    }
</style>