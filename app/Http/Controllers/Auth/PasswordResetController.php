<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\RequestPasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Auth\SendActionLink\FailedToSendActionLink;
use Kreait\Firebase\Exception\Auth\ExpiredOobCode;
use Kreait\Firebase\Exception\Auth\InvalidOobCode;
use Kreait\Firebase\Exception\Auth\OperationNotAllowed;
use Kreait\Firebase\Exception\AuthException;
use Kreait\Firebase\Exception\FirebaseException;

class PasswordResetController extends AuthController
{
    public function requestPasswordReset(RequestPasswordReset $request)
    {
        $request->validated();

        $email = $request->input('email');

        try {
            $this->auth->sendPasswordResetLink($email);

            return response()->json(['message' => 'Password reset link sent to your email']);
        } catch (FailedToSendActionLink $e) {
            Log::error("Error sending password reset link: {$e->getMessage()}");

            return response()->json(['error' => 'Error sending password reset link'], 500);
        } catch (\Exception $e) {
            Log::error("Error sending password reset link: {$e->getMessage()}");

            return response()->json(['error' => 'Error sending password reset link'], 500);
        }
    }

    public function resetPassword(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $code = $request->input('code');

        try {
            $this->auth->verifyPasswordResetCode($code);
            $this->auth->changeUserPassword($email, $password);

            return response()->json(['message' => 'Password reset successfully']);
        } catch (ExpiredOobCode|InvalidOobCode $e) {
            Log::error("Error verifying Firebase reset code: {$e->getMessage()}");

            return response()->json(['error' => 'Invalid or expired reset code'], 401);
        } catch (OperationNotAllowed $e) {
            Log::error("Operation not allowed while verifying Firebase reset code: {$e->getMessage()}");

            return response()->json(['error' => 'Operation not allowed'], 401);
        } catch (FirebaseException|AuthException $e) {
            Log::error("Firebase error:  {$e->getMessage()}");

            return response()->json(['error' => 'Error verifying reset code'], 500);
        } catch (\Exception $e) {
            Log::error("Error changing user password: {$e->getMessage()}");

            return response()->json(['error' => 'Error changing user password'], 500);
        }
    }
}
