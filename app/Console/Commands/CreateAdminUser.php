<?php

namespace App\Console\Commands;

use Filament\Commands\MakeUserCommand;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

use function Laravel\Prompts\password;
use function Laravel\Prompts\text;

class CreateAdminUser extends MakeUserCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alibaba-blog:create-admin
                            {--name= : The name of the user}
                            {--email= : A valid and unique email address}
                            {--password= : The password for the user (min. 8 characters)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Filament user';

    /**
     * @return array{'name': string, 'email': string, 'password': string}
     */
    protected function getUserData(): array
    {
        return [
            'name' => $this->options['name'] ?? text(
                label: 'Name',
                required: true,
            ),

            'email' => $this->options['email'] ?? text(
                label: 'Email address',
                required: true,
                validate: fn (string $email): ?string => match (true) {
                    ! filter_var($email, FILTER_VALIDATE_EMAIL) => 'The email address must be valid.',
                    static::getUserModel()::where('email', $email)->exists() => 'A user with this email address already exists',
                    default => null,
                },
            ),

            'password' => Hash::make($this->options['password'] ?? password(
                label: 'Password',
                required: true,
            )),

            'is_admin' => true,
        ];
    }
}
