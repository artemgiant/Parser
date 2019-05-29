<?php
header('Content-type: text/html; charset=utf-8');
require 'phpQuery.php';
require_once 'Parser.php';
function debug($arr)
{
    echo '<pre>' . print_r($arr, true) . '</pre>';
}

pag(1, 2);
function pag($start = 0, $end=0, $url = 'http://amdy.su/page/2/')
{

    $doc = parser($url, true);

    $content = $doc->find("[id*=post-");
    $linds = [];
    phpQuery::each($content, function ($index, $value) {
        $post = $value;
        $url_post = pq($value)->find('span.read-more > a')->attr('href');
        $doc = parser($url_post, true);
        $content_post = $doc->find('div.entry-content');
        pq($post)->find('div.entry-summary')->html($content_post);
        echo pq($post);
        echo "<hr>";
    });


    $next = $doc->find('.navigation span.current')->next()->attr('href');
    if (isset($next) && ($start < $end)) {
        debug($next);
        ++$start;

        pag($start, 2, $next);
    }

}

function parser($url, $print)
{
    debug($url);
    $parser = new Parser($url, true);
    $file = $parser->set(CURLOPT_FOLLOWLOCATION, true)->set(CURLOPT_RETURNTRANSFER, true)
        ->exec($url);
    $doc = phpQuery::newDocument($file);
    return $doc;
}

