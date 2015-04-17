<?php namespace Insa\Guests\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\Factory as View;
use Insa\Guests\Models\Guest;
use Insa\Guests\Models\Invite;
use Insa\Guests\Repositories\GuestsRepository;
use Insa\Guests\Validation\GuestValidator;
use Response;

class GuestsController extends Controller {

	/**
	 * @var GuestsRepository
	 */
	private $guestsRepository;

	/**
	 * @var View
	 */
	private $view;
    /**
     * @var GuestValidator
     */
    private $guestValidator;

    /**
     * The constructor
     * @param View $view
     * @param GuestsRepository $guestsRepository
     * @param GuestValidator $guestValidator
     */
	function __construct(View $view, GuestsRepository $guestsRepository, GuestValidator $guestValidator)
	{
		$this->view = $view;
		$this->guestsRepository = $guestsRepository;
        $this->guestValidator = $guestValidator;
    }

	/**
	 * List all guests
	 * @return Response
	 */
	public function index()
	{
		$guests = $this->guestsRepository->getAll();

		return $this->view->make('guests.index', compact('guests'));
	}

	/**
	 * Show the form to create a new guest
	 * @return Response
	 */
	public function create()
	{
        $data = [
            'possibleTypes' => Guest::getAllowedTypeValues()
        ];

		return $this->view->make('guests.create', $data);
	}

	/**
	 * Store a new guest
	 * @return Response
	 */
	public function store()
	{
        $data = Input::only('name', 'phoneNumber', 'type');

        $this->guestValidator->validate($data);

        $guest = new Guest($data);
        $invite = new Invite();
        $invite->toInvite = true;
        $invite->numberOfInvite = 0;

        $guest->invite()->associate($invite);
        $this->guestsRepository->save($guest);

        return Redirect::route('guests.index');
	}
}