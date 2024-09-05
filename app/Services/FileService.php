<?php


namespace App\Services;


class FileService extends Service
{
    public function addFile(object $file): string
    {
        $code = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';// Случайные символы
        $codeTheme = substr(str_shuffle($code), 0, 16);// Сгенерировали случайное имя для файлов
        $guessExtensionImage = $file->guessExtension();// получили расширение фото
        $fileName = $codeTheme . '.' . $guessExtensionImage;
        //Записываем файлы
        $file->storeAs('images/recipe', $fileName, 'public');

        return $fileName;
    }

}