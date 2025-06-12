<?php

namespace App\Services\ServiceImpl;

use App\Models\Attendance;
use App\Models\Dtos\UserAdminStoreDto;
use App\Models\Dtos\UserStoreDto;
use App\Models\Dtos\UserUpdateDto;
use App\Models\Employee;
use App\Models\NotificationSetting;
use App\Models\OffDay;
use App\Models\User;
use App\Services\JwtToken\JwtTokenService;
use App\Services\UserService;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravolt\Avatar\Facade as Avatar;
use RamdanRiawan\Accounting;
use RamdanRiawan\StrManipulate;
use stdClass;
use RamdanRiawan\DateTime;

class UserServiceImpl implements UserService
{
    private static $withRelations = [
        'employee.title',
        'user_shift',

    ];
    private static $withCount = [
        'attendances',
        'visits'
    ];

    public static $columnOrder = [
        'id',
        'name',
        'email',
        'email_verified_at',
        'password',
        'remember_token',
        'profile_picture',
        'level',
        'status',
        'created_at',
        'updated_at',
    ];

    public static function findAll(
        $length = 10,
        $start = 0,
        $columnToSearch = [

        ],
        $columnToSearchRelation = [

        ],
        $search = '',
        $andCondition = [],
        $columnOrderName = 'id',
        $columnOrderDir = 'desc',
        $notInCondition = [

        ],
        $notInConditionRelation = [

        ],
        $hasRelations = [
        ]
    )
    {
        if (empty($search) && !$start) {

            $data = User::limit($length);
        } else {

            $data = User::limit($length)->offset($start);
        }

        $data->with(self::$withRelations);
        $data->withCount(self::$withCount);
        $data->when($search, function ($query) use ($columnToSearch, $columnToSearchRelation, $search) {
            $query->where(function ($query) use ($columnToSearch, $columnToSearchRelation, $search) {
                foreach ($columnToSearch as $key => $value) {
                    $query->orWhere($value, 'like', '%' . $search . '%');
                }

                foreach ($columnToSearchRelation as $key => $value) {
                    $query->orWhereHas($key, function ($query) use ($value, $search) {
                        $query->where($value, 'like', '%' . $search . '%');
                    });
                }
            });
        });

        foreach ($andCondition as $key => $item) {
            $data->when($item, function ($query) use ($key, $item) {
                $query->where($key, $item);
            });
        }

        foreach ($notInCondition as $key => $item) {
            $data->whereNotIn($key, $item);
        }

        foreach ($notInConditionRelation as $key => $item) {
            $data->whereHas($key, function ($query) use ($key, $item) {
                foreach ($item as $key => $value) {
                    $query->whereNotIn($key, $value);
                }
            });
        }

        foreach ($hasRelations as $key => $item) {

            $data->has($item);
        }

        $data->orderBy(self::$columnOrder[$columnOrderName] ?? $columnOrderName, $columnOrderDir);
        $data = $data->get();

        foreach ($data as $item) {
            $item = self::addAllAttributes($item);
        }

        return $data;
    }

    public
    static function store(UserStoreDto $userStoreDto)
    {

        $user = User::create([
            'name' => $userStoreDto->getName(),
            'email' => $userStoreDto->getEmail(),
            'password' => Hash::make($userStoreDto->getPassword()),
        ]);

        $user = User::find($user->id);

        $user = self::addAllAttributes($user);

        return $user;
    }

    public
    static function storeAdmin(UserAdminStoreDto $dto)
    {

        $user = User::create([
            'name' => $dto->getName(),
            'email' => $dto->getEmail(),
            'email_verified_at' => $dto->getEmailVerifiedAt(),
            'password' => Hash::make($dto->getPassword()),
            'remember_token' => $dto->getRememberToken(),
            'profile_picture' => $dto->getProfilePicture(),
            'level' => $dto->getLevel(),
            'status' => $dto->getStatus(),
        ]);

        $user = User::find($user->id);

        $user = self::addAllAttributes($user);

        return $user;
    }

    public
    static function update(UserUpdateDto $userUpdateDto)
    {
        $input = [
            'name' => $userUpdateDto->getName(),
            'email' => $userUpdateDto->getEmail(),
        ];

        if ($userUpdateDto->getPassword()) {
            $input['password'] = Hash::make($userUpdateDto->getPassword());
        }

        $user = User::find($userUpdateDto->getId());

        $user->update($input);

        $user = self::addAllAttributes($user);

        return $user;
    }

    public
    static function delete(User $user)
    {
        if(in_array($user->level, ['admin'])) {
            return false;
        }

        DB::transaction(function () use ($user) {

            $user->delete();
        });

        return true;
    }

