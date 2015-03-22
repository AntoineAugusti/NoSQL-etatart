<?php namespace Insa\Guests\Presenters;

use Laracasts\Presenter\Presenter;

class GuestPresenter extends Presenter {

	/**
	 * Show the phone number of a guest
	 * @return string
	 */
	public function phoneNumber()
	{
		return $this->formatPhoneNumber($this->entity->phoneNumber);
	}

	/**
	 * Format a phone number to have an homogeneous display
	 * @param  string $phoneNumber
	 * @return string
	 */
	private function formatPhoneNumber($phoneNumber)
	{
		$phoneNumber = preg_replace('/[^0-9]/','',$phoneNumber);

		if (strlen($phoneNumber) > 10)
		{
			$countryCode = substr($phoneNumber, 0, strlen($phoneNumber)-10);
			$areaCode = substr($phoneNumber, -10, 3);
			$nextThree = substr($phoneNumber, -7, 3);
			$lastFour = substr($phoneNumber, -4, 4);

			$phoneNumber = '+'.$countryCode.' ('.$areaCode.') '.$nextThree.'-'.$lastFour;
		}
		else if (strlen($phoneNumber) == 10)
		{
			$areaCode = substr($phoneNumber, 0, 3);
			$nextThree = substr($phoneNumber, 3, 3);
			$lastFour = substr($phoneNumber, 6, 4);

			$phoneNumber = '('.$areaCode.') '.$nextThree.'-'.$lastFour;
		}
		else if (strlen($phoneNumber) == 7)
		{
			$nextThree = substr($phoneNumber, 0, 3);
			$lastFour = substr($phoneNumber, 3, 4);

			$phoneNumber = $nextThree.'-'.$lastFour;
		}

		return $phoneNumber;
	}
}