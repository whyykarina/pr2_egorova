<?php

namespace App\Http\Controllers;

use App\Models\Vote;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'comment_id' => 'required|exists:comments,id',
            'is_like' => 'required|boolean',
        ]);

        $commentId = $request->input('comment_id');
        $isLike = $request->input('is_like');
        $userId = Auth::id();

        // Проверить, голосовал ли пользователь уже за этот комментарий
        $existingVote = Vote::where('user_id', $userId)
            ->where('comment_id', $commentId)
            ->first();

        if ($existingVote) {
            // Если пользователь уже голосовал, обновить его голос
            $existingVote->is_like = $isLike;
            $existingVote->save();
        } else {
            // Если пользователь не голосовал, создать новый голос
            Vote::create([
                'user_id' => $userId,
                'comment_id' => $commentId,
                'is_like' => $isLike,
            ]);
        }

        // Возвращаем JSON-ответ, чтобы обновить UI
        $comment = Comment::find($commentId);
        $likes = $comment->votes()->where('is_like', true)->count();
        $dislikes = $comment->votes()->where('is_like', false)->count();

        return response()->json([
            'likes' => $likes,
            'dislikes' => $dislikes,
        ]);
    }
}