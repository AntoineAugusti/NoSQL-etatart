<?php namespace Insa\Guests\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\View\Factory as View;
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
	 * @param GuestsRepository $guestsRepository
	 */
	function __construct(View $view, GuestsRepository $guestsRepository)
	{
		$this->guestsRepository = $guestsRepository;
		$this->view = $view;
	}

	public function index()
	{
		$guests = $this->guestsRepository->getAll();

		return $this->view->make('guests.index', compact('guests'));
	}

	public function create()
	{
		return $this->view->make('guests.create');
	}

	public function store()
	{
		// TODO
	}
}