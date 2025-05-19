<nav id="sidebar">
    <div class="sidebar-header text-center">
        <img src="{{ asset('images/profile-pic.jpg') }}" alt="Admin Profile Picture" onerror="this.onerror=null;this.src='default-profile.jpg';">
        <h3>Admin</h3>
    </div>
    <ul class="list-unstyled components">
        <li class="active"><a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
        <li><a href="{{ route('admin.loans.create') }}"><i class="fas fa-plus-circle me-2"></i>Enter Loan</a></li>
        {{-- <li><a href="{{ route('admin.loans.repay') }}"><i class="fas fa-money-bill me-2"></i>Repay Loan</a></li>
        <li><a href="{{ route('admin.clients') }}"><i class="fas fa-users me-2"></i>All Clients</a></li>
        <li><a href="{{ route('admin.interest') }}"><i class="fas fa-percentage me-2"></i>Interest Rate</a></li>
        <li><a href="{{ route('admin.defaulters') }}"><i class="fas fa-exclamation-triangle me-2"></i>Defaulters</a></li>
        <li><a href="{{ route('admin.reports') }}"><i class="fas fa-file-alt me-2"></i>Reports</a></li>
        <li><a href="{{ route('admin.settings') }}"><i class="fas fa-cogs me-2"></i>Settings</a></li>
        <li><a href="{{ route('logout') }}"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li> --}}
    </ul>
</nav>
