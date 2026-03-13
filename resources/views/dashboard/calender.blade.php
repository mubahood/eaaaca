<?php
use App\Models\Utils;
use App\Models\NewsPost;
//last news post
$last_news_post = NewsPost::orderBy('id', 'desc')->first();
if (!isset($display_notice_board)) {
    $display_notice_board = false;
}
?>
<div class="card mb-4 mb-md-5 border-0">
    <div class="card-body py-2 py-md-3">
        <div id='loading'></div>
        <div id='calendar'></div>
    </div>
</div>

@if ($display_notice_board)
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body p-5 p-md-4">
                    <h3 class="fs-30 fw-800 mb-3">ARINEA Updates</h3>
                    <hr>
                    <p class="fs-16 mb-4">
                        {!! $last_news_post->title !!}
                    </p>
                    <a href="{{ url('news-posts') }}" class="btn btn-primary btn-sm">View More</a> 
                    </p>
                </div>
            </div>
        </div>
    </div>
@endif


<script>
    $(document).ready(function() {
        var data = JSON.parse('<?= json_encode($events) ?>');
        var calendarEl = document.getElementById('calendar');


        var calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: {
                left: 'title',
                right: 'prev today next'
            },
            eventClick: function(arg) {
                arg.jsEvent.preventDefault()
                const eve = arg.event._def;
                const activity_id = eve.extendedProps.activity_id;
                $.alert({
                    title: eve.extendedProps.name + " - " + eve.extendedProps.status,
                    content: eve.extendedProps.details,
                    closeIcon: true,
                    buttons: {
                        view: {
                            btnClass: 'btn-primary btn-sm',
                            text: 'VIEW',
                            action: function() {
                                window.open(eve.extendedProps.url_view, '_blank');
                            }
                        },
                        edit: {
                            btnClass: 'btn-primary btn-sm',
                            text: 'UPDATE',
                            action: function() {
                                window.open(eve.extendedProps.url_edit, '_blank');
                            }
                        },

                        CLOSE: function() {

                        },
                    }
                });
            },
            editable: false,
            selectable: false,
            selectMirror: true,
            nowIndicator: true,
            displayEventTime: true,
            events: data,
            loading: function(bool) {
                document.getElementById('loading').style.display =
                    bool ? 'block' : 'none';
            }
        });
        calendar.render();
    });
</script>
