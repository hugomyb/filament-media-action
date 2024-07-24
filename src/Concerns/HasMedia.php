<?php

namespace Hugomyb\FilamentMediaAction\Concerns;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;

trait HasMedia
{

    public \Closure|string|null $mediaUrl;

    public string $mediaType;

    public static function getDefaultName(): ?string
    {
        return 'media';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->modal();

        $this->modalSubmitAction(false);

        $this->modalCancelAction(false);

        $this->modalContent(function () {
            return $this->getContentView();
        });
    }

    public function mediaUrl(string|\Closure|null $mediaUrl): static
    {
        $this->mediaUrl = $mediaUrl;

        return $this;
    }

    public function getMediaUrl(): ?string
    {
        return $this->evaluate($this->mediaUrl, [
            'record' => $this->getRecordInstance()
        ]);
    }

    protected function detectMediaType(): string
    {
        return $this->getMediaType($this->getMediaUrl());
    }

    protected function getMediaType(string $url): string
    {
        // Check if the URL is a YouTube link
        if (preg_match('/(youtube\.com|youtu\.be)/', $url)) {
            return 'youtube';
        }

        $pathInfo = pathinfo($url);
        $extension = strtolower($pathInfo['extension'] ?? '');

        $mediaTypes = [
            'audio' => ['mp3', 'wav', 'ogg'],
            'video' => ['mp4', 'avi', 'mov', 'webm'],
            'image' => ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'webp'],
            'pdf' => ['pdf'],
        ];

        foreach ($mediaTypes as $type => $extensions) {
            if (in_array($extension, $extensions)) {
                return $type;
            }
        }

        return 'unknown';
    }

    public function getContentView(): View|Htmlable
    {
        $this->mediaType = $this->detectMediaType();

        return view('filament-media-action::actions.media-modal-content', [
            'mediaType' => $this->mediaType,
            'mediaUrl' => $this->getMediaUrl(),
        ]);
    }

    private function getRecordInstance(): ?Model {
        if(method_exists($this, 'getRecord') && $this->getRecord()) {
            return $this->getRecord() ? $this->getRecord() : null;
        } else {
            return null;
        }
    }
}
