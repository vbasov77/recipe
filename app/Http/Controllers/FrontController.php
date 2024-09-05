<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\RecipeService;
use Illuminate\View\View;


class FrontController extends Controller
{
    private $recipeService;

    /**
     * FrontController constructor.
     *
     */
    public function __construct()
    {
        $this->recipeService = new RecipeService();
    }


    /**
     * @return View
     */
    public function front(): View
    {
        $recipes = $this->recipeService->findAll();
        $count = count($recipes);

        return view('front', ['recipes' => $recipes, 'count' => $count]);
    }
}