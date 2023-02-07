<?php

namespace App\Handlers\Editor;

use GuzzleHttp\Client;

class ContentFetcher
{
    public function run($url)
    {
        $client = new Client;
        $response = $client->get(
            $url,
            [
                'timeout' => 30,
                'allow_redirects' => true
            ]
        );

        if (200 !== $response->getStatusCode()) {
            return array('status' => 'error', 'title' => trans('updates.error'), 'error' => trans('updates.nodata'));
        }

        $html = (string) $response->getBody()->getContents();

        if (!$html || empty($html)) {
            return array('status' => 'error', 'title' => trans('updates.error'), 'error' => trans('updates.nodata'));
        }

        $tags = $this->getMetaTags($html);

        if (empty($tags)) {
            return array('status' => 'error', 'title' => trans('updates.error'), 'error' => trans('updates.nodata'));
        }

        preg_match_all('#<article(.*)>(.*)</article>#isU', $html, $matches_article);

        if (count($matches_article[0]) > 0) {
            $article = '';
            foreach ($matches_article[0] as $value) {
                $article .= $value;
            }
            $html = $article;
        }

        preg_match_all('#<p(.*)>(.*)</p>#isU', $html, $matches);
        $body = "";
        foreach ($matches[0] as $value) {
            $body .= $value;
        }

        $data = [];
        $title = "";
        $image = "";
        $description = "";

        if (isset($tags['title'])) {
            $title = $tags['title'];
        } elseif (isset($tags['og:title'])) {
            $title = $tags['og:title'];
        } elseif (isset($tags['twitter:title'])) {
            $title = $tags['twitter:title'];
        } elseif (isset($tags['article:title'])) {
            $title = $tags['article:title'];
        }

        if (isset($tags['og:image'])) {
            $image = $tags['og:image'];
        } elseif (isset($tags['twitter:image'])) {
            $image = $tags['twitter:image'];
        } elseif (isset($tags['article:image'])) {
            $image = $tags['article:image'];
        } elseif (isset($tags['image'])) {
            $image = $tags['image'];
        }

        if (isset($tags['og:description'])) {
            $description = $tags['og:description'];
        } elseif (isset($tags['description'])) {
            $description = $tags['description'];
        } elseif (isset($tags['article:description'])) {
            $description = $tags['article:description'];
        }

        if (isset($tags['news_keywords'])) {
            $tags = $tags['news_keywords'];
        } elseif (isset($tags['keywords'])) {
            $tags = $tags['keywords'];
        }

        $data['headline'] = $this->sanitize_text($title);
        $data['description'] = $this->sanitize_text($description);
        $data['tags'] = $this->sanitize_text($tags);
        $data['tags'] = str_replace(', ', ',',  $data['tags']);
        $data['preview'] = $image;

        $allowed_tags = array(
            "<a>", "<b>", "<strong>", "<br>", "<img>", "<hr>", "<i>",
            "<h2>", "<h3>", "<h4>", "<h5>", "<h6>",
            "<ul>", "<li>", "<ol>", "<p>", "<s>", "<u>",
            "<code>", "<abbr>", "<dfn>", "<q>", "<cite>", "<s>", "<small>",
            "<em>", "<figcaption>", "<figure>", "<dd>", "<dt>",
            "<dl>",  "<blockquote>", "<pre>", "<address>",
            "<table>", "<th>", "<td>", "<tr>", "<tfoot>", "<thead>", "<tbody>",
        );

        if (class_exists('DOMDocument')) {
            foreach ($allowed_tags as $key => $tag) {
                $allowed_tags[$key] = str_replace(array('<', '>'), array('', ''), $tag);
            }
            $allowed_attr = array(
                'href',
                'src',
                'data-src',
                'width',
                'height',
                'alt',
                'title',
                '_target',
            );
            $body = str_replace('data-src', 'src', $body);
            $data['content'] = is_string($body) ? $this->getContent($body, $allowed_tags, $allowed_attr) : '';
        } else {
            $data['content'] = is_string($body) ? strip_tags($body, $allowed_tags) : '';
        }

        $entry = new \stdClass();
        $entry->title = $title;
        $entry->body = clean($data['content']);

        $data['entries'] = view('editor._forms.text')->with(compact('entry'))->render();

        return $data;
    }

    public function getMetaTags($str)
    {
        $pattern = '
      ~<\s*meta\s

      # using lookahead to capture type to $1
        (?=[^>]*?
        \b(?:name|property|http-equiv)\s*=\s*
        (?|"\s*([^"]*?)\s*"|\'\s*([^\']*?)\s*\'|
        ([^"\'>]*?)(?=\s*/?\s*>|\s\w+\s*=))
      )

      # capture content to $2
      [^>]*?\bcontent\s*=\s*
        (?|"\s*([^"]*?)\s*"|\'\s*([^\']*?)\s*\'|
        ([^"\'>]*?)(?=\s*/?\s*>|\s\w+\s*=))
      [^>]*>

      ~ix';

        if (preg_match_all($pattern, $str, $out))
            return array_combine($out[1], $out[2]);
        return array();
    }

    public function getContent($html, $safeTags = array(), $safeAttributes = array(), $urlAttributes = array())
    {
        if (empty($html)) {
            return $html;
        }

        $prev = libxml_use_internal_errors(true);
        $dom  = new \DOMDocument();

        $dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
        libxml_use_internal_errors($prev);

        // remove blacklisted tags first
        foreach (['script', 'style', 'head', 'header', 'footer', 'iframe', 'noscript'] as $tag) {
            foreach ($dom->getElementsByTagName($tag) as $node) {
                while ($node->hasChildNodes()) {
                    $node->removeChild($node->firstChild);
                }
            }
        }

        # Loop through all of the nodes:
        $stack = new \SplStack();
        $stack->push($dom->documentElement);

        while ($stack->count() > 0) {
            # Get the next element for processing:
            $element = $stack->pop();

            # Add all the element's child nodes to the stack:
            foreach ($element->childNodes as $child) {
                if ($child instanceof \DOMElement) {
                    $stack->push($child);
                }
            }

            # And now, we do the filtering:
            if (!in_array(strtolower($element->nodeName), $safeTags)) {
                # It's not a safe tag; unwrap it:
                while ($element->hasChildNodes()) {
                    $element->parentNode->insertBefore($element->firstChild, $element);
                }

                # Finally, delete the offending element:
                $element->parentNode->removeChild($element);
            } else {
                # The tag is safe; now filter its attributes:
                for ($i = 0; $i < $element->attributes->length; $i++) {
                    $attribute = $element->attributes->item($i);
                    $name = strtolower($attribute->name);

                    if (!in_array($name, $safeAttributes) || (in_array($name, $urlAttributes) && substr($attribute->value, 0, 7) !== 'http://')) {
                        # Found an unsafe attribute; remove it:
                        $element->removeAttribute($attribute->name);
                        $i--;
                    }
                }
            }
        }

        # Finally, return the safe HTML, minus the DOCTYPE, <html> and <body>:
        $html  = $dom->saveHTML();

        return $html;
    }

    public function sanitize_text($string)
    {
        if (!is_string($string)) {
            return '';
        }

        $string = htmlspecialchars_decode(strip_tags($string), ENT_QUOTES);

        return clean($string, 'titles');
    }
}
