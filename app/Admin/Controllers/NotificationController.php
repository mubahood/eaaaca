<?php

namespace App\Admin\Controllers;

use App\Models\Notification;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Tymon\JWTAuth\Contracts\Providers\Auth;

class NotificationController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Notifications';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Notification());
        $grid->disableCreateButton();
        $grid->disableActions();
        $grid->disableBatchActions();
        $grid->disableExport();
        $grid->disableFilter();
        $grid->disableRowSelector();
        $grid->disableColumnSelector();
        $grid->disableTools();
        $grid->disableCreateButton();
        $u = Admin::user();
        $grid->model()
            ->where('receiver_id', $u->id)
            ->orderBy('id', 'desc');

        $grid->quickSearch('controller');
        $grid->column('created_at', __('Created'))->display(function ($created_at) {
            return date('d-m-Y h:m A', strtotime($created_at));
        })->sortable();
        $grid->column('controller', __('Notification'))->sortable();
        $grid->column('url', __('Action'))
            ->display(function ($url) {
                return "<a href='$url' class='btn btn-primary btn-sm'>View</a>";
            });

        $grid->column('status', __('Status'))
            ->dot([
                'Unread' => 'warning',
                'Read' => 'success',
            ], 'warning')
            ->sortable();

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
        $show = new Show(Notification::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('model', __('Model'));
        $show->field('controller', __('Controller'));
        $show->field('url', __('Url'));
        $show->field('body', __('Body'));
        $show->field('receiver_id', __('Receiver id'));
        $show->field('status', __('Status'));
        $show->field('is_sent', __('Is sent'));
        $show->field('priority', __('Priority'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Notification());

        $form->textarea('model', __('Model'));
        $form->textarea('controller', __('Controller'));
        $form->textarea('url', __('Url'));
        $form->textarea('body', __('Body'));
        $form->number('receiver_id', __('Receiver id'));
        $form->text('status', __('Status'))->default('Unread');
        $form->text('is_sent', __('Is sent'))->default('No');
        $form->text('priority', __('Priority'))->default('Moderate');

        return $form;
    }
}