    public
    static function getToken($email)
    {

        $user = User::where(['email' => $email])->first();

        $token = $user->createToken('login', ['*'], Carbon::now()->addMinutes(User::ACCESS_TOKEN_EXPIRED_IN_MINUTES))->plainTextToken;

        return $token;
    }

    public
    static function loginMobile($email, $password): bool|array
    {
        $credentials = [
            'email' => $email,
            'password' => $password,
        ];

        if (!Auth::attempt($credentials)) {
            return false;
        }

        $token = UserServiceImpl::getToken($email);

        return JwtTokenService::tokenArray($token);
    }

    public
    static function logout(Model|User $user): bool
    {
        $user->currentAccessToken()->delete();

        return true;
    }

    public
    static function findOne($id)
    {

        $data = User::with(self::$withRelations)->where(['id' => $id])->withCount(self::$withCount)->first();

        if (!$data) {
            return null;
        }

        $data = self::addAllAttributes($data);

        return $data;
    }

    public
    static function findAdmin()
    {

        $data = User::with(self::$withRelations)->where(['level' => 'admin'])->withCount(self::$withCount)->first();

        if (!$data) {
            return null;
        }

        $data = self::addAllAttributes($data);

        return $data;
    }

// parameter user belum saya pakai
    public
    static function addAllAttributes(User|Builder|Model|array $item): User|Model|stdClass|null
    {
        if (is_array($item)) {
            $item = json_decode(json_encode($item));
        }

        if (!$item) {
            return null;
        }

        $item->nameCase = StrManipulate::makeCase($item->name);

        $item->isAnonymous = $item->level == 'anonymous';
        $item->isEmployee = $item->level == 'employee';


        $item->isAdmin = $item->level == 'admin';
        $item->isCanDelete = $item->level != 'admin';

        $item->created_at_human = Carbon::parse($item->created_at)->diffForHumans();
        $item->updated_at_human = Carbon::parse($item->updated_at)->diffForHumans();
        $item->deleted_at_human = Carbon::parse($item->deleted_at)->diffForHumans();

        $item->createdAtDateTime = DateTime::getDetail('Y-m-d H:i:s', $item->created_at);
        $item->updatedAtDateTime = DateTime::getDetail('Y-m-d H:i:s', $item->updated_at);
        $item->deletedAtDateTime = DateTime::getDetail('Y-m-d H:i:s', $item->deleted_at);

        $item->isUserCanLogin = $item->status != 'blocked' && $item->status != 'inactive';

        $item->profilePictureUrl = Avatar::create(Str::upper($item->name))->toBase64();

        $item->profilePictureHtml = "

<style>
table tr td img {
    all: initial;
}
</style>

<img src='{$item->profilePictureUrl}'
    style='display:inline-block; width:60px !important; height:60px !important;
    border-radius:50% !important; object-fit:cover !important; overflow:hidden;'>";

        if ($item->profile_picture != null) {

            $item->profilePictureUrl = url(Storage::url($item->profile_picture));
        }

        $item->userCanLoginReason = null;

        if ($item->status == 'blocked') {

            $item->userCanLoginReason = "U are blocked";
        }

        if ($item->status == 'inactive') {

            $item->userCanLoginReason = "Inactive account";
        }

        if (!$item->notification) {
            $item->notification = self::getDefaultNotificationSetting($item);
        }

        // // assign permission
        // if(! $item->permission) {

        //     $item->permission = self::getDefaultPermissionSetting($item);
        // }

        return $item;
    }

    public
    static function findByEmployeeId($id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return null;
        }

        $user = User::find($employee->user_id);

        if (!$user) {
            return null;
        }

        $user = self::addAllAttributes($user);

        return $user;
    }

    public
    static function getDefaultNotificationSetting(User|Authenticatable|Model|stdClass $user)
    {
        $notification = self::enableAllNotificationSetting($user);

        return $notification;
    }

    public
    static function enableAllNotificationSetting(User|Authenticatable|Model|stdClass $user): Model|NotificationSetting
    {
        NotificationSetting::create([
            'user_id' => $user->id,
        ]);

        return NotificationSetting::where([
            'user_id' => $user->id,
        ])->first();
    }

    public
    static function updatePhotoProfile(User $user, UploadedFile $picture)
    {
        $picture = $picture->store('images', 'public');

        $user->update([
            'profile_picture' => $picture
        ]);

        $user = User::with(['employee.title'])->where(['id' => $user->id])->first();

        if (!$user) {
            return null;
        }

        $user = self::addAllAttributes($user);

        return $user;
    }

    public
    static function updateStatus(User $user, $status)
    {
        $user->update([
            'status' => $status,
        ]);

        $user = self::addAllAttributes($user);

        return $user;
    }

}
