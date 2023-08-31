<div class="main-settings__sidebar-container">
    <div class="modal-header">
        <h6 class="modal-title text-uppercase">Settings</h6>
    </div>
    <div class="sidebar-section mt-5">
        <div class="settings-section-header">
            <div class="section-title text-uppercase">
                <h6>Features</h6>
            </div>
        </div>
        <a href="{{route('organization')}}" class="{{  Request::routeIs('organization') ? 'is-active-setting' : ''}}">
            <div class="sidebar-item">
                <span class="">Basic Settings</span>
            </div>
        </a>
        <a href="{{route('settings')}}" class="{{  Request::routeIs('organization') ? 'is-active-setting' : ''}}">
            <div class="sidebar-item">
                <span class="">General Settings</span>
            </div>
        </a>
        <a href="{{route('branches-settings')}}" class="{{  Request::routeIs('branches-settings') ? 'is-active-setting' : ''}}">
            <div class="sidebar-item">
                <span class="">Branch Settings</span>
            </div>
        </a>
    </div>
    <div class="sidebar-section">
        <div class="settings-section-header">
            <div class="section-icon">
                <i class="bx bx-calendar"></i>
            </div>
            <div class="section-title">Calendar</div>
        </div>
        <a href="{{route('appointment-settings')}}" class=" {{  request()->routeIs('appointment-settings') ? 'is-active-setting' : ''}}">
            <div class="sidebar-item">
                <span>Appointments</span>
            </div>
        </a>
        <a href="{{route('appointment-types-settings')}}" class=" {{  request()->routeIs('appointment-types-settings') ? 'is-active-setting' : ''}}">
            <div class="sidebar-item">
                <span>Appointment Types</span>
            </div>
        </a>
        <a href="{{route('change-password')}}" class=" {{  request()->routeIs('change-password') ? 'is-active-setting' : ''}}">
            <div class="sidebar-item">
                <span>Change Password</span>
            </div>
        </a>
    </div>
</div>
