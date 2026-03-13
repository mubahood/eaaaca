<?php

namespace App\Admin\Controllers;

use App\Models\NewsPost;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class NewsPostController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'News Posts';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {

        $grid = new Grid(new NewsPost());
        $grid->disableActions();

        $u = Admin::user();
        $grid->disableBatchActions();
        if ($u->isRole('guest')) {
            $grid->model()
                ->orderBy('id', 'Desc')
                ->where([]);
            $grid->disableExport();
            $grid->disableCreateButton();
            $grid->disableFilter();
        }
        $grid->quickSearch('title')->placeholder('Search...');
        $grid->disableBatchActions();
        $grid->model()->orderBy('id', 'desc');

        $grid->column('photo', __('Photo'))->lightbox(['width' => 60, 'height' => 60]);
        $grid->column('created_at', __('Date'))
            ->display(function ($created_at) {
                return date('d-m-Y', strtotime($created_at));
            })->sortable();
        $grid->column('title', __('Title'))->sortable();
        $grid->column('administrator_id', __('Posted By'))
            ->display(function ($administrator_id) {
                if ($this->administrator == null) {
                    return '-';
                }
                return $this->administrator->name;
            })->sortable();


        $grid->column('news_post_category_id', __('View'))
            ->display(function ($administrator_id) {
                $link = admin_url('news-posts/' . $this->id);
                return "<a href='$link' ><b>View</b></a>";

                if ($this->category == null) {
                    return '-';
                }
                return $this->category->name;
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
        $show = new Show(NewsPost::findOrFail($id));

        $u = Admin::user();
        if (!$u->isRole('admin')) {
            $show->panel()
                ->tools(function ($tools) {
                    $tools->disableEdit();
                    $tools->disableDelete();
                });
        }

        $show->field('created_at', __('Date'))
            ->display(function ($created_at) {
                return date('d-m-Y', strtotime($created_at));
            });
        $show->field('title', __('Title'));
        $show->field('details', __('Details'))
            ->unescape()
            ->as(function ($details) {
                return $details;
            });

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new NewsPost());
        $form->hidden('administrator_id')->default(Admin::user()->id);

        //news_post_category_id
        $form->select('news_post_category_id', __('News Post Category'))
            ->options(\App\Models\NewsPostCategory::all()->pluck('title', 'id'));


        $form->text('title', __('Title'))->rules('required');
        $form->image('photo', __('Photo'));
        $form->quill('details', __('Details'))->rules('required');

        return $form;
    }
}
