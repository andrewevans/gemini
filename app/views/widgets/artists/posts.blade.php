@if (sizeof($posts) > 0)
    <h2>Blog Posts with {{ $artist->alias }}</h2>

    @foreach ($posts as $post)
    <div>
        <h2>({{ $post->post_type }}) ({{ $post->ID }}) {{ $post->post_title }}</h2>
        <?php
        //$dog = preg_replace("/\[caption.*\[\/caption\]/", '', $content);
        $patterns[0] = '/(\[caption)(.*)(\])(.*)(\[\/caption\])/';
        $replacements[0] = '<figure$2>$4</figure>';
        $post->post_content = preg_replace($patterns, $replacements, $post->post_content);
        ?>
    </div>
    @endforeach

    <div>
        <a href="{{ $artist->url() }}/bio">Read more about {{ $artist->alias }}</a>
    </div>
@endif