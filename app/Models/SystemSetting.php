<?php

namespace App\Models;

use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    /**
     * Gettings the OAUTH Credentials since system settings contain the data
     *
     * @return array
     */
    public static function retrieveOauthCredentials()
    {
        $client_id = self::where('meta_key','IS_CLIENT_ID')->value('meta_value');
        $client_secret = self::where('meta_key','IS_CLIENT_SECRET')->value('meta_value');
        $redirect_url = self::where('meta_key','IS_CLIENT_REDIRECT_URL')->value('meta_value');
        return [
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'redirect_url' => $redirect_url
        ];
    }

    /**
     * Create an Infusionsoft Object to be used by OAUTH Service
     *
     * @return \stdClass
     */
    public static function retrieveCurrentInfsAccount()
    {
        $client_id = self::where('meta_key','IS_CLIENT_ID')->value('meta_value');
        $client_secret = self::where('meta_key','IS_CLIENT_SECRET')->value('meta_value');
        $redirect_url = self::where('meta_key','IS_CLIENT_REDIRECT_URL')->value('meta_value');
        $access_token = self::where('meta_key','IS_ACCESS_TOKEN')->value('meta_value');
        $refresh_token = self::where('meta_key','IS_REFRESH_TOKEN')->value('meta_value');
        $account_name = self::where('meta_key','IS_APP_NAME')->value('meta_value');
        $account = self::where('meta_key','IS_ACCOUNT')->value('meta_value');
        $expiration = self::where('meta_key','IS_TOKEN_EXPIRATION')->value('meta_value');

        $infusionsoft = new \stdClass();
        $infusionsoft->client_id = $client_id;
        $infusionsoft->client_secret = $client_secret;
        $infusionsoft->redirect_url = $redirect_url;
        $infusionsoft->access_token = $access_token;
        $infusionsoft->refresh_token = $refresh_token;
        $infusionsoft->app_name = $account_name;
        $infusionsoft->account = $account;
        $infusionsoft->expire_date = $expiration;

        return $infusionsoft;
    }

    /**
     * @param $data
     * @return \stdClass
     */
    public static function updateTokens($data)
    {
        self::where('meta_key','IS_ACCESS_TOKEN')->update(array('meta_value' => $data['access_token']));
        self::where('meta_key','IS_REFRESH_TOKEN')->update(array('meta_value' => $data['refresh_token']));
        self::where('meta_key','IS_TOKEN_EXPIRATION')->update(array('meta_value' => $data['expires_in']));
        return self::retrieveCurrentInfsAccount();
    }
}
