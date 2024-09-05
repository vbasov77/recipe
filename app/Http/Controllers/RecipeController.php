<?php

namespace App\Http\Controllers;

use App\Services\CommentService;
use App\Services\FileService;
use App\Services\RecipeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class RecipeController extends Controller
{
    private $recipeService;
    private $fileService;
    private $commentService;

    /**
     * RecipeController constructor.
     */
    public function __construct()
    {
        $this->recipeService = new RecipeService();
        $this->fileService = new FileService();
        $this->commentService = new CommentService();
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): View
    {
        return view('recipe.create');
    }


    public function store(Request $request)
    {
        $text = $request->input('text') ?: [];
        $inputImg = $request->input('img') ?: [];
        $img = $request->file('img') ?: [];
        $newArray = $this->recipeService->getElementsArray($text, $img, $inputImg);
        $id = $this->recipeService->store($request, $newArray);

        return redirect()->action([RecipeController::class, 'show'], ['id' => $id]);
    }

    /**
     * @param Request $request
     * @return View
     */
    public function show(Request $request): View
    {
        $recipe = $this->recipeService->show($request->id);
        $elements = json_decode($recipe->elements);
        $comments = $this->commentService->findAllById($request->id);

        return view('recipe.show', ['recipe' => $recipe, 'elements' => $elements, 'comments' => $comments]);
    }

    /**
     * @param Request $request
     * @return View
     */
    public function edit(Request $request): View
    {

        $recipe = $this->recipeService->show($request->id);
        $elements = json_decode($recipe->elements);
        $count = count($elements);
        return view('recipe.edit', ['recipe' => $recipe, 'elements' => $elements, 'count' => $count]);
    }


    public function update(Request $request)
    {
        $text = $request->input('text') ?: [];
        $inputImg = $request->input('img') ?: [];
        $img = $request->file('img') ?: [];

        $elements = $this->recipeService->getElementsArray($text, $img, $inputImg);
        $this->recipeService->update($request, $elements);

        return redirect()->route('recipe', ['id' => $request->input('id')]);
    }


    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(Request $request): RedirectResponse
    {
        try {
            $this->recipeService->destroy($request->id);
            exit(json_encode(true));
        } catch (\Exception $e) {
            exit(json_encode($e));
        }
    }
}
