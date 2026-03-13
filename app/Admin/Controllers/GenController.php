<?php

namespace App\Admin\Controllers;

use App\Models\Gen;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class GenController extends AdminController
{
    protected $title = 'Generator';

    protected function grid()
    {
        $grid = new Grid(new Gen());
        $grid->disableBatchActions();
        $grid->column('id', 'ID')->sortable();
        $grid->column('created_at', 'Created')->sortable();
        return $grid;
    }

    protected function detail($id)
    {
        $show = new Show(Gen::findOrFail($id));
        $show->field('id', 'ID');
        $show->field('created_at', 'Created At');
        return $show;
    }

    protected function form()
    {
        $form = new Form(new Gen());
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
