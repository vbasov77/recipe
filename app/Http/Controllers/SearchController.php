<?php

namespace App\Http\Controllers;

use App\Services\RecipeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class SearchController extends Controller
{
    private $recipeService;

    public function __construct()
    {
        $this->recipeService = new RecipeService();
    }

    public function search(Request $request)
    {
        if (!empty(session('search'))) {
            $request->session()->forget('search');
            $request->session()->save();
        }
        $request->session()->put('search', $request->search);
        $request->session()->save();
        $search = $request->input("search");
        if(mb_strlen($search) > 3){
            $search = mb_substr($search, 0, -2);
        }
        // Если ищем везде
        $recipes = $this->recipeService->searchEveryWhereOnRequest($search);

        return view('search.search', ['recipes' => $recipes]);
    }

    public function deleteSession(Request $request)
    {
        $request->session()->forget('search');
        $request->session()->save();
    }
}
