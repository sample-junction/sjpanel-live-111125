<?php

namespace App\Listeners\Backend\Auth\User;
 use App\Mail\Backend\RedeemApprove\RedeemApprovedEmail;
 use App\Repositories\Inpanel\Redeem\RedeemRepository;
 use Illuminate\Support\Facades\Mail;

 /**
 * Class UserEventListener.
 */
class UserEventListener
{
    /**
     * @param $event
     */
    public $redeemRepo;

    public function __construct(RedeemRepository $redeemRepo)
    {
        $this->redeemRepo = $redeemRepo;
    }

    public function onCreated($event)
    {
        \Log::info('User Created');
    }

    /**
     * @param $event
     */
    public function onUpdated($event)
    {
        \Log::info('User Updated');
    }

    /**
     * @param $event
     */
    public function onDeleted($event)
    {
        \Log::info('User Deleted');
    }

    /**
     * @param $event
     */
    public function onConfirmed($event)
    {
        \Log::info('User Confirmed');
    }

    /**
     * @param $event
     */
    public function onUnconfirmed($event)
    {
        \Log::info('User Unconfirmed');
    }

    /**
     * @param $event
     */
    public function onPasswordChanged($event)
    {
        \Log::info('User Password Changed');
    }

    /**
     * @param $event
     */
    public function onDeactivated($event)
    {
        \Log::info('User Deactivated');
    }

    /**
     * @param $event
     */
    public function onReactivated($event)
    {
        \Log::info('User Reactivated');
    }

    /**
     * @param $event
     */
    public function onSocialDeleted($event)
    {
        \Log::info('User Social Deleted');
    }

    /**
     * @param $event
     */
    public function onPermanentlyDeleted($event)
    {
        \Log::info('User Permanently Deleted');
    }

    /**
     * @param $event
     */
    public function onRestored($event)
    {
        \Log::info('User Restored');
    }

    public function onConfirmationRedeemPoints($event)
    {


        \Log::info('666 Checking mail : '.json_encode($event));
       

        $user = $event->user;
        $redeem_request_id = $event->redeem_request_id;
        $this->redeemRepo->updateUserAddData($user,$redeem_request_id);
    }

    public function onApprovalRedeemRequest($event)
    {
        $user = $event->user;
        $request_redeem = $event->redeem_request;
        $email = new RedeemApprovedEmail($user,$request_redeem);
        Mail::send($email);
    }
    /**
     * Register the listeners for the subscriber.
     *
     * @param \Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            \App\Events\Backend\Auth\User\UserCreated::class,
            'App\Listeners\Backend\Auth\User\UserEventListener@onCreated'
        );

        $events->listen(
            \App\Events\Backend\Auth\User\UserUpdated::class,
            'App\Listeners\Backend\Auth\User\UserEventListener@onUpdated'
        );

        $events->listen(
            \App\Events\Backend\Auth\User\UserDeleted::class,
            'App\Listeners\Backend\Auth\User\UserEventListener@onDeleted'
        );

        $events->listen(
            \App\Events\Backend\Auth\User\UserConfirmed::class,
            'App\Listeners\Backend\Auth\User\UserEventListener@onConfirmed'
        );

        $events->listen(
            \App\Events\Backend\Auth\User\UserUnconfirmed::class,
            'App\Listeners\Backend\Auth\User\UserEventListener@onUnconfirmed'
        );

        $events->listen(
            \App\Events\Backend\Auth\User\UserPasswordChanged::class,
            'App\Listeners\Backend\Auth\User\UserEventListener@onPasswordChanged'
        );

        $events->listen(
            \App\Events\Backend\Auth\User\UserDeactivated::class,
            'App\Listeners\Backend\Auth\User\UserEventListener@onDeactivated'
        );

        $events->listen(
            \App\Events\Backend\Auth\User\UserReactivated::class,
            'App\Listeners\Backend\Auth\User\UserEventListener@onReactivated'
        );

        $events->listen(
            \App\Events\Backend\Auth\User\UserSocialDeleted::class,
            'App\Listeners\Backend\Auth\User\UserEventListener@onSocialDeleted'
        );

        $events->listen(
            \App\Events\Backend\Auth\User\UserPermanentlyDeleted::class,
            'App\Listeners\Backend\Auth\User\UserEventListener@onPermanentlyDeleted'
        );

        $events->listen(
            \App\Events\Backend\Auth\User\UserRestored::class,
            'App\Listeners\Backend\Auth\User\UserEventListener@onRestored'
        );
        $events->listen(
            \App\Events\Backend\Auth\User\UserRedeemRequestControl::class,
            'App\Listeners\Backend\Auth\User\UserEventListener@onConfirmationRedeemPoints'
        );
        $events->listen(
            \App\Events\Backend\Auth\User\AfterRedeemApprove::class,
            'App\Listeners\Backend\Auth\User\UserEventListener@onApprovalRedeemRequest'
        );
    }
}
