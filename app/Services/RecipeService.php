<?php


namespace App\Services;


use App\Models\Recipe;
use App\Repositories\RecipeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class RecipeService extends Service
{
    private $recipeRepository;
    private $fileService;

    public function __construct()
    {
        $this->recipeRepository = new RecipeRepository();
        $this->fileService = new FileService();
    }

    public function store(Request $request, array $elem): int
    {
        $jsonRecipe = collect($elem)->toJson();
        $recipe = [
            'user_id' => Auth::id(),
            'title' => $request->input('name'),
            'description' => $request->input('description'),
            'elements' => $jsonRecipe
        ];

        return $this->recipeRepository->store($recipe);
    }

    /**
     * @param Request $request
     * @param array $elem
     */
    public function update(Request $request, array $elem): void
    {
        $jsonRecipe = collect($elem)->toJson();
        $recipe = [
            'id' => $request->input('id'),
            'user_id' => Auth::id(),
            'title' => $request->input('name'),
            'description' => $request->input('description'),
            'elements' => $jsonRecipe
        ];

        $this->recipeRepository->update($recipe);
    }

    public function show(int $id)
    {
        return $this->recipeRepository->show($id);
    }

    public function findAll()
    {
        return $this->recipeRepository->findAll();
    }

    /**
     * Метод сливает два массива text и img в один - elements
     * для дальнейшего перевода в Json
     *
     * @param array $text
     * @param array $img
     * @param array $inputImg
     * @return array
     */
    public function getElementsArray(array $text, array $img, array $inputImg): array
    {
        $newArray = [];
        $count = $this->getMaxKey($text, $img, $inputImg);

        for ($i = 0; $i <= $count; $i++) {
            if (!empty($text[$i])) {
                $newArray[] = ['elem' => 'text', 'v' => $text[$i]];
            } elseif (!empty($inputImg[$i])) {
                $newArray[] = ['elem' => 'img', 'v' => $inputImg[$i]];
            } else {
                if (!empty($img[$i])) {
                    $file = $img[$i];
                    $fileName = $this->fileService->addFile($file);
                    $newArray[] = ['elem' => 'img', 'v' => $fileName];
                }
            }
        }
        return $newArray;
    }

    public function updateElements(int $id, array $elem): void
    {
        $jsonRecipe = collect($elem)->toJson();
        $this->recipeRepository->updateElements($id, $jsonRecipe);
    }

    public function destroy(int $id)
    {
        $this->recipeRepository->destroy($id);
    }

    public function getMaxKey($arr1, $arr2, $arr3)
    {
        $arr = [];
        if (count($arr1)) {
            $arr[] = max(array_keys($arr1));
        }
        if (count($arr2)) {
            $arr[] = max(array_keys($arr2));
        }
        if (count($arr3)) {
            $arr[] = max(array_keys($arr3));
        }

        return max($arr);
    }

    public function searchEveryWhereOnRequest(string $search): object
    {
        return $this->recipeRepository->searchEveryWhereOnRequest($search);
    }
}