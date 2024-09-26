<?php

namespace App\Console\Commands\User;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use function Laravel\Prompts\select;
use function Laravel\Prompts\password;

class Create extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:user:create {first_name} {last_name} {email} {password} {role}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        User::create([
            'first_name' => $this->argument('first_name'),
            'last_name' => $this->argument('last_name'),
            'email' => $this->argument('email'),
            'password' => $this->argument('password'),
            'role_id' => $this->argument('role'),
        ]);
    }

    protected function promptForMissingArgumentsUsing(): array
    {
        return [
            'first_name' => 'What is the user\'s first name?',
            'last_name' => 'What is the user\'s last name?',
            'email' => 'What is the user\'s email address?',
            'password' => fn() => password('What is the user\'s password?'),
            'role' => fn() => select(
                label: 'What is the user\'s role?',
                options: Role::all()->pluck('name', 'id')->toArray(),
                default: 1,
            ),
        ];
    }
}
