<?php

namespace App\Admin\Controllers;

use App\Models\DiscussionBoardPost;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class DiscussionBoardPostController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Discussion Board - Posts';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new DiscussionBoardPost());
        $grid->disableBatchActions();
        $grid->disableExport();
        //disable delete from row actions
        $grid->disableActions();

        $grid->column('created_at', __('Created'))
            ->display(function ($created_at) {
                return date('d-m-Y', strtotime($created_at));
            })->sortable();
        $grid->column('photo', __('Photo'))->lightbox(['width' => 60, 'height' => 60])
            ->sortable();
        $grid->column('topic', __('Topic'))->sortable();
        $grid->column('comments', __('Comments'))
            ->display(function ($comments) {
                return count($comments);
            });


        $grid->column('administrator_id', __('Posted by'))
            ->display(function ($administrator_id) {
                if ($this->administrator == null)
                    return '';
                return $this->administrator->name;
            })->sortable();

        //column for read post
        $grid->column('Read', __('Read'))
            ->display(function ($details) {
                //Read link
                $read_link = admin_url('discussion-board-posts/' . $this->id);
                return '<a href="' . $read_link . '" class="btn btn-primary btn-sm" >Read More</a>';
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
        $show = new Show(DiscussionBoardPost::findOrFail($id));

        //disable delete
        $show->panel()->tools(function ($tools) {
            $tools->disableDelete();
        });

        $show->field('created_at', __('Date'))->as(function ($created_at) {
            return date('d-m-Y', strtotime($created_at));
        });
        $show->field('topic', __('Topic'));
        $show->field('administrator_id', __('Posted by'))
            ->as(function ($administrator_id) {
                if ($this->administrator == null)
                    return '';
                return $this->administrator->name;
            });

        $show->field('photo', __('Thumbnail'))->image();
        $show->field('details', __('Post Details'))->unescape(function ($details) {
            return $details;
        });

        $show->divider();

        $show->id('Coments')->unescape()->as(function ($id) {
            $comments = DiscussionBoardPost::find($id)->comments;
            $comments_html = '';
            foreach ($comments as $key => $comment) {
                $comments_html .= '<div class="card mb-2">';
                $comments_html .= '<div class="card-body">';
                //add deate created
                $comments_html .= '<h6 class="card-subtitle mb-2 text-muted">' . date('d-m-Y', strtotime($comment->created_at)) . '</h6>';
                $comments_html .= '<p class="card-text">' . $comment->body . '</p>';
                $comments_html .= '<h5 class="card-title text-primary"> Comment By<b>' . $comment->administrator->name . '</b></h5>';
                $comments_html .= '</div>';
                $comments_html .= '</div>';
            }
            //add new comment button
            $comments_html .= '<div class="card mb-2">';
            $comments_html .= '<div class="card-body p-5">';
            $comments_html .= '<form action="' . admin_url('discussion-board-posts/' . $id) . '" method="post">';
            $comments_html .= csrf_field();
            $comments_html .= '<input type="hidden" name="_method" value="PUT">';
            $comments_html .= '<input type="hidden" name="last_comment_administrator_id" value="' . Admin::user()->id . '">';
            $comments_html .= '<div class="form-group">';
            $comments_html .= '<label for="last_comment_body">Enter Your Comment</label>';
            $comments_html .= '<textarea class="form-control" id="last_comment_body" name="last_comment_body" rows="3"></textarea>';
            $comments_html .= '</div>';
            $comments_html .= '<button type="submit" class="btn btn-primary">Submit</button>';
            $comments_html .= '</form>';
            $comments_html .= '</div>';
            $comments_html .= '</div>';

            return $comments_html;
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
        $form = new Form(new DiscussionBoardPost());
        $u = Admin::user();

        if ($form->isCreating()) {
            $form->hidden('administrator_id', __('Administrator id'))->default(Admin::user()->id);
            $form->text('topic', __('Topic of discussion'))->rules('required');
            $form->image('photo', __('Photo'));
            $form->quill('details', __('Details'))->rules('required');
        } else {
            $form->display('topic', __('Topic of discussion'));
            $form->display('administrator_id', __('Posted by'))
                ->with(function ($administrator_id) {
                    if ($this->administrator == null)
                        return '';
                    return $this->administrator->name;
                });

            $form->display('photo', __('Photo'))->with(function ($photo) {
                return "<img src='" . url("storage/" . $photo) . "' width='100px' height='100px'>";
            });
            $form->display('details', __('Details'))->with(function ($details) {
                return $details;
            });
            $form->divider('Add New Comment');
            $form->textarea('last_comment_body', __('Enter Your Comment'))->rules('required');
            $form->hidden(
                'last_comment_administrator_id',
                __('Administrator id')
            )->default($u->id)->rules('required');

            /*             $form->hasMany('comments', 'Comments (Press new to add a Comment)', function (Form\NestedForm $form) {
                $u = Admin::user();
                $form->hidden('administrator_id', __('Administrator id'))->default($u->id);
                $form->textarea('body', __('Comment'))->rules('required');
            })
            ->disableDelete(); */
        }
        $form->divider();

        $form->disableReset();
        $form->disableCreatingCheck();
        return $form;
    }
}
