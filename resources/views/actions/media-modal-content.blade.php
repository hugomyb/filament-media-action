<div class="w-full flex justify-center items-center h-full">

    @if ($mediaType === 'youtube')
        @php
            // Extract the YouTube video ID from the URL
            $queryString = parse_url($mediaUrl, PHP_URL_QUERY);
            parse_str($queryString, $queryParams);
            $youtubeId = $queryParams['v'] ?? '';
        @endphp

        @if ($youtubeId)
            <iframe width="100%" height="480" src="https://www.youtube.com/embed/{{ $youtubeId }}" frameborder="0"
                    allowfullscreen></iframe>
        @else
            <p>Invalid YouTube URL.</p>
        @endif

    @elseif ($mediaType === 'audio')

        <audio controls>
            <source src="{{ $mediaUrl }}" type="audio/{{ pathinfo($mediaUrl, PATHINFO_EXTENSION) }}">
            Your browser does not support the audio element.
        </audio>

    @elseif ($mediaType === 'video')

        <video width="560" height="315" controls>
            <source src="{{ $mediaUrl }}" type="video/{{ pathinfo($mediaUrl, PATHINFO_EXTENSION) }}">
            Your browser does not support the video tag.
        </video>

    @elseif ($mediaType === 'image')

        <img src="{{ $mediaUrl }}" alt="Media Image" style="max-width: 100%; height: auto;">

    @elseif ($mediaType === 'pdf')

        <embed src="{{ $mediaUrl }}" type="application/pdf" width="100%" height="480">

    @else
        <p>Unsupported media type.</p>
    @endif
</div>
