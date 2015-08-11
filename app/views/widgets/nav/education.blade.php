<ul class="dropdown-menu">
    <li><a href="{{ str_replace(get_site_url() , '', get_permalink($parent->ID)) }}">{{ $parent->post_title }}</a> </li>
    <li class="divider"></li>
    @foreach ($posts as $post)
    <li><a href="{{ str_replace(get_site_url() , '', get_permalink($post->ID)) }}">{{ $post->post_title }}</a></li>
    @endforeach
</ul>
