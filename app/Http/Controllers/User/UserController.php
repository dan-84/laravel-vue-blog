<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\UserRepository;

class UserController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $users;

    /**
     * UserController constructor.
     */
    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    /**
     * Show user homepage.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('user.home');
    }
}
