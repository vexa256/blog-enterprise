<?php

namespace App\Handlers\Editor;

class QuizFetcher
{
    public function get_form($type, $args = [])
    {
        $entry = (object)$args;

        if ($type == 'question') {
            return view('editor._forms.quiz.question')->with(compact('entry'))->render();
        } elseif ($type == 'result') {
            return view('editor._forms.quiz.result')->with(compact('entry'))->render();
        }
    }

    public function run($url, $required_type)
    {
        $_result = app(QuizParser::class)->run($url);
        $question_html = null;
        $results_html = null;
        $data = $_result['data'];
        $type = $data['type'];
        $questions = $data['questions'];
        $results   = $data['results'];

        if ($type !== $required_type) {
            return array('status' => 'error', 'title' => trans('updates.error'), 'error' => trans('addpost.quiz_type_not_match', ['type' => $required_type]));
        }

        if (empty($data) || empty($questions)) {
            return array('status' => 'error', 'title' => trans('updates.error'), 'error' => trans('updates.nodata'));
        }

        if ($questions) {
            foreach ($questions as $question) {
                $question_html .= $this->get_form('question', [
                    'uniquid' => $question['id'] ?? '',
                    'title' => $question['heading'],
                    'image' => $question['image'],
                    'video' => $this->parse_answer_format($question['answers_col']),
                    'answers' => collect($question['answers'])->map(function ($answer) use ($type) {
                        return (object)[
                            'title' => $answer['title'],
                            'image' => $answer['image'],
                            'video' => $answer['result'],
                            'answer_type' => $type,
                        ];
                    }),
                ]);
            }
        }


        if ($results) {
            foreach ($results as $result) {
                $results_html .= $this->get_form('result', [
                    'uniquid' => $result['id'],
                    'title' => $result['heading'],
                    'image' => $result['image'],
                    'body' => $result['description'],
                ]);
            }
        }

        return [
            'headline' => $_result['title'],
            'description' => $_result['description'],
            'preview' => $_result['image'],
            'entries' => $question_html,
            'results' => $results_html,
        ];
    }

    public function parse_answer_format($format)
    {
        if ('col-2' === $format) {
            return 2;
        } elseif ('col-3' === $format) {
            return 1;
        }

        return 3;
    }
}
