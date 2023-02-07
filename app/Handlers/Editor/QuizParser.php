<?php

namespace App\Handlers\Editor;

use DOMDocument;
use GuzzleHttp\Client;

/**
 * Used for retrieving social data from social sites and caching them
 */
class QuizParser
{
    private function fetchPage($endpoint)
    {
        try {
            $client = new Client;
            $response = $client->get(
                $endpoint,
                [
                    'headers' => [
                        "Accept-Encoding" => "application/html",
                        "Content-Type"    => "application/html",
                        "cache-control"   => "no-cache",
                    ],
                    'timeout' => 30,
                ]
            );

            return (200 == $response->getStatusCode()) ? (string) $response->getBody()->getContents() : false;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function run($url)
    {
        $html = $this->fetchPage($url);

        $result = array(
            'title' => '',
            'description' => '',
            'id' => '',
            'image' => '',
            'data' => [],
        );
        if (class_exists('DOMDocument') && $html) {
            $prev = libxml_use_internal_errors(true);
            $doc  = new DOMDocument();

            $doc->loadHTML($html);
            libxml_use_internal_errors($prev);

            $metas = $doc->getElementsByTagName('meta');

            for ($i = 0; $i < $metas->length; $i++) {

                $meta = $metas->item($i);

                if ($meta->getAttribute('name') === 'title') {
                    $result['title'] = $meta->getAttribute('content');
                }

                if ($meta->getAttribute('name') === 'description') {
                    $result['description'] = $meta->getAttribute('content');
                }

                if ($meta->getAttribute('property') === 'bf:buzzid') {
                    $result['id'] = $meta->getAttribute('content');
                }

                if ($meta->getAttribute('property') === 'og:image') {
                    $result['image'] = $this->parse_image($meta->getAttribute('content'));
                }
            }

            $metas = $doc->getElementsByTagName('script');
            for ($i = 0; $i < $metas->length; $i++) {
                $meta = $metas->item($i);
                if ($meta->getAttribute('type') === 'text/x-config') {
                    if (strpos($meta->nodeValue, '"questions"') !== -1) {
                        $data             = json_decode($meta->nodeValue, true);
                        $result['data'] = $this->parse_data($data);
                        break;
                    }
                }
            }
        }

        return $result;
    }

    public function parse_data($result)
    {
        $data = array(
            'type'        => '',
            'id'        => '',
            'questions' => array(),
            'results'   => array(),
        );

        if (isset($result['subbuzz'])) {
            $_data = $result['subbuzz'];

            $type         = $this->parse_type($_data);
            $data['type'] = $type;
            $data['id']   = $_data['id'];

            if ('poll' !== $type) {
                foreach ($_data['results'] as $__result) {
                    $_result = array(
                        'id'              => $__result['id'],
                        'heading'         => isset($__result['header']) ? $this->parse_title($__result['header']) : null,
                        'image_text'      => isset($__result['image_text']) ? $this->parse_title($__result['image_text']) : null,
                        'description'     => isset($__result['description']) ? $this->parse_description($__result['description']) : null,
                        'image'           => $this->parse_image($__result['image']),
                        'image_height'    => isset($__result['image_height']) ? $this->parse_image_height($__result['image_width'], $__result['image_height']) : null,
                        'image_text_size' => isset($__result['tile_metadata']['tileStyles']['fontSize']) ? $__result['tile_metadata']['tileStyles']['fontSize'] : null,
                    );

                    if ('trivia' === $type || 'checklist' === $type) {
                        $_result = array_merge(
                            $_result,
                            array(
                                'rangeMin' => $__result['range_start'],
                                'rangeMax' => $__result['range_end'],
                            )
                        );
                    }

                    $data['results'][] = $_result;
                }
            }

            if ('checklist' === $type) {
                $data['metadata'] = $_data['metadata'];
            }

            foreach ($_data['questions'] as $question) {
                $answers = array();
                foreach ($question['answers'] as $answer) {
                    $_answer = array(
                        'id'    => $answer['id'],
                        'title' => $this->parse_title($answer['header']),
                        'image' => $this->parse_image($answer['image'], 'answer'),
                    );
                    if ('personality' === $type) {
                        $_answer = array_merge(
                            $_answer,
                            array(
                                'result' => $data['results'][$answer['personality_index']]['id'],
                            )
                        );
                    } elseif ('trivia' === $type) {
                        $_answer = array_merge(
                            $_answer,
                            array(
                                'result' => '0' != $answer['correct'] ? 'on' : null,
                            )
                        );
                    }

                    $answers[] = $_answer;
                };

                $data['questions'][$question['id']] = array(
                    'id'              => $question['id'],
                    'heading'         => isset($question['header']) ? $this->parse_title($question['header']) : null,
                    'image_text'      => isset($question['image_text']) ? $this->parse_title($question['image_text']) : null,
                    'image_text_size' => isset($question['tile_metadata']['tileStyles']['fontSize']) ? $question['tile_metadata']['tileStyles']['fontSize'] : null,
                    'image'           => $this->parse_image($question['image']),
                    'image_height'    => isset($question['image_height']) ? $this->parse_image_height($question['image_width'], $question['image_height']) : null,
                    'answers_col'     => $this->parse_answer_format($question['format']),
                    'answers'         => $answers,
                );
            }
        } elseif (isset($result['data']['content'])) {
            $_data = $result['data']['content'];

            $type         = $this->parse_type($_data);
            $data['type'] = $type;
            $data['id']   =  isset($result['context']['subbuzzId']) ? $result['context']['subbuzzId'] :  $result['id'];

            foreach ($_data['results'] as $__result) {
                $r_id = isset($__result['id']) ? $__result['id'] : uniqid();
                $_result = array(
                    'id'              =>  $r_id,
                    'heading'         => null,
                    'image_text'      => isset($__result['title']) ? $this->parse_description($__result['title']) : null,
                    'description'     => isset($__result['description']) ? $this->parse_description($__result['description']) : null,
                    'image'           => isset($__result['image']['src']) ? $this->parse_image($__result['image']['src']) : null,
                    'image_height'    => isset($__result['image']['meta']['height']) ? $this->parse_image_height($__result['image']['meta']['width'], $__result['image']['meta']['height']) : null,
                    'image_text_size' => null,
                );

                $data['results'][$r_id] = $_result;
            }

            foreach ($_data['questions'] as $question) {
                $answers   = array();
                $has_image = false;
                foreach ($question['answers'] as $answer) {
                    $answers[] = array(
                        'id'     => $answer['pid'],
                        'title'  => $this->parse_title($answer['text']),
                        'image'  => isset($answer['image']['src']) ? $this->parse_image($answer['image']['src'], 'answer') : null,
                        'result' => $answer['resultId'],
                    );
                    if (!$has_image && isset($answer['image']['src'])) {
                        $has_image = true;
                    }
                };

                $data['questions'][$question['pid']] = array(
                    'id'              => $question['pid'],
                    'heading'         => isset($question['title']) ? $this->parse_title($question['title']) : null,
                    'image_text'      => isset($question['title']) ? $this->parse_title($question['title']) : null,
                    'image_text_size' => null,
                    'image'           => isset($question['image']['src']) ? $this->parse_image($question['image']['src']) : null,
                    'image_height'    => isset($question['image']['meta']['height']) ? $this->parse_image_height($question['image']['meta']['width'], $question['image']['meta']['height']) : null,
                    'answers_col'     => $has_image ? 'col-2' : 'text',
                    'answers'         => $answers,
                );
            }
        } elseif (isset($result['data'])) {
            $_data = $result['data'];

            $type         = $this->parse_type($_data);
            $data['type'] = $type;
            $data['id']   = isset($node_data['context']['subbuzzId']) ? $node_data['context']['subbuzzId'] : uniqid();

            foreach ($_data['results'] as $__result) {
                $r_id = isset($__result['id']) ? $__result['id'] : uniqid();
                $result_media = isset($__result['tile_metadata']['tile_styles']['media']) ? $__result['tile_metadata']['tile_styles']['media'] : (isset($__result['media']) ? $__result['media'] : null);

                $_result = array(
                    'id'              =>  $r_id,
                    'heading'         => isset($__result['title']) ? $this->parse_title($__result['title']) : null,
                    'image_text'      => isset($__result['title']) ? $this->parse_description($__result['title']) : null,
                    'description'     => isset($__result['description']) ? $this->parse_description($__result['description']) : null,
                    'image'           => isset($result_media['url']) ? $this->parse_image($result_media['url']) : null,
                    'image_height'    => isset($result_media['meta']['height']) ? $this->parse_image_height($result_media['meta']['width'], $result_media['meta']['height']) : null,
                    'image_text_size' => null,
                );

                $data['results'][$r_id] = $_result;
            }

            foreach ($_data['questions'] as $question) {
                $answers   = array();
                $has_image = true;
                foreach ($question['answers'] as $answer) {
                    $answer_media = isset($answer['tile_metadata']['tile_styles']['media']) ? $answer['tile_metadata']['tile_styles']['media'] : (isset($answer['media']) ? $answer['media'] : null);
                    $_answer = array(
                        'id'    => isset($answer['id']) ? $answer['id'] : uniqid(),
                        'title' => $this->parse_title($answer['text']),
                        'image'  => isset($answer_media['url']) ? $this->parse_image($answer_media['url'], 'answer') : null,
                    );

                    if ('personality' === $type) {
                        $_answer = array_merge(
                            $_answer,
                            array(
                                'result' => $data['results'][reset($answer['result_ids'])]['id'],
                            )
                        );
                    } elseif ('trivia' === $type) {
                        $_answer = array_merge(
                            $_answer,
                            array(
                                'result' => $answer['correct'] ? 'on' : null,
                            )
                        );
                    }
                    $answers[] = $_answer;
                    if (!$has_image && !empty($_answer['image'])) {
                        $has_image = true;
                    }
                };

                $q_id = isset($question['id']) ? $question['id'] : uniqid();
                $question_media = isset($question['tile_metadata']['tile_styles']['media']) ? $question['tile_metadata']['tile_styles']['media'] : (isset($question['media']) ? $question['media'] : null);

                $data['questions'][$q_id] = array(
                    'id'              => $q_id,
                    'heading'         => isset($question['title']) ? $this->parse_title($question['title']) : null,
                    'image_text'      => isset($question['title']) ? $this->parse_title($question['title']) : null,
                    'image_text_size' => null,
                    'image'           => isset($question_media['url']) ? $this->parse_image($question_media['url']) : null,
                    'image_height'    => isset($question_media['meta']['height']) ? $this->parse_image_height($question_media['meta']['width'], $question_media['meta']['height']) : null,
                    'answers_col' => isset($question['format']) ? $this->parse_answer_format($question['format']) : ($has_image ? 'col-2' : 'text'),
                    'answers'         => $answers,
                );
            }
        }

        return $data;
    }

    public function parse_title($title)
    {
        return str_replace(
            array(
                '"',
            ),
            array(
                "'",
            ),
            strip_tags($title)
        );
    }

    public function parse_description($description)
    {
        return strip_tags($description);
    }

    public function parse_image_height($width, $height)
    {
        return $width > 900 ? intval($height) / 1.4 : $height;
    }

    public function parse_type($_data)
    {
        $type = isset($_data['formatName']) ? $_data['formatName'] : null;
        if (empty($type)) {
            $type = isset($_data['type']) ? $_data['type'] : 'personality';
        }

        if ('standard' === $type) {
            return 'trivia';
        }

        return $type;
    }


    public function parse_image($image, $type = '')
    {
        if (strpos($image, 'unsplash') !== false) {
            if ($type == 'answer') {
                return $image . '&fit=crop&w=500&h=500&q=80';
            }
            return $image . '&fit=crop&w=1400&q=80';
        }

        $img = explode('?crop=', $image);

        return $img[0];
    }

    public function parse_answer_format($format)
    {
        if ('2-UP' === $format) {
            return 'col-2';
        } elseif ('3-UP' === $format) {
            return 'col-3';
        }

        return 'text';
    }
}
