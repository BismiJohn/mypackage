<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customers::paginate(8);

        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required',
                'contact_email' => 'required|email',
                'contact_phone' => 'required|integer',
                'address' => 'required|string',
            ]);

            $project = Customers::create($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'New Customer added successfully.',
                'redirect' => route('customers.index'),
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Log the validation error
            Log::error('Validation Error: ', $e->errors());

            return response()->json([
                'success' => false,
                'message' => 'Validation error occurred.',
                'errors' => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            // Log any other errors
            Log::error('Error: ', ['exception' => $e]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while adding new customer.',
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $customer_details = Customers::findOrFail($id);
        return $customer_details;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($customer_id)
    {
        $customer = Customers::findOrFail($customer_id);
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $customer_id)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'contact_email' => 'required|email',
            'contact_phone' => 'required|integer',
            'address' => 'required|string',
        ]);

        $customer = Customers::findOrFail($customer_id);
        $customer->update($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Customer data updated successfully.',
            'redirect' => route('customers.index'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($customer_id)
    {
        $customer = Customers::findOrFail($customer_id);
        $customer->delete();

        return redirect()->route('projects.index')->with('success', 'Customer deleted successfully!');
    }
}
