<?php
namespace app\Providers;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\TwoFactorAuthenticationProvider;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Http\Requests\LoginRequest;
use Laravel\Fortify\Http\Responses\FailedPasswordResetLinkRequestResponse;
use Laravel\Fortify\Http\Responses\FailedPasswordResetResponse;
use Laravel\Fortify\Http\Responses\LoginResponse;
use Laravel\Fortify\Http\Responses\LogoutResponse as FortifyLogoutResponse;
use Laravel\Fortify\Http\Responses\PasswordConfirmationResponse;
use Laravel\Fortify\Http\Responses\PasswordResetResponse;
use Laravel\Fortify\Http\Responses\SuccessfulPasswordResetLinkRequestResponse;
use Laravel\Fortify\Http\Responses\SuccessfulPasswordResetResponse;
use Laravel\Fortify\Http\Responses\TwoFactorChallengeResponse;
use Laravel\Fortify\Http\Responses\TwoFactorLoginResponse;
use Laravel\Fortify\Http\Responses\TwoFactorQrCodeResponse;
use Laravel\Fortify\Rules\Password;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Fortify\TwoFactorQrCodeUrl;
use Laravel\Fortify\TwoFactorVerification;
use Laravel\Fortify\Validators\PasswordValidator;
use Laravel\Fortify\Validators\RequestValidator;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\ServiceProvider;


class FortifyServiceProvider extends ServiceProvider
{
    // ...

    protected function registerValidationRules()
    {
        Validator::extend('password', function ($attribute, $value, $parameters, $validator) {
            // ...
        });

        Validator::extend('password_confirmation', function ($attribute, $value, $parameters, $validator) {
            // ...
        });

        Fortify::validateRegistrationsUsing(function (Request $request) {
            // ...
        });

        Fortify::validateLoginsUsing(function (LoginRequest $request) {
            // ...
        });

        Fortify::authenticateUsing(function (LoginRequest $request) {
            // ...
        });

        Fortify::authenticateThrough(function (Request $request) {
            // ...
        });

        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);

        Fortify::createUsersUsing(CreateNewUser::class);

        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);

        Fortify::confirmPasswordsUsing(function (Request $request) {
            return new ConfirmPassword;
        });

        Fortify::twoFactorChallengeView('auth.two-factor-challenge');

        Fortify::twoFactorEmailView('auth.two-factor-email');

        Fortify::twoFactorQrCodeView('auth.two-factor-qr-code');

        Fortify::registerView('auth.register');

        Fortify::requestPasswordResetLinkView('auth.forgot-password');

        Fortify::resetPasswordView('auth.reset-password');

        Fortify::verifyEmailView('auth.verify-email');

        Fortify::loginView('auth.login');

        Fortify::authenticateThrough(function (Request $request) {
            // ...
        });

        Fortify::loginResponse(function (LoginRequest $request) {
            return app(LoginResponse::class);
        });

        Fortify::logoutResponse(function (Request $request) {
            return app(FortifyLogoutResponse::class);
        });

        Fortify::confirmPasswordsUsing(function (Request $request) {
            return new ConfirmPassword;
            });
            Fortify::twoFactorChallengeView('auth.two-factor-challenge');

            Fortify::twoFactorEmailView('auth.two-factor-email');
        
            Fortify::twoFactorRegisterView('auth.two-factor-registration');
        
            Fortify::loginView('auth.login');
        
            Fortify::requestPasswordResetLinkView('auth.forgot-password');
        
            Fortify::resetPasswordView('auth.reset-password');
        
            Fortify::verifyEmailView('auth.verify-email');
        
            Fortify::registerView('auth.register');
        
            Fortify::requestPasswordResetLinkView(function () {
                return view('auth.forgot-password');
            });
        
            Fortify::resetPasswordView(function ($request) {
                return view('auth.reset-password', ['request' => $request]);
            });
        
            Fortify::verifyEmailView(function () {
                return view('auth.verify-email');
            });
        
            Fortify::authenticateUsing(function (LoginRequest $request) {
                $user = User::where('email', $request->email)->first();
        
                if ($user && Hash::check($request->password, $user->password)) {
                    return $user;
                }
                
                throw ValidationException::withMessages([
                    Fortify::username() => __('auth.failed'),
                ]);
            });
        
            Fortify::createUsersUsing(CreateNewUser::class);
        
            Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        
            Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        
            Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        
            Fortify::passwordConfirmationView(function () {
                return view('auth.passwords.confirm');
            });
        
            Fortify::requestPasswordResetLinkView('auth.forgot-password')->emailView(function () {
                return view('auth.passwords.email');
            });
        
            Fortify::resetPasswordView('auth.reset-password')->passwordConfirmationView(function () {
                return view('auth.passwords.confirm');
            });
        
            Fortify::loginView('auth.login')->captchaView(function () {
                return view('auth.captcha');
            });
        
            Fortify::registerView('auth.register')->captchaView(function () {
                return view('auth.captcha');
            });
        
            Fortify::passwordResetView(function ($request) {
                return view('auth.passwords.reset', ['request' => $request]);
            })->passwordConfirmationView(function () {
                return view('auth.passwords.confirm');
            });
        
            Fortify::failedPasswordResetLinkRequestResponse(fn ($request) => back()->withErrors([
                'email' => __('auth.failed'),
            ]));
        
            Fortify::passwordResetLinkRequestView(function () {
                return view('auth.passwords.email');
            });
        
            Fortify::successfulPasswordResetLinkRequestResponse(fn ($request) => back()->with('status', trans('passwords.sent')));
        
            Fortify::passwordResetView(function ($request) {
                return view('auth.passwords.reset', ['request' => $request]);
            });
        
            Fortify::passwordResetResponse(function ($request, $response) {
                return $response->status(200);
            });
        
            Fortify::confirmable(function () {
                return config('auth.defaults.passwords') !== 'users';
            });
        
            Fortify::twoFactorChallengeResponse(function (TwoFactorChallengeRequest $request, $response) {
                return $response;
            });
        
            Fortify::logoutResponse(fn ($request) => app(LogoutResponse::class)());
        
            Fortify::registerView(function () {
                return view('auth.register');
            });
        }
    }        
