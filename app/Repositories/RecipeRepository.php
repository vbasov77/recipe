<?php


namespace App\Repositories;


use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecipeRepository extends Repository
{
    public function store(array $elem): int
    {
        return Recipe::insertGetId($elem);
    }

    public function update($recipe): void
    {
        Recipe::where('id', $recipe['id'])->update($recipe);
    }

    public function findAll()
    {
        return Recipe::all();
    }


    public function show(int $id)
    {
        return Recipe::where('id', $id)->first();
    }

    public function updateElements(int $id, string $elem): void
    {
        Recipe::where('id', $id)->update(['elements' => $elem]);
    }

    public function destroy(int $id): void
    {
        Recipe::where('id', $id)->delete();
    }

    public function searchEveryWhereOnRequest(string $search)
    {
        return DB::table('recipe')->where("title", 'LIKE', "%$search%")->orWhere("description", 'LIKE', "%$search%")
            ->orWhere("elements", 'LIKE', "%$search%")->orderBy('created_at', 'desc')->paginate(10);
    }
}