<?php

namespace App\Services;

use App\Jobs\ProcessWriteNews;
use Illuminate\Support\Facades\Config;
use SimplePie\SimplePie;
use TextAnalysis\Tokenizers\WhitespaceTokenizer;
use Vedmant\FeedReader\Facades\FeedReader;

class RssReaderService
{
    private array $urls;

    public function __construct()
    {
        $this->urls = Config::get('rss.urls', []);
    }

    private function readRssFeed(string $url): void
    {
        /** @mixin SimplePie */
        $feed = FeedReader::read($url);

        foreach ($feed->get_items(0, $feed->get_item_quantity()) as $item) {
            $title = $this->cleanedString($item->get_title());
            $description = $this->cleanedString($item->get_description());

            $trigramTitle = $this->tokenizeItem($title);
            $trigramDescription = $this->tokenizeItem($description);

            ProcessWriteNews::dispatch(
                $title,
                $description,
                $item->get_permalink(),
                $trigramTitle,
                $trigramDescription,
            );
        }
    }

    public function getFeed(string $url): void
    {
        /** @mixin SimplePie */
        $feed = FeedReader::read($url);

        foreach ($feed->get_items(0, $feed->get_item_quantity()) as $item) {
            $title = $this->cleanedString($item->get_title());
            $description = $this->cleanedString($item->get_description());
            var_dump($title);
            $trigramTitle = $this->tokenizeItem($title);
            $trigramDescription = $this->tokenizeItem($description);
        }
    }

    private function tokenizeItem(?string $item): array
    {
        if ($item === null) {
            return [];
        }

        $token = tokenize($item, WhitespaceTokenizer::class);

        $normalToken = normalize_tokens($token, 'mb_strtolower');

        return ngrams($normalToken, 3);
    }

    private function cleanedString(?string $string): ?string
    {
        if ($string === null) {
            return null;
        }

        return preg_replace(
            '/<[^>]*>|\s+|📌|📄|📢|👉|\xc2\xa0|[[:punct:]]|[[:cntrl:]]/u',
            ' ',
            trim($string),
        );
    }

    public function run(): void
    {
        foreach ($this->urls as $url) {
            $this->readRssFeed($url);
        }
    }
}
