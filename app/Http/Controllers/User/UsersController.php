<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (auth()->user()?->role_id === 2) {
                return redirect()->route('forms.incident.index');
            }
            return $next($request);
        });
    }

    private array $states = [
        'Western Australia',
        'Victoria',
        'New South Wales',
        'Queensland',
        'South Australia',
        'Tasmania',
        'Australian Capital Territory',
        'Northern Territory',
    ];

    public function index(Request $request)
    {
        $roles = Role::orderBy('name')->get();

        $users = User::with('role')
            ->when($request->filled('search'), fn ($q) =>
                $q->where(fn ($q) =>
                    $q->where('name',  'like', '%' . $request->search . '%')
                      ->orWhere('email', 'like', '%' . $request->search . '%')
                )
            )
            ->when($request->filled('role'),   fn ($q) => $q->where('role_id', $request->role))
            ->when($request->filled('state'),  fn ($q) => $q->where('state', $request->state))
            ->when($request->filled('status'), fn ($q) => $q->where('active', $request->status === 'active' ? 1 : 0))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('pages.users', compact('users', 'roles'))->with('states', $this->states);
    }

    public function create()
    {
        $roles = Role::orderBy('name')->get();

        return view('pages.user-create', compact('roles'))->with('states', $this->states);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'                  => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'email', 'max:255', 'unique:users,email'],
            'role_id'               => ['required', 'exists:roles,id'],
            'state'                 => ['nullable', 'string', 'max:100'],
            'active'                => ['required', 'in:0,1'],
            'password'              => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'string'],
        ]);

        User::create($validated);

        return redirect()->route('users.index')
            ->with('success', 'Staff account created successfully.');
    }

    public function edit(string $id)
    {
        $user  = User::with('role')->findOrFail($id);
        $roles = Role::orderBy('name')->get();

        return view('pages.user-edit', compact('user', 'roles'))->with('states', $this->states);
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $rules = [
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role_id' => ['required', 'exists:roles,id'],
            'state'   => ['nullable', 'string', 'max:100'],
            'active'  => ['required', 'in:0,1'],
        ];

        if ($request->filled('password')) {
            $rules['password']              = ['string', 'min:8', 'confirmed'];
            $rules['password_confirmation'] = ['required', 'string'];
        }

        $validated = $request->validate($rules);

        if (! $request->filled('password')) {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('users.index')
            ->with('success', 'Staff account updated successfully.');
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        if ($user->id === Auth::id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Staff account deleted.');
    }
}
