<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPassword as ResetPasswordNotification;
use Carbon\Carbon;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use App\Models\UserSubscription;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    public $varta;

    const ACTIVE = 'Active';
    const INACTIVE = 'Suspended';
    const BLOCKED = 'Blocked';
    const BLOCK_FIFTHTEEN_DAYS = '15_days';
    const BLOCK_ONE_MONTH = '1_month';
    const BLOCK_THREE_MONTH = '3_month';
    const BLOCK_SIX_MONTH = '6_month';
    const BLOCK_ONE_YEAR = '1_year';
    // Device Tpe
    public const DEVICE_ANDROID = 2;
    public const DEVICE_IOS = 1;

    // Profile Status
    public const PROFILE_STATUS_INACTIVE = 0;
    public const PROFILE_STATUS_ACTIVE = 1;

    // Status
    public const STATUS_DELETEUSER = 3;
    // public const STATUS_ACTIVE = 1;
    public const STATUS_SUSPENDED = 2;
    public const STATUS_ADMIN_BLOCK = 1;
    public const STATUS_TOKEN_EXPIRED = 4;
    public const STATUS_BLOCK_SUSPENDED = 2;


    // Profile
    public const PROFILE_NOT_SETUP = 0;
    public const PROFILE_SETUP = 1;
    public const PROFILE_QUESTION_SETUP = 2;

    // Subscription Type
    public const SUBSCRIPTION_ONE_MONTH = 1;
    public const SUBSCRIPTION_THREE_MONTH = 2;
    public const SUBSCRIPTION_SIX_MONTH = 3;
    public const SUBSCRIPTION_TWELVE_MONTH = 4;

    // Gender
    public const GENDER_MALE = 1;
    public const GENDER_FEMALE = 2;
    public const GENDER_OTHER = 3;
    public const GENDER_ALL = 4;

    public const PREFERENCE_MIN_AGE = 18;
    public const PREFERENCE_MAX_AGE = 45;
    public const DEFAULT_FREE_SPARKS = 3;

    public const MIN_PERCENTAGE_FOR_MATCH = 40;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
        'user_type',
        'first_name',
        'last_name',
        'mobile_no',
        'gender',
        'profile_pic',
        'profile_pic_thumb',
        'interested_state',
        'suburb',
        'latitude',
        'longitude',
        'is_setup_profile',
        'business_logo',
        'business_name',
        'business_profile_link',
        'device_type',
        'device_token',
        'app_version',
        'os_version',
        'device_name',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($user) {
            // $user['account_id'] = self::generateAccountId($user['dob']);
        });
    }

    // public function getProfilePicAttribute($value)
    // {
    //     if (empty($value) || $value == 'default_image.png') {
    //         return asset('images/default_image.png');
    //     }

    //     return asset("storage/users/" . $value);
    // }
    public function getIsProfileSetupAttribute($value)
    {
        return (int) $value;
    }

    public function getFullNameAttribute()
    {
        if (!empty($this->first_name) || !empty($this->last_name)) {
            return ucfirst($this->first_name) . ' ' . ucfirst($this->last_name);
        }
        return null;
    }

    public function getThumbnailAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        return asset("storage/users/thumb/" . $value);
    }
    public function setDobAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['dob'] = date('Y-m-d', strtotime($value));
        }
    }
    public function getDobAttribute($value)
    {
        if (empty($value)) {
            return null;
        }
        $dateOfBirth = Carbon::createFromFormat('Y-m-d H:i:s', $value);
        return $dateOfBirth->format('d-m-Y');
    }
    public function getAgeAttribute()
    {
        $dob = $this->attributes['dob'];
        if (empty($dob)) {
            return null;
        }
        return Carbon::parse($this->dob)->age;
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token, $this->email, $this));
    }

    public function occupations()
    {
        return $this->belongsToMany(Occupation::class, 'user_occupation')->where('is_approved', '<>', Occupation::REJECTED);
    }
    public function interests()
    {
        return $this->belongsToMany(Interest::class, 'user_interest')->where('is_approved', '<>', Interest::REJECTED);
    }
    public function pets()
    {
        return $this->belongsToMany(Pet::class, 'user_pet');
    }

    public function question()
    {
        return $this->hasOne(Question::class);
    }

    public function userImages()
    {
        return $this->hasMany(UserImage::class)->orderBy('id', 'ASC');
    }
    public function profilePicture()
    {
        return $this->hasOne(UserImage::class)->where('is_profile_pic', 1)->latest()->first()?->image;
    }

    public function blockUsers()
    {
        return $this->hasMany(BlockUser::class, 'by_user_id', 'id');
    }

    private function getBlockedUserIds($userId)
    {
        return BlockUser::where('by_user_id', $userId)->get()->pluck('user_id')->toArray();
    }
    private function getHiddenUsersIds()
    {
        return User::where('profile_status', self::PROFILE_STATUS_INACTIVE)->get()->pluck('id')->toArray();
    }
    private function getAdminBlockedUserIds()
    {
        return User::whereIn('status', [self::STATUS_ADMIN_BLOCK, self::STATUS_SUSPENDED])->get()->pluck('id')->toArray();
    }
    private function getReportedUserIds($userId)
    {
        return ReportUser::where('by_user_id', $userId)->get()->pluck('user_id')->toArray();
    }
    private function getMatchedUserIds($userId)
    {
        return User::whereIn('id', function ($query) use ($userId) {
            $query->select('from_user_id')
                ->from('user_matches')
                ->where('user_id', $userId)
                ->whereIn('status', [UserMatch::STATUS_APPROVED, UserMatch::STATUS_PENDING]);
        })
            ->orWhereIn('id', function ($query) use ($userId) {
                $query->select('user_id')
                    ->from('user_matches')
                    ->where('from_user_id', $userId)
                    ->whereIn('status', [UserMatch::STATUS_APPROVED, UserMatch::STATUS_PENDING]);
            })
            ->orderBy(function ($query) {
                $query->select('is_recent')
                    ->from('user_matches')
                    ->whereColumn('users.id', '=', 'user_matches.from_user_id')
                    ->orWhereColumn('users.id', '=', 'user_matches.user_id')
                    ->latest()
                    ->limit(1);
            }, 'desc')
            ->get()->pluck('id')->toArray();
    }

    public function scopeNearest($query, $user)
    {
        $minAge = ($user['min_age'] >= self::PREFERENCE_MIN_AGE) ? $user['min_age'] : self::PREFERENCE_MIN_AGE;
        $maxAge = $user['max_age'];
        $minDistance = $user['min_proximity'] * 1000;
        $maxDistance = $user['max_proximity'] * 1000;
        $longitude = $user['longitude'] ?? '';
        $latitude = $user['latitude'] ?? '';

        if (!empty($longitude) && !empty($latitude)) {
            $query->whereRaw(
                "ST_Distance_Sphere(POINT(`longitude`, `latitude`), POINT({$longitude}, {$latitude})) BETWEEN {$minDistance} AND {$maxDistance}",
            );
        }
        if ((int)$maxAge < self::PREFERENCE_MAX_AGE) {
            $query->whereBetween('dob', [Carbon::now()->subYears($maxAge), Carbon::now()->subYears($minAge)]);
        } elseif ((int)$maxAge == self::PREFERENCE_MAX_AGE) {
            $query->whereDate('dob', '<=', Carbon::now()->subYears($minAge));
            // $query->orWhereDate('dob', '<=', Carbon::now()->subYears($minAge));
        } else {
            $query->whereDate('dob', '>=', Carbon::now()->subYears($minAge));
        }
        if (in_array((int)$user['interested_in'], [self::GENDER_MALE, self::GENDER_FEMALE, self::GENDER_OTHER])) {
            $query->where('gender', $user['interested_in']);
        }
        return $query->where('id', '<>', $user['id']);
    }
    public function scopeExcludeUsers($query)
    {
        $userId = Auth::user()->id;
        $blockedUserIds = $this->getBlockedUserIds($userId);
        $reportedUserIds = $this->getReportedUserIds($userId);
        $alreadyMatchedUserIds = $this->getMatchedUserIds($userId);
        $adminBlockedUserIds = $this->getAdminBlockedUserIds();
        $hiddenUsers = $this->getHiddenUsersIds();
        $excludeUserIds = [...$reportedUserIds, ...$blockedUserIds, ...$alreadyMatchedUserIds, ...$adminBlockedUserIds, ...$hiddenUsers];
        if (!empty($excludeUserIds)) {
            return $query->whereNotIn('id', $excludeUserIds);
        }
        return $query;
    }

    public function scopePercentage($query)
    {
        $userId = Auth::user()->id;
        $loggedInUser = User::find($userId);

        $matchingUsers = User::where('id', '<>', $userId)
            ->with('occupations', 'interests', 'question')
            ->get();

        // Questions to fetch
        $questionArray = [
            "fav_song",
            "date_sound",
            "movie_title",
            "love_language",
            "fav_foods",
            "fav_dessert",
            "makes_happy",
            "partner_quality",
            "grateful_for",
            "happy_place",
            "party_trick",
            "holiday",
            "star_sign"
        ];

        // LoggedIn Users Occupations
        $loggedInUsersOccupations = $loggedInUser->occupations;

        // LoggedIn Users Interests
        $loggedInUsersInterests = $loggedInUser->interests;

        // LoggedIn Users Questions
        $loggedInUsersQuestions = $loggedInUser->question()->select($questionArray)->first()?->toArray();

        $userIds = [];
        foreach ($matchingUsers as $user) {
            $percentage = 0;
            $userQuestion = $user->question()->select($questionArray)->first()?->toArray();

            foreach ($loggedInUsersQuestions as $question => $answer) {
                if (!empty($answer) && isset($userQuestion[$question]) && $answer === $userQuestion[$question]) {
                    $percentage += 5;
                }
            }

            foreach ($loggedInUsersOccupations as $occupation) {
                if ($user->occupations->contains($occupation)) {
                    $percentage += 10;
                }
            }

            foreach ($loggedInUsersInterests as $interest) {
                if ($user->interests->contains($interest)) {
                    $percentage += 10;
                }
            }

            if ($percentage >= self::MIN_PERCENTAGE_FOR_MATCH) {
                $userIds[] = $user->id;
            }
        }

        return $query->whereIn('id', $userIds);
    }

    // public function User_booking(){
    //     return $this->hasMany(User_booking::class,'user_id','id');

    // }
    public function industry_experience()
    {
        return $this->hasMany(IndustryExperience::class, 'user_id', 'id');
    }

    public function certification_details()
    {
        return $this->hasMany(CertificationDetails::class, 'user_id', 'id');
    }
    public function availabilityDrivers()
    {
        return $this->hasMany(AvailabilityDrivers::class, 'user_id');
    }
    public function industryExperiences()
    {
        return $this->hasMany(IndustryExperience::class, 'user_id');
    }

    // public function emergency_contacts_detail()
    // {
    //     return $this->hasMany(EmergencyContactsDetail::class, 'user_id', 'id');
    // }

}
