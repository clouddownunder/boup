<div class="site-menubar site-menubar-light">
  <div class="site-menubar-body">
    <div>
      <div>
        <ul class="site-menu" data-plugin="menu">
          <li class="site-menu-item @if(in_array('dashboard', Request::segments())) active @endif">
            <a href="{{route('admin.dashboard')}}">
              <i class="site-menu-icon md-view-dashboard" aria-hidden="true"></i>
              <span class="site-menu-title">{{ __('admin.dashboard-menu') }}</span>
            </a>
          </li>
          <li class="site-menu-item @if(in_array('users', Request::segments())) active @endif">
            <a href="{{route('users.index')}}">
              <i class="site-menu-icon md-accounts-list" aria-hidden="true"></i>
              <span class="site-menu-title">{{ __('admin.users-menu') }}</span>
            </a>
          </li>
          {{-- <li class="site-menu-item has-sub @if(in_array('occupations', Request::segments())) active @endif">
            <a href="javascript:void(0)">
              <i class="site-menu-icon md-group-work" aria-hidden="true"></i>
              <span class="site-menu-title">{{ __('admin.occupation-menu') }}</span>
            </a>
            <ul class="site-menu-sub sm-sub-down">
              <li class="site-menu-item @if(in_array('request', Request::segments())  && in_array('occupations', Request::segments())) active @endif">
                <a href="{{route('occupations.index',["status"=>"request"])}}">
                  <span class="site-menu-title">Requested</span>
                </a>
              </li>
              <li class="site-menu-item @if(in_array('approved', Request::segments()) && in_array('occupations', Request::segments())) active @endif">
                <a href="{{route('occupations.index',["status"=>"approved"])}}">
                  <span class="site-menu-title">Approved</span>
                </a>
              </li>
              <li class="site-menu-item @if(in_array('rejected', Request::segments()) && in_array('occupations', Request::segments())) active @endif">
                <a href="{{route('occupations.index',["status"=>"rejected"])}}">
                  <span class="site-menu-title">Rejected</span>
                </a>
              </li>
            </ul>
          </li>
          <li class="site-menu-item has-sub @if(in_array('interests', Request::segments())) active @endif">
            <a href="javascript:void(0)">
              <i class="site-menu-icon md-present-to-all" aria-hidden="true"></i>
              <span class="site-menu-title">{{ __('admin.interest-menu') }}</span>
            </a>
            <ul class="site-menu-sub sm-sub-down">
              <li class="site-menu-item @if(in_array('request', Request::segments()) && in_array('interests', Request::segments())) active @endif">
                <a href="{{route('interests.index',["status"=>"request"])}}">
                  <span class="site-menu-title">Requested</span>
                </a>
              </li>
              <li class="site-menu-item @if(in_array('approved', Request::segments()) && in_array('interests', Request::segments())) active @endif">
                <a href="{{route('interests.index',["status"=>"approved"])}}">
                  <span class="site-menu-title">Approved</span>
                </a>
              </li>
              <li class="site-menu-item @if(in_array('rejected', Request::segments()) && in_array('interests', Request::segments())) active @endif">
                <a href="{{route('interests.index',["status"=>"rejected"])}}">
                  <span class="site-menu-title">Rejected</span>
                </a>
              </li>
            </ul>
          </li>
          <li class="site-menu-item @if(in_array('reported-users', Request::segments())) active @endif">
            <a href="{{route('reported-users.index')}}">
              <i class="site-menu-icon md-accounts-list" aria-hidden="true"></i>
              <span class="site-menu-title">{{ __('admin.users-reported-menu') }}</span>
            </a>
          </li> --}}
          {{-- <li class="site-menu-item @if(in_array('jobs', Request::segments())) active @endif">
            <a href="{{route('jobs.index')}}">
              <i class="site-menu-icon md-view-list-alt" aria-hidden="true"></i>
              <span class="site-menu-title">{{ __('admin.jobs-menu') }}</span>
            </a>
          </li> --}}
          {{-- <li class="site-menu-item has-sub @if(in_array('modify', Request::segments())) active @endif">
            <a href="javascript:void(0)">
              <i class="site-menu-icon md-present-to-all" aria-hidden="true"></i>
              <span class="site-menu-title">{{ __('admin.modify-menu') }}</span>
            </a>
            <ul class="site-menu-sub sm-sub-down">
              <li class="site-menu-item @if(in_array('request', Request::segments())  && in_array('modify', Request::segments())) active @endif">
                <a href="{{route('modify.index',["status"=>"request"])}}">
                  <span class="site-menu-title">Requested</span>
                </a>
              </li>
              <li class="site-menu-item @if(in_array('approved', Request::segments()) && in_array('modify', Request::segments())) active @endif">
                <a href="{{route('modify.index',["status"=>"approved"])}}">
                  <span class="site-menu-title">Approved</span>
                </a>
              </li>
              <li class="site-menu-item @if(in_array('rejected', Request::segments()) && in_array('modify', Request::segments())) active @endif">
                <a href="{{route('modify.index',["status"=>"rejected"])}}">
                  <span class="site-menu-title">Rejected</span>
                </a>
              </li>
            </ul>
          </li> --}}
          {{-- <li class="site-menu-item @if(in_array('booking-session', Request::segments())) active @endif">
            <a href="{{route('booking-session.index')}}">
              <i class="site-menu-icon md-group-work" aria-hidden="true"></i>
              <span class="site-menu-title">{{ __('admin.booking-menu') }}</span>
            </a>
          </li> --}}
          {{-- <li class="site-menu-item @if(in_array('notification', Request::segments())) active @endif">
            <a href="{{route('notification.index')}}">
              <i class="site-menu-icon icon md-notifications"></i>
              <span class="site-menu-title">{{ __('admin.notification-menu') }}</span>
            </a>
          </li> --}}
          <li class="site-menu-item @if(in_array('feedback', Request::segments())) active @endif">
            <a href="{{route('feedback.index')}}">
              <i class="site-menu-icon md-comment-list" aria-hidden="true"></i>
              <span class="site-menu-title">{{ __('admin.feedback-menu') }}</span>
            </a>
          </li>
          {{-- <li class="site-menu-item @if(in_array('JobApplication', Request::segments())) active @endif">
            <a href="{{route('JobApplication.index')}}">
              <i class="site-menu-icon md-comment-list" aria-hidden="true"></i>
              <span class="site-menu-title">{{ __('admin.job-application-menu') }}</span>
            </a>
          </li> --}}
          {{-- <li class="site-menu-item @if(in_array('faq-management', Request::segments())) active @endif">
            <a href="{{route('faq-management.index')}}">
              <i class="site-menu-icon md-receipt" aria-hidden="true"></i>
              <span class="site-menu-title">{{ __('admin.faq-menu') }}</span>
            </a>
          </li> --}}
          
          {{-- <li class="site-menu-item @if(in_array('PushNotification', Request::segments())) active @endif">
            <a href="{{route('PushNotification.index')}}">
              <i class="site-menu-icon icon md-notifications"></i>
              <span class="site-menu-title">{{ __('admin.notification-menu') }}</span>
            </a>
          </li> --}}
          {{-- <li class="site-menu-item @if(in_array('terms-of-use', Request::segments())) active @endif">
            <a href="{{route('admin.termAndCondition')}}">
              <i class="site-menu-icon md-comment-list" aria-hidden="true"></i>
              <span class="site-menu-title">{{ __('admin.terms-menu') }}</span>
            </a>
          </li>
          <li class="site-menu-item @if(in_array('privacy-policy', Request::segments())) active @endif">
            <a href="{{route('admin.privacyPolicy')}}">
              <i class="site-menu-icon md-comment-list" aria-hidden="true"></i>
              <span class="site-menu-title">{{ __('admin.pp-menu') }}</span>
            </a>
          </li> --}}
           <li class="site-menu-item @if(in_array('ApiMessages', Request::segments())) active @endif">
                <a href="{{route('ApiMessages.index')}}">
                  <i class="site-menu-icon icon md-receipt"></i>
                  <span class="site-menu-title">{{ __('admin.api-messages-menu') }}</span>
                </a>
            </li>
          {{-- <li class="site-menu-item @if(in_array('connection-responses', Request::segments())) active @endif">
            <a href="{{route('connection-responses.index')}}">
              <i class="site-menu-icon md-receipt" aria-hidden="true"></i>
              <span class="site-menu-title">{{ __('admin.connection-response-menu') }}</span>
            </a>
          </li> --}}


        </ul>
      </div>
    </div>
  </div>
</div>