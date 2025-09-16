<?php

namespace App\Services;

use App\Models\SQ3RSession;
use Illuminate\Support\Str;

class ConceptMapGenerator
{
    private $stopWords = [
        'the', 'and', 'is', 'in', 'to', 'of', 'a', 'an', 'that', 'this', 'it', 'with', 'for', 'on', 'as', 'by', 'at',
        'be', 'or', 'are', 'was', 'were', 'been', 'have', 'has', 'had', 'do', 'does', 'did', 'will', 'would', 'could',
        'should', 'may', 'might', 'must', 'can', 'shall', 'from', 'up', 'out', 'down', 'off', 'over', 'under', 'again',
        'further', 'then', 'once', 'here', 'there', 'when', 'where', 'why', 'how', 'all', 'any', 'both', 'each', 'few',
        'more', 'most', 'other', 'some', 'such', 'no', 'nor', 'not', 'only', 'own', 'same', 'so', 'than', 'too', 'very',
        'just', 'now', 'also', 'about', 'above', 'across', 'after', 'against', 'along', 'among', 'around', 'because',
        'before', 'behind', 'below', 'beneath', 'beside', 'between', 'beyond', 'during', 'except', 'inside', 'instead',
        'into', 'like', 'near', 'since', 'through', 'throughout', 'till', 'toward', 'under', 'until', 'via', 'within'
    ];

    private $importantPos = ['NN', 'NNS', 'NNP', 'NNPS', 'VB', 'VBD', 'VBG', 'VBN', 'VBP', 'VBZ', 'JJ', 'JJR', 'JJS'];

    public function generateFromSQ3R(SQ3RSession $session)
    {
        $text = $this->combineSQ3RText($session);

        if (empty(trim($text))) {
            return $this->getEmptyConceptMap();
        }

        $concepts = $this->extractKeyConcepts($text);
        $nodes = $this->createNodes($concepts);
        $edges = $this->createSemanticEdges($nodes, $text);
        $hierarchicalData = $this->addHierarchy($nodes, $edges, $session);

        return [
            'nodes' => $hierarchicalData['nodes'],
            'edges' => $hierarchicalData['edges'],
            'metadata' => [
                'source' => 'SQ3R Session: ' . $session->module_title,
                'concepts_extracted' => count($concepts),
                'processing_method' => 'enhanced_semantic_analysis',
                'session_id' => $session->id
            ]
        ];
    }

    private function combineSQ3RText(SQ3RSession $session)
    {
        $textParts = [];

        if ($session->survey_notes) $textParts[] = $session->survey_notes;
        if ($session->question_notes) $textParts[] = $session->question_notes;
        if ($session->read_notes) $textParts[] = $session->read_notes;
        if ($session->recite_notes) $textParts[] = $session->recite_notes;
        if ($session->review_notes) $textParts[] = $session->review_notes;

        return implode(' ', $textParts);
    }

    private function extractKeyConcepts($text)
    {
        $cleanedText = $this->preprocessText($text);
        $concepts = $this->extractNounPhrases($cleanedText);
        $scoredConcepts = $this->scoreConcepts($concepts, $text);
        $topConcepts = collect($scoredConcepts)
            ->sortByDesc('score')
            ->take(20)
            ->toArray();

        return $topConcepts;
    }

    private function preprocessText($text)
    {
        $text = preg_replace('/\s+/', ' ', $text);
        $text = preg_replace('/[^\w\s\.\,\!\?\-]/', '', $text);
        $text = strtolower($text);

        return $text;
    }

