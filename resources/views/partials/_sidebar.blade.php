<div id="sidebar-menu">
    <ul class="metismenu list-unstyled" id="side-menu">
        <li class="menu-title" key="t-menu">Menu</li>
        @can('access-newsfeed')
        <li>
            <a href="{{route('timeline')}}" class="waves-effect">
                <i class="bx bx-news"></i>
                <span key="t-chat">Newsfeed</span>
            </a>
        </li>
        @endcan
        <li>
        <li class="menu-title" key="t-pages">COMMUNICATION</li>
        @can('access-bulksms')
        <li>
            <a href="javascript: void(0);" class="has-arrow waves-effect">
                <i class="bx bxs-message"></i>
                <span key="t-crypto"> Bulk SMS </span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
                @can('access-bulksms-wallet')<li><a href="{{route('top-up-transactions')}}" key="t-wallet">Wallet</a></li>@endcan
                @can('send-bulksms')<li><a href="{{route('compose-sms')}}" key="t-wallet">Compose</a></li>@endcan
                <li><a href="{{route('schedule-sms')}}" key="t-wallet">Schedule</a></li>
                @can('topup-bulksms')<li><a href="{{route('top-up')}}" key="t-wallet">Top-up</a></li>@endcan
               @can('bulksms-phonegroup') <li><a href="{{route('phone-groups')}}" key="t-wallet">Phone Group</a></li> @endcan
                <li><a href="{{route('batch-report')}}" key="t-report">Delivery Report</a></li>
            </ul>
        </li>
        @endcan
        @can('access-followup')
        <li>
            <a href="javascript: void(0);" class="has-arrow waves-effect">
                <i class="bx bx-phone-call"></i>
                <span key="t-crypto"> Follow-up </span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
                @can('add-client')<li><a href="{{route('clients')}}" key="t-wallet">Add Contact</a></li>@endcan
                @can('contact-client')<li><a href="{{route('clients')}}" key="t-wallet">Contacts</a></li>@endcan
                <li><a href="{{route('remittance')}}" key="t-wallet">My Task</a></li>
                <li><a href="{{route('accounting.accounts')}}" key="t-wallet">Assignment</a></li>
            </ul>
        </li>
        @endcan
        <li class="menu-title" key="t-pages">TIME</li>
        @can('access-calendar')
        <li>
            <a href="{{route('calendar')}}" class="waves-effect">
                <i class="bx bx-calendar"></i>
                <span key="t-chat">Calendar</span>
            </a>
        </li>
        @endcan
        <li>
            <a href="{{route('show-appointments')}}" class="waves-effect">
                <i class="bx bx-timer"></i>
                <span key="t-chat">Appointments</span>
            </a>
        </li>
        @can('access-workflow')
        <li>
            <a href="{{route('workflow')}}" class="waves-effect">
                <i class="bx bx-infinite"></i>
                <span key="t-chat">Workflow</span>
            </a>
        </li>
        @endcan
        @can('access-attendance')
        <li>
            <a href="{{route('attendance')}}" class="waves-effect">
                <i class="bx bx-chart"></i>
                <span key="t-chat">Attendance</span>
            </a>
        </li>
        @endcan
        <li class="menu-title">Persons</li>
        @can('access-branches')
        <li>
            <a href="{{route('pastors')}}" class="waves-effect">
                <i class="bx bxs-user-badge"></i>
                <span key="t-chat">Pastors</span>
            </a>
        </li>
        @endcan
        @can('access-users')
        <li>
            <a href="{{route('clients')}}" class="waves-effect">
                <i class="bx bxs-user"></i>
                <span key="t-chat">Users</span>
            </a>
        </li>
        @endcan
        <li class="menu-title">Extras</li>
        @can('access-branches')
        <li>
            <a href="{{route('church-branches')}}" class="waves-effect">
                <i class="bx bx-map"></i>
                <span key="t-chat">Branches</span>
            </a>
        </li>
        @endcan
        @can('access-documents')
        <li>
            <a href="{{route('cloud-storage')}}" class="waves-effect">
                <i class="bx bx-file"></i>
                <span key="t-chat">Documents</span>
            </a>
        </li>
        @endcan
        <li>
            <a href="{{route('my-notifications')}}" class="waves-effect">
                <i class="bx bx-alarm"></i>
                <span key="t-chat">Notifications</span>
            </a>
        </li>
        <li class="menu-title">Financial Accounts</li>
        @can('access-finance')
        <li>
            <a href="javascript: void(0);" class="has-arrow waves-effect">
                <i class="bx bxs-landmark"></i>
                <span key="t-crypto"> Financials </span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
               @can('access-income') <li><a href="{{route('income')}}" key="t-wallet">Income</a></li> @endcan
                @can('access-expenses')<li><a href="{{route('expense')}}" key="t-wallet">Expenses</a></li> @endcan
                @can('access-remittance')<li><a href="{{route('remittance')}}" key="t-wallet">Remittance</a></li> @endcan
                @can('access-accounts')<li><a href="{{route('accounting.accounts')}}" key="t-wallet">Account Summary</a></li> @endcan
                @can('access-categories')<li><a href="{{route('accounting.categories')}}" key="t-wallet">Account Categories</a></li> @endcan
            </ul>
        </li>
        @endcan
        @can('access-finance-report')
        <li>
            <a href="javascript: void(0);" class="has-arrow waves-effect">
                <i class="bx bxs-report"></i>
                <span key="t-report"> Reports</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
               @can('access-income-report')<li><a href="{{route('cashbook', 'income')}}" key="t-report">Income</a></li> @endcan
               @can('access-expense-report')<li><a href="{{route('cashbook', 'expense')}}" key="t-report">Expense</a></li> @endcan
               @can('access-cashbook') <li><a href="{{route('cashbook', 'cashbook')}}" key="t-report">Cashbook</a></li> @endcan
               @can('access-remittance-report') <li><a href="{{route('show-remittance-report')}}" key="t-report">Remittance</a></li> @endcan
               @can('access-attendance-report')<li><a href="{{route('appointment-reports')}}" key="t-report">Attendance</a></li> @endcan
               @can('access-audit-trail') <li><a href="{{route('appointment-reports')}}" key="t-report">Audit Trail</a></li> @endcan
            </ul>
        </li>
        @endcan
        @can('access-settings')
        <li class="menu-title">Administration</li>
        <li>
            <a href="javascript: void(0);" class="has-arrow waves-effect">
                <i class="bx bx-cog"></i>
                <span key="t-crypto">Settings</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
                <li><a href="{{route('manage-roles')}}" key="t-wallet">Roles</a></li>
                <li><a href="{{route('organization')}}" key="t-wallet">Basic</a></li>
                <li><a href="{{route('settings')}}" key="t-wallet">General </a></li>
                <li><a href="{{route('branches-settings')}}" key="t-wallet">Branches</a></li>
                <li><a href="{{route('manage-permissions')}}" key="t-wallet">Permissions</a></li>
                <li><a href="{{route('branches-settings')}}" key="t-wallet">Branch Assignment</a></li>
            </ul>
        </li>
        @endcan
    </ul>
</div>
