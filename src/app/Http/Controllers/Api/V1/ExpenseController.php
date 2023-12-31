<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Http\Resources\ExpenseCollection;
use App\Http\Resources\ExpenseResource;
use App\Models\Expense;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ExpenseController extends Controller
{
    public function __construct()
    {
        $this->middleware('throttle:api')->only(['store', 'update', 'delete']);
        $this->authorizeResource(Expense::class, 'expense');
    }

    /**
     * Display a listing of the resource.
     */
    public function index():ExpenseCollection
    {
        $expenses = QueryBuilder::for(Expense::class)
            ->allowedFilters([
                'created_at', 'price', 'category_id',
                AllowedFilter::scope('current_created_at', null, 'currentMonth, currentYear')
            ])
            ->defaultSort('-created_at')
            ->allowedSorts(['price', 'created_at'])
            ->allowedIncludes(['category']);

        return new ExpenseCollection($expenses->where('user_id', Auth::id())->paginate());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExpenseRequest $request): ExpenseResource
    {
        $validated = $request->validated();

        $expense = Auth::user()->expenses()->create($validated);

        return new ExpenseResource($expense);
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense): ExpenseResource
    {
        return new ExpenseResource($expense);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExpenseRequest $request, Expense $expense): ExpenseResource
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::id();

        $expense->update($validated);

        return new ExpenseResource($expense);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense): Response
    {
        $expense->delete();

        return response()->noContent();
    }
}
