<?php

namespace App\Admin\Controllers;

use App\Models\Offence;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class OffenceController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Offence';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Offence());
        $grid->model()->orderBy('name', 'asc');
        $grid->quickSearch('name');
        $grid->disableBatchActions();
        $grid->column('name', __('Name'))->sortable();
        $grid->column('description', __('Description'));


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
        $show = new Show(Offence::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('description', __('Description'));
        $show->field('deleted_at', __('Deleted at'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Offence());

        $form->text('name', __('Name'))->rules('required');
        $form->textarea('description', __('Description'));

        return $form;
    }
}
