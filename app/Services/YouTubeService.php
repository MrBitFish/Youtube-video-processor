<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Carbon\CarbonInterval;

class YouTubeService
{
    public function fetchVideo(string $id)
    {
        $response = Http::get(
            'https://www.googleapis.com/youtube/v3/videos', [
                'id' => $id,
                'key' => config('services.youtube.key'),
                'part' => 'snippet,contentDetails,statistics'
            ]
        );

        if (!$response->successful()) {
            return null;
        }

        $json = $response->json();


        if (empty($json['items'])) {
            return null;
        }

        return $this->transform($json['items'][0]);
    }

    private function transform(array $video)
    {
        $snippet  = $video['snippet'];
        $stats    = $video['statistics'];
        $details  = $video['contentDetails'];
        $desc     = $snippet['description'] ?? '';

        $interval = CarbonInterval::fromString($details['duration']);
        $seconds = $interval->totalSeconds;

        $formatted = $seconds >= 3600
            ? gmdate("H:i:s", $seconds)
            : gmdate("i:s", $seconds);

        $views    = (int)($stats['viewCount'] ?? 0);
        $likes    = (int)($stats['likeCount'] ?? 0);
        $comments = (int)($stats['commentCount'] ?? 0);

        $engagement = $views > 0
            ? min(1, ($likes + $comments) / $views)
            : 0;

        return [
            "video_id"        => $video['id'],
            "title"           => $snippet['title'],
            "length_seconds"  => $seconds,
            "length_formatted"=> $formatted,
            "sponsored"       => $this->detectSponsor($desc),
            "engagement_score"=> $engagement,
            "ratio_view_like" => $views > 0 ? $likes / $views : 0,
            "external_links"  => $this->extractLinks($desc),
            "is_shorts"       => $this->isShorts($details, $snippet),
            "average_daily_stats" => $this->dailyStats($stats, $snippet),
            "description_word_length_counts" => $this->wordLengthCounts($desc),
            "description_timestamps" => $this->timestamps($desc),
        ];
    }

    private function detectSponsor(string $desc): bool
    {
        $keywords = [
            'sponsor', 'brought to you by', 'this video is sponsored',
            'thanks to', 'raid shadow legends', 'ad', 'paid partnership', 'paid promotion'
        ];

        $descLower = strtolower($desc);

        foreach ($keywords as $key) {
            if (str_contains($descLower, $key)) {
                return true;
            }
        }

        return false;
    }

    private function extractLinks(string $desc): array
    {
        preg_match_all('/https?:\/\/\S+/i', $desc, $matches);
        return $matches[0] ?? [];
    }

    private function isShorts(array $details, array $snippet): bool
    {
        $title = strtolower($snippet['title'] ?? '');
        $duration = $details['duration'] ?? '';

        if (str_contains($title, '#shorts')) {
            return true;
        }

        if ($duration && CarbonInterval::fromString($duration)->totalSeconds < 60) {
            return true;
        }

        return false;
    }

    private function dailyStats(array $stats, array $snippet): array
    {
        $published = Carbon::parse($snippet['publishedAt']);
        $days = max(1, $published->diffInDays());

        return [
            "views"    => (int)($stats['viewCount'] ?? 0) / $days,
            "likes"    => (int)($stats['likeCount'] ?? 0) / $days,
            "comments" => (int)($stats['commentCount'] ?? 0) / $days,
        ];
    }

    private function wordLengthCounts(string $desc): array
    {
        return collect(preg_split('/\W+/', Str::lower($desc), -1, PREG_SPLIT_NO_EMPTY))
            ->map(fn($w) => strlen($w))
            ->countBy()
            ->sortKeys()
            ->toArray();
    }

    private function timestamps(string $desc): array
    {
        preg_match_all('/(\d{1,2}:\d{2}(?::\d{2})?)\s*(.+)/m', $desc, $m, PREG_SET_ORDER);

        return array_map(function ($match) {
            return [
                'time'  => $match[1],
                'label' => trim($match[2]),
            ];
        }, $m);
    }
}
