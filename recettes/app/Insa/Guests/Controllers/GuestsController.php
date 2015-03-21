<?php namespace Insa\Guests\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\View\Factory as View;
use Insa\Guests\Models\Guest;
use Insa\Guests\Repositories\GuestsRepository;

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
	 * The constructor
	 * @param View $view
	 * @param GuestsRepository $guestsRepository
	 */
	function __construct(View $view, GuestsRepository $guestsRepository)
	{
		$this->view = $view;
		$this->guestsRepository = $guestsRepository;
	}

	/**
	 * List all guests
	 * @return \Response
	 */
	public function index()
	{
		$guests = $this->guestsRepository->getAll();

		return $this->view->make('guests.index', compact('guests'));
	}

	/**
	 * Show the form to create a new guest
	 * @return \Response
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
	 * @return \Response
	 */
	public function store()
	{
		// TODO
	}
}