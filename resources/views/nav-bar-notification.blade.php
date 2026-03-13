<li class="dropdown notifications-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
        <i class="fa fa-bell-o"></i>
        <span class="label label-danger">{{ count($notifications) }}</span>
    </a>
    <ul class="dropdown-menu">
        <li class="header">You have {{ count($notifications) }} unread notifications</li>
        <li>

            @foreach ($notifications as $item)
        <li>
            <a href="{{ $item->url }}" title="{{ $item->controller }}">
                <i class="fa fa-bell text-red"></i> {{ Str::limit($item->controller, 30, '...') }}
            </a>
        </li>
        @endforeach
</li>
<li class="footer"><a href="{{ admin_url('notifications') }}" title="View all notifications">View all</a></li>
</ul>
</li>

</li>
