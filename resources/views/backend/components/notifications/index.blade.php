<li id="fetch_notifications" class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-bell"></i>
        @if(adminNotifications()['total_notify_count'] > 0)
            <span class="badge badge-warning navbar-badge">{{ adminNotifications()['total_notify_count'] }}</span>
        @endif
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="min-width: 400px !important;">
        <span class="dropdown-item dropdown-header">{{ adminNotifications()['total_notifications_count'] }} Notifications</span>
        <div class="dropdown-divider"></div>
        @if(adminNotifications()["login"]->count()>0)
            <a href="{{ route('notifications.type','login') }}" class="dropdown-item">
                <i class="fas fa-users mr-2"></i> {{adminNotifications()["login"]->count()}} New login
                <span class="float-right text-muted text-sm">{{ adminNotifications()["login"]->first()->created_at->diffForHumans() }}</span>
            </a>
            <div class="dropdown-divider"></div>
        @endif
        @if(adminNotifications()["visitors"]->count()>0)
        <a href="{{ route('notifications.type','web_visitor') }}" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> {{adminNotifications()["visitors"]->count()}} New visitor
            <span class="float-right text-muted text-sm">{{ adminNotifications()["visitors"]->first()->created_at->diffForHumans() }}</span>
        </a>
        <div class="dropdown-divider"></div>
        @endif
        @if(adminNotifications()["users"]->count()>0)
            <a href="{{ route('notifications.type','new_user') }}" class="dropdown-item">
                <i class="fas fa-users mr-2"></i> {{adminNotifications()["users"]->count()}} New buyer
                <span class="float-right text-muted text-sm">{{ (adminNotifications()["users"]->count() > 0) ? adminNotifications()["users"]->first()->created_at->diffForHumans() : 0 }}</span>
            </a>
            <div class="dropdown-divider"></div>
        @endif
        @if(adminNotifications()["answers"]->count()>0)
        <a href="{{ route('notifications.type','question_completed') }}" class="dropdown-item">
            <i class="fas fa-list-alt mr-2"></i> {{adminNotifications()["answers"]->count()}} Questionnaire completion
            <span class="float-right text-muted text-sm">{{ (adminNotifications()["answers"]->count() > 0) ? adminNotifications()["answers"]->first()->created_at->diffForHumans() : 0 }}</span>
        </a>
        <div class="dropdown-divider"></div>
        @endif
        @if(adminNotifications()["orders"]->count()>0)
            <a href="{{ route('notifications.type','orders') }}" class="dropdown-item">
                <i class="fas fa-shopping-basket mr-2"></i> {{adminNotifications()["orders"]->count()}} New orders
                <span class="float-right text-muted text-sm">{{ (adminNotifications()["orders"]->count() > 0) ? adminNotifications()["orders"]->first()->created_at->diffForHumans() : 0 }}</span>
            </a>
            <div class="dropdown-divider"></div>
        @endif
        @if(adminNotifications()["booking"]->count()>0)
            <a href="{{ route('notifications.type','booking') }}" class="dropdown-item">
                <i class="fas fa-calendar-alt mr-2"></i> {{adminNotifications()["booking"]->count()}} New Reservations
                <span class="float-right text-muted text-sm">{{ (adminNotifications()["booking"]->count() > 0) ? adminNotifications()["booking"]->first()->created_at->diffForHumans() : 0 }}</span>
            </a>
            <div class="dropdown-divider"></div>
        @endif
        @if(adminNotifications()["withdrawal"]->count()>0)
            <a href="{{ route('notifications.type','withdrawal_request') }}" class="dropdown-item">
                <i class="fas fa-hand-holding-usd mr-2"></i> {{adminNotifications()["withdrawal"]->count()}} New Withdrawal request
                <span class="float-right text-muted text-sm">{{ (adminNotifications()["withdrawal"]->count() > 0) ? adminNotifications()["withdrawal"]->first()->created_at->diffForHumans() : 0 }}</span>
            </a>
            <div class="dropdown-divider"></div>
        @endif
        @if(adminNotifications()["vouchers"]->count()>0)
            <a href="{{ route('notifications.type','voucher_usage') }}" class="dropdown-item">
                <i class="fas fa-ticket-alt mr-2"></i> {{adminNotifications()["vouchers"]->count()}} New voucher usage
                <span class="float-right text-muted text-sm">{{ (adminNotifications()["vouchers"]->count() > 0) ? adminNotifications()["vouchers"]->first()->created_at->diffForHumans() : 0 }}</span>
            </a>
            <div class="dropdown-divider"></div>
        @endif
        @if(adminNotifications()["funds"]->count()>0)
            <a href="{{ route('notifications.type','fund_transfer') }}" class="dropdown-item">
                <i class="fas fa-money-check mr-2"></i> {{adminNotifications()["funds"]->count()}} New fund transfer
                <span class="float-right text-muted text-sm">{{ (adminNotifications()["funds"]->count() > 0) ? adminNotifications()["funds"]->first()->created_at->diffForHumans() : 0 }}</span>
            </a>
            <div class="dropdown-divider"></div>
        @endif
        @if(adminNotifications()["donations"]->count()>0)
            <a href="{{ route('notifications.type','donation') }}" class="dropdown-item">
                <i class="fas fa-hand-holding-heart mr-2"></i> {{adminNotifications()["donations"]->count()}} New donation
                <span class="float-right text-muted text-sm">{{ (adminNotifications()["donations"]->count() > 0) ? adminNotifications()["donations"]->first()->created_at->diffForHumans() : 0 }}</span>
            </a>
            <div class="dropdown-divider"></div>
        @endif

        @if(adminNotifications()['total_notify_count'] > 0)
        @else
            <a href="javascript:void(0)" class="dropdown-item p-3">
                <i class="fas fa-info mr-2"></i> <small>No New Notification</small>
            </a>
        @endif
        <div class="dropdown-divider"></div>
        <a href="{{ route('notifications.index') }}" class="dropdown-item dropdown-footer">See All Notifications</a>
    </div>
</li>
