<?php
namespace App\Repositories;

use App\Models\Users\User;
use App\Models\Users\Profile;
use App\Models\Users\UserPreference;

use App\Jobs\SendMail;

use Illuminate\Support\Str;
use App\Notifications\Activation;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class UserRepository
{
    protected $user;
    protected $role;
    protected $email;

    /**
     * Instantiate a new instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user  = $user;
    }

    /**
     * Get all users with profile
     *
     * @return User
     */

    public function getAll()
    {
        return $this->user->with('profile')->get();
    }

    /**
     * Count users
     *
     * @return integer
     */

    public function count()
    {
        return $this->user->count();
    }

    /**
     * Count users registered between dates
     *
     * @return integer
     */

    public function countDateBetween($start_date, $end_date)
    {
        return $this->user->createdAtDateBetween(['start_date' => $start_date, 'end_date' => $end_date])->count();
    }

    /**
     * Find user by Id
     *
     * @param integer $id
     * @return User
     */

    public function findOrFail($id = null)
    {
        $user = $this->user->with('profile', 'userPreference')->find($id);

        if (! $user) {
            throw ValidationException::withMessages(['message' => trans('user.could_not_find')]);
        }

        return $user;
    }

    /**
     * Find user by Email
     *
     * @param email $email
     * @return User
     */

    public function findByEmail($email = null)
    {
        return $this->user->with('profile', 'userPreference')->filterByEmail($email)->first();
    }

    /**
     * Find user by activation token
     *
     * @param string $token
     * @return User
     */

    public function findByActivationToken($token = null)
    {
        return $this->user->with('profile', 'userPreference')->whereActivationToken($token)->first();
    }

    /**
     * List user except authenticated user by name & email
     *
     * @param string $token
     * @return User
     */

    public function listByNameAndEmailExceptAuthUser()
    {
        return $this->user->where('id', '!=', \Auth::user()->id)->get()->pluck('name_with_email', 'id')->all();
    }

    /**
     * Paginate all todos using given params.
     *
     * @param array $params
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */

    public function paginate($params = array())
    {
        $sort_by               = isset($params['sort_by']) ? $params['sort_by'] : 'created_at';
        $order                 = isset($params['order']) ? $params['order'] : 'desc';
        $page_length           = isset($params['page_length']) ? $params['page_length'] : config('config.page_length');
        $name                  = isset($params['name']) ? $params['name'] : null;
        $email                 = isset($params['email']) ? $params['email'] : null;
        $role_id               = isset($params['role_id']) ? $params['role_id'] : null;
        $status                = isset($params['status']) ? $params['status'] : null;
        $created_at_start_date = isset($params['created_at_start_date']) ? $params['created_at_start_date'] : null;
        $created_at_end_date   = isset($params['created_at_end_date']) ? $params['created_at_end_date'] : null;

        $query = $this->user->with('profile')->filterByName($name)->filterByEmail($email)->filterByRoleId($role_id)->filterByStatus($status)->createdAtDateBetween([
            'start_date' => $created_at_start_date,
            'end_date' => $created_at_end_date
        ]);

        if ($sort_by === 'first_name') {
            $query->select('users.*', \DB::raw('(select first_name from profiles where users.id = profiles.user_id) as first_name'))->orderBy('first_name', $order);
        } elseif ($sort_by === 'last_name') {
            $query->select('users.*', \DB::raw('(select last_name from profiles where users.id = profiles.user_id) as last_name'))->orderBy('last_name', $order);
        } else {
            $query->orderBy($sort_by, $order);
        }

        return $query->paginate($page_length);
    }

    /**
     * Create a new user.
     *
     * @param array $params
     * @return Todo
     */

    public function create($params, $register = 0)
    {
        $user = $this->user->forceCreate($this->formatParams($params, 'register'));

        if ($register) {
            $role_id = $this->role->findByName(config('system.default_role.'.($this->count() > 1 ? 'user' : 'admin')))->id;
        } else {
            $role_id = isset($params['role_id']) ? $params['role_id'] : null;
        }

        $profile = $this->associateProfile($user);

        $this->updateProfile($profile, $params);

        if (isset($params['send_email']) && isset($params['send_email']) && $params['send_email']) {
            SendMail::dispatch($user->email, [
                'slug'      => 'welcome-email-user',
                'user'      => $user,
                'password'  => $params['password'],
                'module'    => 'user',
                'module_id' => $user->id
            ]);
        }

        if ($register && config('config.email_verification')) {
            $user->notify(new Activation($user));
        }

        return $user;
    }

    /**
     * Prepare given params for inserting into database.
     *
     * @param array $params
     * @param string $type
     * @return array
     */

    private function formatParams($params, $action = 'create')
    {
        $formatted = [
            'email'       => isset($params['email']) ? $params['email'] : null,
            'status' => 'activated',
            'password' => isset($params['password']) ? bcrypt($params['password']) : null,
            'activation_token' => Str::uuid()
        ];

        if ($action === 'register') {
            if (config('config.email_verification')) {
                $formatted['status'] = 'pending_activation';
            } elseif (config('config.account_approval')) {
                $formatted['status'] = 'pending_approval';
            }
        }

        return $formatted;
    }

    /**
     * Associate user to profile.
     *
     * @param User
     * @return Profile
     */

    private function associateProfile($user)
    {
        $profile = new Profile;
        $user->profile()->save($profile);

        $user_preference = new UserPreference;
        $user->userPreference()->save($user_preference);

        return $profile;
    }

    /**
     * Update user profile.
     *
     * @param Profile
     * @param array $params
     * @return null
     */

    public function updateProfile($profile, $params = array())
    {
        $profile->name                = isset($params['name']) ? $params['name'] : $profile->name;
        $profile->address_line_1      = isset($params['address_line_1']) ? $params['address_line_1'] : $profile->address_line_1;
        $profile->address_line_2      = isset($params['address_line_2']) ? $params['address_line_2'] : $profile->address_line_2;
        $profile->city                = isset($params['city']) ? $params['city'] : $profile->city;
        $profile->state               = isset($params['state']) ? $params['state'] : $profile->state;
        $profile->zipcode             = isset($params['zipcode']) ? $params['zipcode'] : $profile->zipcode;
        $profile->country_id          = isset($params['country_id']) ? $params['country_id'] : $profile->country_id;
        $profile->phone               = isset($params['phone']) ? $params['phone'] : $profile->phone;
        $profile->date_of_birth       = isset($params['date_of_birth']) ? ($params['date_of_birth'] ? : null) : $profile->date_of_birth;
        $profile->save();
    }

    /**
     * Update given user.
     *
     * @param User $user
     * @param array $params
     *
     * @return User
     */
    public function update(User $user, $params = array())
    {
        $this->updateProfile($user->Profile, $params);

        $this->updatePreference($user->UserPreference, $params);

        return $user;
    }

    /**
     * Update given user preference.
     *
     * @param UserPreference $user_preference
     * @param array $params
     *
     * @return User
     */
    public function updatePreference(UserPreference $user_preference, $params = array())
    {
        $user_preference->color_theme = isset($params['color_theme']) ? $params['color_theme'] : config('config.color_theme');
        $user_preference->direction   = isset($params['direction']) ? $params['direction'] : config('config.direction');
        $user_preference->locale      = isset($params['locale']) ? $params['locale'] : config('config.locale');
        $user_preference->sidebar     = isset($params['sidebar']) ? $params['sidebar'] : config('config.sidebar');
        $user_preference->save();

        if ($user_preference->direction === 'rtl') {
            \Cache::put('direction', 'rtl', 1440 * 60);
        } else {
            \Cache::put('direction', 'ltr', 1440 * 60);
        }
        \Cache::put('locale',$user_preference->locale,config('jwt.ttl'));
    }

    /**
     * Update given user status.
     *
     * @param User $user
     * @param string $status
     *
     * @return User
     */
    public function status(User $user, $status = null)
    {
        if (!in_array($status, ['activated','pending_activation','pending_approval','banned','disapproved'])) {
            throw ValidationException::withMessages(['message' => trans('general.invalid_action')]);
        }

        $user->status = $status;
        $user->save();

        return $user;
    }

    /**
     * Force reset user password.
     *
     * @param User $user
     * @param string $password
     *
     * @return User
     */
    public function forceResetPassword(User $user, $password = null)
    {
        $user->password = bcrypt($password);
        $user->save();

        return $user;
    }

    /**
     * Send email to user.
     *
     * @param User $user
     * @param array $params
     *
     * @return null
     */
    public function sendEmail(User $user, $params = array())
    {
        $body = isset($params['body']) ? $params['body'] : null;
        $subject = isset($params['subject']) ? $params['subject'] : null;
        $email = $user->email;

        \Mail::send('emails.email', compact('body'), function ($message) use ($subject, $email) {
            $message->to($email)->subject($subject);
        });

        $this->email->record([
            'to' => $email,
            'subject' => $subject,
            'body' => $body,
            'module' => 'user',
            'module_id' => $user->id
        ]);
    }

    /**
     * Delete user.
     *
     * @param integer $id
     * @return bool|null
     */
    public function delete(User $user)
    {
        return $user->delete();
    }

    /**
     * Delete multiple users.
     *
     * @param array $ids
     * @return bool|null
     */
    public function deleteMultiple($ids)
    {
        return $this->user->whereIn('id', $ids)->delete();
    }
}
