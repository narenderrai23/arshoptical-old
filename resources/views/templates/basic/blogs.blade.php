
        @extends($activeTemplate.'layouts.frontend')
        @section('content')
 <section class="inner-page-sec-padding-bottom">
            <div class="container">
                <div class="blog-post post-details mb--50">
                    <div class="blog-image">
                        <img src="image/others/blog-img-big-1.jpg
            
            " alt="">
                    </div>
                    <div class="blog-content mt--30">
                        <header>
                            <h3 class="blog-title"> {{$blog->title}}</h3>
                            <div class="post-meta">
                                <span class="post-author">
                                    <i class="fas fa-user"></i>
                                    <span class="text-gray">Posted by : </span>
                                    admin
                                </span>
                                <span class="post-separator">|</span>
                                <span class="post-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span class="text-gray">On : </span>
                                    {{$blog->created_at->format('M, d Y')}}
                                </span>
                            </div>
                        </header>
                        <article>
                            <h3 class="d-none sr-only">blob-article</h3>
                            <p class="p-0">{{!! $blog->desciption !!}}</p>
                        </article>
                        <footer class="blog-meta">
                            <div> </div>
                        </footer>
                    </div>
                </div>
        
          
               
            </div>
        </section>

        @endsection