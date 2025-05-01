<?php

namespace App\View\Components;

use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ContactSearchBarComponent extends Component
{
    public $users;

    public function __construct()
    {
        $this->users = User::all();
    }

    public function render(): View|Closure|string
    {
        return view('components.contact-search-bar-component');
    }
}
