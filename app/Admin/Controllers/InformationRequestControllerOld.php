<?php

namespace App\Admin\Controllers;

use App\Models\CaseModel;
use App\Models\InformationRequest;
use App\Models\Offence;
use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Controllers\AdminController;
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
        $grid = new Grid(new InformationRequest());
        $grid->disableBatchActions();

        $grid->column('created_at', __('Created'))
            ->display(function ($created_at) {
                return date('d-m-Y', strtotime($created_at));
            })->sortable();
        $grid->column('administrator_id', __('Applicant'))
            ->display(function ($administrator_id) {
                if ($this->administrator == null)
                    return '';
                return $this->administrator->name;
            })->sortable();
        $grid->column('title', __('Reason'))->sortable();
        $grid->column('request_reference_no', __('Reference No.'));
        $grid->column('case_id', __('Case'))
            ->display(function ($case_id) {
                if ($this->case == null)
                    return '-';
                return $this->case->title;
            })->sortable();
        $grid->column('review_by_id', __('Review'))->display(function ($administrator_id) {
            if ($this->review_by == null)
                return '';
            return $this->review_by->name;
        })->sortable();
        $grid->column('type_of_crimes_investigated', __('Crimes to investigated'))
            ->display(function ($type_of_crimes_investigated) {
                $offences = Offence::whereIn('id', $type_of_crimes_investigated)->get();
                $offences = $offences->map(function ($offence) {
                    return "<span class='label label-success'>{$offence->name}</span>";
                });
                return join('&nbsp;', $offences->toArray());
            })
            ->hide();
        $grid->column('description_of_circumstances', __('Description of circumstances'))->hide();
        $grid->column('purpose_for_information_request', __('Purpose for information request'))->hide();
        $grid->column('connection_btw_information_request', __('Connection btw information request'))->hide();
        $grid->column('identity_of_the_persons', __('Identity of the persons'))->hide();
        $grid->column('reasons_tobe_in_member_state', __('Reasons tobe in member state'))->hide();
        $grid->column('reason_for_request', __('Reason for request'))->hide();
        /*  $grid->column('review_on', __('Review on'))->hide();
        $grid->column('review_status', __('Review Status'))
            ->label([
                '0' => 'Not Reviewed',
                '1' => 'Reviewed',
            ], 'info');
        $grid->column('review_notes', __('Review notes')); */


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
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('administrator_id', __('Administrator id'));
        $show->field('title', __('Title'));
        $show->field('request_reference_no', __('Request reference no'));
        $show->field('case_id', __('Case id'));
        $show->field('review_by_id', __('Review by id'));
        $show->field('type_of_crimes_investigated', __('Type of crimes investigated'));
        $show->field('description_of_circumstances', __('Description of circumstances'));
        $show->field('purpose_for_information_request', __('Purpose for information request'));
        $show->field('connection_btw_information_request', __('Connection btw information request'));
        $show->field('identity_of_the_persons', __('Identity of the persons'));
        $show->field('reasons_tobe_in_member_state', __('Reasons tobe in member state'));
        $show->field('reason_for_request', __('Reason for request'));
        $show->field('review_on', __('Review on'));
        $show->field('review_status', __('Review status'));
        $show->field('review_notes', __('Review notes'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {

        /* 
ALTER TABLE `information_requests` ADD `sender_id` INT NULL DEFAULT '1', ADD `sender_country_id` INT NULL DEFAULT '1' AFTER `sender_id`, ADD `sender_id` INT NULL DEFAULT '1' AFTER `sender_country_id`, ADD `sender_country_id` INT NULL DEFAULT '1' AFTER `sender_id`;
*/
        $form = new Form(new InformationRequest());
        $u = auth()->user();
        //administrator_id hidden
        $form->hidden('sender_id')->default($u->id);

        $form->select('receiver_id', __('Receiver Focal Point'))
            ->options(Administrator::toSelectArray())
            ->rules('required');
        $form->text('title', __('Reason'))->rules('required');

        $form->text('request_reference_no', __('Request Reference No'));

        $form->select('case_id', __('Case'))->options(CaseModel::casesToArray())
            ->rules('required');

        $form->multipleSelect('type_of_crimes_investigated', __('Crimes to investigate'))
            ->options(Offence::list())
            ->rules('required');

        $form->textarea('description_of_circumstances', __('Description of circumstances'));
        /*        $form->textarea('connection_btw_information_request', __('Connection btw information request'));
        $form->textarea('purpose_for_information_request', __('Purpose for information request'));
        $form->textarea('identity_of_the_persons', __('Identity of the persons')); 
                $form->textarea('reasons_tobe_in_member_state', __('Reasons tobe in member state'));
        */

        $form->textarea('reason_for_request', __('Reason for request'));
        if ($u->isRole('admin')) {
            $form->radioCard('review_on', __('Review on'))
                ->options([
                    '1' => 'Yes',
                    '0' => 'No',
                ])->default('0');
            $form->text('review_status', __('Review status'));
            $form->textarea('review_notes', __('Review notes'));
        }

        return $form;
    }
}
