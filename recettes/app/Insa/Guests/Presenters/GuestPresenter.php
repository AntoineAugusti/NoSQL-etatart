<?php

namespace Insa\Guests\Presenters;

use Illuminate\Support\Facades\Lang;
use Laracasts\Presenter\Presenter;

class GuestPresenter extends Presenter
{
    /**
     * Show the phone number of a guest.
     *
     * @return string
     */
    public function phoneNumber()
    {
        return $this->formatPhoneNumber($this->entity->phoneNumber);
    }

    /**
     * Format a phone number to have an homogeneous display.
     *
     * @param string $phoneNumber
     *
     * @return string
     */
    private function formatPhoneNumber($phoneNumber)
    {
        $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);

        if (strlen($phoneNumber) > 10) {
            $countryCode = substr($phoneNumber, 0, strlen($phoneNumber) - 10);
            $areaCode = substr($phoneNumber, -10, 3);
            $nextThree = substr($phoneNumber, -7, 3);
            $lastFour = substr($phoneNumber, -4, 4);

            $phoneNumber = '+'.$countryCode.' ('.$areaCode.') '.$nextThree.'-'.$lastFour;
        } elseif (strlen($phoneNumber) == 10) {
            $areaCode = substr($phoneNumber, 0, 3);
            $nextThree = substr($phoneNumber, 3, 3);
            $lastFour = substr($phoneNumber, 6, 4);

            $phoneNumber = '('.$areaCode.') '.$nextThree.'-'.$lastFour;
        } elseif (strlen($phoneNumber) == 7) {
            $nextThree = substr($phoneNumber, 0, 3);
            $lastFour = substr($phoneNumber, 3, 4);

            $phoneNumber = $nextThree.'-'.$lastFour;
        }

        return $phoneNumber;
    }

    public function type()
    {
        return Lang::get('guests.'.$this->entity->type);
    }

    public function inviteType()
    {
        if ($this->entity->hasBeenInvited()) {
            return 'mdi-action-done';
        } else {
            return 'mdi-alert-warning';
        }
    }

    public function inviteInfo()
    {
        if ($this->entity->hasBeenInvited()) {
            return Lang::get('guests.invitedThe').' '.$this->entity->getInvite()->lastInvite->format('d/m/Y').' ('.Lang::get('guests.numberOfInvitations').': '.$this->entity->getInvite()->numberOfInvitations.')';
        } else {
            return Lang::get('guests.neverInvited');
        }
    }
}
