<?php



/**
 * Laravel-admin - admin builder based on Laravel.
 * @author z-song <https://github.com/z-song>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 * Encore\Admin\Form::forget(['map', 'editor']);
 *
 * Or extend custom form field:
 * Encore\Admin\Form::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */

use App\Models\User;
use Encore\Admin\Auth\Database\Administrator;

/* $u = User::find(2);
$rand_no = rand(1, 1000000);
echo "RAND NO. <b>$rand_no</b><br>";
echo "OLD U NO. <b>{$u->status}</b><br><hr>";
$u->status = $rand_no;

$u->save();


die(); */

use App\Models\Utils;
use Encore\Admin\Facades\Admin;
use Illuminate\Support\Facades\Auth;
use App\Admin\Extensions\Nav\Shortcut;
use App\Admin\Extensions\Nav\Dropdown;

if (isset($_SERVER['REQUEST_URI'])) {
    $explode = explode('/', $_SERVER['REQUEST_URI']);
    if (in_array('logout', $explode)) {
        $u = Admin::user();
        if ($u != null) {
            $u = User::find($u->id);
            $u->code_sent = 'No';
            $u->code = '';
            $u->code_verified = 'No';
            $u->save();
        }
        Auth::logout();
        $url = admin_url();
    }
}

$explode = explode('/', $_SERVER['REQUEST_URI']);
if (!in_array('logout', $explode)) {
    $u = Admin::user();
    if ($u != null) {
        $u = User::find($u->id);
        $receiver = $u;
        if ($u->code_sent != 'Yes') {
            $code = rand(100000, 999999);
            $message = "Your EAAACA 2FA code is $code";
            if (strlen($u->email) < 5) {
                $u->email = $receiver->username;
            }
            if (strlen($u->email) < 5) {
                die("email not found");
            }
            $data['email'] = $receiver->email;
            $data['name'] = $receiver->name;
            $data['subject'] = 'EAAACA 2FA Code';
            $data['body'] = $message;
            $data['view'] = 'mail';
            $data['data'] = $message;
            try {
                Utils::mail_sender($data);
                $u->code = $code;
                $u->code_sent = 'Yes';
                $u->code_verified = 'No';
                $u->save();
            } catch (\Throwable $th) {
                $u->code_sent = 'No';
                $u->code_verified = 'No';
                //$u->save();
                dd($th->getMessage());
                return;
            }
            $pending_url = url('2fa');
            die("<script>location.href='$pending_url';</script>");
            return;
        }

        if ($u->code_verified != 'Yes') {
            /* $u->code_verified = 'Yes';
            $u->save(); */
            $pending_url = url('2fa');
            die("<script>location.href='$pending_url';</script>");
            return;
        }

        if ($u->status != 1) {
            $pending_url = url('pending');
            die("<script>location.href='$pending_url';</script>");
            return;
        }
    }
}



//form remove continue editing
Encore\Admin\Form::init(function (Encore\Admin\Form $form) {
    $form->tools(function ($tools) {
        $tools->disableDelete();
        $tools->disableView();
    });
    $form->disableReset();
    $form->disableCreatingCheck();
    $form->disableViewCheck();
});


Utils::system_boot();


Admin::css('/assets/js/calender/main.css');
Admin::js('/assets/js/calender/main.js');

Admin::css('/css/jquery-confirm.min.css');
Admin::js('/assets/js/jquery-confirm.min.js');
Admin::navbar(function (\Encore\Admin\Widgets\Navbar $navbar) {

    $u = Auth::user();

    /*     $navbar->left(view('admin.search-bar', [
        'u' => $u
    ]));

    $navbar->left(Shortcut::make([
        'News post' => 'news-posts/create',
        'Products or Services' => 'products/create',
        'Jobs and Opportunities' => 'jobs/create',
        'Event' => 'events/create',
    ], 'fa-plus')->title('ADD NEW'));
    $navbar->left(Shortcut::make([
        'Person with disability' => 'people/create',
        'Association' => 'associations/create',
        'Group' => 'groups/create',
        'Service provider' => 'service-providers/create',
        'Institution' => 'institutions/create',
        'Counselling Centre' => 'counselling-centres/create',
    ], 'fa-wpforms')->title('Register new'));

    $navbar->left(new Dropdown()); */
    $data['notifications'] = Utils::get_user_notifications($u);
    $navbar->right(view('nav-bar-notification', $data));

    /*    $navbar->right(Shortcut::make([
        'How to update your profile' => '',
        'How to register a new person with disability' => '',
        'How to register as service provider' => '',
        'How to register to post a products & services' => '',
        'How to register to apply for a job' => '',
        'How to register to use mobile App' => '',
        'How to register to contact us' => '',
        'How to register to give a testimonial' => '',
        'How to register to contact counselors' => '',
    ], 'fa-question')->title('HELP')); */
});




Encore\Admin\Form::forget(['map', 'editor']);
Admin::css(url('/assets/css/bootstrap.css'));
Admin::css('/css/styles.css');
//Admin::css('https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css');
