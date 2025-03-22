<div class="card mb-3">
    <div class="card-body">
        <form action="{{ route('comments.store', $topic->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="body">Ваш комментарий</label>
                <textarea class="form-control @error('body') is-invalid @enderror" id="body" name="body" rows="3"></textarea>
                @error('body')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Добавить комментарий</button>
        </form>
    </div>
</div>