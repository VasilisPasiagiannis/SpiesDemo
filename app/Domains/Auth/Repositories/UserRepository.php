<?php

namespace App\Domains\Auth\Repositories;

use App\Exceptions\GeneralException;
use App\Domains\Auth\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid as PackageUuid;

class UserRepository implements UserRepositoryInterface
{

    private User $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function get(): array
    {
        // TODO: Implement get() method.
    }

    public function getAuthUser(): ?User
    {
        $user = Auth::user()->load(['roles', 'permissions']);
        return $user;
    }

    public function hasRole(int $userId, string|int $role):bool
    {
        $user = $this->model->findOrFail($userId);
        return $user->hasRole($role);
    }

    public function getById(string $id): ?User
    {
        $user = $this->model->with(['roles','permissions'])->findOrFail($id);
        return $user;
    }

    /**
     * @param string $roleId
     * @return User[]
     */
    public function getByRoleId(string $roleId): array
    {
        $users = $this->model->whereHas('roles', function ($query) use ($roleId) {
            $query->where('id', $roleId);
        })->get();

        return $users;
    }

    /**
     * @throws GeneralException
     */
    public function store(User|Model $entity): ?User
    {
        DB::beginTransaction();

        try {
            $pass = $entity->password;
            if (!$pass) {
                $pass = Str::random(12);
            }

            if(!$entity->uuid){
                $entity->uuid = PackageUuid::uuid4()->toString();
            }

            while ($this->model::where('uuid', $entity->uuid)->exists()) {
                $entity->uuid = PackageUuid::uuid4()->toString();
            }

            $user = $this->model::create([
                'uuid' => $entity->uuid,
                'name' => $entity->name ?? null,
                'email' => $entity->email ?? null,
                'password' => bcrypt($pass) ?? null,
                'email_verified_at' =>  $entity->email_verified_at ? now() : null,
                'active' => $entity->active ?? true,
            ]);

            $user->syncRoles($entity->roles ?? []);

            $user->syncPermissions($entity->permissions ?? []);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            throw new GeneralException(__('There was a problem creating this user. Please try again.'));
        }

        DB::commit();

        return $user;
    }

    /**
     * @throws GeneralException
     */
    public function update(User|Model $entity, string $id, bool $updateRole = false): ?User
    {
        DB::beginTransaction();

        try {
            $user = User::find($id);

            if(!$user->user_verified && $entity->user_verified){
                $entity->user_verified = now();
            }

            if(!$user->email_verified_at && $entity->email_verified_at){
                $entity->email_verified_at = now();
            }

            $user->update([
                'name' => $entity->name,
                'email' => $entity->email,
                'email_verified_at' => $entity->email_verified_at,
                'profile_photo_url' => $entity->profile_photo_url,
                'user_verified' => $entity->user_verified,
                'user_verified_at' => $user->user_verified_at ?? null,
            ]);

            if($updateRole){
                if (!$user->isMasterAdmin()) {
                    // Replace selected roles/permissions

                    $user->syncRoles($entity->roles ?? []);

                    $user->syncPermissions($entity->permissions ?? []);
                }
            }
        } catch (Exception $e) {
            DB::rollBack();

            throw new GeneralException(__('There was a problem updating this user. Please try again.'));
        }

        DB::commit();

        return $user;
    }

    public function deleteById(string $id): bool
    {
        $user = User::find($id);
        if ($user->id === auth()->id()) {
            return false;
        }

        $user->delete();

        return true;
    }


    /**
     * @param User $user
     * @return JsonResponse
     */
    public function apiAuthentication(User $user): JsonResponse
    {
        if(Auth::attempt(['email' => $user->email, 'password' => $user->password])){
            $user = Auth::user();
            if($user->canApi()):
//                $success['token'] =  $user->createToken('app')->plainTextToken;
                $success['token'] =  $user->createToken('app',['*'], Carbon::now()->addHours(4))->plainTextToken;
                return response()->json(['success' => $success], 200);
            else:
                return response()->json(['error'=>'Unauthorised'], 401);
            endif;
        }
        else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }

    /**
     * @return JsonResponse
     */
    public function apiLogOut(): JsonResponse
    {
        $user = Auth::user();
        $user->currentAccessToken()->delete();
        Auth::guard('web')->logout();
        return response()->json(['success'=>'Logged Out'],200);
    }

}
