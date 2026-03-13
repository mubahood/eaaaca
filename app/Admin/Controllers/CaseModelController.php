<?php

namespace App\Admin\Controllers;

use App\Models\CaseModel;
use App\Models\Country;
use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\Constraint\Count;

class CaseModelController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Cases';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new CaseModel());
        $u = Admin::user();
        $grid->disableBatchActions();
        if ($u->isRole('guest')) {
            $grid->model()
                ->orderBy('id', 'Desc')
                ->where([
                    'administrator_id' => $u->id,
                ]);
            $grid->disableExport();
            $grid->disableFilter();
        } else {
            if (!$u->isRole('admin')) {
                $grid->model()
                    ->orderBy('id', 'Desc')
                    ->where([
                        'country_id' => $u->country_id,
                    ]);
            }
        }
        $grid->column('id', __('Id'))->sortable();
        $grid->column('title', __('Title'))->sortable();
        $grid->column('created_at', __('Created'))
            ->display(function ($created_at) {
                return date('d-m-Y', strtotime($created_at));
            })->sortable();
        $grid->column('updated_at', __('Last Updated'))
            ->display(function ($created_at) {
                //return date and time
                return date('d-m-Y h:i:s', strtotime($created_at));
            })->sortable();
        $grid->column('administrator_id', __('Created By'))
            ->display(function ($administrator_id) {
                if ($this->owner == null) {
                    return '-';
                }
                return $this->owner->name;
            })->sortable();
        $grid->column('country_id', __('Member State'))
            ->sortable()
            ->display(function ($country_id) {
                if ($this->country == null) {
                    return '-';
                }
                return $this->country->name;
            });

        $grid->column('status', __('Status'))
            ->label([
                'Investigation' => 'warning',
                'Closed' => 'success',
            ])->sortable()
            ->filter([
                'Investigation' => 'Under Investigation',
                'Closed' => 'Closed',
            ]);
        $grid->column('contributors', __('Contributors'))
            ->display(function ($contributors) {
                $count = count($contributors);
                return $count;
            });
        $grid->column('attachments', __('Attachments'))
            ->display(function ($attachments) {
                $count = count($attachments);
                return $count;
            });
        $grid->column('findings', __('Findings'))
            ->display(function ($findings) {
                $count = count($findings);
                return $count;
            })->sortable();

        $grid->column('content', __('Content'))
            ->hide();

        $grid->actions(function ($actions) {
            $u = Admin::user();
            if (!$u->isRole('admin')) {
                $actions->disableDelete();
            }
        });
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
        $show = new Show(CaseModel::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('administrator_id', __('Administrator id'));
        $show->field('country_id', __('Country id'));
        $show->field('title', __('Title'));
        $show->field('status', __('Status'));
        $show->field('content', __('Content'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new CaseModel());
        $u = Auth::user();

        $form->divider('Case Basic Information');
        $u = Admin::user();
        $form->hidden('administrator_id')->default($u->id); 
        if ($form->isCreating()) {
            $form->text('title', __('Case Title'))->rules('required');
            $options = [
                'Investigation'   => 'Under Investigation',
                'Closed' => 'Closed',
                'Pending' => 'Pending',
            ];
            if ($u->isRole('guest')) {
                $options = [
                    'Pedning' => 'Pending'
                ];
            }
            $form->radioCard('status', __('Case Status'))
                ->options($options)
                ->rules('required')
                ->default('Pending');
            $form->quill('content', __('Case Details'));
        } else {

            $form->display('title', __('Case Title'))->rules('required');
            $form->radio('status', __('Case Status'))
                ->options([
                    'Investigation'   => 'Under Investigation',
                    'Closed' => 'Closed',
                ]);
            $form->quill('content', __('Case Details'))->disable(true);
        }


        if (!$u->isRole('guest')) {
            $form->divider('Contributors');
            $form->hasMany('contributors', 'Contributors', function (Form\NestedForm $form) {
                $form->select('administrator_id', __('Contributor'))
                    ->options(Administrator::all()->pluck('name', 'id'))
                    ->rules('required');
                $form->hidden('notified')->default('No');
            });
        }
        $form->divider('Attachments');
        $form->hidden('administrator_id')->default(Admin::user()->id);
        $form->hasMany('attachments', function (Form\NestedForm $form) {
            $u = Admin::user();
            $form->hidden('administrator_id')->default($u->id);  
            $form->text('name', __('Attachment Title'))->rules('required');
            $form->file('file', __('Attachment File'));
        });

        if (!$u->isRole('guest')) {
            $form->divider('Findings');
            $form->hasMany('findings', function (Form\NestedForm $form) {
                $form->hidden('administrator_id')->default(Admin::user()->id);
                $form->text('title', __('Title'))->rules('required');
                $form->quill('details', __('Details'))->rules('required');
            });
        }


        $form->disableCreatingCheck();
        $form->disableViewCheck();
        $form->disableReset();
        return $form;
    }
}
