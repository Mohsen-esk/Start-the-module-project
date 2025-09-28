<article class="poetry-card" data-category="{{ $post->category->name ?? 'نامشخص' }}">
    <div class="card-background"></div>
    <div class="card-content">
        <div class="card-header">
            <h2 class="card-title">{{ $post->title ?? 'بدون عنوان' }}</h2>
            <div class="card-bookmark">
                @auth
                    <form action="{{ route('posts.save', $post) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn border-0 p-0" title="ذخیره پست">
                            @if(Auth::user()->savedPosts->contains($post))
                                <i class="bi bi-bookmark-fill text-success" style="font-size: 1.5rem;"></i>
                            @else
                                <i class="bi bi-bookmark" style="font-size: 1.5rem;"></i>
                            @endif
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" title="برای ذخیره کردن وارد شوید">
                        <i class="bi bi-bookmark" style="font-size: 1.5rem;"></i>
                    </a>
                @endauth
            </div>
        </div>
        
        <div class="card-body">
            <p class="card-excerpt">
                {{ Str::limit(strip_tags($post->content), 150) }}
            </p>
        </div>
        
        <div class="card-meta">
            <div class="meta-row">
                <div class="author-info">
                    <div class="author-avatar">
                        <img src="{{ $post->user->avatar }}" alt="{{ $post->user->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div class="author-details">
                        <span class="author-name">{{ $post->user->nickname ?? $post->user->name ?? 'ناشناس' }}</span>
                        <span class="publish-date">{{ $post->created_at->format('Y/m/d') }}</span>
                    </div>
                </div>
                @if ($post->category)
                    <div class="category-tag {{ Str::slug($post->category->name) }}-tag">
                        <i class="bi bi-tag-fill"></i>
                        {{ $post->category->name }}
                    </div>
                @endif
            </div>
            <div class="card-stats">
                <div class="stat">
                    <i class="bi bi-eye-fill"></i>
                    <span>{{ $post->views_count ?? 0 }}</span>
                </div>
                <div class="stat">
                    <i class="bi bi-heart-fill"></i>
                    <span>{{ $post->likes_count ?? 0 }}</span>
                </div>
                <div class="stat">
                    <i class="bi bi-chat-fill"></i>
                    <span>{{ $post->comments_count ?? 0 }}</span>
                </div>
            </div>
        </div>
        
        <div class="card-actions">
            <a href="{{ route('posts.show', $post->slug ?? $post->id) }}" class="action-btn primary">
                <span>مطالعه</span>
                <i class="bi bi-arrow-left"></i>
            </a>
            @auth
                @if (Auth::id() === $post->user_id)
                    <a href="{{ route('posts.edit', $post->id) }}" class="action-btn">
                        <span>ویرایش</span>
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="action-btn danger" onclick="return confirm('آیا مطمئن هستید؟');">
                            <span>حذف</span>
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                @endif
            @endauth
        </div>
    </div>
</article>