    private function extractNounPhrases($text)
    {
        $concepts = [];
        $sentences = explode('.', $text);

        foreach ($sentences as $sentence) {
            $sentence = trim($sentence);
            if (empty($sentence)) continue;

            $patterns = [
                '/\bthe\s+([a-z\s]+?)\s+([a-z]+?)\s/is',
                '/\b([a-z]+?)\s+of\s+([a-z]+?)\b/is',
                '/\b([a-z]+?)\s+and\s+([a-z]+?)\b/is',
                '/\b([a-z]+?)\s+in\s+([a-z]+?)\b/is',
            ];

            foreach ($patterns as $pattern) {
                if (preg_match_all($pattern, $sentence, $matches)) {
                    for ($i = 1; $i < count($matches); $i++) {
                        if (!empty($matches[$i][0])) {
                            $concept = trim($matches[$i][0]);
                            if (strlen($concept) > 2 && !in_array($concept, $this->stopWords)) {
                                $concepts[] = $concept;
                            }
                        }
                    }
                }
            }

            $words = str_word_count($sentence, 1);
            foreach ($words as $word) {
                if (strlen($word) > 3 && !in_array($word, $this->stopWords)) {
                    $concepts[] = $word;
                }
            }
        }

        return array_count_values($concepts);
    }

    private function scoreConcepts($concepts, $originalText)
    {
        $scoredConcepts = [];
        $totalWords = str_word_count($originalText);

        foreach ($concepts as $concept => $frequency) {
            $tf = $frequency / $totalWords;
            $lengthBonus = strlen($concept) > 5 ? 1.2 : 1.0;
            $positionBonus = $this->getPositionBonus($concept, $originalText);
            $coherenceScore = $this->getCoherenceScore($concept);

            $score = ($tf * 100) * $lengthBonus * $positionBonus * $coherenceScore;

            $scoredConcepts[] = [
                'concept' => $concept,
                'frequency' => $frequency,
                'score' => $score,
                'tf' => $tf
            ];
        }

        return $scoredConcepts;
    }

    private function getPositionBonus($concept, $text)
    {
        $position = strpos(strtolower($text), strtolower($concept));
        if ($position === false) return 1.0;
        $earlyPositionBonus = 1.0 + (1 - ($position / strlen($text))) * 0.5;

        return $earlyPositionBonus;
    }

    private function getCoherenceScore($concept)
    {
        $words = explode(' ', $concept);
        if (count($words) > 1) {
            return 1.2;
        }

        return 1.0;
    }

    private function createNodes($concepts)
    {
        $nodes = [];
        $colors = ['#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4', '#FFEAA7', '#DDA0DD', '#98D8C8', '#F7DC6F'];

        foreach ($concepts as $index => $conceptData) {
            $concept = $conceptData['concept'];
            $score = $conceptData['score'];

            if ($score > 10) {
                $category = 'main_concept';
                $size = 3;
                $color = $colors[0];
            } elseif ($score > 5) {
                $category = 'sub_concept';
                $size = 2;
                $color = $colors[1];
            } else {
                $category = 'detail';
                $size = 1;
                $color = $colors[2];
            }

            $nodes[] = [
                'id' => Str::slug($concept),
                'type' => 'concept',
                'position' => [
                    'x' => rand(100, 800),
                    'y' => rand(100, 600),
                ],
                'data' => [
                    'label' => ucfirst($concept),
                    'frequency' => $conceptData['frequency'],
                    'score' => $score,
                    'category' => $category,
                    'size' => $size,
                    'color' => $color,
                ],
                'style' => [
                    'background' => $color,
                    'width' => (40 + $size * 20) . 'px',
                    'height' => (40 + $size * 20) . 'px',
                    'fontSize' => (12 + $size * 2) . 'px',
                ]
            ];
        }

        return $nodes;
    }

