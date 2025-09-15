<?php

namespace App\Services;

use App\Models\SQ3RSession;
use Illuminate\Support\Str;

class ConceptMapGenerator
{
    public function generateFromSQ3R(SQ3RSession $session)
    {
        $text = $session->review_notes . ' ' . $session->read_notes;

        // Simple keyword extraction (TF-based)
        $keywords = $this->extractKeywords($text);

        // Create nodes from top keywords
        $nodes = $this->createNodes($keywords);

        // Create edges based on co-occurrence
        $edges = $this->createEdges($nodes, $text);

        return [
            'nodes' => $nodes,
            'edges' => $edges,
        ];
    }

    private function extractKeywords($text, $limit = 15)
    {
        // Remove common stop words
        $stopWords = ['the', 'and', 'is', 'in', 'to', 'of', 'a', 'an', 'that', 'this', 'it', 'with', 'for', 'on', 'as', 'by', 'at'];

        // Tokenize and count frequencies
        $words = str_word_count(strtolower($text), 1);
        $words = array_diff($words, $stopWords);
        $frequencies = array_count_values($words);

        // Sort by frequency descending
        arsort($frequencies);

        // Return top keywords
        return array_slice($frequencies, 0, $limit, true);
    }

    private function createNodes($keywords)
    {
        $nodes = [];
        $position = 0;

        foreach ($keywords as $word => $frequency) {
            $nodes[] = [
                'id' => Str::slug($word),
                'type' => 'concept',
                'position' => [
                    'x' => rand(100, 800),
                    'y' => rand(100, 600),
                ],
                'data' => [
                    'label' => ucfirst($word),
                    'frequency' => $frequency,
                ],
            ];
            $position++;
        }

        return $nodes;
    }

    private function createEdges($nodes, $text)
    {
        $edges = [];
        $text = strtolower($text);

        for ($i = 0; $i < count($nodes); $i++) {
            for ($j = $i + 1; $j < count($nodes); $j++) {
                $word1 = $nodes[$i]['data']['label'];
                $word2 = $nodes[$j]['data']['label'];

                // Check if words appear together in sentences
                $coOccurrence = $this->checkCoOccurrence($word1, $word2, $text);

                if ($coOccurrence > 0) {
                    $edges[] = [
                        'id' => "edge-{$word1}-{$word2}",
                        'source' => $nodes[$i]['id'],
                        'target' => $nodes[$j]['id'],
                        'label' => 'related',
                        'strength' => $coOccurrence,
                    ];
                }
            }
        }

        return $edges;
    }

    private function checkCoOccurrence($word1, $word2, $text)
    {
        // Simple co-occurrence check within a window of words
        $words = str_word_count($text, 1);
        $windowSize = 10;
        $coOccurrenceCount = 0;

        for ($i = 0; $i < count($words) - $windowSize; $i++) {
            $window = array_slice($words, $i, $windowSize);

            if (in_array($word1, $window) && in_array($word2, $window)) {
                $coOccurrenceCount++;
            }
        }

        return $coOccurrenceCount;
    }
}
