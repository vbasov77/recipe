<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\FileService;
use App\Services\RecipeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


class ImgController extends Controller
{
    private $fileService;
    private $recipeService;

    public function __construct()
    {
        $this->fileService = new FileService();
        $this->recipeService = new RecipeService();
    }

    public function deleteImg(Request $request)
    {
        File::delete(public_path('storage/images/recipe/' . $request->file));// Удалили файл
        $id = (int)$request->id;
        $recipe = $this->recipeService->show($id);
        $elements = json_decode($recipe->elements);
        $count = count($elements);

        for ($i = 0; $i < $count; $i++) {
            if ($elements[$i]->v === $request->file) {
                $elem = $elements[$i]->v = null;
            }
        }
        $this->recipeService->updateElements($id, $elements);

        exit(json_encode($elem));
    }

}