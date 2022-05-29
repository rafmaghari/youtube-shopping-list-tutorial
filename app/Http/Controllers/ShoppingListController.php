<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreShoppingList;
use App\Models\ShoppingList;
use Illuminate\Http\Request;

class ShoppingListController extends Controller
{
    public function list()
    {
        // this will return all the list in our database
        $shoppingList = ShoppingList::all();

        return response()->json(['data' => $shoppingList]);
    }
    public function index()
    {
        return view('app');
    }

    public function store(StoreShoppingList $request)
    {
        // let's add in fillable the qty and name  in Shopping list model
        ShoppingList::create($request->validated());

        return response()->json(['message' => 'Shopping list successfully added'], 201);
    }

    public function update(StoreShoppingList $request, ShoppingList $shoppingList)
    {
        $shoppingList->update($request->validated());

        return response()->json(['message' => 'Shopping list successfully updated'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ShoppingList  $shoppingList
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShoppingList $shoppingList)
    {
        $shoppingList->delete();

        return response()->json(['message' => 'Shopping list successfully deleted'], 200);
    }
}
