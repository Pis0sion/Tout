<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
return [
    /*
     *  render driver
     */
    'driver' => 'gd',

    'fonts' => [
        /*
         * |--------------------------------------------------------------------------
         * | fontUrl
         * |--------------------------------------------------------------------------
         * |
         * | fontUrl
         * |
         */
        'fontUrl' => BASE_PATH . '/config/autoload/simhei.ttf',

        /*
         * |--------------------------------------------------------------------------
         * | fontSize
         * |--------------------------------------------------------------------------
         * |
         * | fontSize
         * |
         */
        'fontSize' => 16,

        /*
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
