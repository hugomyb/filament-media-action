<div class="w-full flex flex-col justify-center items-center h-full" style="min-height: 480px">

    @if ($mediaType === 'youtube')
        @php
            // Extract the YouTube video ID from the URL
            $queryString = parse_url($mediaUrl, PHP_URL_QUERY);
            parse_str($queryString, $queryParams);
            $youtubeId = $queryParams['v'] ?? '';
        @endphp

        @if ($youtubeId)
            <iframe class="rounded-lg" width="100%" height="100%" src="https://www.youtube.com/embed/{{ $youtubeId }}" frameborder="0"
                    allowfullscreen></iframe>
        @else
            <p>Invalid YouTube URL.</p>
        @endif

    @elseif ($mediaType === 'audio')

        <audio class="rounded-lg" controls>
            <source src="{{ $mediaUrl }}" type="audio/{{ pathinfo($mediaUrl, PATHINFO_EXTENSION) }}">
            Your browser does not support the audio element.
        </audio>

    @elseif ($mediaType === 'video')

        <video class="rounded-lg" width="100%" height="480" controls>
            <source src="{{ $mediaUrl }}" type="video/{{ pathinfo($mediaUrl, PATHINFO_EXTENSION) }}">
            Your browser does not support the video tag.
        </video>

    @elseif ($mediaType === 'image')

        <img class="rounded-lg" src="{{ $mediaUrl }}" alt="Media Image" style="max-width: 100%; height: auto;">

    @elseif ($mediaType === 'pdf')

        <embed class="rounded-lg" src="{{ $mediaUrl }}" type="application/pdf" width="100%" height="500">

    @else
        <p>Unsupported media type.</p>
    @endif
</div>
