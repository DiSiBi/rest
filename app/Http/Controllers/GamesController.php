<?php

namespace App\Http\Controllers;

use App\Http\Resources\GameCollection;
use App\Http\Resources\GameResource;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GamesController extends Controller
{
    public function index(): GameCollection
    {
        return new GameCollection(Game::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'string|required',
        ]);
        return new GameResource(Game::create($validated));
    }

    public function show(int $id): GameResource
    {
        return new GameResource(Game::findOrFail($id));
    }

    public function update(Request $request, int $id): GameResource
    {
        $game = Game::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'string',
        ]);
        $game->update($validated);
        return new GameResource($game);
    }


    public function destroy(int $id): Response
    {
        Game::destroy($id);
        return response()->noContent();
    }
}
