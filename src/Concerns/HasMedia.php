<?php

namespace Hugomyb\FilamentMediaAction\Concerns;

use Closure;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;

trait HasMedia
{
    public \Closure | string | null $media;

    public ?string $mediaType;

    public ?string $mime = 'unknown';

    protected bool | Closure $hasAutoplay = false;

    protected array | Closure $mediaControlsList = [];

    public ?bool $preloadAuto = true;

    public static function getDefaultName(): ?string
    {
        return 'media';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->modalSubmitAction(false);

        $this->modalCancelAction(false);

        $this->modalContent(function () {
            return $this->getContentView();
        });
    }

    public function media(string|\Closure|null $url): static
    {
        $this->media = $url;

        return $this;
    }

    public function getMedia(): ?string
    {
        return $this->evaluate($this->media, [
            ...$this->resolveDefaultClosureDependencyForEvaluationByName('record'),
            ...$this->resolveDefaultClosureDependencyForEvaluationByName('model'),
            ...$this->resolveDefaultClosureDependencyForEvaluationByName('arguments'),
            ...$this->resolveDefaultClosureDependencyForEvaluationByName('data'),
            ...$this->resolveDefaultClosureDependencyForEvaluationByName('livewire'),
        ]);
    }

    public function autoplay(bool|\Closure $hasAutoplay = true): static
    {
        $this->hasAutoplay = $hasAutoplay;

        return $this;
    }

    public function hasAutoplay(): bool
    {
        return (bool) $this->evaluate($this->hasAutoplay, [
            ...$this->resolveDefaultClosureDependencyForEvaluationByName('record'),
            'mediaType' => $this->mediaType,
        ]);
    }

    public function controlsList(array|Closure $list): static
    {
        $this->mediaControlsList = $list;

        return $this;
    }

    public function disableDownload(bool|Closure $when = true): static
    {
        return $this->addMediaControlToken('nodownload', $when);
    }

    public function disableFullscreen(bool|Closure $when = true): static
    {
        return $this->addMediaControlToken('nofullscreen', $when);
    }

    public function disableRemotePlayback(bool|Closure $when = true): static
    {
        return $this->addMediaControlToken('noremoteplayback', $when);
    }

    protected function addMediaControlToken(string $token, bool|Closure $when): static
    {
        if ($this->evaluate($when, [
            ...$this->resolveDefaultClosureDependencyForEvaluationByName('record'),
            ...$this->resolveDefaultClosureDependencyForEvaluationByName('model'),
            ...$this->resolveDefaultClosureDependencyForEvaluationByName('arguments'),
            ...$this->resolveDefaultClosureDependencyForEvaluationByName('data'),
            ...$this->resolveDefaultClosureDependencyForEvaluationByName('livewire'),
        ])) {
            $current = (array) $this->evaluate($this->mediaControlsList, [
                ...$this->resolveDefaultClosureDependencyForEvaluationByName('record'),
                ...$this->resolveDefaultClosureDependencyForEvaluationByName('model'),
                ...$this->resolveDefaultClosureDependencyForEvaluationByName('arguments'),
                ...$this->resolveDefaultClosureDependencyForEvaluationByName('data'),
                ...$this->resolveDefaultClosureDependencyForEvaluationByName('livewire'),
            ]);

            if (in_array($token, $current, true) === false) {
                $current[] = $token;
                $this->mediaControlsList = $current;
            }
        }

        return $this;
    }

    protected function getMediaControlsList(): ?string
    {
        $list = (array) $this->evaluate($this->mediaControlsList, [
            ...$this->resolveDefaultClosureDependencyForEvaluationByName('record'),
            ...$this->resolveDefaultClosureDependencyForEvaluationByName('model'),
            ...$this->resolveDefaultClosureDependencyForEvaluationByName('arguments'),
            ...$this->resolveDefaultClosureDependencyForEvaluationByName('data'),
            ...$this->resolveDefaultClosureDependencyForEvaluationByName('livewire'),
        ]);

        return filled($list) ? implode(' ', $list) : null;
    }

    protected function detectMediaType(): string
    {
        return $this->getMediaType($this->getMedia());
    }

    protected function getMediaType(?string $url): ?string
    {
        // Check if the URL is a YouTube link
        if (preg_match('/(youtube\.com|youtu\.be)/', $url)) {
            return 'youtube';
        }

        // Parse the URL to remove query parameters
        $parsedUrl = parse_url($url, PHP_URL_PATH);

        // Handle cases where the URL path ends with a slash (no file)
        if (str_ends_with($parsedUrl, '/')) {
            $parsedUrl = rtrim($parsedUrl, '/');
        }

        // Get path info from the parsed URL
        $pathInfo = pathinfo($parsedUrl);
        $extension = strtolower($pathInfo['extension'] ?? '');

        // Define media types and their extensions
        $mediaTypes = [
            'audio' => ['mp3', 'wav', 'ogg', 'aac'],
            'video' => ['mp4', 'avi', 'mov', 'webm'],
            'image' => ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'webp'],
            'pdf' => ['pdf'],
        ];

        // Check if the extension matches any media type
        foreach ($mediaTypes as $type => $extensions) {
            if (in_array($extension, $extensions)) {
                $this->mime = "$type/$extension"; // Set the MIME type
                return $type;
            }
        }

        // If the extension is not found, use HTTP headers to detect the content type
        $headers = @get_headers($url, 1);

        if (is_array($headers)) {
            $headers = array_change_key_case($headers, CASE_LOWER);

            $rawType = $headers['content-type'] ?? null;
            $contentType = is_array($rawType) ? reset($rawType) : $rawType;

            if ($contentType) {
                $type = match (true) {
                    str_contains($contentType, 'audio') => 'audio',
                    str_contains($contentType, 'video') => 'video',
                    str_contains($contentType, 'image') => 'image',
                    str_contains($contentType, 'pdf') => 'pdf',
                    default => null,
                };

                if ($type !== null) {
                    $this->mime = $contentType;

                    return $type;
                }
            }
        }

        $this->mime = 'unknown';
        return 'unknown';
    }

    public function preload(?bool $preloadAuto=true): static
    {
        $this->preloadAuto = $preloadAuto;

        return $this;
    }

    public function getContentView(): View|Htmlable
    {
        $this->mediaType = $this->detectMediaType();

        return view('filament-media-action::actions.media-modal-content', [
            'mediaType' => $this->mediaType,
            'media' => $this->getMedia(),
            'mime' => $this->mime,
            'autoplay' => $this->hasAutoplay(),
            'preload' => $this->preloadAuto,
            'controlsList' => $this->getMediaControlsList(),
        ]);
    }
}
