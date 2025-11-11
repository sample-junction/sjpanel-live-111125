<?php
/**
 * Created by PhpStorm.
 * User: Sample Junction
 * Date: 3/29/2019
 * Time: 4:27 PM
 */
Breadcrumbs::for('admin.auth.redeem_points', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push(__('Redeem Points Requests'), route('admin.auth.user.redeem_points'));
});
