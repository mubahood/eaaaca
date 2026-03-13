<?php

namespace App\Admin\Controllers;

use App\Models\NewsPostCategory;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class NewsPostCategoryController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'News Posts Categories';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new NewsPostCategory());
        $grid->disableBatchActions();
        $grid->model()->orderBy('title', 'asc');
        $grid->column('title', __('Title'))->sortable();
        $grid->column('details', __('Details'));

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
        $show = new Show(NewsPostCategory::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('title', __('Title'));
        $show->field('photo', __('Photo'));
        $show->field('details', __('Details'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new NewsPostCategory());

        $form->text('title', __('Title'))->rules('required');
        $form->file('photo', __('Photo'));
        $form->textarea('details', __('Details'));

        return $form;
    }
}
