<?php

declare(strict_types=1);
/**
 * This file is part of hyperf-ext/jwt
 *
 * @link     https://github.com/hyperf-ext/jwt
 * @contact  eric@zhu.email
 * @license  https://github.com/hyperf-ext/jwt/blob/master/LICENSE
 */


return [

    /**
     *  render driver
     */
    'driver' => 'gd',

    'fonts' => [

        /**
         * |--------------------------------------------------------------------------
         * | fontUrl
         * |--------------------------------------------------------------------------
         * |
         * | fontUrl
         * |
         */
        'fontUrl' => BASE_PATH . '/config/autoload/simhei.ttf',

        /**
         * |--------------------------------------------------------------------------
         * | fontSize
         * |--------------------------------------------------------------------------
         * |
         * | fontSize
         * |
         */
        'fontSize' => 16,

        /**
         * |--------------------------------------------------------------------------
         * | fontColor
         * |--------------------------------------------------------------------------
         * |
         * | fontColor
         * |
         */
        'fontColor' => '#000000',
    ],

];