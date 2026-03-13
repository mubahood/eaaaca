<?php

namespace App\Admin\Controllers;

use App\Models\Country;
use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CountryController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Member States'; //states


    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Country());
        $grid->disableBatchActions();
        $grid->model()->orderBy('name', 'asc');
        //quick search
        $grid->quickSearch('name');

        $grid->column('flag', __('Flag'))->lightbox(['width' => 60, 'height' => 60])
            ->sortable();
        $grid->column('name', __('Name'))->sortable();
        $grid->column('administrator_id', __('Contact Person'))
            ->display(function ($administrator_id) {
                if ($this->administrator == null) {
                    return '-';
                }
                return $this->administrator->name;
            }) 
            ->sortable();

        $grid->column('cases', __('Cases'))
            ->display(function ($cases) {
                return count($cases);
            });
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
        $show = new Show(Country::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('name', __('Name'));
        $show->field('flag', __('Flag'));
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
        $form = new Form(new Country());

        $form->text('name', __('Name'))->rules('required');

        $ajax_url = url(
            '/api/ajax?'
                . "search_by_1=name"
                . "&search_by_2=id"
                . "&model=User"
        );
        $form->select('administrator_id', "Contact person")
            ->options(function ($id) {
                $a = Administrator::find($id);
                if ($a) {
                    return [$a->id => "#" . $a->id . " - " . $a->name];
                }
            })
            ->ajax($ajax_url)->rules('required');

        $form->image('flag', __('Flag'));
        $form->textarea('details', __('Details'));



        $form->disableReset();
        return $form;
    }
}
