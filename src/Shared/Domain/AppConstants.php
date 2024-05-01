<?php

namespace App\Shared\Domain;

final class AppConstants
{
    public static string $ACTUA_GET_POSTS = 'https://sala-negra.com/actua_public_api_v1/get_posts';
    public static string $ACTUA_GET_EVENTS = 'https://sala-negra.com/actua_public_api_v1/get_events';
    public static string $ACTUA_FILTER_EVENTS = 'https://sala-negra.com/actua_public_api_v1/get_events?start=';
    public static string $DB_HOST = 'mongodb+srv://';
    public static string $DB_USER = 'api_service:';
    public static string $DB_PASS = 'vMODFIxAgeDwubs1';
    public static string $DB_CONFIG = '@appdb.wsfpnnm.mongodb.net/?retryWrites=true&w=majority&appName=appDb';
    public static string $DEFAULT_DB = 'sala';
}
