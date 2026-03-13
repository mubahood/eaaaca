<?php

namespace App\Admin\Controllers;

use App\Models\InformationRequest;
use App\Models\Notification;
use App\Models\Offence;
use App\Models\Utils;
use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class InformationRequestController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Information Requests';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {

        // $not = Notification::find(1);
        // $not->send_mail();
        // die('done sending mail');
        // Utils::mail_sender();
        // die("done sending mail");
        // /* $m = InformationRequest::find(17);
        // $m->sendCreatedNotification();
        // die(); */
        $grid = new Grid(new InformationRequest());
        $grid->disableBatchActions();
        $grid->disableActions();
        $grid->quickSearch('request_reference_no')->placeholder('Search...');
        $conds = [];
        $u = Admin::user();
        if (!$u->isRole('admin')) {
            $grid->model()
                ->orderBy('id', 'Desc')
                ->where([
                    'sender_id' => Admin::user()->id,
                ])
                ->orWhere([
                    'receiver_id' => Admin::user()->id,
                ]);
        }
        $grid->model()->OrderBy('id', 'Desc');
        $grid->column('id', __('ID'))->sortable();
        $grid->column('created_at', __('Created'))
            ->display(function ($created_at) {
                return date('d-m-Y', strtotime($created_at));
            })->sortable();

        $grid->column('sender_id', __('Sender'))
            ->display(function ($sender_country_id) {
                if ($this->sender == null) {
                    return '-';
                }
                return $this->sender->name;
            })->sortable();
        $grid->column('receiver_id', __('Receiver'))
            ->display(function ($receiver_id) {
                if ($this->receiver == null) {
                    return '-';
                }
                return $this->receiver->name;
            })->sortable();
     
        $grid->column('request_reference_no', __('Request Reff No.'))->sortable();
        $grid->column('description_of_circumstances', __('Description of circumstances'))->sortable();
        $grid->column('purpose_for_information_request', __('Purpose for information request'))->hide();
        $grid->column('connection_btw_information_request', __('Connection btw information request'))->hide();
        $grid->column('identity_of_the_persons', __('Identity of the persons'))->hide();
        $grid->column('reasons_tobe_in_member_state', __('Reasons tobe in member state'))->hide();
        $grid->column('reason_for_request', __('Reason for request'))->hide();
        $grid->column('status', __('Status'))
            ->filter([
                'Pending' => 'Pending',
                'Waiting for response' => 'Waiting for response',
                'Halted' => 'Halted',
                'Completed' => 'Completed',
            ], 'Pending')
            ->label([
                'Pending' => 'warning',
                'Waiting for response' => 'info',
                'Halted' => 'danger',
                'Completed' => 'success',
            ], 'warning')
            ->sortable();
        $grid->column('view', __('View'))
            ->display(function ($view) {
                $link = admin_url('information-requests/' . $this->id . "/edit");
                return "<a href='$link' ><b>View</b></a>";
            })->sortable();

        return $grid;
    }

    /** 
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(InformationRequest::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('organization_id', __('Organization id'));
        $show->field('member_state_id', __('Member state id'));
        $show->field('date_time_of_request', __('Date time of request'));
        $show->field('request_reference_no', __('Request reference no'));
        $show->field('case_id', __('Case id'));
        $show->field('type_of_crimes_investigated', __('Type of crimes investigated'));
        $show->field('description_of_circumstances', __('Description of circumstances'));
        $show->field('purpose_for_information_request', __('Purpose for information request'));
        $show->field('connection_btw_information_request', __('Connection btw information request'));
        $show->field('identity_of_the_persons', __('Identity of the persons'));
        $show->field('reasons_tobe_in_member_state', __('Reasons tobe in member state'));
        $show->field('reason_for_request', __('Reason for request'));
        $show->field('review_on', __('Review on'));
        $show->field('review_status_id', __('Review status id'));
        $show->field('review_notes', __('Review notes'));
        $show->field('review_by_id', __('Review by id'));
        $show->field('status_id', __('Status id'));
        $show->field('user_id', __('User id'));
        $show->field('deleted_at', __('Deleted at'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('receiver_id', __('Receiver id'));
        $show->field('receiver_country_id', __('Receiver country id'));
        $show->field('sender_id', __('Sender id'));
        $show->field('sender_country_id', __('Sender country id'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new InformationRequest());

        if ($form->isEditing()) {
            $id = request()->segments()[1];
            $model = InformationRequest::find($id);
            if ($model != null) {
                $u = Admin::user();
                $notifications = Notification::where([
                    'model' => 'InformationRequest',
                    'model_id' => $model->id,
                    'receiver_id' => $u->id
                ])->get();
                foreach ($notifications as $notification) {
                    $notification->status = 'Read';
                    $notification->save();
                }
            }
        }


        $u = Admin::user();
        if ($form->isCreating()) {
            $form->hidden('status', __('Status'))->default('Pending');
            $form->hidden('sender_id', __('Sender'))->default($u->id);
            $recs = Administrator::toSelectArray();
            unset($recs[$u->id]);
            $form->select('receiver_id', __('Receiver Focal Point'))
                ->options($recs)
                ->rules('required');
            $form->text('request_reference_no', __('Reference number of this request'))->rules('required');
            $form->radioCard('has_previous_reques', 'Has this request been made before?')
                ->options(['Yes' => 'Yes', 'No' => 'No'])
                ->when('Yes', function ($form) {
                    $form->select('information_request_id', __('Select Previous Request'))
                        ->options(InformationRequest::toSelectArray())
                        ->rules('required');
                })->rules('required');
            $form->textarea('description_of_circumstances', __('Description of the circumstances in which the offence(s) was (were) committed, including the time, place an degree of participation in the offence(s) by the person who is the subject of the request for information or intelligence.'))
                ->help('Enter description of the circumstances in which the offence(s) was (were) committed here')
                ->rules('required');

            $form->checkbox('type_of_crimes_investigated', __('Crimes to investigate'))
                ->options(Offence::list())
                ->stacked()
                ->rules('required');
            $form->textarea('purpose_for_information_request', __('Identity(ies) (as far as known) of the person(s) being the main subject(s) of the criminal investigation or criminal intelligence operation underlying the request for information or intelligence'))->rules('required');
            $form->textarea('connection_btw_information_request', __("Connection between the purpose for which the information or intelligence is requested and the person who is the subject fo the information or intelligence."))->rules('required');
            $form->textarea('identity_of_the_persons', __('Reasons for believing that the information or intelligence is in the requested Member State'))->rules('required');
            $form->radio('reasons_tobe_in_member_state', __('Restrictions of the use of information contained in this request for purposes other than those for which it has been supplied of preventing an immediate and serious threat to public security.'))
                ->options([
                    'Use granted' => 'Use granted',
                    'Use granted, but do not mention the information provider' => 'Use granted, but do not mention the information provider',
                    'Do not use without authorisation of the information provider' => 'Do not use without authorisation of the information provider',
                    'Do not use' => 'Do not use'
                ])
                ->stacked()
                ->rules('required');
        } else {
            $form->divider("Request Information");
            $form->display('sender_id', __('Sender'))
                ->with(function ($sender_id) {
                    $sender = Administrator::find($sender_id);
                    if ($sender == null) {
                        return '-';
                    }
                    return $sender->name;
                });
            $recs = Administrator::toSelectArray();
            $form->display('receiver_id', __('Receiver Focal Point'))
                ->with(function ($receiver_id) {
                    $receiver = Administrator::find($receiver_id);
                    if ($receiver == null) {
                        return '-';
                    }
                    return $receiver->name;
                });
            $form->text('request_reference_no', __('Reference number of this request'))
                ->disable();
            $form->radio('has_previous_reques', 'Has this request been made before?')
                ->options(['Yes' => 'Yes', 'No' => 'No'])
                ->when('Yes', function ($form) {
                    $form->select('information_request_id', __('Select Previous Request'))
                        ->options(InformationRequest::toSelectArray());
                })
                ->disable();
            $form->textarea('description_of_circumstances', __('Description of the circumstances in which the offence(s) was (were) committed, including the time, place an degree of participation in the offence(s) by the person who is the subject of the request for information or intelligence.'))
                ->help('Enter description of the circumstances in which the offence(s) was (were) committed here')
                ->disable();

            $form->checkbox('type_of_crimes_investigated', __('Crimes to investigate'))
                ->options(Offence::list())
                ->stacked()
                ->disable();
            $form->textarea('purpose_for_information_request', __('Identity(ies) (as far as known) of the person(s) being the main subject(s) of the criminal investigation or criminal intelligence operation underlying the request for information or intelligence'))
                ->disable();
            $form->textarea('connection_btw_information_request', __("Connection between the purpose for which the information or intelligence is requested and the person who is the subject fo the information or intelligence."))
                ->disable();
            $form->textarea('identity_of_the_persons', __('Reasons for believing that the information or intelligence is in the requested Member State'))
                ->disable();
            $form->radio('reasons_tobe_in_member_state', __('Restrictions of the use of information contained in this request for purposes other than those for which it has been supplied of preventing an immediate and serious threat to public security.'))
                ->options([
                    'Use granted' => 'Use granted',
                    'Use granted, but do not mention the information provider' => 'Use granted, but do not mention the information provider',
                    'Do not use without authorisation of the information provider' => 'Do not use without authorisation of the information provider',
                    'Do not use' => 'Do not use'
                ])
                ->stacked()->disable();
            $form->divider("Request Response");


            //get current url segments
            $segment = InformationRequest::where([
                'id' => request()->segments()[1]
            ])->first();
            $u = Admin::user();

            if ($u->id == $segment->receiver_id) {
                $form->radioCard('status', __('Mark Request Status As'))
                    ->options([
                        'Pending' => 'Pending',
                        'Waiting for response' => 'Received & Waiting for response',
                        'Halted' => 'Halted',
                        'Completed' => 'Completed',
                    ])
                    ->rules('required');

                $form->quill('gen_response', __('General Response'))
                    ->help('Enter response here');

                //has manay information_request_reponses
                $form->hasMany('information_request_reponses', 'Reponse Attachments', function (Form\NestedForm $form) {
                    $form->text('description', __('Description'))->rules('required');
                    $form->file('file', __('Attachment'));
                });
            } else {
                $form->disableViewCheck();
                $form->disableSubmit();
                $form->select('status', __('Request Status'))
                    ->options([
                        'Pending' => 'Pending',
                        'Waiting for response' => 'Waiting for response',
                        'Halted' => 'Halted',
                        'Completed' => 'Completed',
                    ])
                    ->disable();
                $form->hasMany('information_request_reponses', 'Request Responses', function (Form\NestedForm $form) {
                    $form->display('description', __('Description'))->disable();
                    $form->file('file', __('Attachment'))
                        ->downloadable()
                        ->disable();
                })->disableCreate()
                    ->disableDelete();
            }
        }



        $form->disableCreatingCheck();
        $form->disableViewCheck();
        $form->disableReset();
        $form->tools(function (Form\Tools $tools) {
            $tools->disableDelete();
            $tools->disableView();
        });
        return $form;
    }
}