    private function createSemanticEdges($nodes, $text)
    {
        $edges = [];
        $text = strtolower($text);

        for ($i = 0; $i < count($nodes); $i++) {
            for ($j = $i + 1; $j < count($nodes); $j++) {
                $concept1 = strtolower($nodes[$i]['data']['label']);
                $concept2 = strtolower($nodes[$j]['data']['label']);

                $relationship = $this->findRelationship($concept1, $concept2, $text);

                if ($relationship) {
                    $edges[] = [
                        'id' => "edge-{$nodes[$i]['id']}-{$nodes[$j]['id']}",
                        'source' => $nodes[$i]['id'],
                        'target' => $nodes[$j]['id'],
                        'type' => 'smoothstep',
                        'label' => $relationship,
                        'style' => [
                            'stroke' => '#999',
                            'strokeWidth' => 2,
                        ]
                    ];
                }

                $coOccurrence = $this->checkCoOccurrence($concept1, $concept2, $text);
                if ($coOccurrence > 2 && !$relationship) {
                    $edges[] = [
                        'id' => "edge-{$nodes[$i]['id']}-{$nodes[$j]['id']}-cooccur",
                        'source' => $nodes[$i]['id'],
                        'target' => $nodes[$j]['id'],
                        'type' => 'smoothstep',
                        'label' => 'related',
                        'style' => [
                            'stroke' => '#ccc',
                            'strokeWidth' => 1,
                            'strokeDasharray' => '5,5',
                        ]
                    ];
                }
            }
        }

        return $edges;
    }

    private function findRelationship($concept1, $concept2, $text)
    {
        $patterns = [
            "/$concept1\s+(is|are|was|were)\s+(.{0,20}?)\s+$concept2/" => 'is',
            "/$concept1\s+(has|have|had)\s+(.{0,20}?)\s+$concept2/" => 'has',
            "/$concept1\s+(includes?|contains?|comprises?)\s+(.{0,20}?)\s+$concept2/" => 'includes',
            "/$concept2\s+(of|in|from)\s+(.{0,20}?)\s+$concept1/" => 'part of',
            "/$concept1\s+(causes?|leads?\s+to|results?\s+in)\s+(.{0,20}?)\s+$concept2/" => 'causes',
        ];

        foreach ($patterns as $pattern => $relationship) {
            if (preg_match($pattern, $text)) {
                return $relationship;
            }
        }

        return null;
    }

    private function checkCoOccurrence($word1, $word2, $text)
    {
        $words = str_word_count($text, 1);
        $windowSize = 15;
        $coOccurrenceCount = 0;

        for ($i = 0; $i < count($words) - $windowSize; $i++) {
            $window = array_slice($words, $i, $windowSize);
            $window = array_map('strtolower', $window);

            if (in_array($word1, $window) && in_array($word2, $window)) {
                $coOccurrenceCount++;
            }
        }

        return $coOccurrenceCount;
    }

    private function addHierarchy($nodes, $edges, $session)
    {
        $centralNode = [
            'id' => 'central-' . Str::slug($session->module_title),
            'type' => 'concept',
            'position' => ['x' => 400, 'y' => 300],
            'data' => [
                'label' => $session->module_title,
                'category' => 'central',
                'size' => 5,
                'color' => '#FF4757',
            ],
            'style' => [
                'background' => '#FF4757',
                'width' => '120px',
                'height' => '120px',
                'fontSize' => '16px',
                'fontWeight' => 'bold',
            ]
        ];

        array_unshift($nodes, $centralNode);
        foreach ($nodes as $node) {
            if ($node['data']['category'] === 'main_concept' && $node['id'] !== $centralNode['id']) {
                $edges[] = [
                    'id' => "edge-central-{$node['id']}",
                    'source' => $centralNode['id'],
                    'target' => $node['id'],
                    'type' => 'smoothstep',
                    'label' => 'relates to',
                    'style' => [
                        'stroke' => '#666',
                        'strokeWidth' => 3,
                    ]
                ];
            }
        }

        return [
            'nodes' => $nodes,
            'edges' => $edges
        ];
    }

    private function getEmptyConceptMap()
    {
        return [
            'nodes' => [],
            'edges' => [],
            'metadata' => [
                'source' => 'Empty SQ3R Session',
                'concepts_extracted' => 0,
                'processing_method' => 'enhanced_semantic_analysis'
            ]
        ];
    }
}
