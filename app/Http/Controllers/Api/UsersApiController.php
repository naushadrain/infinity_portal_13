<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

/**
 * @OA\Schema(
 *     schema="User",
 *     type="object",
 *     @OA\Property(property="id",    type="integer", example=1),
 *     @OA\Property(property="name",  type="string",  example="Sarah Mitchell"),
 *     @OA\Property(property="email", type="string",  format="email", example="sarah@infiniteability.com.au"),
 *     @OA\Property(property="role_id", type="integer", example=2),
 *     @OA\Property(property="state",   type="string",  example="Victoria"),
 *     @OA\Property(property="active",  type="integer", enum={0,1}, example=1),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 *
 * @OA\Schema(
 *     schema="UserCreateRequest",
 *     required={"name","email","role_id","active","password","password_confirmation"},
 *     @OA\Property(property="name",     type="string",  maxLength=255, example="Sarah Mitchell"),
 *     @OA\Property(property="email",    type="string",  format="email", example="sarah@infiniteability.com.au"),
 *     @OA\Property(property="role_id",  type="integer", example=2),
 *     @OA\Property(property="state",    type="string",  example="Victoria"),
 *     @OA\Property(property="active",   type="integer", enum={0,1}, example=1),
 *     @OA\Property(property="password", type="string",  minLength=8, example="secret1234"),
 *     @OA\Property(property="password_confirmation", type="string", example="secret1234")
 * )
 *
 * @OA\Schema(
 *     schema="UserUpdateRequest",
 *     required={"name","email","role_id","active"},
 *     @OA\Property(property="name",     type="string",  maxLength=255, example="Sarah Mitchell"),
 *     @OA\Property(property="email",    type="string",  format="email", example="sarah@infiniteability.com.au"),
 *     @OA\Property(property="role_id",  type="integer", example=2),
 *     @OA\Property(property="state",    type="string",  example="Victoria"),
 *     @OA\Property(property="active",   type="integer", enum={0,1}, example=1),
 *     @OA\Property(property="password", type="string",  minLength=8, example="newsecret1234"),
 *     @OA\Property(property="password_confirmation", type="string", example="newsecret1234")
 * )
 *
 * @OA\Schema(
 *     schema="PaginatedUsers",
 *     @OA\Property(property="data",  type="array", @OA\Items(ref="#/components/schemas/User")),
 *     @OA\Property(property="total", type="integer", example=50),
 *     @OA\Property(property="per_page", type="integer", example=15),
 *     @OA\Property(property="current_page", type="integer", example=1),
 *     @OA\Property(property="last_page", type="integer", example=4)
 * )
 */
class UsersApiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/users",
     *     summary="List all staff accounts",
     *     description="Returns a paginated, filterable list of staff user accounts.",
     *     tags={"Users"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="search",  in="query", description="Search by name or email",     required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(name="role",    in="query", description="Filter by role ID",            required=false, @OA\Schema(type="integer")),
     *     @OA\Parameter(name="state",   in="query", description="Filter by Australian state",   required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(name="status",  in="query", description="Filter by status (active|disabled)", required=false, @OA\Schema(type="string", enum={"active","disabled"})),
     *     @OA\Parameter(name="page",    in="query", description="Page number",                  required=false, @OA\Schema(type="integer", default=1)),
     *     @OA\Parameter(name="per_page",in="query", description="Records per page (max 100)",   required=false, @OA\Schema(type="integer", default=15)),
     *     @OA\Response(response=200, description="Paginated list of users", @OA\JsonContent(ref="#/components/schemas/PaginatedUsers")),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = min((int) $request->input('per_page', 15), 100);

        $users = User::with('role')
            ->when($request->filled('search'), fn ($q) =>
                $q->where(fn ($q) =>
                    $q->where('name', 'like', '%' . $request->search . '%')
                      ->orWhere('email', 'like', '%' . $request->search . '%')
                )
            )
            ->when($request->filled('role'),   fn ($q) => $q->where('role_id', $request->role))
            ->when($request->filled('state'),  fn ($q) => $q->where('state', $request->state))
            ->when($request->filled('status'), fn ($q) => $q->where('active', $request->status === 'active' ? 1 : 0))
            ->latest()
            ->paginate($perPage);

        return response()->json($users);
    }

    /**
     * @OA\Post(
     *     path="/users",
     *     summary="Create a new staff account",
     *     description="Creates a new staff user account with the provided details.",
     *     tags={"Users"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UserCreateRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Staff account created successfully."),
     *             @OA\Property(property="data", ref="#/components/schemas/User")
     *         )
     *     ),
     *     @OA\Response(response=422, description="Validation error"),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'                  => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'email', 'max:255', 'unique:users,email'],
            'role_id'               => ['required', 'exists:roles,id'],
            'state'                 => ['nullable', 'string', 'max:100'],
            'active'                => ['required', 'in:0,1'],
            'password'              => ['required', Password::min(8)->uncompromised(), 'confirmed'],
            'password_confirmation' => ['required', 'string'],
        ]);

        $user = User::create($validated);

        return response()->json([
            'message' => 'Staff account created successfully.',
            'data'    => $user->load('role'),
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/users/{id}",
     *     summary="Get a staff account",
     *     description="Returns the details of a single staff user account.",
     *     tags={"Users"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="id", in="path", description="User ID", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(
     *         response=200,
     *         description="User details",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(response=404, description="User not found"),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function show(string $id): JsonResponse
    {
        $user = User::with('role')->findOrFail($id);

        return response()->json($user);
    }

    /**
     * @OA\Put(
     *     path="/users/{id}",
     *     summary="Update a staff account",
     *     description="Updates an existing staff user account. Leave password blank to keep the current password.",
     *     tags={"Users"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="id", in="path", description="User ID", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UserUpdateRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Staff account updated successfully."),
     *             @OA\Property(property="data", ref="#/components/schemas/User")
     *         )
     *     ),
     *     @OA\Response(response=422, description="Validation error"),
     *     @OA\Response(response=404, description="User not found"),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function update(Request $request, string $id): JsonResponse
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
            $rules['password']              = ['string', Password::min(8)->uncompromised(), 'confirmed'];
            $rules['password_confirmation'] = ['required', 'string'];
        }

        $validated = $request->validate($rules);

        if (! $request->filled('password')) {
            unset($validated['password']);
        }

        $user->update($validated);

        return response()->json([
            'message' => 'Staff account updated successfully.',
            'data'    => $user->fresh('role'),
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/users/{id}",
     *     summary="Delete a staff account",
     *     description="Permanently deletes a staff user account. You cannot delete your own account.",
     *     tags={"Users"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="id", in="path", description="User ID", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(
     *         response=200,
     *         description="User deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Staff account deleted.")
     *         )
     *     ),
     *     @OA\Response(response=403, description="Cannot delete your own account"),
     *     @OA\Response(response=404, description="User not found"),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function destroy(Request $request, string $id): JsonResponse
    {
        $user = User::findOrFail($id);

        if ($user->id === $request->user()?->id) {
            return response()->json(['message' => 'You cannot delete your own account.'], 403);
        }

        $user->delete();

        return response()->json(['message' => 'Staff account deleted.']);
    }
}
