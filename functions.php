<?php

function validateInputData($data)
{
    $validatedData = [];
    $validatedData['email'] = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
    $validatedData['name'] = filter_var($data['name'], FILTER_SANITIZE_STRING);
    $validatedData['text'] = filter_var($data['text'], FILTER_SANITIZE_STRING);
    return $validatedData;
}

function saveDataToDataSource($data)
{
    $jsonString = json_encode($data);
    $fileStream = fopen('comments.csv', 'a');
    fwrite($fileStream, $jsonString . "\n");
    fclose($fileStream);
}

function getGuestBookComments()
{
    $comments = [];
    if (file_exists('comments.csv')) {
        $fileStream = fopen('comments.csv', 'r');
        while (!feof($fileStream)) {
            $jsonString = fgets($fileStream);
            $comment = json_decode($jsonString, true);
            if (empty($comment)) break;
            $comments[] = $comment;
        }
        fclose($fileStream);
    }
    return $comments;
}