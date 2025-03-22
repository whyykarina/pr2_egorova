<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    public function store(Request $request, Topic $topic)
    {
        $request->validate([
            'body' => 'required',
        ]);

        $comment = new Comment([
            'body' => $request->input('body'),
            'user_id' => Auth::id(),
            'topic_id' => $topic->id,
        ]);

        $comment->save();

        return redirect()->route('topics.show', $topic->id)->with('success', 'Комментарий успешно добавлен!');
    }

    public function edit(Comment $comment)
    {
        if (! Gate::allows('update-comment', $comment)) {
            abort(403);
        }
        return view('comments.edit', compact('comment'));
    }

    public function update(Request $request, Comment $comment)
    {
         if (! Gate::allows('update-comment', $comment)) {
            abort(403);
        }
        $request->validate([
            'body' => 'required',
        ]);

        $comment->body = $request->input('body');
        $comment->save();

        return redirect()->route('topics.show', $comment->topic_id)->with('success', 'Комментарий успешно обновлен!');
    }

    public function destroy(Comment $comment)
    {
        if (! Gate::allows('delete-comment', $comment)) {
            abort(403);
        }
        $comment->delete();
        return redirect()->route('topics.show', $comment->topic_id)->with('success', 'Комментарий успешно удален!');
    }
}