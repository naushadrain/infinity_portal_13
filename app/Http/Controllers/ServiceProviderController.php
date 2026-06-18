<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceProvider;

class ServiceProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $serviceList = config('settings.service_lists');

        $states = ServiceProvider::query()
            ->whereNotNull('state')
            ->where('state', '!=', '')
            ->distinct()
            ->orderBy('state')
            ->pluck('state');

        $serviceIds = ServiceProvider::query()
            ->whereNotNull('provider_services')
            ->pluck('provider_services')
            ->flatMap(function ($services) {
                $decoded = json_decode($services, true);

                if (json_last_error() === JSON_ERROR_NONE) {
                    return is_array($decoded) ? $decoded : [$decoded];
                }

                return explode(',', $services);
            })
            ->map(fn($id) => trim($id))
            ->filter()
            ->unique()
            ->values();

        $query = ServiceProvider::query();

        if ($request->filled('provider_name')) {
            $query->where('provider_name', 'like', '%' . $request->provider_name . '%');
        }

        if ($request->filled('state')) {
            $query->where('state', $request->state);
        }

        if ($request->filled('service_name')) {
            $serviceId = $request->service_name;

            $query->where(function ($q) use ($serviceId) {
                $q->where('provider_services', $serviceId)
                    ->orWhere('provider_services', 'like', '%"' . $serviceId . '"%')
                    ->orWhere('provider_services', 'like', '%[' . $serviceId . ',%')
                    ->orWhere('provider_services', 'like', '%,' . $serviceId . ',%')
                    ->orWhere('provider_services', 'like', '%,' . $serviceId . ']%')
                    ->orWhere('provider_services', 'like', '%' . $serviceId . '%');
            });
        }

        $serviceProviders = $query->latest()->paginate(10)->withQueryString();

        return view('pages.service-providers', compact(
            'serviceProviders',
            'states',
            'serviceIds',
            'serviceList'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.service-provider-create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'provider_name' => ['required', 'string', 'max:255'],
            'provider_services' => ['required', 'array', 'min:1'],
            'provider_services.*' => ['required', 'integer'],
            'state' => ['required', 'integer'],
            'address' => ['required', 'string', 'max:500'],
            'phone' => ['required', 'string', 'max:30'],
            'email' => ['required', 'email', 'max:255'],
            'website' => ['nullable', 'string', 'max:255'],
        ]);

        ServiceProvider::create([
            'provider_name' => $validated['provider_name'],
            'provider_services' => json_encode($validated['provider_services']),
            'state' => $validated['state'],
            'address' => $validated['address'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'website' => $validated['website'] ?? null,
        ]);

        return redirect()
            ->route('service-providers.index')
            ->with('success', 'Service provider created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $serviceProvider = ServiceProvider::findOrFail($id);
        return view('pages.service-provider-edit', compact('serviceProvider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $serviceProvider = ServiceProvider::findOrFail($id);

        $validated = $request->validate([
            'provider_name' => ['required', 'string', 'max:255'],
            'provider_services' => ['required', 'array', 'min:1'],
            'provider_services.*' => ['required', 'integer'],
            'state' => ['required', 'integer'],
            'address' => ['required', 'string', 'max:500'],
            'phone' => ['required', 'string', 'max:30'],
            'email' => ['required', 'email', 'max:255'],
            'website' => ['nullable', 'string', 'max:255'],
        ]);

        $serviceProvider->update([
            'provider_name' => $validated['provider_name'],
            'provider_services' => json_encode($validated['provider_services']),
            'state' => $validated['state'],
            'address' => $validated['address'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'website' => $validated['website'] ?? null,
        ]);

        return redirect()
            ->route('service-providers.index')
            ->with('success', 'Service provider updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $serviceProvider = ServiceProvider::findOrFail($id);
        $serviceProvider->delete();

        return redirect()
            ->route('service-providers.index')
            ->with('success', 'Service provider deleted successfully.');
    }
}
