<?php
if (!isset($events_count)) {
    $events_count = 0;
}
if (!isset($project_count)) {
    $project_count = 0;
}
if (!isset($tasks_count)) {
    $tasks_count = 0;
}
if (!isset($pending_requests)) {
    $pending_requests = [];
}
if (!isset($waiting_requests)) {
    $waiting_requests = [];
}
if (!isset($title)) {
    $title = 'Pending Requests';
}
?>
<div class="row">
    <div class="col-12">
        <div class="row">
            <div class="col-md-4">
                @include('widgets.box-6', [
                    'is_dark' => false,
                    'title' => 'Pending Requests',
                    'icon' => 'box',
                    'number' => count($pending_requests),
                    'link' => 'javascript:;',
                ])
            </div>
            <div class="col-md-4">
                @include('widgets.box-6', [
                    'is_dark' => false,
                    'title' => 'Waiting Response',
                    'icon' => 'list-task',
                    'number' => count($waiting_requests),
                    'link' => 'javascript:;',
                ])
            </div>
            <div class="col-md-4">
                @include('widgets.box-6', [
                    'is_dark' => false,
                    'title' => 'Registered Users',
                    'icon' => 'calendar-event-fill',
                    'number' => $users,
                    'link' => 'javascript:;',
                ])
            </div>
        </div>
    </div>
</div>
{{-- <div class="row">
    <div class="col-md-6">
        @include('dashboard.upcoming-events', [
            'items' => $events->take(8),
        ])
    </div>
    <div class="col-md-6">
        @include('dashboard.tasks', [
            'items' => $events->take(8),
        ])
    </div>
</div>
 --}}
