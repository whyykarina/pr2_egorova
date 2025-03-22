<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;


class TopicController extends Controller
{
    public function index()
    {
        $topics = Topic::with('user', 'category')->latest()->paginate(10); // Загружать связанные данные и пагинировать
        $categories = Category::all();
        return view('topics.index', compact('topics','categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('topics.create',compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
            'category_id' => 'required|exists:categories,id'
        ]);

        $topic = new Topic([
            'title' => $request->input('title'),
            'body' => $request->input('body'),
            'user_id' => Auth::id(),
            'category_id' => $request->input('category_id')
        ]);

        $topic->save();

        return redirect()->route('topics.index')->with('success', 'Тема успешно создана!');
    }

    public function show(Topic $topic)
    {
        $topic->load('user', 'category', 'comments.user'); // Загрузить связанные данные для отображения
        return view('topics.show', compact('topic'));
    }

    public function edit(Topic $topic)
    {
        if (! Gate::allows('update-topic', $topic)) {
            abort(403);
        }

        $categories = Category::all();
        return view('topics.edit', compact('topic','categories'));
    }

    public function update(Request $request, Topic $topic)
    {
        $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
            'category_id' => 'required|exists:categories,id'
        ]);

        $topic->title = $request->input('title');
        $topic->body = $request->input('body');
        $topic->category_id = $request->input('category_id');
        $topic->save();

        return redirect()->route('topics.index')->with('success', 'Тема успешно обновлена!');
    }

    public function destroy(Topic $topic)
    {
        if (! Gate::allows('delete-topic', $topic)) {
            abort(403);
        }
        $topic->delete();
        return redirect()->route('topics.index')->with('success', 'Тема успешно удалена!');
    }

    public function filterByCategory(Category $category)
    {
        $topics = $category->topics()->with('user', 'category')->latest()->paginate(10);
        $categories = Category::all();
        return view('topics.index', compact('topics', 'categories', 'category'));
    }

}