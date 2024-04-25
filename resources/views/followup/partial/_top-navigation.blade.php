<ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
    <li class="nav-item">
        <a class="nav-link {{request()->routeIs('marketing-dashboard') ? 'active' : '' }}" href="{{route('marketing-dashboard')}}" role="tab">
            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
            <span class="d-none d-sm-block">Dashboard</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{request()->routeIs('leads') ? 'active' : '' }}"  href="{{route('leads')}}" role="tab">
            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
            <span class="d-none d-sm-block">Leads</span>
        </a>
    </li>
    <!-- <li class="nav-item">
        <a class="nav-link {request()->routeIs('marketing-messaging') ? 'active' : '' }}" href="{route('marketing-messaging')}}" role="tab">
            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
            <span class="d-none d-sm-block">Messaging</span>
        </a>
    </li> -->
   <!-- <li class="nav-item">
        <a class="nav-link request()->routeIs('marketing-automations') ? 'active' : '' }}" href="route('marketing-automations')}}" role="tab">
            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
            <span class="d-none d-sm-block">Automations</span>
        </a>
    </li> -->
    <!--<li class="nav-item">
        <a class="nav-link" href="#messages1" role="tab">
            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
            <span class="d-none d-sm-block">Referrals</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#messages1" role="tab">
            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
            <span class="d-none d-sm-block">Settings</span>
        </a>
    </li> -->
</ul>
