@extends('layouts.app')

@section('content')

<div class="profile-page">

    <!-- HEADER PROFILE -->
    <div class="profile-header">
        <div class="profile-avatar">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=000&color=fff&size=200"
                 alt="avatar">
        </div>

        <div class="profile-info">
            <h1>{{ $user->name }}</h1>
            <p class="profile-email">{{ $user->email }}</p>

            <div class="profile-stats">
                <div class="stat">
                    <span class="number">{{ $totalPosts }}</span>
                    <span class="label">Posts</span>
                </div>

                <div class="stat">
                    <span class="number">{{ $totalLikes }}</span>
                    <span class="label">Likes</span>
                </div>

                <div class="stat">
                    <span class="number">{{ $totalFavorites }}</span>
                    <span class="label">Favoris</span>
                </div>
            </div>

            @auth
                @if(auth()->id() === $user->id)
                    <a href="#" class="btn-edit">Modifier mon profil</a>
                @endif
            @endauth
        </div>
    </div>

    <!-- POSTS LIST -->
    <div class="profile-posts">
        <h2>Looks publiés</h2>

        @if($posts->count() === 0)
            <p class="empty-text">Aucun post publié pour le moment.</p>
        @else
            <div class="posts-grid">
                @foreach($posts as $post)
                    <div class="post-card">

                        <a href="{{ route('posts.show', $post->id) }}">
                            <div class="post-image">
                                <img src="{{ $post->image_url ?? 'https://placehold.co/600x600?text=Trendora' }}"
                                     alt="post image">
                            </div>
                        </a>

                        <div class="post-body">
                            <h3>{{ $post->title }}</h3>

                            <p class="post-desc">
                                {{ Str::limit($post->description, 90) }}
                            </p>

                            <div class="post-meta">
                                <span>❤️ {{ $post->likes->count() }}</span>
                                <span>⭐ {{ $post->favorites->count() }}</span>
                            </div>

                            @if($post->clothingItems->count() > 0)
                                <div class="clothing-tags">
                                    @foreach($post->clothingItems->take(3) as $item)
                                        <span class="tag">{{ $item->name }}</span>
                                    @endforeach

                                    @if($post->clothingItems->count() > 3)
                                        <span class="tag more">+{{ $post->clothingItems->count() - 3 }}</span>
                                    @endif
                                </div>
                            @endif
                        </div>

                    </div>
                @endforeach
            </div>

            <div class="pagination">
                {{ $posts->links() }}
            </div>
        @endif
    </div>

</div>

@endsection