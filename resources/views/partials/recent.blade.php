<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <strong>Recent Fine Settings</strong>
    </div>
    <div class="card-body">
        <p><strong>Fine Rate:</strong> {{ $rate }}%</p>
<p><strong>Fine Duration:</strong> {{ $fineDuration }} days</p>

        <p><strong>Last Updated:</strong> 
            {{ $lastUpdated ? $lastUpdated->diffForHumans() : 'Not set' }}
        </p>
    </div>
</div>
