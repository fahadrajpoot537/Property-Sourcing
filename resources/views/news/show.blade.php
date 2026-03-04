@extends('layouts.app')

@section('meta_title', $article->meta_title ?? $article->title . ' | Property Sourcing Group')
@section('meta_description', $article->meta_description ?? Str::limit(strip_tags($article->excerpt ?? $article->content), 160))
@section('meta_keywords', $article->meta_keywords ?? 'property sourcing, blog, investment, ' . $article->title)

@section('content')

    <article class="bg-white">
        <!-- Header -->
        <header class="py-5 bg-blue text-white overflow-hidden position-relative">
            <div class="container py-4 position-relative z-1">
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}"
                                class="text-white opacity-75 text-decoration-none small">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('news.index') }}"
                                class="text-white opacity-75 text-decoration-none small">News</a></li>
                        <li class="breadcrumb-item active text-white small" aria-current="page">
                            {{ Str::limit($article->title, 30) }}
                        </li>
                    </ol>
                </nav>

                <h1 class="display-4 fw-bold mb-4 col-lg-9">{{ $article->title }}</h1>

                <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-pink d-flex align-items-center justify-content-center me-3"
                        style="width: 45px; height: 45px;">
                        <i class="bi bi-person-fill fs-5"></i>
                    </div>
                    <div>
                        <p class="mb-0 fw-bold small">{{ $article->author_name ?? 'The Property Sourcing Group' }}</p>
                        <p class="mb-0 small opacity-75">
                            {{ \Carbon\Carbon::parse($article->published_at ?? $article->created_at)->format('d F Y') }}
                        </p>
                    </div>
                </div>
            </div>
            <!-- Decorative bg -->
            <div class="position-absolute top-0 end-0 h-100 opacity-10 d-none d-lg-block"
                style="width: 400px; background: linear-gradient(45deg, transparent, var(--primary-pink)); clip-path: polygon(20% 0%, 100% 0%, 100% 100%, 0% 100%);">
            </div>
        </header>

        <!-- Main Content Area -->
        <div class="container py-5">
            <div class="row g-5">
                <!-- Article Body -->
                <div class="col-lg-8">
                    @if($article->image_url)
                        <div class="mb-5">
                            <img src="{{ asset('storage/' . $article->image_url) }}" class="img-fluid rounded-4 shadow-sm w-100"
                                alt="{{ $article->title }}">
                        </div>
                    @endif

                    <div class="article-content fs-5 lh-lg text-secondary">
                        {!! $article->content !!}
                    </div>

                    <!-- Shared Row -->
                    <div class="mt-5 pt-5 border-top d-flex flex-wrap justify-content-between align-items-center gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <span class="fw-bold text-blue">Share this:</span>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}"
                                target="_blank" class="btn btn-outline-secondary btn-sm rounded-circle"
                                style="width: 35px; height: 35px; padding: 0; line-height: 35px;"><i
                                    class="bi bi-facebook"></i></a>
                            <a href="https://www.instagram.com/shareArticle?mini=true&url={{ urlencode(request()->fullUrl()) }}"
                                target="_blank" class="btn btn-outline-secondary btn-sm rounded-circle"
                                style="width: 35px; height: 35px; padding: 0; line-height: 35px;"><i
                                    class="bi bi-instagram"></i></a>
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(request()->fullUrl()) }}"
                                target="_blank" class="btn btn-outline-secondary btn-sm rounded-circle"
                                style="width: 35px; height: 35px; padding: 0; line-height: 35px;"><i
                                    class="bi bi-linkedin"></i></a>
                        </div>
                        <a href="{{ route('news.index') }}" class="btn btn-light rounded-pill px-4 fw-bold shadow-sm"><i
                                class="bi bi-arrow-left me-2"></i> Back to All News</a>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <div class="sticky-top" style="top: 100px;">
                        <!-- Recent Posts -->
                        <div class="card border-0 bg-light rounded-4 p-4 mb-4">
                            <h5 class="fw-bold text-blue mb-4 pb-2 border-bottom">Recent Updates</h5>
                            @foreach($recent as $post)
                                <div class="d-flex gap-3 mb-4 last-mb-0">
                                    <div class="flex-shrink-0" style="width: 80px; height: 60px;">
                                        <img src="{{ $post->image_url ? asset('storage/' . $post->image_url) : 'https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&q=80&w=200' }}"
                                            class="w-100 h-100 rounded object-fit-cover shadow-sm" alt="">
                                    </div>
                                    <div class="overflow-hidden">
                                        <h6 class="fw-bold text-blue small mb-1 lh-sm">
                                            <a href="{{ route('news.show', $post->slug) }}"
                                                class="text-decoration-none text-blue hover-pink">{{ Str::limit($post->title, 45) }}</a>
                                        </h6>
                                        <span class="text-muted smaller"><i
                                                class="bi bi-calendar3 me-1"></i>{{ \Carbon\Carbon::parse($post->published_at ?? $post->created_at)->format('M d, Y') }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Inquiry Form (From Home Hero) -->
                        <div class="hero-form-card shadow-lg border-0">
                            <div class="text-center mb-4">
                                <h4 class="fw-bold text-blue mb-1">Unlock Exclusive Deals</h4>
                                <p class="text-muted small">Join our VIP list for free access</p>
                            </div>
                            <form action="#" method="POST">
                                <div class="mb-2">
                                    <input type="text" class="form-control" placeholder="Full Name*" required>
                                </div>
                                <div class="mb-2">
                                    <input type="email" class="form-control" placeholder="Email Address*" required>
                                </div>
                                <div class="mb-2">
                                    <input type="tel" class="form-control" placeholder="Phone Number*" required>
                                </div>
                                <div class="mb-3">
                                    <select class="form-select text-muted" required>
                                        <option value="">When are you ready to buy?*</option>
                                        <option value="Immediately">Immediately</option>
                                        <option value="1-3 Months">Within 1-3 Months</option>
                                        <option value="3-6 Months">Within 3-6 Months</option>
                                        <option value="Just Researching">Just Researching</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-custom-blue w-100 py-3 fw-bold shadow">
                                    Get Access Now <i class="bi bi-arrow-right-short"></i>
                                </button>
                                <div class="text-center mt-3">
                                    <small class="text-muted" style="font-size: 0.7rem;">Your data is secure with
                                        us.</small>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </article>

    <style>
        .article-content {
            color: #444 !important;
        }

        .article-content p {
            margin-bottom: 25px;
        }

        .article-content h2,
        .article-content h3 {
            color: var(--primary-blue);
            margin-top: 40px;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .article-content ul,
        .article-content ol {
            margin-bottom: 25px;
        }

        .article-content blockquote {
            border-left: 5px solid var(--primary-pink);
            padding: 15px 25px;
            font-style: italic;
            background: #fdf5f9;
            border-radius: 0 10px 10px 0;
            margin: 30px 0;
        }

        .hover-pink:hover {
            color: var(--primary-pink) !important;
        }

        .smaller {
            font-size: 0.8rem;
        }

        .last-mb-0:last-child {
            margin-bottom: 0 !important;
        }
    </style>
@endsection