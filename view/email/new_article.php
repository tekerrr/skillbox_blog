<?php

$rowText = '<u>Заголовок письма</u>: <i>На сайте добавлена новая запись: “%1$s”</i>
<u>Содержимое письма</u>:
<i>Новая статья: “%1$s”,
    %2$s
    <a href="%5$s%3$s/%4$s">Читать</a>
    -------
     <a href="%5$s/?unsubscribe/%6$s/%7$s/">Отписаться от рассылки</a></i>' . PHP_EOL . PHP_EOL;

$text = sprintf($rowText, $article['title'], $article['abstract'], PATH_ARTICLES, $article['id'], HOST_NAME, $sub['id'], $sub['hash']);


return $text;
