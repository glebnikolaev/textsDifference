<?php

function diff($old, $new)
{
    //составляем матрицу предложений и вычисляем "сдвиги" в ключах
    $matrix = [];
    $maxlen = 0;
    foreach ($old as $oindex => $ovalue) {
        $nkeys = array_keys($new, $ovalue);
        foreach ($nkeys as $nindex) {
            $matrix[$oindex][$nindex] = isset($matrix[$oindex - 1][$nindex - 1]) ?
                    $matrix[$oindex - 1][$nindex - 1] + 1 : 1;
            if ($matrix[$oindex][$nindex] > $maxlen) {
                $maxlen = $matrix[$oindex][$nindex];
                $omax = $oindex + 1 - $maxlen;
                $nmax = $nindex + 1 - $maxlen;
            }
        }
    }
    if ($maxlen == 0) {
        return [
            [
                'deleted' => $old, 
                'inserted' => $new
            ]
        ];
    }
    
    //объеденяем все обратно в массив и возвращаем его 
    return array_merge(
            diff(
                array_slice($old, 0, $omax), 
                array_slice($new, 0, $nmax)
            ), 
            array_slice($new, $nmax, $maxlen), 
            diff(
                array_slice($old, $omax + $maxlen), 
                array_slice($new, $nmax + $maxlen)
            )
            
        );
}

function mainDiff($article_one, $article_two)
{
    //регулярное выражение для наиболее классической конструкции предложения
    $sentence_regexp = "/(?<=[A-Za-z]{2}[.?!])\s+(?=[A-Z][a-z]+)/s";
    $article = '';
    //вызываем функцию сравнения, получаем массив с предложениями
    $diff = diff(preg_split($sentence_regexp, $article_one), preg_split($sentence_regexp, $article_two));
    foreach ($diff as $k) {
        if (is_array($k)) {
            $article .= changesDrawing($k);
        } else {
            $article .= $k . ' ';
        }
    }
    //Заменяем переносы строк на <br>
    $result = str_replace(array("\r\n", "\r", "\n"), '<br>', $article);
    return $result;
}

//Расскрашиваем изменения в зависимости от измененности предложения
function changesDrawing($k)
{
    //Создаем уникальный идентификатор изменения
    $id = substr(md5(uniqid(rand(),1)), 0, 6);
    //Исправленное предложение 
    //!!! Если в след за исправленным предложением идет удаленное или добавленное, 
    //то они объеденятся в один блок!!! Удобно если помечать не предложения а слова.
    if(!empty($k['deleted']) && !empty($k['inserted'])) {
        $sentence = '<span class="replaced badge-info" id="r-'.$id.'" data-id="'.$id.'">' . implode(' ', $k['deleted']) . '</span> ';
        $sentence .= '<span class="new badge-warning" id="n-'.$id.'" data-id="'.$id.'">' . implode(' ', $k['inserted']) . '</span> ';
    }
    //Удаленное предложение
    elseif(!empty($k['deleted']) && empty($k['inserted'])) {
        $sentence = '<span class="badge-danger" id="'.$id.'">' . implode(' ', $k['deleted']) . '</span> ';
    }
    //Добавленное предложение
    elseif(empty($k['deleted']) && !empty($k['inserted'])) {
        $sentence = '<span class="badge-success" id="'.$id.'">' . implode(' ', $k['inserted']) . '</span> ';
    }
    return $sentence;

}
